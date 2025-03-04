<?php

namespace Morgenbord\CoreBundle\Controller\Api\V0;

use Doctrine\ORM\EntityManagerInterface;
use Morgenbord\CoreBundle\Entity\UserWidget;
use Morgenbord\CoreBundle\Service\WidgetRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v0/widget', name: 'api_v0_widget')]
class WidgetController extends AbstractController
{
    public function __construct(
        private WidgetRegistry $widgetRegistry
    ) { }

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
