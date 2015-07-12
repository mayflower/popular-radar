<?php

namespace Mayflower\PopularRadarBundle\Model\APIVoter;

use Mayflower\PopularRadarBundle\Form\Data\BuzzwordFormData;
use Mayflower\PopularRadarBundle\Model\Comparison\Strategy\StrategyInterface;
use Mayflower\PopularRadarBundle\Model\ResultMapping\Buzzword;

/**
 * GitHubForksStrategy
 *
 * Strategy that compares github forks
 *
 * @author Maximilian Bosch <ma27.git@gmail.com>
 */
class GitHubForksStrategy extends AbstractGitHubVoter implements StrategyInterface
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
        $type = 'fork(s) on GitHub';

        $buzzword1 = $this->findRepositoryBySearchTerm($formData->getBuzzword1());
        $buzzword2 = $this->findRepositoryBySearchTerm($formData->getBuzzword2());

        return array(
            new Buzzword(
                $buzzword1['owner']['login'] . '/' . $buzzword1['name'],
                $buzzword1['forks_count'],
                $type,
                $this->getDisplayAlias()
            ),
            new Buzzword(
                $buzzword2['owner']['login'] . '/' . $buzzword2['name'],
                $buzzword2['forks_count'],
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
        return 'GitHub Forks';
    }
}
