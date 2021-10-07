<?php

namespace App\Service;

use App\Form\Monitoring\SearchBorrowersType;
use Symfony\Component\Form\FormFactoryInterface;

class SearchBorrowersViewFactory
{
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function create()
    {
        return $this->formFactory->create(SearchBorrowersType::class)
            ->createView();
    }
}
