<?php

namespace ConferenceSchedulerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use ConferenceSchedulerBundle\Entity\Conference;

class ConferenceType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('title')
                ->add('description')
                ->add('image')
                ->add('access', ChoiceType::class, [
                    'choices' => [
                        'Open' => 1,
                        'Particular' => 2,
                    ]
                ])
                ->add('price', MoneyType::class)
                ->add('hall')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Conference::class
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'conferenceschedulerbundle_conference';
    }

}
