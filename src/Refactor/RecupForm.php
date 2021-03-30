<?php


namespace App\Refactor;


use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class RecupForm extends AbstractController
{
    public function RecupFormComplete(Request $request): \Symfony\Component\Form\FormInterface
    {
        $categoryForm = $this->createForm(CategoryType::class);
        $categoryForm->handleRequest($request);
        return $categoryForm;
    }
}