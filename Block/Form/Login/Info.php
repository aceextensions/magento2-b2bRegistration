<?php
/**
 * Ace Extensions
 *
 * @category   Ace
 * @package    Ace_B2bRegistration
 * @author     Durga Shankar Gupta (dsguptas@gmail.com)
 * @copyright  Copyright (c) 2019 Ace Extensions ( http://aceextensions.com )
 */

namespace Ace\B2bRegistration\Block\Form\Login;

use Ace\B2bRegistration\Helper\Data;

class Info extends \Magento\Customer\Block\Form\Login\Info
{
    /**
     * @var Data
     */
    protected $helper;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * Info constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Registration $registration
     * @param \Magento\Customer\Model\Url $customerUrl
     * @param \Magento\Checkout\Helper\Data $checkoutData
     * @param \Magento\Framework\Url\Helper\Data $coreUrl
     * @param Data $helper
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param array $data
     */
    public function __construct (
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Registration $registration,
        \Magento\Customer\Model\Url $customerUrl,
        \Magento\Checkout\Helper\Data $checkoutData,
        \Magento\Framework\Url\Helper\Data $coreUrl,
        Data $helper,
        \Magento\Framework\Module\Manager $moduleManager,
        array $data = []
    ) {
        parent::__construct($context, $registration, $customerUrl, $checkoutData, $coreUrl, $data);
        $this->helper = $helper;
        $this->storeManager = $context->getStoreManager();
        $this->scopeConfig = $context->getScopeConfig();
        $this->moduleManager = $moduleManager;
    }

    /**
     * Enable module
     * @return bool
     */
    public function isEnable ()
    {
        return $this->helper->isEnable();
    }

    /**
     * Enable Shortcut Link
     * @return bool
     */
    public function isEnableShortcutLink ()
    {
        return $this->helper->isEnableShortcutLink();
    }

    /**
     * Get Shortcut Link Text
     * @return string
     */
    public function getShortcutLinkText ()
    {
        return $this->helper->getShortcutLinkText();
    }

    /**
     * Get B2b Account Create Url
     * @return string
     */
    public function getUrlB2bAccountCreate ()
    {
        $bbUrl = $this->helper->getB2bUrl();
        $baseUrl = $this->storeManager->getStore()->getBaseUrl();
        $bbCreateUrl = $baseUrl . $bbUrl . ".html";
        return $bbCreateUrl;
    }

    /**
     * Render block HTML
     * @return string
     */
    protected function _toHtml ()
    {
        if ($this->moduleManager->isOutputEnabled('Ace_ForceLogin')) {
            $enableRegister = $this->scopeConfig->isSetFlag(
                'forcelogin/general/disable_register',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
            if ($enableRegister || !$this->getTemplate()) {
                return '';
            } else {
                return $this->fetchView($this->getTemplateFile());
            }
        } else {
            return $this->fetchView($this->getTemplateFile());
        }
    }
}
