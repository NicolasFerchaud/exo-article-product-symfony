<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('image', FileType::class,[
                'label' => 'image',// change le nom du label dans le form twig
                'mapped' => false,//true par défaut, à mettre false pour pas envoyé direct en bdd pour traité l'image à part (lui donner un nom unique...)
                'required' => false,//car l'image n'est pas obligatoire pour mes articles
                'constraints' => [//limite de taille d'image à 2 megas
                    new File([
                        'maxSize' => '2M'
                        ])
                ]
            ])
            ->add('createdAt',DateType::class, [
                'widget' => 'single_text'//format propre de date
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'title',
                //'choice_label' => function($category) {
                //return $category->getId() . ' ' . $category->getTitle();
                //},
                'placeholder' => ' '
            ] )
            ->add('isPublished')
            ->add('envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
