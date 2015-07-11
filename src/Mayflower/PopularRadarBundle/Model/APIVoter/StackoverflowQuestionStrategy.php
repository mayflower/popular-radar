<?php

namespace Mayflower\PopularRadarBundle\Model\APIVoter;

use Mayflower\PopularRadarBundle\Exception\NoResultsException;
use Mayflower\PopularRadarBundle\Form\Data\BuzzwordFormData;
use Mayflower\PopularRadarBundle\Model\Comparison\Strategy\StrategyInterface;
use Mayflower\PopularRadarBundle\Model\ResultMapping\Buzzword;

/**
 * StackoverflowQuestionStrategy
 *
 * Compares questions on stackoverflow
 *
 * @author Maximilian Bosch <ma27.git@gmail.com>
 */
class StackoverflowQuestionStrategy extends AbstractVoter implements StrategyInterface
{
    /**
     * {@inheritdoc}
     */
    public function supports(BuzzwordFormData $formData)
    {
        return in_array($this->getDisplayAlias(), $formData->getStrategies());
    }

    /**
     * {@inheritdoc}
     */
    public function apply(BuzzwordFormData $formData)
    {
        $type = 'question(s)';

        $buzzword1 = $this->findTagFromStackOverflow($formData->getBuzzword1());
        $buzzword2 = $this->findTagFromStackOverflow($formData->getBuzzword2());

        return array(
            new Buzzword($buzzword1['name'], $buzzword1['count'], $type, $this->getDisplayAlias()),
            new Buzzword($buzzword2['name'], $buzzword2['count'], $type, $this->getDisplayAlias())
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDisplayAlias()
    {
        return 'Stackoverflow Questions';
    }

    /**
     * Finds tag data of stack overflow
     *
     * @param string $buzzword
     *
     * @return array
     *
     * @throws NoResultsException If a specific tag could not be found
     */
    private function findTagFromStackOverflow($buzzword)
    {
        $client  = $this->getClient();
        $request = $client->createRequest(
            'GET',
            sprintf(
                'http://api.stackexchange.com/2.2/tags?order=desc&sort=popular&inname=%s&site=stackoverflow',
                $buzzword
            )
        );

        $tagList = $client->send($request)->json();

        if (count($tagList['items']) === 0) {
            throw new NoResultsException;
        }

        return $tagList['items'][0];
    }
}
