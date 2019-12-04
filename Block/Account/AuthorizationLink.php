<?php
/**
 * Ace Extensions
 *
 * @category   Ace
 * @package    Ace_B2bRegistration
 * @author     Durga Shankar Gupta (dsguptas@gmail.com)
 * @copyright  Copyright (c) 2019 Ace Extensions ( http://aceextensions.com )
 */

namespace Ace\B2bRegistration\Block\Account;

use Magento\Framework\View\Element\Template\Context;
use Magento\Customer\Model\Url;
use Magento\Framework\Data\Helper\PostHelper;
use Ace\B2bRegistration\Helper\Data;

class AuthorizationLink extends \Magento\Customer\Block\Account\AuthorizationLink
{
    /**
     * @var $context
     */
    protected $context;
    /**
     * @var \Magento\Framework\App\Http\Context $httpContext
     */
    protected $httpContext;
    /**
     * @var Magento\Customer\Model\Url $customerUrl
     */
    protected $customerUrl;
    /**
     * @var Magento\Framework\Data\Helper\PostHelper $postDataHelper
     */
    protected $postDataHelper;
    /**
     * @var Data
     */
    protected $helper;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * AuthorizationLink constructor.
     * @param Context $context
     * @param \Magento\Framework\App\Http\Context $httpContext
     * @param Url $customerUrl
     * @param PostHelper $postDataHelper
     * @param Data $helper
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param array $data
     */
    public function __construct (
        Context $context,
        \Magento\Framework\App\Http\Context $httpContext,
        Url $customerUrl,
        PostHelper $postDataHelper,
        Data $helper,
        \Magento\Framework\Module\Manager $moduleManager,
        array $data = []
    ) {
        parent::__construct($context, $httpContext, $customerUrl, $postDataHelper, $data);
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
     * Enable Shortcut Link In Header
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
     * Get url in Config module
     * @return string
     */
    public function getB2bUrl ()
    {
        return $this->helper->getB2bUrl();
    }

    /**
     * Get B2b Url
     * @return string
     */
    public function getUrlB2bAccountCreate ()
    {
        $baseUrl = $this->storeManager->getStore()->getBaseUrl();
        $urlConfig = $this->getB2bUrl();
        $bbCreateUrl = $baseUrl . $urlConfig . '.html';
        return $bbCreateUrl;
    }

    /**
     * Check Force Login Install
     * @return int
     */
    public function checkForceLoginInstall ()
    {
        return $this->moduleManager->isOutputEnabled('Ace_ForceLogin');
    }

    /**
     * Check Force Login Enable
     * @return bool
     */
    public function isEnableForceLogin ()
    {
        return $this->scopeConfig->isSetFlag(
            'forcelogin/general/enable',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Enable customer register
     * @return bool
     */
    public function getEnableRegister ()
    {
        return $this->scopeConfig->isSetFlag(
            'forcelogin/general/disable_register',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
