<?php

namespace MorgenBord\CoreBundle\Widget;

use MorgenBord\CoreBundle\Entity\UserWidget;
use MorgenBord\CoreBundle\Entity\Widget;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormFactoryInterface;

class ParametersForms
{
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function getForm(Widget $widget, $crsfProtection = false)
    {
        $configurationFqcn = $this->getParametersFqcnFromWidget($widget);
        return $this->getFormFromFqcn($configurationFqcn, $crsfProtection);
    }

    public function getFormBuilderFromFqcn(string $configurationFqcn, $crsfProtection = false)
    {
        $formBuilder = $this->formFactory->createBuilder(FormType::class, null, [
            'csrf_protection' => $crsfProtection,
            'allow_extra_fields' => true,
        ]);

        $config = new $configurationFqcn();
        $config->createParametersForm($formBuilder);

        return $formBuilder;
    }

    public function getFormFromFqcn(string $configurationFqcn, $crsfProtection = false)
    {
        $formBuilder = $this->getFormBuilderFromFqcn($configurationFqcn, $crsfProtection);

        return $formBuilder->getForm();
    }

    public function getParametersFqcnFromWidget(Widget $widget)
    {
        return preg_replace('/Bundle$/', 'Parameters', $widget->getParameterFormFqcn());
    }

    /**
     * Load widget parameters into the UserWidget
     *
     * @param Widget $widget Widget to load parameters for
     * @param UserWidget $userWidget UserWidget to set parameters in
     * @param array $userParameters User parameters to merge with default parameter values
     * @return void
     */
    public function loadParameters(UserWidget $userWidget, array $userParameters)
    {
        $configurationFqcn = $this->getParametersFqcnFromWidget($userWidget);
        $config = $this->processParameters($configurationFqcn, $userParameters);
        
        $userWidget->setParameters($config);
    }
    
    /**
     * In any case, it takes the user's parameters and merges them with the default parameters
     *
     * @param string $configurationFqcn The FQCN of the widget's configuration class
     * @param array $userParameters
     * @return array
     */
    public function processParameters(string $configurationFqcn, array $userParameters): array
    {
        unset($userParameters['_token']);
        $form = $this->getFormFromFqcn($configurationFqcn);
        $form->submit($userParameters);
        return array_merge($form->getData(), $form->getExtraData());
    }
}