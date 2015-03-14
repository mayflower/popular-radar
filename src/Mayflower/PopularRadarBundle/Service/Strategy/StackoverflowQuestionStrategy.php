<?php

namespace Mayflower\PopularRadarBundle\Service\Strategy;

use Guzzle\Http\Client;
use Mayflower\PopularRadarBundle\Exception\NoResultsException;
use Mayflower\PopularRadarBundle\Form\Data\BuzzwordFormData;
use Mayflower\PopularRadarBundle\Model\Buzzword;

/**
 * StackoverflowQuestionStrategy
 *
 * Strategy which compares stackoverflow questions
 * @author Maximilian Bosch <ma27.git@gmail.com>
 */
class StackoverflowQuestionStrategy implements StrategyInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * {@inheritdoc}
     */
    public function supports(BuzzwordFormData $formData)
    {
        return $formData->isStackoverflowQuestions();
    }

    /**
     * {@inheritdoc}
     */
    public function setHttpClient(Client $client)
    {
        $this->client = $client;
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
            new Buzzword($buzzword1['name'], $buzzword1['count'], $type),
            new Buzzword($buzzword2['name'], $buzzword2['count'], $type)
        );
    }

    /**
     * Finds tag data of stack overflow
     *
     * @param string $buzzword
     *
     * @return array
     */
    private function findTagFromStackOverflow($buzzword)
    {
        $tagList = json_decode(gzdecode($this->client->get(
            sprintf(
                'http://api.stackexchange.com/2.2/tags?order=desc&sort=popular&inname=%s&site=stackoverflow',
                $buzzword
            )
        )->send()->getBody(true)), true);

        if (count($tagList['items']) === 0) {
            throw new NoResultsException;
        }

        return $tagList['items'][0];
    }
}
