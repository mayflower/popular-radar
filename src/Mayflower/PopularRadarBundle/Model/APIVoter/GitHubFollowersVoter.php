<?php

namespace Mayflower\PopularRadarBundle\Model\APIVoter;

use Mayflower\PopularRadarBundle\Exception\NoResultsException;
use Mayflower\PopularRadarBundle\Form\Data\BuzzwordFormData;
use Mayflower\PopularRadarBundle\Model\Comparison\Strategy\StrategyInterface;
use Mayflower\PopularRadarBundle\Model\ResultMapping\Buzzword;

/**
 * GitHubFollowersVoter
 *
 * A voter that compares the amount of followers
 *
 * @author Maximilian Bosch <ma27.git@gmail.com>
 */
class GitHubFollowersVoter extends AbstractVoter implements StrategyInterface
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
        $type = 'followers(s) on GitHub';

        $buzzword1 = $this->getGitHubProfile($formData->getBuzzword1());
        $buzzword2 = $this->getGitHubProfile($formData->getBuzzword2());

        return array(
            new Buzzword(
                $buzzword1['login'],
                $buzzword1['followers'],
                $type,
                $this->getDisplayAlias()
            ),
            new Buzzword(
                $buzzword2['login'],
                $buzzword2['followers'],
                $type,
                $this->getDisplayAlias()
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDisplayAlias()
    {
        return 'GitHub Followers';
    }

    /**
     * Loads the github profile of a specific user
     *
     * @param string $name
     *
     * @return array
     */
    private function getGitHubProfile($name)
    {
        $client  = $this->getClient();
        $request = $client->createRequest('GET', sprintf('https://api.github.com/search/users?q=%s', $name));

        $response = $client->send($request)->json();
        if ($response['total_count'] === 0) {
            throw new NoResultsException;
        }

        $userTarget = $response['items'][0]['url'];
        $request    = $client->createRequest('GET', $userTarget);
        $response   = $client->send($request)->json();

        return $response;
    }
}
