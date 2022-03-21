<?php

namespace MorgenBord\CoreBundle\Widget;

use MorgenBord\CoreBundle\Entity\User;
use MorgenBord\CoreBundle\Entity\UserWidget;
use MorgenBord\CoreBundle\Entity\Widget;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class Registration
{
    private $em;
    private $parametersForms;
    // private $request;
    private $widgets;

    public function __construct(EntityManagerInterface $em, ParametersForms $parametersForms, RequestStack $requestStack)
    {
        $this->parametersForms = $parametersForms;
        $this->em = $em;
        // $this->request = $requestStack->getCurrentRequest();
        $this->widgets = $requestStack->getCurrentRequest()->widgets;
    }

    public function getRegisteredWidgets(): array
    {
        return $this->widgets;
    }

    public function getRegisteredWidget($shortname): Widget
    {
        return $this->widgets[$shortname];
    }

    /**
     * Undocumented function
     *
     * @param Widget $registeredWidget
     * @return UserWidget
     */
    public function createUserWidget(Widget $registeredWidget): UserWidget
    {
        $userWidget = new UserWidget();
        $userWidget->setParameterFormFqcn($registeredWidget->getParameterFormFqcn());
        $userWidget->setTwigFile($registeredWidget->getTwigFile());

        return $userWidget;
    }

    /**
     * Complete algorithm to register a widget
     *
     * @param array $widgetDetails ["shortname" => string, "widget_parameters" => array]
     * @param User $user
     * @return void
     */
    public function addUserWidget(array $widgetDetails, User $user)
    {
        $registeredWidget = $this->getRegisteredWidget($widgetDetails['shortname']);
        // dd($registeredWidget);
        // Créer un objet à mettre en BDD avec sa configuration.
        $userWidget = $this->createUserWidget($registeredWidget);
        $userWidget->setOwner($user);

        $this->parametersForms->loadParameters($userWidget, $widgetDetails['form']);

        $this->em->persist($userWidget);
        $this->em->flush();

        return $userWidget;
    }

    public function editUserWidget(UserWidget $userWidget, array $widgetDetails)
    {
        $this->parametersForms->loadParameters($userWidget, $widgetDetails['form']);
        $this->em->flush();
    }

    public function removeUserWidget(UserWidget $userWidget)
    {
        $this->em->remove($userWidget);
        $this->em->flush();
    }
}