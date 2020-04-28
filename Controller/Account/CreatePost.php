<?php
/**
 * Aceextensions Extensions
 *
 * @category   Aceextensions
 * @package    Aceextensions_B2bRegistration
 * @author     Durga Shankar Gupta (dsguptas@gmail.com)
 * @copyright  Copyright (c) 2019 Aceextensions Extensions ( http://aceextensions.com )
 */

namespace Aceextensions\B2bRegistration\Controller\Account;

use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;
use Magento\Store\Model\ScopeInterface;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Framework\UrlFactory;
use Magento\Customer\Model\Metadata\FormFactory;
use Magento\Newsletter\Model\SubscriberFactory;
use Magento\Customer\Api\Data\RegionInterfaceFactory;
use Magento\Customer\Api\Data\AddressInterfaceFactory;
use Magento\Customer\Model\Url as CustomerUrl;
use Magento\Framework\Escaper;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Customer\Model\CustomerExtractor;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Data\Form\FormKey\Validator;
use Aceextensions\B2bRegistration\Helper\Data;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Stdlib\Cookie\PhpCookieManager;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;
use Psr\Log\LoggerInterface;
use Magento\Customer\Model\Account\Redirect as AccountRedirect;
use Magento\Customer\Helper\Address;
use Magento\Store\Model\StoreManagerInterface;
use Aceextensions\B2bRegistration\Model\Config\Source\CustomerAttribute;

/**
 * Class CreatePost
 * @package Aceextensions\B2bRegistration\Controller\Account
 */
