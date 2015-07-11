<?php

namespace Mayflower\PopularRadarBundle\Model\APIVoter;

use GuzzleHttp\Client;

/**
 * AbstractVoter
 *
 * Voter base class
 *
 * @author Maximilian Bosch <ma27.git@gmail.com>
 */
abstract class AbstractVoter
{
    /**
     * @var Client
     */
    private $client;

    /**
     * {@inheritdoc}
     */
    public function setHttpClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Returns the client
     *
     * @return Client
     */
    protected function getClient()
    {
        return $this->client;
    }
}
