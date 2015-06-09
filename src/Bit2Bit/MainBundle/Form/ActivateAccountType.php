<?php

namespace Bit2Bit\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ActivateAccountType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('username', null, array(
                    'label' => 'Nazwa użytkownika (nie będzie można zmienić)',
                    'required' => true                    
                ))
                ->add('name',null,array(
                    'label' => 'Imię'
                ))
                ->add('surname',null,array(
                    'label' => 'Nazwisko'
                ))
                ->add('password','password',array(
                    'label' => 'Hasło'
                ))
                ->add('submit', 'submit', array(
                    'label' => 'Wyślij'
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
            'data_class' => 'Bit2Bit\MainBundle\Entity\User'
        ));
    }

    /**
     * Metoda zwraca nazwę formularza.
     * 
     * @return string
     */
    public function getName() {
        return 'activate_user';
    }

}
