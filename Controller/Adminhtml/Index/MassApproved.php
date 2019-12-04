<?php
/**
 * Ace Extensions
 *
 * @category   Ace
 * @package    Ace_B2bRegistration
 * @author     Durga Shankar Gupta (dsguptas@gmail.com)
 * @copyright  Copyright (c) 2019 Ace Extensions ( http://aceextensions.com )
 */

namespace Ace\B2bRegistration\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;
use Magento\Eav\Model\Entity\Collection\AbstractCollection;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Controller\ResultFactory;
use Psr\Log\LoggerInterface;
use Ace\B2bRegistration\Model\Config\Source\CustomerAttribute;

/**
 * Class MassApproved
 * @package Ace\B2bRegistration\Controller\Adminhtml\Index
 */
class MassApproved extends \Magento\Customer\Controller\Adminhtml\Index\AbstractMassAction
{
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * MassApproved constructor.
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param CustomerRepositoryInterface $customerRepository
     * @param LoggerInterface $logger
     */
    public function __construct (
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        CustomerRepositoryInterface $customerRepository,
        LoggerInterface $logger
    ) {
        parent::__construct($context, $filter, $collectionFactory);
        $this->customerRepository = $customerRepository;
        $this->logger = $logger;
    }

    /**
     * Mass Approval
     * @param AbstractCollection $collection
     * @return \Magento\Backend\Model\View\Result\Redirect $resultRedirect
     */
    protected function massAction (AbstractCollection $collection)
    {
        try {
            $customersUpdated = 0;
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            foreach ($collection->getAllIds() as $customerId) {
                // Verify customer exists
                $customer = $this->customerRepository->getById($customerId);
                $customer->setCustomAttribute("b2b_activasion_status", CustomerAttribute::B2B_APPROVAL);
                $this->saveAttribute($customer);
                $customersUpdated++;
            }
            if ($customersUpdated) {
                // @codingStandardsIgnoreStart
                $this->messageManager->addSuccessMessage(__('A total of %1 record(s) were updated.',
                    $customersUpdated));
                // @codingStandardsIgnoreEnd
            }
            /* @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setPath($this->getComponentRefererUrl());

            return $resultRedirect;
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }

    /**
     * Save Customer
     * @param object $customer
     * @return \Magento\Customer\Api\Data\CustomerInterface
     */
    protected function saveAttribute ($customer)
    {
        return $this->customerRepository->save($customer);
    }

    /**
     * @return bool
     */
    protected function _isAllowed ()
    {
        return $this->_authorization->isAllowed('Ace_B2bRegistration::b2bregistration_approval');
    }
}
