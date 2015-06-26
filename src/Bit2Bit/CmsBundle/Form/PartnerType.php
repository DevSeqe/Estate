<?php

namespace Bit2Bit\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PartnerType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('name', null, array(
                    'label' => 'Partner',
                    'required' => true           
                ))
                ->add('url',null,array(
                    'label' => 'Adres URL',
                    'required' => false
                )) 
                ->add('image','hidden')                 
                ->add('submit', 'submit', array(
                    'label' => 'Zapisz'
                ))
        ;
    }

    /**
     * Metoda buduje widok formularza.
     * 
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options) {
        parent::buildView($view, $form, $options);
    }

    /**
     * Metoda dodaje do FormBuilder'a opcje możliwe do zdefiniowania podczas
     * tworzenia formularza.
     * 
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'csrf_protection' => true,
            'data_class' => 'Bit2Bit\CmsBundle\Entity\Partner'
        ));
    }

    /**
     * Metoda zwraca nazwę formularza.
     * 
     * @return string
     */
    public function getName() {
        return 'partner';
    }

}
