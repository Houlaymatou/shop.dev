<?php
namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('presentation')
            ->add('price')
            ->add('stock')
            ->add('techs')
            ->add('details')
            ->add('url')
            //->add('category')génère un simple champ text
            ->add('category', EntityType::class, array(
            	'class' => 'AppBundle:Category',
            	'choice_label' => 'name',
            	//'choice_value' => 'url'
            	))
            ->add('save', SubmitType::class)
           
        ;
    }
}