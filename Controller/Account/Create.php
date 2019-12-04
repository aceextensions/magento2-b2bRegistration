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

use Magento\Customer\Model\Session;
use Magento\Customer\Model\Registration;
use Ace\B2bRegistration\Helper\Data;

/**
 * Class Create
 * @package Ace\B2bRegistration\Controller\Account
 */
class Create extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    /**
     * @var \Magento\Framework\Controller\Result\ForwardFactory
     */
    protected $resultForwardFactory;
    /**
     * @var Session
     */
    protected $session;
    /**
     * @var Magento\Customer\Model\Session
     */
    protected $customerSession;
    /**
     * @var Registration
     */
    protected $registration;
    /**
     * @var Data
     */
    protected $helper;

    /**
     * Create constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory
     * @param Session $customerSession
     * @param Registration $registration
     * @param Data $helper
     */
    public function __construct (
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory,
        Session $customerSession,
        Registration $registration,
        Data $helper
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->session = $customerSession;
        $this->registration = $registration;
        $this->helper = $helper;
        parent::__construct($context);
    }

    /**
     * @return $this
     */
    protected function _isAllowed ()
    {
        return $this->_authorization->isAllowed('Ace_B2bRegistration::config_b2bregistration');
    }

    /**
     * Execute view action
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute ()
    {
        $enable = $this->helper->isEnable();
        if ($enable) {
            if ($this->session->isLoggedIn()) {
                /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setPath('customer/*');
                return $resultRedirect;
            }

            $resultPage = $this->resultPageFactory->create();
            return $resultPage;
        } else {
            $resultForward = $this->resultForwardFactory->create();
            $resultForward->forward('noroute');
            return $resultForward;
        }
    }
}