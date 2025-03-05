<?php

namespace Morgenbord\CoreBundle\EventListener;

use Doctrine\ORM\Event\PostLoadEventArgs;
use Morgenbord\CoreBundle\Entity\UserWidget;
use Morgenbord\CoreBundle\Service\WidgetRegistry;
class UserWidgetListener
{
    public function __construct(
        private WidgetRegistry $widgetRegistry
    ) {}

    /**
     * Adds the widget data dynamically to the userWidget
     * 
     * @param PostLoadEventArgs $args
     * 
     * @return void
     */
    public function postLoad(UserWidget $userWidget)
    {
        $widget = $this->widgetRegistry->getWidgetByFqcn($userWidget->getParameterFormFqcn());
        $userWidget->setName($widget->getName());
        $userWidget->setShortName($widget->getShortName());
    }
}