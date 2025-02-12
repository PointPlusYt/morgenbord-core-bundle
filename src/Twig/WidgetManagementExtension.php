<?php

namespace Morgenbord\CoreBundle\Twig;

use Morgenbord\CoreBundle\Entity\UserWidget;
use Morgenbord\CoreBundle\Entity\Widget;
use Morgenbord\CoreBundle\Widget\ParametersForms;
use Symfony\Component\HttpKernel\KernelInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class WidgetManagementExtension extends AbstractExtension
{
    private $kernel;
    private $parametersForms;

    public function __construct(KernelInterface $kernel, ParametersForms $parametersForms)
    {
        $this->kernel = $kernel;
        $this->parametersForms = $parametersForms;
    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('get_actual_parameters', [$this, 'getActualParameters']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_widget_form', [$this, 'getWidgetForm']),
            new TwigFunction('get_widgets_entries', [$this, 'getWidgetsEntries']),
        ];
    }

    public function getWidgetForm(Widget $widget)
    {
        return $this->parametersForms->getForm($widget, true)->createView();
    }

    public function getWidgetsEntries()
    {
        $bundlesDir = $this->kernel->getProjectDir() . '/public/bundles/';
        $directoryList = scandir($bundlesDir);
        $entries = [];
        foreach ($directoryList as $directory) {
            if (is_dir($bundlesDir . $directory) && $directory !== '.' && $directory !== '..') {
                $bundleDir = $bundlesDir . $directory;
                $bundlesFiles = scandir($bundleDir);
                foreach ($bundlesFiles as $file) {
                    if (is_file($bundleDir . '/' . $file)) {
                        $entryName = pathinfo($file, PATHINFO_FILENAME);
                        $entries[] = $entryName;
                    }
                }
            }
        }
        return $entries;
    }

    public function getActualParameters(UserWidget $widget)
    {
        $configurationFqcn = $this->parametersForms->getParametersFqcnFromWidget($widget);
        return $this->parametersForms->processParameters($configurationFqcn, $widget->getParameters());
    }
}
