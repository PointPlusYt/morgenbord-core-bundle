<?php

namespace Morgenbord\CoreBundle\Widget;

use Doctrine\ORM\EntityManagerInterface;
use Morgenbord\CoreBundle\Entity\User;
use Morgenbord\CoreBundle\Entity\UserWidget;
use Morgenbord\CoreBundle\Entity\Widget;
use Morgenbord\CoreBundle\Service\WidgetRegistry;

class Registration
{
    public function __construct(
        private EntityManagerInterface $em,
        private ParametersForms $parametersForms,
        private WidgetRegistry $widgetRegistry
    ) { }

    /**
     * Undocumented function
     *
     * @param Widget $registeredWidget
     * @return UserWidget
     */
    public function createUserWidget(Widget $registeredWidget, User $user): UserWidget
    {
        $userWidget = new UserWidget();
        $userWidget->setParameterFormFqcn($registeredWidget->getParameterFormFqcn());
        $userWidget->setTwigFile($registeredWidget->getTwigFile());
        $userWidget->setOwner($user);
        $userWidget->setName($registeredWidget->getName());
        $userWidget->setShortName($registeredWidget->getShortName());
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
        $registeredWidget = $this->widgetRegistry->getWidget($widgetDetails['shortname']);

        // Créer un objet à mettre en BDD avec sa configuration.
        $userWidget = $this->createUserWidget($registeredWidget, $user);

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
