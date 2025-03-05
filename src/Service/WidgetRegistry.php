<?php

namespace Morgenbord\CoreBundle\Service;

use Morgenbord\CoreBundle\Entity\Widget;

class WidgetRegistry
{
    private array $widgets = [];

    public function addWidget(Widget $widget)
    {
        $this->widgets[$widget->getShortName()] = $widget;
    }

    public function getWidgets(): array
    {
        return $this->widgets;
    }

    public function getWidget(string $shortname): Widget
    {
        return $this->widgets[$shortname];
    }

    public function getWidgetByFqcn(string $fqcn): Widget
    {
        foreach ($this->widgets as $widget) {
            if ($fqcn === $widget->getParameterFormFqcn()) {
                return $widget;
            }
        }
    }

    public function setWidgets(array $widgets)
    {
        $this->widgets = $widgets;
    }
}