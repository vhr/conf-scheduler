<?php

namespace ConferenceSchedulerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use ConferenceSchedulerBundle\Entity\ConferenceProgram;

class ConferenceProgramType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name')
                ->add('start', TimeType::class)
                ->add('end', TimeType::class)
//                ->add('description')
//                ->add('access', ChoiceType::class, [
//                    'choices' => [
//                        'Open' => 1,
//                        'Particular' => 2,
//                    ]
//                ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => ConferenceProgram::class
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'conferenceschedulerbundle_conference_program';
    }

}
