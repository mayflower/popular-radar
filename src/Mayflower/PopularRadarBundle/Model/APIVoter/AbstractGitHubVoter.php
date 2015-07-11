<?php

namespace Mayflower\PopularRadarBundle\Model\APIVoter;

use Mayflower\PopularRadarBundle\Exception\NoResultsException;

/**
 * AbstractGitHubVoter
 *
 * Base class for voters using github
 *
 * @author Maximilian Bosch <ma27.git@gmail.com>
 */
abstract class AbstractGitHubVoter extends AbstractVoter
{
    /**
     * Finds a repository from github
     *
     * @param string $buzzword
     *
     * @return integer
     *
     * @throws NoResultsException
     */
    protected function findRepository($buzzword)
    {
        $client  = $this->getClient();
        $request = $client->createRequest(
            'GET',
            sprintf(
                'https://api.github.com/search/repositories?%s',
                http_build_query(array('q' => $buzzword))
            )
        );

        $response = $client->send($request)->json();

        if ($response['total_count'] === 0) {
            throw new NoResultsException;
        }

        $first = $response['items'][0];

        return $first;
    }
}
