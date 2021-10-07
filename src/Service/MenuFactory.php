<?php

namespace App\Service;

use App\Form\MenuSearchType;
use Symfony\Component\Form\FormFactoryInterface;

class MenuFactory
{
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function create()
    {
        return $this->formFactory->create(MenuSearchType::class)
            ->createView();
    }
}

