<?php

namespace Mayflower\PopularRadarBundle\Tests\Model\Comparison;

use Mayflower\PopularRadarBundle\Exception\NoResultsException;
use Mayflower\PopularRadarBundle\Form\Data\BuzzwordFormData;
use Mayflower\PopularRadarBundle\Model\Comparison\BuzzwordDataComparator;
use Mayflower\PopularRadarBundle\Model\Comparison\Strategy\StrategyStorage;
use Mayflower\PopularRadarBundle\Model\ResultMapping\Buzzword;

class BuzzwordDataComparatorTest extends \PHPUnit_Framework_TestCase
{
    public function testRunStrategies()
    {
        $strategy1 = $this->getMock('Mayflower\\PopularRadarBundle\\Model\\Comparison\\Strategy\\StrategyInterface');
        $strategy1
            ->expects($this->any())
            ->method('supports')
            ->will($this->returnValue(true))
        ;

        $strategy1
            ->expects($this->once())
            ->method('apply')
            ->will($this->returnValue(
                array(
                    new Buzzword('foo', 12, 'GitHub Forks', 'GitHub Forks'),
                    new Buzzword('bar', 10, 'GitHub Forks', 'GitHub Forks')
                )
            ))
        ;

        $strategy1
            ->expects($this->any())
            ->method('getDisplayAlias')
            ->will($this->returnValue('GitHub Forks'))
        ;

        $strategy2 = $this->getMock('Mayflower\\PopularRadarBundle\\Model\\Comparison\\Strategy\\StrategyInterface');
        $strategy2
            ->expects($this->any())
            ->method('supports')
            ->will($this->returnValue(false))
        ;

        $strategy2
            ->expects($this->never())
            ->method('apply')
        ;

        $storage = new StrategyStorage();
        $storage->addStrategy($strategy1);
        $storage->addStrategy($strategy2);

        $formData = new BuzzwordFormData();
        $formData->setBuzzword1('foo');
        $formData->setBuzzword2('bar');
        $formData->setStrategies(array('GitHub Forks'));

        $comparator = new BuzzwordDataComparator($storage);
        $result     = $comparator->compareBuzzwords($formData);

        $this->assertCount(1, $result);
        $this->assertInstanceOf('Mayflower\\PopularRadarBundle\\Model\\ResultMapping\\Buzzword', $result[0][0]);
        $this->assertInstanceOf('Mayflower\\PopularRadarBundle\\Model\\ResultMapping\\Buzzword', $result[0][1]);
    }

    public function testStrategyError()
    {
        $strategy1 = $this->getMock('Mayflower\\PopularRadarBundle\\Model\\Comparison\\Strategy\\StrategyInterface');
        $strategy1
            ->expects($this->any())
            ->method('supports')
            ->will($this->returnValue(true))
        ;

        $strategy1
            ->expects($this->once())
            ->method('apply')
            ->will(
                $this->returnCallback(
                    function () {
                        throw new NoResultsException;
                    }
                )
            )
        ;

        $strategy1
            ->expects($this->any())
            ->method('getDisplayAlias')
            ->will($this->returnValue('GitHub Forks'))
        ;

        $storage = new StrategyStorage();
        $storage->addStrategy($strategy1);

        $formData = new BuzzwordFormData();
        $formData->setBuzzword1('foo');
        $formData->setBuzzword2('bar');

        $comparator = new BuzzwordDataComparator($storage);
        $result     = $comparator->compareBuzzwords($formData);

        $this->assertCount(1, $result);

        $first = $result[0];
        $this->assertInstanceOf('Mayflower\\PopularRadarBundle\\Model\\ResultMapping\\FailedCompare', $first);

        $this->assertSame('GitHub Forks', $first->getDisplayName());
    }
}
