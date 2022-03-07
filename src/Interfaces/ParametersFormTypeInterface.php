<?php

namespace MorgenBord\Core\Interfaces;

use Symfony\Component\Form\FormBuilderInterface;

interface ParametersFormTypeInterface
{
    public function createParametersForm(FormBuilderInterface $builder);
}