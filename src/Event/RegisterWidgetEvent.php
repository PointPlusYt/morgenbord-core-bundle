<?php

namespace MorgenBord\Core\Event;

use MorgenBord\Core\Entity\Widget;
use Symfony\Contracts\EventDispatcher\Event;

class RegisterWidgetEvent extends Event
{
    const NAME = 'morning_bord.register_widget';

    private $widgets = [];

    public function getWidgets(): array
    {
        return $this->widgets;
    }

    public function addWidget(Widget $widget)
    {
        if ($this->hasWidget($widget)) {
            throw new \InvalidArgumentException('Widget is already registered with this name : ' . $widget->getShortname());
        } else {
            $this->widgets[$widget->getShortName()] = $widget;
        }
    }

    public function removeWidget(Widget $widget)
    {
        if ($this->hasWidget($widget)) {
            unset($this->widgets[$widget->getShortName()]);
        } else {
            throw new \InvalidArgumentException('Widget is not registered and you are trying to remove it');
        }
    }

    public function hasWidget(Widget $widget): bool
    {
        return isset($this->widgets[$widget->getShortName()]);
    }
}