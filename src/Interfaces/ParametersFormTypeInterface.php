<?php

namespace MorgenBord\CoreBundle\Interfaces;

use Symfony\Component\Form\FormBuilderInterface;

interface ParametersFormTypeInterface
{
    public function createParametersForm(FormBuilderInterface $builder);
}