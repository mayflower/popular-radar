<?php

namespace Mayflower\PopularRadarBundle\Tests\DependencyInjection\Compiler;

use Mayflower\PopularRadarBundle\DependencyInjection\Compiler\AddStrategyToStoragePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class AddStrategyToStoragePassTest extends \PHPUnit_Framework_TestCase
{
    public function testInjectStrategy()
    {
        $guzzleClientDefinition = new Definition('GuzzleHttp\\Client');
        $storageDefinition      = new Definition(
            'Mayflower\\PopularRadarBundle\\Model\\Comparison\\Strategy\\StrategyStorage'
        );

        $strategyMock = $this->getMock(
            'Mayflower\\PopularRadarBundle\\Model\\Comparison\\Strategy\\StrategyInterface'
        );
        $mockDefinition = new Definition(get_class($strategyMock));
        $mockDefinition->addTag('radar.voter');

        $builder = new ContainerBuilder();
        $builder->setDefinitions(
            array(
                'mayflower.popular_radar.strategy_storage'   => $storageDefinition,
                'mayflower.popular_radar.guzzle.http_client' => $guzzleClientDefinition,
                'mayflower.popular_radar.example_voter'      => $mockDefinition
            )
        );

        $this->assertCount(0, $builder->getDefinition('mayflower.popular_radar.example_voter')->getMethodCalls());

        $compiler = new AddStrategyToStoragePass();
        $compiler->process($builder);

        $builtStorageDefinition = $builder->getDefinition('mayflower.popular_radar.strategy_storage');
        $this->assertCount(1, $builtStorageDefinition->getMethodCalls());

        $calls = $builtStorageDefinition->getMethodCalls();
        $first = $calls[0];

        $this->assertSame('addStrategy', $first[0]);
        $this->assertSame('mayflower.popular_radar.example_voter', (string) $first[1][0]);

        $this->assertCount(1, $builder->getDefinition('mayflower.popular_radar.example_voter')->getMethodCalls());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Strategy must implement "Mayflower\PopularRadarBundle\Model\Comparison\Strategy\StrategyInterface"!
     */
    public function testInvalidStrategy()
    {
        $storageDefinition      = new Definition(
            'Mayflower\\PopularRadarBundle\\Model\\Comparison\\Strategy\\StrategyStorage'
        );

        $mockDefinition = new Definition('Mayflower\\PopularRadarBundle\\Model\\Comparison\\Strategy\\StrategyStorage');
        $mockDefinition->addTag('radar.voter');

        $builder = new ContainerBuilder();
        $builder->setDefinitions(
            array(
                'mayflower.popular_radar.strategy_storage' => $storageDefinition,
                'mayflower.popular_radar.example_voter'    => $mockDefinition
            )
        );

        $compiler = new AddStrategyToStoragePass();
        $compiler->process($builder);
    }
}
