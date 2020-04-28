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
use Magento\Customer\Api\CustomerRepositoryInterface;
use Aceextensions\B2bRegistration\Helper\Data;
use Psr\Log\LoggerInterface;
use Aceextensions\B2bRegistration\Model\Config\Source\CustomerAttribute;

class UpgradeStatusObserver implements ObserverInterface
{
    /**
     * @var Magento\Customer\Api\CustomerRepositoryInterface
     */
    protected $customerRepository;
    /**
     * @var Magento\Customer\Model\Session
     */
    protected $helper;
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * UpgradeStatusObserver constructor.
     * @param CustomerRepositoryInterface $customerRepository
     * @param Data $helper
     * @param LoggerInterface $logger
     */
    public function __construct (
        CustomerRepositoryInterface $customerRepository,
        Data $helper,
        LoggerInterface $logger
    ) {
        $this->customerRepository = $customerRepository;
        $this->helper = $helper;
        $this->logger = $logger;
    }

    /**
     * Set Normal status to normal account
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute (\Magento\Framework\Event\Observer $observer)
    {
        if ($this->helper->isEnable()) {
            try {
                $customer = $observer->getCustomer();
                $customer->setCustomAttribute("b2b_activasion_status", CustomerAttribute::NORMAL_ACCOUNT);
                $this->customerRepository->save($customer);
            } catch (\Exception $e) {
                $this->logger->debug($e->getMessage());
            }
        }
    }
}
