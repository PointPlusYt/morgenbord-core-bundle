<?php

namespace MorgenBord\Core\Controller\Api\V0;

use MorgenBord\Core\Entity\User;
use MorgenBord\Core\Entity\UserWidget;
use MorgenBord\Core\Widget\Registration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v0/widget', name: 'api_v0_widget')]
class WidgetController extends AbstractController
{
    private $request;
    private $widgets;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->widgets = $requestStack->getCurrentRequest()->widgets;
    }

    // #[Route('', name: '_register', methods: ['POST'])]
    // public function register(Registration $widgetRegistration): Response
    // {        
    //     // get widget details from form or json
    //     $widgetDetails = json_decode($this->request->getContent(), true);
    //     // TEMP TO GET actual user
    //     // $this->getUser();
    //     $user = $this->manager->getRepository(User::class)->findOneBy([]);
    //     $userWidget = $widgetRegistration->addUserWidget($widgetDetails, $user);

    //     return $this->json([$this->widgets, $userWidget], 200, [], ['groups' => ['read']]);
    // }

    #[Route('/data/{id}', name: 'get_widget_data', methods: ['GET'])]
    public function getWidgetData(UserWidget $userWidget): Response
    {
        return $this->json($userWidget->getData());
    }

    #[Route('/data/{id}', name: 'put_widget_data', methods: ['PUT', 'PATCH'])]
    public function putWidgetData(EntityManagerInterface $em, RequestStack $request, UserWidget $userWidget): Response
    {
        $data = json_decode($request->getCurrentRequest()->getContent(), true);
        $userWidget->setData($data);
        $em->flush();
        return $this->json($userWidget->getData());
    }
}
