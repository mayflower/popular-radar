<?php

namespace Mayflower\PopularRadarBundle\Model\APIVoter;

use Mayflower\PopularRadarBundle\Form\Data\BuzzwordFormData;
use Mayflower\PopularRadarBundle\Model\Comparison\Strategy\StrategyInterface;
use Mayflower\PopularRadarBundle\Model\ResultMapping\Buzzword;

/**
 * PackagistDownloadsVoter
 *
 * A voter that compares the downloads on packagist
 *
 * @author Maximilian Bosch <ma27.git@gmail.com>
 */
class PackagistDownloadsVoter extends AbstractPackagistVoter implements StrategyInterface
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
        $resultTypeName = 'download(s) at Packagist';

        $package1 = $this->findPackage($formData->getBuzzword1());
        $package2 = $this->findPackage($formData->getBuzzword2());

        return array(
            new Buzzword($package1['name'], $package1['downloads'], $resultTypeName, $this->getDisplayAlias()),
            new Buzzword($package2['name'], $package2['downloads'], $resultTypeName, $this->getDisplayAlias())
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDisplayAlias()
    {
        return 'Downloads at Packagist';
    }
}
