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
        return $formData->isGithubStars();
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
        $type = 'star(s)';

        $buzzword1 = $this->findStarsFromRepository($formData->getBuzzword1());
        $buzzword2 = $this->findStarsFromRepository($formData->getBuzzword2());

        return array(
            new Buzzword($formData->getBuzzword1(), $buzzword1, $type),
            new Buzzword($formData->getBuzzword2(), $buzzword2, $type)
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
    private function findStarsFromRepository($buzzword)
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

        return count(
            $this->client->get(
                sprintf('https://api.github.com/repos/%s/%s/stargazers', $first['owner']['login'], $first['name'])
            )->send()->json()
        );
    }
}
