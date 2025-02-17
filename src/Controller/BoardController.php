<?php

namespace Morgenbord\CoreBundle\Controller;

use Morgenbord\CoreBundle\Entity\UserWidget;
use Morgenbord\CoreBundle\Repository\UserRepository;
use Morgenbord\CoreBundle\Repository\UserWidgetRepository;
use Morgenbord\CoreBundle\Widget\ParametersForms;
use Morgenbord\CoreBundle\Widget\Registration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoardController extends AbstractController
{
    #[Route('/', name: 'board')]
    public function index(Request $request, UserWidgetRepository $userWidgetRepository, ParametersForms $parametersForms): Response
    {
        return $this->render('@MorgenbordCore/board.html.twig', [
            'userWidgets' => $userWidgetRepository->findByUser($this->getUser()),
        ]);
    }

    #[Route('/add-widget', name: 'add_widget', methods: ['POST'])]
    public function add(Registration $widgetRegistration, RequestStack $request, UserRepository $userRepository): Response
    {
        // get widget details from form or json
        $widgetDetails = $request->getCurrentRequest()->request->all();
        // TEMP TO GET actual user
        // $this->getUser();
        $user = $userRepository->findOneBy([]);
        $userWidget = $widgetRegistration->addUserWidget($widgetDetails, $user);

        return $this->redirectToRoute('morgenbord_board');
    }

    #[Route('/edit-widget/{id}', name: 'edit_widget')]
    public function edit(ParametersForms $parametersForms, Registration $widgetRegistration, RequestStack $request, UserWidget $userWidget): Response
    {
        if ($request->getCurrentRequest()->getMethod() === 'POST') {
            $widgetDetails = $request->getCurrentRequest()->request->all();
            $userWidget = $widgetRegistration->editUserWidget($userWidget, $widgetDetails);
            return $this->redirectToRoute('morgenbord_board');
        } else {
            $form = $parametersForms->getForm($userWidget);
            $form->submit($userWidget->getParameters());
            return $this->render('edit_widget.html.twig', [
                'form' => $form->createView(),
                'userWidget' => $userWidget,
            ]);
        }
    }

    #[Route('/remove-widget/{id}', name: 'remove_widget')]
    public function remove(Registration $widgetRegistration, UserWidget $userWidget): Response
    {
        $userWidget = $widgetRegistration->removeUserWidget($userWidget);
        return $this->redirectToRoute('morgenbord_board');
    }
}
