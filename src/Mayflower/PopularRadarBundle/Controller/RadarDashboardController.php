<?php

namespace Mayflower\PopularRadarBundle\Controller;

use Mayflower\PopularRadarBundle\Form\Data\BuzzwordFormData;
use Mayflower\PopularRadarBundle\Model\ResultMapping\FailedCompare;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * RadarDashboardController
 *
 * This controller handles the dashboard which can compare two buzzwords
 *
 * @author Maximilian Bosch <ma27.git@gmail.com>
 */
class RadarDashboardController extends Controller
{
    /**
     * Action which is responsible for the dashboard page
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Method({"GET", "POST"})
     * @Route("/")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $data = new BuzzwordFormData();
        $form = $this->createForm('mayflower_popular_radar_type', $data);

        $form->handleRequest($request);

        $responseData = array('form' => $form->createView());
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \Mayflower\PopularRadarBundle\Model\Comparison\BuzzwordDataComparator $comparator */
            $comparator     = $this->get('mayflower.popular_radar.comparator');
            $internalResult = $comparator->compareBuzzwords($data);

            if (count($internalResult) > 0) {
                $responseData['result'] = array_map(
                    function ($value) {
                        if ($value instanceof FailedCompare) {
                            return array(
                                'failed'      => true,
                                'error_model' => $value
                            );
                        }

                        /** @var \Mayflower\PopularRadarBundle\Model\ResultMapping\Buzzword[] $value */
                        $isFirstLarger = $value[0]->getCountLength() > $value[1]->getCountLength();
                        $isSame        = $value[1]->getCountLength() === $value[0]->getCountLength();

                        $firstBuzzword  =  $isFirstLarger ? $value[0] : $value[1];
                        $secondBuzzword = !$isFirstLarger ? $value[0] : $value[1];

                        return array(
                            'is_same'      => $isSame,
                            'first'        => $firstBuzzword->toArray(),
                            'second'       => $secondBuzzword->toArray(),
                            'display_name' => $firstBuzzword->getDisplayName(),
                            'failed'       => false
                        );
                    },
                    $internalResult
                );
            } else {
                $responseData['no_comparison'] = true;
            }
        }

        return $responseData;
    }
}
