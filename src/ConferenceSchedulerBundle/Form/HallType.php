<?php

namespace ConferenceSchedulerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use ConferenceSchedulerBundle\Entity\Hall;
use ConferenceSchedulerBundle\Form\GoodsType;

class HallType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name')
                ->add('userLimit')
                ->add('image')
                ->add('description')
                ->add('goods', CollectionType::class, [
                    'entry_type' => GoodsType::class,
                    'allow_add' => true,
                ])
//                ->add('goods')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Hall::class
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'conferenceschedulerbundle_hall';
    }

}