class CreatePost extends \Magento\Customer\Controller\AbstractAccount
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
     * @var Magento\Store\Model\ScopeInterface;
     */
    protected $scopeConfig;
    /**
     * @var AccountManagementInterface
     */
    protected $accountManagement;
    /**
     * @var UrlFactory
     */
    protected $urlFactory;
    /**
     * @var FormFactory
     */
    protected $formFactory;
    /**
     * @var SubscriberFactory
     */
    protected $subscriberFactory;
    /**
     * @var RegionInterfaceFactory
     */
    protected $regionDataFactory;
    /**
     * @var AddressInterfaceFactory
     */
    protected $addressDataFactory;
    /**
     * @var Magento\Customer\Model\Url
     */
    protected $customerUrl;
    /**
     * @var Escaper
     */
    protected $escaper;
    /**
     * @var CustomerExtractor
     */
    protected $customerExtractor;
    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;
    /**
     * @var Validator
     */
    protected $formKeyValidator;
    /**
     * @var Data
     */
    protected $helper;
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;
    /**
     * @var StateInterface
     */
    protected $inlineTranslation;
    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;
    /**
     * @var PhpCookieManager
     */
    protected $cookieMetadataManager;
    /**
     * @var CookieMetadataFactory
     */
    protected $cookieMetadataFactory;
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var AccountRedirect
     */
    protected $accountRedirect;
    /**
     * @var Address
     */
    protected $addressHelper;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * CreatePost constructor.
     * @param Context $context
     * @param Session $customerSession
     * @param ScopeConfigInterface $scopeConfig
     * @param AccountManagementInterface $accountManagement
     * @param UrlFactory $urlFactory
     * @param FormFactory $formFactory
     * @param SubscriberFactory $subscriberFactory
     * @param RegionInterfaceFactory $regionDataFactory
     * @param AddressInterfaceFactory $addressDataFactory
     * @param CustomerUrl $customerUrl
     * @param Escaper $escaper
     * @param CustomerExtractor $customerExtractor
     * @param DataObjectHelper $dataObjectHelper
     * @param Validator $formKeyValidator
     * @param Data $helper
     * @param CustomerRepositoryInterface $customerRepository
     * @param StateInterface $inlineTranslation
     * @param TransportBuilder $transportBuilder
     * @param PhpCookieManager $cookieMetadataManager
     * @param CookieMetadataFactory $cookieMetadataFactory
     * @param LoggerInterface $logger
     * @param AccountRedirect $accountRedirect
     * @param Address $addressHelper
     * @param StoreManagerInterface $storeManager
     */
    public function __construct (
        Context $context,
        Session $customerSession,
        ScopeConfigInterface $scopeConfig,
        AccountManagementInterface $accountManagement,
        UrlFactory $urlFactory,
        FormFactory $formFactory,
        SubscriberFactory $subscriberFactory,
        RegionInterfaceFactory $regionDataFactory,
        AddressInterfaceFactory $addressDataFactory,
        CustomerUrl $customerUrl,
        Escaper $escaper,
        CustomerExtractor $customerExtractor,
        DataObjectHelper $dataObjectHelper,
        Validator $formKeyValidator,
        Data $helper,
        CustomerRepositoryInterface $customerRepository,
        StateInterface $inlineTranslation,
        TransportBuilder $transportBuilder,
        PhpCookieManager $cookieMetadataManager,
        CookieMetadataFactory $cookieMetadataFactory,
        LoggerInterface $logger,
        AccountRedirect $accountRedirect,
        Address $addressHelper,
        StoreManagerInterface $storeManager
    ) {
        $this->helper = $helper;
        $this->customerRepository = $customerRepository;
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->cookieMetadataManager = $cookieMetadataManager;
        $this->cookieMetadataFactory = $cookieMetadataFactory;
        $this->customerSession = $customerSession;
        $this->scopeConfig = $scopeConfig;
        $this->accountManagement = $accountManagement;
        $this->urlFactory = $urlFactory;
        $this->formFactory = $formFactory;
        $this->subscriberFactory = $subscriberFactory;
        $this->regionDataFactory = $regionDataFactory;
        $this->addressDataFactory = $addressDataFactory;
        $this->customerUrl = $customerUrl;
        $this->escaper = $escaper;
        $this->customerExtractor = $customerExtractor;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->formKeyValidator = $formKeyValidator;
        $this->logger = $logger;
        $this->accountRedirect = $accountRedirect;
        $this->addressHelper = $addressHelper;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * Add address to customer during create account
     * @return \Magento\Customer\Api\Data\AddressInterface |$addressDataObject;
     */
    protected function extractAddress ()
    {
        if (!$this->getRequest()->getPost('create_address')) {
            return null;
        }
        $addressForm = $this->formFactory->create('customer_address', 'customer_register_address');
        $allowedAttributes = $addressForm->getAllowedAttributes();
        $addressData = [];
        $regionDataObject = $this->regionDataFactory->create();
        foreach ($allowedAttributes as $attribute) {
            $attributeCode = $attribute->getAttributeCode();
            $value = $this->getRequest()->getParam($attributeCode);
            if ($value === null) {
                continue;
            }
            switch ($attributeCode) {
                case 'region_id':
                    $regionDataObject->setRegionId($value);
                    break;
                case 'region':
                    $regionDataObject->setRegion($value);
                    break;
                default:
                    $addressData[$attributeCode] = $value;
            }
        }
        $addressDataObject = $this->addressDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $addressDataObject,
            $addressData,
            '\Magento\Customer\Api\Data\AddressInterface'
        );
        $addressDataObject->setRegion($regionDataObject);

        $addressDataObject->setIsDefaultBilling(
            $this->getRequest()->getParam('default_billing', false)
        )->setIsDefaultShipping(
            $this->getRequest()->getParam('default_shipping', false)
        );
        return $addressDataObject;
    }

    /**
     * Make sure that password and password confirmation matched
     * @param string $password
     * @param string $confirmation
     * @return void
     * @throws InputException
     */
    protected function checkPasswordConfirmation ($password, $confirmation)
    {
        if ($password != $confirmation) {
            throw new InputException(__('Please make sure your passwords match.'));
        }
    }

    /**
     * Create B2b account Action
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute ()
    {
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $this->checkLogin();

        if (!$this->getRequest()->isPost() || !$this->formKeyValidator->validate($this->getRequest())) {
            $url = $this->urlFactory->create()->getUrl('*/*/create', ['_secure' => true]);
            $resultRedirect->setUrl($this->_redirect->error($url));
            return $resultRedirect;
        }

        $autoApproval = $this->helper->isAutoApproval();
        $this->customerSession->regenerateId();

        try {
            $address = $this->extractAddress();
            $addresses = $address === null ? [] : [$address];
            $customer = $this->customerExtractor->extract('customer_account_create', $this->_request);
            $customer->setAddresses($addresses);

            $password = $this->getRequest()->getParam('password');
            $confirmation = $this->getRequest()->getParam('password_confirmation');
            $redirectUrl = $this->customerSession->getBeforeAuthUrl();

            $this->checkPasswordConfirmation($password, $confirmation);

            $customer = $this->accountManagement
                ->createAccount($customer, $password, $redirectUrl);

            $this->subcribeCustomer($customer);
            $this->saveGroupAttribute($customer);

            $this->_eventManager->dispatch(
                'aceextensions_customer_register_success',
                ['account_controller' => $this, 'customer' => $customer]
            );
            $customerEmail = $customer->getEmail();
            $emailTemplate = $this->helper->getAdminEmailTemplate();
            $confirmationStatus = $this->accountManagement->getConfirmationStatus($customer->getId());
            if ($confirmationStatus === AccountManagementInterface::ACCOUNT_CONFIRMATION_REQUIRED) {
                $this->setCustomerStatusConfirm($customer);
                $this->customerRepository->save($customer);
                $email = $this->customerUrl->getEmailConfirmationUrl($customer->getEmail());
                // @codingStandardsIgnoreStart
                $this->messageManager->addSuccess(
                    __(
                        'You must confirm your account. Please check your email for the confirmation link or <a href="%1">click here</a> for a new link.',
                        $email
                    )
                );
                // @codingStandardsIgnoreEnd
                $this->sendEmail($customerEmail, $emailTemplate);
                $url = $this->urlFactory->create()->getUrl('customer/account/login', ['_secure' => true]);
                $resultRedirect->setUrl($this->_redirect->success($url));
            } elseif (!$autoApproval) {
                //Set status is B2b Pending and redirect to login page with success messenger, send email to admin
                $customer->setCustomAttribute("b2b_activasion_status", CustomerAttribute::B2B_PENDING);
                $this->customerRepository->save($customer);
                $message = $this->helper->getPendingMess();
                $this->messageManager->addSuccessMessage($message);
                $this->sendEmail($customerEmail, $emailTemplate);
                $url = $this->urlFactory->create()->getUrl('customer/account/login', ['_secure' => true]);
                $resultRedirect->setUrl($this->_redirect->success($url));
            } else {
                // set status is B2b Approval and redirect to success url
                $customer->setCustomAttribute("b2b_activasion_status", CustomerAttribute::B2B_APPROVAL);
                $this->customerRepository->save($customer);
                $this->customerSession->setCustomerDataAsLoggedIn($customer);
                $this->messageManager->addSuccess($this->getSuccessMessage());
                $requestedRedirect = $this->accountRedirect->getRedirectCookie();
                if (!$this->scopeConfig->getValue('customer/startup/redirect_dashboard') && $requestedRedirect) {
                    $resultRedirect->setUrl($this->_redirect->success($requestedRedirect));
                    $this->accountRedirect->clearRedirectCookie();
                    return $resultRedirect;
                }
                $resultRedirect = $this->accountRedirect->getRedirect();
            }
            $this->checkCookie();

            return $resultRedirect;
        } catch (StateException $e) {
            $url = $this->urlFactory->create()->getUrl('customer/account/forgotpassword');
            // @codingStandardsIgnoreStart
            $message = __(
                'There is already an account with this email address. If you are sure that it is your email address, <a href="%1">click here</a> to get your password and access your account.',
                $url
            );
            // @codingStandardsIgnoreEnd
            $this->messageManager->addError($message);
        } catch (InputException $e) {
            $this->messageManager->addErrorMessage($this->escaper->escapeHtml($e->getMessage()));
            foreach ($e->getErrors() as $error) {
                $this->messageManager->addErrorMessage($this->escaper->escapeHtml($error->getMessage()));
            }
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($this->escaper->escapeHtml($e->getMessage()));
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('We can\'t save the customer.'));
        }

        $this->customerSession->setCustomerFormData($this->getRequest()->getPostValue());
        $defaultUrl = $this->urlFactory->create()->getUrl('b2b/account/create', ['_secure' => true]);
        $resultRedirect->setUrl($this->_redirect->error($defaultUrl));
        return $resultRedirect;
    }

    /**
     * Set Customer Status Confirm Email
     * @return void
     */
    protected function setCustomerStatusConfirm ($customer)
    {
        $autoApproval = $this->helper->isAutoApproval();
        if ($autoApproval) {
            $customer->setCustomAttribute("b2b_activasion_status", CustomerAttribute::B2B_APPROVAL);
        } else {
            $customer->setCustomAttribute("b2b_activasion_status", CustomerAttribute::B2B_PENDING);
        }
    }

    /**
     * Check Customer Login
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    protected function checkLogin ()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($this->customerSession->isLoggedIn()) {
            $resultRedirect->setPath('customer/account/index');
            return $resultRedirect;
        }
    }

    /**
     * Check Cookie
     * @return void
     */
    protected function checkCookie ()
    {
        if ($this->cookieMetadataManager->getCookie('mage-cache-sessid')) {
            $metadata = $this->cookieMetadataFactory->createCookieMetadata();
            $metadata->setPath('/');
            $this->cookieMetadataManager->deleteCookie('mage-cache-sessid', $metadata);
        }
    }

    /**
     * Check subcribe customer
     * @param object $customer
     * @return void
     */
    protected function subcribeCustomer ($customer)
    {
        if ($this->getRequest()->getParam('is_subscribed', false)) {
            $this->subscriberFactory->create()->subscribeCustomerById($customer->getId());
        }
    }

    /**
     * Save B2b Customer Group
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     * @return void
     */
    protected function saveGroupAttribute ($customer)
    {
        try {
            $customerGroupId = $this->helper->getCustomerGroup();
            $tax = $this->getRequest()->getPostValue('taxvat');
            $gender = $this->getRequest()->getPostValue('gender');

            if ($tax) {
                $customer->setTaxvat($tax);
            }
            if ($gender) {
                $customer->setGender($gender);
            }
            $customer->setGroupId($customerGroupId);
            $this->customerRepository->save($customer);
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }

    /**
     * Send Email to Admin
     * @param string $customerEmail
     * @param string $emailTemplate
     * @return void
     */
    protected function sendEmail ($customerEmail, $emailTemplate)
    {
        if ($this->helper->isEnableAdminEmail()) {
            try {
                $store = $this->storeManager->getStore()->getId();
                $recipients = $this->helper->getAdminEmail();
                $recipients = str_replace(' ', '', $recipients);
                $recipients = (explode(',', $recipients));
                $email = $this->helper->getAdminEmailSender();
                $emailValue = 'trans_email/ident_' . $email . '/email';
                $emailName = 'trans_email/ident_' . $email . '/name';
                $emailSender = $this->scopeConfig->getValue($emailValue, ScopeInterface::SCOPE_STORE);
                $emailNameSender = $this->scopeConfig->getValue($emailName, ScopeInterface::SCOPE_STORE);
                $this->inlineTranslation->suspend();
                $sender = [
                    'name' => $this->escaper->escapeHtml($emailNameSender),
                    'email' => $this->escaper->escapeHtml($emailSender),
                ];
                $transport = $this->transportBuilder
                    ->setTemplateIdentifier($emailTemplate)
                    ->setTemplateOptions(
                        [
                            'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                            'store' => $store,
                        ]
                    )
                    ->setTemplateVars([
                        'varEmail' => $customerEmail,
                    ])
                    ->setFrom($sender)
                    ->addTo($recipients)
                    ->getTransport();
                $transport->sendMessage();
                $this->inlineTranslation->resume();
            } catch (\Exception $e) {
                $this->logger->debug($e->getMessage());
            }
        }
    }

    /**
     * Retrieve success message
     * @return string
     */
    protected function getSuccessMessage ()
    {
        if ($this->addressHelper->isVatValidationEnabled()) {
            if ($this->addressHelper->getTaxCalculationAddressType() == Address::TYPE_SHIPPING) {
                // @codingStandardsIgnoreStart
                $message = __(
                    'If you are a registered VAT customer, please <a href="%1">click here</a> to enter your shipping address for proper VAT calculation.',
                    $this->urlModel->getUrl('customer/address/edit')
                );
                // @codingStandardsIgnoreEnd
            } else {
                // @codingStandardsIgnoreStart
                $message = __(
                    'If you are a registered VAT customer, please <a href="%1">click here</a> to enter your billing address for proper VAT calculation.',
                    $this->urlModel->getUrl('customer/address/edit')
                );
                // @codingStandardsIgnoreEnd
            }
        } else {
            $message = __('Thank you for registering with %1.', $this->storeManager->getStore()->getFrontendName());
        }
        return $message;
    }
}