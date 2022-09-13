<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('descriptionCourte')
            ->add('price',MoneyType::class)
            ->add('slug')
            ->add('mainPicture',UrlType::class)
            ->add('categorie',EntityType::class,[
                'label'=> 'Categories',
                'attr'=>['class'=>'form-control'],
                'placeholder'=>'--Choisir une categorie--',
                'class'=>Categorie::class,
                'choice_label' => function(Categorie $categorie){
                    return strtoupper($categorie->getName());
                }
            ]);


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
