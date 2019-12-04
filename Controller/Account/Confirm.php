<?php
/**
 * Ace Extensions
 *
 * @category   Ace
 * @package    Ace_B2bRegistration
 * @author     Durga Shankar Gupta (dsguptas@gmail.com)
 * @copyright  Copyright (c) 2019 Ace Extensions ( http://aceextensions.com )
 */

namespace Ace\B2bRegistration\Controller\Account;

use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Helper\Address;
use Magento\Framework\UrlFactory;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Ace\B2bRegistration\Helper\Data;
use Magento\Customer\Model\Metadata\ElementFactory;
use Magento\Framework\Exception\StateException;
use Ace\B2bRegistration\Model\Config\Source\CustomerAttribute;

/**
 * Class Confirm
 * @package Ace\B2bRegistration\Controller\Account
 */
class Confirm extends \Magento\Customer\Controller\Account\Confirm
{
    /**
     * @var Magento\Framework\App\Action\Context
     */
    protected $context;
    /**
     * @var Magento\Customer\Model\Session
     */
    protected $customerSession;
    /**
     * @var Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var Magento\Customer\Api\AccountManagementInterface
     */
    protected $customerAccountManagement;
    /**
     * @var Magento\Customer\Api\CustomerRepositoryInterface
     */
    protected $customerRepository;
    /**
     * @var Magento\Customer\Helper\Address
     */
    protected $addressHelper;
    /**
     * @var Magento\Framework\UrlFactory
     */
    protected $urlFactory;
    /**
     * @var Magento\Framework\Controller\ResultFactory
     */
    protected $resultFactory;
    /**
     * @var Ace\CustomerApproval\Helper\Data
     */
    protected $helper;
    /**
     * @var ElementFactory
     */
    protected $metadataElement;
    /**
     * @var \Magento\Customer\Api\CustomerMetadataInterface
     */
    protected $customerMetaData;

    /**
     * Confirm constructor.
     * @param Context $context
     * @param Session $customerSession
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param AccountManagementInterface $customerAccountManagement
     * @param CustomerRepositoryInterface $customerRepository
     * @param Address $addressHelper
     * @param UrlFactory $urlFactory
     * @param Redirect $resultFactory
     * @param Data $helper
     * @param ElementFactory $metadataElement
     * @param \Magento\Customer\Api\CustomerMetadataInterface $customerMetaData
     */
    public function __construct (
        Context $context,
        Session $customerSession,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        AccountManagementInterface $customerAccountManagement,
        CustomerRepositoryInterface $customerRepository,
        Address $addressHelper,
        UrlFactory $urlFactory,
        Redirect $resultFactory,
        Data $helper,
        ElementFactory $metadataElement,
        \Magento\Customer\Api\CustomerMetadataInterface $customerMetaData
    ) {
        parent::__construct(
            $context,
            $customerSession,
            $scopeConfig,
            $storeManager,
            $customerAccountManagement,
            $customerRepository,
            $addressHelper,
            $urlFactory
        );
        $this->helper = $helper;
        $this->metadataElement = $metadataElement;
        $this->customerMetaData = $customerMetaData;
    }

    /**
     * @return Redirect
     */
    public function execute ()
    {
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        if ($this->session->isLoggedIn()) {
            $resultRedirect->setPath('*/*/');
            return $resultRedirect;
        }
        try {
            $customerId = $this->getRequest()->getParam('id', false);
            $key = $this->getRequest()->getParam('key', false);
            if (empty($customerId) || empty($key)) {
                throw new \Exception(__('Bad request.'));
            }

            // log in and send greeting email
            $customerEmail = $this->customerRepository->getById($customerId)->getEmail();
            $customer = $this->customerAccountManagement->activate($customerEmail, $key);
            $customerValue = $this->getValue($customerId);
            if ($customerValue && $customerValue == CustomerAttribute::B2B_PENDING) {
                $message = $this->helper->getPendingMess();
                $this->messageManager->addErrorMessage($message);
                $url = $this->urlModel->getUrl('customer/account/login', ['_secure' => true]);
                return $resultRedirect->setUrl($this->_redirect->error($url));
            } else {
                $this->session->setCustomerDataAsLoggedIn($customer);
                $this->messageManager->addSuccessMessage($this->getSuccessMessage());
                $resultRedirect->setUrl($this->getSuccessRedirect());
                return $resultRedirect;
            }
        } catch (StateException $e) {
            $this->messageManager->addExceptionMessage($e, __('This confirmation key is invalid or has expired.'));
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('There was an error confirming the account'));
        }

        $url = $this->urlModel->getUrl('*/*/index', ['_secure' => true]);
        return $resultRedirect->setUrl($this->_redirect->error($url));
    }

    /**
     * Get B2b Status by b2b_activasion_status attribute
     * @param object $customerStatus
     * @return string
     */
    protected function getValue ($customerId)
    {
        $customerValue = "";
        $customerStatus = $this->customerRepository->getById($customerId)
            ->getCustomAttribute('b2b_activasion_status');
        if ($customerStatus) {
            $customerValue = $customerStatus->getValue($customerStatus);
        }
        return $customerValue;
    }
}
