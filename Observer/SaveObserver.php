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
use Aceextensions\B2bRegistration\Helper\Data;
use Aceextensions\B2bRegistration\Helper\Email;
use Aceextensions\B2bRegistration\Model\Config\Source\CustomerAttribute;
use Magento\Customer\Api\CustomerRepositoryInterface;

class SaveObserver implements ObserverInterface
{
    /**
     * @var Aceextensions\CustomerApproval\Helper\Data
     */
    protected $helper;
    /**
     * @var Aceextensions\CustomerApproval\Helper\Email
     */
    protected $emailHelper;
    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    protected $customerRepositoryInterface;

    /**
     * SaveObserver constructor.
     * @param Data $helper
     * @param Email $emailHelper
     * @param CustomerRepositoryInterface $customerRepositoryInterface
     */
    public function __construct (
        Data $helper,
        Email $emailHelper,
        CustomerRepositoryInterface $customerRepositoryInterface
    ) {
        $this->helper = $helper;
        $this->emailHelper = $emailHelper;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
    }


    /**
     * Send Email to customer when status is approval or reject
     * @param \Magento\Framework\Event\Observer $observer
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute (\Magento\Framework\Event\Observer $observer)
    {
        if ($this->helper->isEnable()) {
            if ($this->helper->isEnableCustomerEmail()) {
                $customer = $observer->getCustomer();
                if ($customer->getId()) {
                    $customerId = $customer->getId();
                    $currentCustomer = $this->customerRepositoryInterface->getById($customerId);
                    $oldStatus = $currentCustomer->getCustomAttribute('b2b_activasion_status');
                    if ($oldStatus) {
                        $oldStatus = $oldStatus->getValue();
                    } else {
                        $oldStatus = CustomerAttribute::NORMAL_ACCOUNT;
                    }
                    $newStatus = $customer->getData('b2b_activasion_status');
                    $customerEmail = $customer->getEmail();
                    $customerName = $customer->getName();
                    $storeId = $customer->getData('store_id');
                    if ($newStatus == CustomerAttribute::B2B_APPROVAL) {
                        if ($oldStatus == CustomerAttribute::B2B_PENDING || $oldStatus == CustomerAttribute::B2B_REJECT || $oldStatus == CustomerAttribute::NORMAL_ACCOUNT) {
                            $emailTemplate = $this->helper->getCustomerApproveEmailTemplate();
                            $this->emailHelper->sendEmail($customerEmail, $emailTemplate, $customerName, $storeId);
                        }
                    } elseif ($newStatus == CustomerAttribute::B2B_REJECT) {
                        if ($oldStatus == CustomerAttribute::B2B_PENDING || $oldStatus == CustomerAttribute::B2B_APPROVAL || $oldStatus == CustomerAttribute::NORMAL_ACCOUNT) {
                            $emailTemplate = $this->helper->getCustomerRejectEmailTemplate();
                            $this->emailHelper->sendEmail($customerEmail, $emailTemplate, $customerName, $storeId);
                        }
                    }
                }
            }
        }
    }
}
