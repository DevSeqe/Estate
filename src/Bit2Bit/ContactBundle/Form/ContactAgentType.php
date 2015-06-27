<?php

namespace Bit2Bit\ContactBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactAgentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('name', null, array(
                    'label' => false,
                    'attr' => array(
                        'class' => '',
                        'placeholder' => 'Imię i nazwisko/Firma'
                    ),
                    'required' => true           
                ))     
                ->add('phone', null, array(
                    'label' => false,
                    'attr' => array(
                        'class' => '',
                        'placeholder' => 'Numer telefonu'
                    ),
                    'required' => true           
                ))  
                ->add('email', null, array(
                    'label' => false,
                    'attr' => array(
                        'class' => '',
                        'placeholder' => 'Adres email'
                    ),
                    'required' => true           
                ))  
                ->add('category','text', array(
                    'label' => false,                    
                    'attr' => array(
                        'class' => '',
                        'readonly' => true,
//                        'value' => 'Kontakt w sprawie oferty'
                    ),
                    'required' => true           
                ))  
                ->add('content', null, array(
                    'label' => false,
                    'attr' => array(
                        'class' => '',
                        'placeholder' => 'Wiadomość'
                    ),
                    'required' => true           
                ))  
                ->add('submit', 'submit', array(
                    'label' => 'Wyślij wiadomość',
                    'attr' => array(
                        'class' => 'btn-gray'
                    )
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
            'data_class' => 'Bit2Bit\ContactBundle\Entity\Mail'
        ));
    }

    /**
     * Metoda zwraca nazwę formularza.
     * 
     * @return string
     */
    public function getName() {
        return 'contact';
    }

}
