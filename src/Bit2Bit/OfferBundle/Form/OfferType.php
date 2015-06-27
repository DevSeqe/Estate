<?php

namespace Bit2Bit\OfferBundle\Form;

use Bit2Bit\OfferBundle\Enum\MarketType;
use Bit2Bit\OfferBundle\Enum\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OfferType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('name', null, array(
                    'label' => 'Numer oferty',
                    'required' => true           
                ))
                ->add('slug','hidden')
                ->add('localization',null,array(
                    'label' => 'Lokalizacja',
                    'required' => true
                )) 
                ->add('pricePerMeter',null,array(
                    'label' => 'Cena za m kw.',
                    'required' => true
                )) 
                ->add('area',null,array(
                    'label' => 'Powierzchnia',
                    'required' => true
                )) 
                ->add('rooms',null,array(
                    'label' => 'Liczba pokoi',
                    'required' => true
                )) 
                ->add('floor',null,array(
                    'label' => 'Piętro',
                    'required' => true
                )) 
                ->add('numberOfFloors',null,array(
                    'label' => 'Liczba pięter',
                    'required' => true
                )) 
                ->add('type','choice',array(
                    'label' => 'Typ oferty',
                    'choices' => Type::getList(),
                    'required' => true
                )) 
                ->add('marketType','choice',array(
                    'label' => 'Typ rynku',
                    'choices' => MarketType::getList(),
                    'required' => true
                )) 
                ->add('availableFrom','date',array(
                    'label' => 'Dostępne od',
                    'required' => true
                )) 
                ->add('description',null,array(
                    'label' => 'Opis',
                    'attr' => array(
                        'class' => 'ckeditor'
                    )
                ))
                ->add('details',null,array(
                    'label' => 'Szczegóły',
                    'attr' => array(
                        'class' => 'ckeditor'
                    )
                ))
                ->add('agent', null, array(
                    'label' => 'Agent',
                    'required' => true
                ))
                ->add('hotOffer', null, array(
                    'label' => 'Gorąca oferta?',
                    'required' => false
                ))
                ->add('published', null, array(
                    'label' => 'Opublikować?',
                    'required' => false
                ))
                ->add('rent', null, array(
                    'label' => 'Wynajem?',
                    'required' => false
                ))
                ->add('commition', null, array(
                    'label' => 'Bez prowizji?',
                    'required' => false
                ))
                ->add('video', null, array(
                    'label' => 'Link do filmu',
                    'required' => false
                ))
                ->add('discount', null, array(
                    'label' => 'Zniżka'
                ))
                ->add('water', 'choice', array(
                    'label' => 'Woda?',
                    'choices' => array(
                        'yes' => 'Tak',
                        'no' => 'Nie',
                        'process' => 'W drodze'
                    ),
                    'multiple' => false
                ))
                ->add('gas', 'choice', array(
                    'label' => 'Gaz?',
                    'choices' => array(
                        'yes' => 'Tak',
                        'no' => 'Nie',
                        'process' => 'W drodze'
                    ),
                    'multiple' => false
                ))
                ->add('sewerage', 'choice', array(
                    'label' => 'Kanalizacja?',
                    'choices' => array(
                        'yes' => 'Tak',
                        'no' => 'Nie',
                        'process' => 'W drodze'
                    ),
                    'multiple' => false
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
            'data_class' => 'Bit2Bit\OfferBundle\Entity\Offer'
        ));
    }

    /**
     * Metoda zwraca nazwę formularza.
     * 
     * @return string
     */
    public function getName() {
        return 'offer';
    }

}
