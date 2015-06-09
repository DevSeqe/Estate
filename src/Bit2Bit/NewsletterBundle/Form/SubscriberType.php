<?php

namespace Bit2Bit\NewsletterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SubscriberType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('name', null, array(
                    'label' => 'Imię i nazwisko subskrybenta',
                    'required' => false                    
                ))
                ->add('email','email',array(
                    'label' => 'Adres email'
                ))
                ->add('active',null,array(
                    'label' => 'Aktywować wysyłanie maili?',
                    'required' => false                    
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
            'data_class' => 'Bit2Bit\NewsletterBundle\Entity\Subscriber'
        ));
    }

    /**
     * Metoda zwraca nazwę formularza.
     * 
     * @return string
     */
    public function getName() {
        return 'create_subscriber';
    }

}
