<?php

namespace Bit2Bit\OfferBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LocalizationType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('city', null, array(
                    'label' => 'Miasto/Miejscowość',
                    'required' => true           
                ))
                ->add('street',null,array(
                    'label' => 'Ulica',
                    'required' => false
                )) 
                ->add('building',null,array(
                    'label' => 'Numer budynku',
                    'required' => true
                )) 
                ->add('latitude',null,array(
                    'label' => 'Szerokość geo.',
                    'required' => false
                )) 
                ->add('longitude',null,array(
                    'label' => 'Długość geo.',
                    'required' => false
                )) 
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
            'data_class' => 'Bit2Bit\OfferBundle\Entity\Localization'
        ));
    }

    /**
     * Metoda zwraca nazwę formularza.
     * 
     * @return string
     */
    public function getName() {
        return 'create_localization';
    }

}
