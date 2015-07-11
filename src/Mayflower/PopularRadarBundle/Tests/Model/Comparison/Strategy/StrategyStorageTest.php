<?php

namespace Mayflower\PopularRadarBundle\Tests\Model\Comparison\Strategy;

use Mayflower\PopularRadarBundle\Model\Comparison\Strategy\StrategyStorage;

class StrategyStorageTest extends \PHPUnit_Framework_TestCase
{
    public function testAddStrategy()
    {
        $storage = new StrategyStorage();
        $mock    = $this->getMock('Mayflower\\PopularRadarBundle\\Model\\Comparison\\Strategy\\StrategyInterface');

        $storage->addStrategy($mock);
        $this->assertContains($mock, $storage->getStrategies());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage There's already a strategy named "GitHub Stargazers"!
     */
    public function testAddStrategyTwice()
    {
        $storage = new StrategyStorage();
        $mock    = $this->getMock('Mayflower\\PopularRadarBundle\\Model\\Comparison\\Strategy\\StrategyInterface');

        $mock
            ->expects($this->any())
            ->method('getDisplayAlias')
            ->will($this->returnValue('GitHub Stargazers'))
        ;

        $storage->addStrategy($mock);
        $storage->addStrategy($mock);
    }
}
