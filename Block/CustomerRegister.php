<?php
/**
 * Ace Extensions
 *
 * @category   Ace
 * @package    Ace_B2bRegistration
 * @author     Durga Shankar Gupta (dsguptas@gmail.com)
 * @copyright  Copyright (c) 2019 Ace Extensions ( http://aceextensions.com )
 */

namespace Ace\B2bRegistration\Block;

use Magento\Framework\View\Element\Template\Context;
use Ace\B2bRegistration\Helper\Data;
use Magento\Customer\Helper\Address;

class CustomerRegister extends \Magento\Customer\Block\Form\Register
{
    /**
     * @var Magento\Framework\View\Element\Template\Context
     */
    protected $context;
    /**
     * @var Magento\Directory\Helper\Data
     */
    protected $directoryHelper;
    /**
     * @var Magento\Framework\Json\EncoderInterface
     */
    protected $jsonEncoder;
    /**
     * @var Magento\Framework\App\Cache\Type\Config
     */
    protected $configCacheType;
    /**
     * @var Magento\Directory\Model\ResourceModel\Region\CollectionFactory
     */
    protected $regionCollectionFactory;
    /**
     * @var Magento\Directory\Model\ResourceModel\Country\CollectionFactory
     */
    protected $countryCollectionFactory;
    /**
     * @var Magento\Framework\Module\Manager
     */
    protected $moduleManager;
    /**
     * @var Magento\Customer\Model\Session
     */
    protected $customerSession;
    /**
     * @var Magento\Customer\Model\Url
     */
    protected $customerUrl;
    /**
     * @var Address
     */
    protected $address;
    /**
     * @var \Magento\Directory\Helper\Data
     */
    protected $helperDirectoryData;
    /**
     * @var Data
     */
    protected $helper;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManagerInterface;
    /**
     * @var Escaper
     */
    protected $escaper;
    /**
     * @var \Magento\Framework\App\ProductMetadataInterface
     */
    protected $productMetadata;

