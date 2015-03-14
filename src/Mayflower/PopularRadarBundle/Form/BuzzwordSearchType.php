<?php

namespace Mayflower\PopularRadarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * BuzzwordSearchType
 *
 * Form type which contains the form elements for the buzzword search
 *
 * @author Maximilian Bosch <ma27.git@gmail.com>
 */
class BuzzwordSearchType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'mayflower_popular_radar_type';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('buzzword1', 'text', array('label' => 'First Buzzword'))
            ->add('buzzword2', 'text', array('label' => 'Second Buzzword'))
            ->add('githubForks', 'checkbox', array('label' => 'Compare GitHub Forks', 'required' => false))
            ->add(
                'stackoverflowQuestions',
                'checkbox',
                array('label' => 'Compare Stackoverflow questions', 'required' => false)
            )
        ;
    }
}
