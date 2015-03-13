<?php

namespace Mayflower\PopularRadarBundle\Service\Strategy;

use Guzzle\Http\Client;
use Mayflower\PopularRadarBundle\Form\Data\BuzzwordFormData;

/**
 * GoogleTrendsStrategy
 *
 * Strategy which reads data from google trends
 *
 * @author Maximilian Bosch <ma27.git@gmail.com>
 */
class GoogleTrendsStrategy implements StrategyInterface
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
        return $formData->isGoogleTrends();
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
        $data = $this->client->get(
            sprintf(
                'http://www.google.com/trends/fetchComponent?%s',
                http_build_query(array(
                    'q'      => implode(', ', array($formData->getBuzzword1(), $formData->getBuzzword2())),
                    'cid'    => 'TIMESERIES_GRAPH_0',
                    'export' => 3
                ))
            )
        )->send();

        $content = $data->getBody();

        $result = explode('|', preg_replace('\{\"c\"\:(.*)\}\,\{\"c\"', '$1|', $content));
        var_dump($result);
    }
}