    /**
     * CustomerRegister constructor.
     * @param Context $context
     * @param \Magento\Directory\Helper\Data $directoryHelper
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param \Magento\Framework\App\Cache\Type\Config $configCacheType
     * @param \Magento\Directory\Model\ResourceModel\Region\CollectionFactory $regionCollectionFactory
     * @param \Magento\Directory\Model\ResourceModel\Country\CollectionFactory $countryCollectionFactory
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Customer\Model\Url $customerUrl
     * @param \Magento\Directory\Helper\Data $helperDirectoryData
     * @param Data $helper
     * @param Address $address
     * @param \Magento\Framework\App\ProductMetadataInterface $productMetadata
     * @param array $data
     */
    public function __construct (
        Context $context,
        \Magento\Directory\Helper\Data $directoryHelper,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\App\Cache\Type\Config $configCacheType,
        \Magento\Directory\Model\ResourceModel\Region\CollectionFactory $regionCollectionFactory,
        \Magento\Directory\Model\ResourceModel\Country\CollectionFactory $countryCollectionFactory,
        \Magento\Framework\Module\Manager $moduleManager,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Model\Url $customerUrl,
        \Magento\Directory\Helper\Data $helperDirectoryData,
        Data $helper,
        Address $address,
        \Magento\Framework\App\ProductMetadataInterface $productMetadata,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $directoryHelper,
            $jsonEncoder,
            $configCacheType,
            $regionCollectionFactory,
            $countryCollectionFactory,
            $moduleManager,
            $customerSession,
            $customerUrl,
            $data
        );
        $this->helperDirectoryData = $helperDirectoryData;
        $this->helper = $helper;
        $this->address = $address;
        $this->escaper = $context->getEscaper();
        $this->productMetadata = $productMetadata;
        $this->storeManagerInterface = $context->getStoreManager();
    }

    /**
     *  Get Title Of B2b Account Create Page
     * @return void
     */
    protected function _prepareLayout ()
    {
        $title = $this->helper->getTitle();
        if ($title) {
            $this->pageConfig->getTitle()->set(__($title));
        } else {
            $this->pageConfig->getTitle()->set(__('Create New Customer Account'));
        }
    }

    /**
     * Count Stress
     * @return int
     */
    public function getStressCount ()
    {
        return $this->address->getStreetLines();
    }

    /**
     * Enable Date Field
     * @return bool
     */
    public function getDateField ()
    {
        return $this->helper->getDateField();
    }

    /**
     * Enable Tax Field
     * @return bool
     */
    public function getTaxField ()
    {
        return $this->helper->getTaxField();
    }

    /**
     * Enable Gender Field
     * @return bool
     */
    public function getGenderField ()
    {
        return $this->helper->getGenderField();
    }

    /**
     * Enable Address Field
     * @return bool
     */
    public function getAddressField ()
    {
        return $this->helper->getAddressField();
    }

    /**
     * Get Prefix Field
     * @return bool
     */
    public function getPrefixField ()
    {
        return $this->helper->getPrefixField();
    }

    /**
     * Get Prefix Options
     * @return array|bool
     */
    public function getPrefixOptions ()
    {
        return $this->_prepareNamePrefixSuffixOptions($this->helper->getPrefixOptions());
    }

    /**
     * Get Suffix Field
     * @return bool
     */
    public function getSuffixField ()
    {
        return $this->helper->getSuffixField();
    }

    /**
     * Get Suffix Field Options
     * @return array|bool
     */
    public function getSuffixOptions ()
    {
        return $this->_prepareNamePrefixSuffixOptions($this->helper->getSuffixOptions());
    }

    /**
     * Get enable Middle Field
     * @return bool
     */
    public function getMiddleField ()
    {
        return $this->helper->getMiddleField();
    }

    /**
     * Convert String To arrays
     * @param string $options
     * @return array|bool
     */
    public function _prepareNamePrefixSuffixOptions ($options)
    {
        $options = trim($options);
        if (empty($options)) {
            return false;
        }
        $result = [];
        $options = explode(';', $options);
        foreach ($options as $value) {
            $value = $this->escaper->escapeHtml(trim($value));
            $result[$value] = $value;
        }
        return $result;
    }

    /**
     * Get Post Action
     * @return string
     */
    public function getPostAction ()
    {
        $baseUrl = $this->storeManagerInterface->getStore()->getBaseUrl();
        $postAction = $baseUrl . 'b2b/account/createpost';
        return $postAction;
    }

    /**
     * Get Directory Helper Data
     * @return \Magento\Directory\Helper\Data
     */
    public function getHelperDirectoryData ()
    {
        return $this->helperDirectoryData;
    }

    /**
     * Get Suffix Field Default Config
     * @return string
     */
    public function getSuffixFieldDefault ()
    {
        return $this->helper->getSuffixFieldDefault();
    }

    /**
     * Get Prefix Field Default Config
     * @return string
     */
    public function getPreffixFieldDefault ()
    {
        return $this->helper->getPreffixFieldDefault();
    }

    /**
     * Get Dob Field Default Config
     * @return string
     */
    public function getDobFieldDefault ()
    {
        return $this->helper->getDobFieldDefault();
    }

    /**
     * Get Tax Field Default Config
     * @return string
     */
    public function getTaxFieldDefault ()
    {
        return $this->helper->getTaxFieldDefault();
    }

    /**
     * Get Gender Field Default Config
     * @return string
     */
    public function getGenderFieldDefault ()
    {
        return $this->helper->getGenderFieldDefault();
    }

    /**
     * Get Telephone Field Default Config
     * @return string
     */
    public function getTelephoneFieldDefault ()
    {
        return $this->helper->getTelephoneFieldDefault();
    }

    /**
     * Get Company Field Default Config
     * @return string
     */
    public function getCompanyFieldDefault ()
    {
        return $this->helper->getCompanyFieldDefault();
    }

    /**
     * Get Fax Field Default Config
     * @return string
     */
    public function getFaxFieldDefault ()
    {
        return $this->helper->getFaxFieldDefault();
    }

    /**
     * Get Vat Field Default Config
     * @return string
     */
    public function getVatFieldDefault ()
    {
        return $this->helper->getVatFieldDefault();
    }

    /**
     * Compare Magento Version
     * @return bool
     */
    public function getMagentoVersion ()
    {
        $version = $this->productMetadata->getVerSion();
        if (version_compare($version, '2.2.0') < 0) {
            return true;
        } else {
            return false;
        }
    }
}
