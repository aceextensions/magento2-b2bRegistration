<?php
/**
 * Aceextensions Extensions
 *
 * @category   Aceextensions
 * @package    Aceextensions_B2bRegistration
 * @author     Durga Shankar Gupta (dsguptas@gmail.com)
 * @copyright  Copyright (c) 2019 Aceextensions Extensions ( http://aceextensions.com )
 */

namespace Aceextensions\B2bRegistration\Observer;

use Magento\Framework\Event\ObserverInterface;

class RedirectB2bUrl implements ObserverInterface
{
    /**
     * @var \Aceextensions\B2bRegistration\Helper\Data
     */
    private $helper;

    /**
     * RedirectB2bUrl constructor.
     * @param \Aceextensions\B2bRegistration\Helper\Data $helper
     */
    public function __construct (
        \Aceextensions\B2bRegistration\Helper\Data $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * Redirect to b2b/account/create
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute (\Magento\Framework\Event\Observer $observer)
    {
        $enable = $this->helper->isEnable();
        if ($enable) {
            $request = $observer->getData('request');
            $bbUrl = $this->helper->getB2bUrl();
            $urlRequest = $request->getOriginalPathInfo();
            $urlRequest = str_replace('/', '', $urlRequest);
            $urlRequest = str_replace('.html', '', $urlRequest);
            if ($bbUrl == $urlRequest) {
                $controllerRequest = $observer->getData('controller_action')->getRequest();
                $controllerRequest->initForward();
                $controllerRequest->setModuleName('b2b');
                $controllerRequest->setControllerName('account');
                $controllerRequest->setActionName('create');
                $controllerRequest->setDispatched(false);
            }
        }
    }
}
