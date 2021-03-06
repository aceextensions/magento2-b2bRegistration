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
use Magento\Framework\Exception\EmailNotConfirmedException;
use Aceextensions\B2bRegistration\Model\Config\Source\CustomerAttribute;

class LoginObserver implements ObserverInterface
{
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;
    /**
     * @var Aceextensions\CustomerApproval\Helper\Data
     */
    protected $helper;

    /**
     * LoginObserver constructor.
     * @param \Magento\Framework\App\Request\Http $request
     * @param Data $helper
     */
    public function __construct (
        \Magento\Framework\App\Request\Http $request,
        Data $helper
    ) {
        $this->request = $request;
        $this->helper = $helper;
    }

    /**
     * Check Login in Checkout Page
     * @param \Magento\Framework\Event\Observer $observer
     * @throws EmailNotConfirmedException
     * @return void
     */
    public function execute (\Magento\Framework\Event\Observer $observer)
    {
        if ($this->helper->isEnable()) {
            $customerValue = $observer->getModel()->getData('b2b_activasion_status');
            if ($customerValue == CustomerAttribute::B2B_PENDING) {
                $message = $this->helper->getPendingMess();
                if ($this->request->isAjax()) {
                    throw new EmailNotConfirmedException(__($message));
                }
            }
            if ($customerValue == CustomerAttribute::B2B_REJECT) {
                $message = $this->helper->getDisapproveMess();
                if ($this->request->isAjax()) {
                    throw new EmailNotConfirmedException(__($message));
                }
            }
        }
    }
}
