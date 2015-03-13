<?php

namespace Mayflower\PopularRadarBundle\Service\Strategy;

use Guzzle\Http\Client;
use Mayflower\PopularRadarBundle\Exception\NoResultsException;
use Mayflower\PopularRadarBundle\Form\Data\BuzzwordFormData;
use Mayflower\PopularRadarBundle\Model\Buzzword;

/**
 * GitHubStarsStrategy
 *
 * Compares the buzzwords by the git stars
 *
 * @author Maximilian Bosch <ma27.git@gmail.com>
 */
class GitHubForksStrategy implements StrategyInterface
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
        return $formData->isGithubForks();
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
        $type = 'fork(s)';

        $buzzword1 = $this->findRepository($formData->getBuzzword1());
        $buzzword2 = $this->findRepository($formData->getBuzzword2());

        return array(
            new Buzzword($buzzword1['owner']['login'] . '/' . $buzzword1['name'], $buzzword1['forks_count'], $type),
            new Buzzword($buzzword2['owner']['login'] . '/' . $buzzword2['name'], $buzzword2['forks_count'], $type)
        );
    }

    /**
     * Finds a repository from github
     *
     * @param string $buzzword
     *
     * @return integer
     *
     * @throws NoResultsException
     */
    private function findRepository($buzzword)
    {
        $request = $this->client->get(
            sprintf(
                'https://api.github.com/search/repositories?%s',
                http_build_query(array('q' => $buzzword))
            )
        );
        $response = $request->send()->json();

        if ($response['total_count'] === 0) {
            throw new NoResultsException;
        }

        $first = $response['items'][0];

        return $first;
    }
}
