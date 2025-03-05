<?php

namespace Morgenbord\CoreBundle\EventSubscriber;

use Morgenbord\CoreBundle\Event\RegisterWidgetEvent;
use Morgenbord\CoreBundle\Service\WidgetRegistry;
use Morgenbord\CoreBundle\Widget\ParametersForms;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
class RequestSubscriber implements EventSubscriberInterface
{
    public function __construct(
        public EventDispatcherInterface $eventDispatcher,
        private ParametersForms $parametersForms,
        private WidgetRegistry $widgetRegistry,
    ) { }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        $registerWidgetEvent = new RegisterWidgetEvent();
        $registerWidgetEvent->parametersForms = $this->parametersForms;

        $this->eventDispatcher->dispatch(
            $registerWidgetEvent,
            RegisterWidgetEvent::NAME
        );

        $this->widgetRegistry->setWidgets($registerWidgetEvent->getWidgets());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 1000],
        ];
    }
}
