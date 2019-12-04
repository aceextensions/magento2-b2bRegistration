<?php
/**
 * Ace Extensions
 *
 * @category   Ace
 * @package    Ace_B2bRegistration
 * @author     Durga Shankar Gupta (dsguptas@gmail.com)
 * @copyright  Copyright (c) 2019 Ace Extensions ( http://aceextensions.com )
 */

namespace Ace\B2bRegistration\Plugin;

use Magento\Framework\UrlInterface;
use Ace\B2bRegistration\Helper\Data;

class CustomerListing
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;
    /**
     * @var Data
     */
    protected $helper;

    /**
     * CustomerListing constructor.
     * @param UrlInterface $urlBuilder
     * @param Data $helper
     */
    public function __construct (
        UrlInterface $urlBuilder,
        Data $helper
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->helper = $helper;
    }

    /**
     * Create Massaction in Admin
     * @param \Magento\Framework\View\Layout\Generic $subject
     * @param \Closure $proceed
     * @param string $component
     * @return array|mixed
     */
    public function aroundBuild (\Magento\Framework\View\Layout\Generic $subject, \Closure $proceed, $component)
    {
        if ($this->helper->isEnable()) {
            if ($component->getName() == 'customer_listing') {
                $result = $proceed($component);
                if (is_array($result)) {
                    if (isset($result['components']['customer_listing']['children']['customer_listing']['children']
                        ['listing_top']['children']['listing_massaction'])) {
                        $approveUrl = $this->urlBuilder->getUrl(
                            'b2b/index/massApproved',
                            $paramsHere = []
                        );
                        $disApproveUrl = $this->urlBuilder->getUrl(
                            'b2b/index/massDisapproved',
                            $paramsHere = []
                        );
                        $approvedAction = [
                            'component' => 'uiComponent',
                            'type' => 'approved',
                            'label' => 'Approved Customer(s)',
                            'url' => $approveUrl,
                            'confirm' => [
                                'title' => 'Approved Customer(s)',
                                'message' => __('Are you sure to Approved selected customers ?')
                            ]
                        ];

                        $disApprovedAction = [
                            'component' => 'uiComponent',
                            'type' => 'disapproved',
                            'label' => 'Reject Customer(s)',
                            'url' => $disApproveUrl,
                            'confirm' => [
                                'title' => 'Reject Customer(s)',
                                'message' => __('Are you sure to Reject selected customers ?')
                            ]
                        ];

                        $result['components']['customer_listing']['children']['customer_listing']['children']
                        ['listing_top']['children']['listing_massaction']['config']['actions'][] = $approvedAction;

                        $result['components']['customer_listing']['children']['customer_listing']['children']
                        ['listing_top']['children']['listing_massaction']['config']['actions'][] = $disApprovedAction;
                    }
                }
            }
        }
        if (isset($result)) {
            return $result;
        }
        return $proceed($component);
    }
}
