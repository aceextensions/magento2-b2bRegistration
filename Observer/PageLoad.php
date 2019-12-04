<?php
/**
 * Ace Extensions
 *
 * @category   Ace
 * @package    Ace_B2bRegistration
 * @author     Durga Shankar Gupta (dsguptas@gmail.com)
 * @copyright  Copyright (c) 2019 Ace Extensions ( http://aceextensions.com )
 */

namespace Ace\B2bRegistration\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Ace\B2bRegistration\Model\Config\Source\CustomerAttribute;

class PageLoad implements ObserverInterface
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;
    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    protected $customerRepositoryInterface;
    /**
     * @var \Ace\B2bRegistration\Helper\Data
     */
    protected $helper;
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * PageLoad constructor.
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
     * @param \Ace\B2bRegistration\Helper\Data $helper
     * @param LoggerInterface $logger
     */
    public function __construct (
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        \Ace\B2bRegistration\Helper\Data $helper,
        LoggerInterface $logger
    ) {
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->customerSession = $customerSession;
        $this->helper = $helper;
        $this->logger = $logger;
    }

    /**
     * Force Login Customer When admin change account status to Reject
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute (\Magento\Framework\Event\Observer $observer)
    {
        if ($this->helper->isEnable()) {
            try {
                $customerId = $this->customerSession->getCustomerId();
                $customer = $this->customerRepositoryInterface->getById($customerId);
                $customerAttr = $customer->getCustomAttribute('b2b_activasion_status');
                if ($customerAttr) {
                    $customerValue = $customerAttr->getValue();
                    if ($customerValue == CustomerAttribute::B2B_REJECT) {
                        $this->customerSession->logout();
                    }
                }
            } catch (\Exception $e) {
                $this->logger->debug($e->getMessage());
            }
        }
    }
}
