<?php

namespace Mayflower\PopularRadarBundle\Form\Type;

use Mayflower\PopularRadarBundle\Model\Comparison\Strategy\StrategyInterface;
use Mayflower\PopularRadarBundle\Model\Comparison\Strategy\StrategyStorage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
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
     * @var StrategyInterface[]
     */
    private $strategies = array();

    /**
     * Constructor
     *
     * @param StrategyStorage $storage
     */
    public function __construct(StrategyStorage $storage)
    {
        $this->strategies = $storage->getStrategies();
    }

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
        $buzzwordComparisonLabels = array_map(
            function (StrategyInterface $strategy) {
                return $strategy->getDisplayAlias();
            },
            $this->strategies
        );

        $builder
            ->add('buzzword1', 'text', array('label' => 'First Buzzword'))
            ->add('buzzword2', 'text', array('label' => 'Second Buzzword'))
            ->add('strategies', 'choice', array(
                'choice_list' => new ChoiceList($buzzwordComparisonLabels, $buzzwordComparisonLabels),
                'multiple'    => true,
                'expanded'    => true
            ))
        ;
    }
}
