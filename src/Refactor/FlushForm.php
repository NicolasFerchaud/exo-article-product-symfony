<?php


namespace App\Refactor;


use Doctrine\ORM\EntityManagerInterface;

class FlushForm
{
    public function FlushForm(\Symfony\Component\Form\FormInterface $categoryForm, EntityManagerInterface $entityManager)
    {
        $category = $categoryForm->getData();

        $entityManager->persist($category);
        $entityManager->flush();
        return $category;
    }
}