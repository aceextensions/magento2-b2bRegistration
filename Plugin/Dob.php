<?php
/**
 * Ace Extensions
 *
 * @category   Ace
 * @package    Ace_B2bRegistration
 * @author     Durga Shankar Gupta (dsguptas@gmail.com)
 * @copyright  Copyright (c) 2019 Ace Extensions ( http://aceextensions.com )
 */

namespace Ace\B2bRegistration\Plugin;

use Ace\B2bRegistration\Helper\Data;
use Magento\Framework\View\Element\Html\Date;
use Magento\Customer\Api\CustomerMetadataInterface;

class Dob
{
    /**
     * @var Data
     */
    protected $helper;
    /**
     * @var Date
     */
    protected $dateElement;
    /**
     * @var CustomerMetadataInterface
     */
    protected $customerMetadata;
    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $timezone;

    /**
     * Dob constructor.
     * @param Data $helper
     * @param Date $dateElement
     * @param CustomerMetadataInterface $customerMetadata
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
     */
    public function __construct (
        Data $helper,
        Date $dateElement,
        CustomerMetadataInterface $customerMetadata,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
    ) {
        $this->helper = $helper;
        $this->dateElement = $dateElement;
        $this->customerMetadata = $customerMetadata;
        $this->timezone = $timezone;
    }

    /**
     * Get Date of birth Html Field
     * @param \Magento\Customer\Block\Widget\Dob $subject
     * @param \Closure $proceed
     * @return string
     */
    public function aroundGetFieldHtml (\Magento\Customer\Block\Widget\Dob $subject, \Closure $proceed)
    {
        if ($this->helper->isEnable()) {
            $this->dateElement->setData([
                'extra_params' => $this->getHtmlExtraParams(),
                'name' => $subject->getHtmlId(),
                'id' => $subject->getHtmlId(),
                'class' => $subject->getHtmlClass(),
                'value' => $subject->getValue(),
                'date_format' => $subject->getDateFormat(),
                'image' => $subject->getViewFileUrl('Magento_Theme::calendar.png'),
                'years_range' => '-120y:c+nn',
                'max_date' => '-1d',
                'change_month' => 'true',
                'change_year' => 'true',
                'show_on' => 'both'
            ]);
            return $this->dateElement->getHtml();
        } else {
            return $proceed();
        }
    }

    /**
     * Get Extra Params
     * @return string
     */
    public function getHtmlExtraParams ()
    {
        $date = $this->timezone->getDateFormat();
        $extraParams = [
            "'validate-date':{'dateFormat': '$date'}"
        ];

        if ($this->isRequired()) {
            $extraParams[] = 'required:true';
        }

        $extraParams = implode(', ', $extraParams);

        return 'data-validate="{' . $extraParams . '}"';
    }

    /**
     * Check Required
     * @return bool
     */
    public function isRequired ()
    {
        $attributeMetadata = $this->_getAttribute('dob');
        return $attributeMetadata ? (bool)$attributeMetadata->isRequired() : false;
    }

    /**
     * Retrieve customer attribute instance
     * @param string $attributeCode
     * @return \Magento\Customer\Api\Data\AttributeMetadataInterface|null
     */
    protected function _getAttribute ($attributeCode)
    {
        try {
            return $this->customerMetadata->getAttributeMetadata($attributeCode);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            return null;
        }
    }
}
