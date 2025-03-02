<?php

namespace Morgenbord\CoreBundle\EventSubscriber;

use Morgenbord\CoreBundle\Event\RegisterWidgetEvent;
use Morgenbord\CoreBundle\Widget\ParametersForms;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestSubscriber implements EventSubscriberInterface
{
    public $eventDispatcher;
    private $parametersForms;

    public function __construct(EventDispatcherInterface $eventDispatcher, ParametersForms $parametersForms)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->parametersForms = $parametersForms;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        $registerWidgetEvent = new RegisterWidgetEvent();
        $registerWidgetEvent->parametersForms = $this->parametersForms;

        $this->eventDispatcher->dispatch(
            $registerWidgetEvent,
            RegisterWidgetEvent::NAME
        );

        // TODO : stop dynamic assignment
        $request->widgets = $registerWidgetEvent->getWidgets();

    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 1000],
        ];
    }
}
