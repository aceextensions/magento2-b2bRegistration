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

class Form
{
    /**#@+
     * Values for ignoreInvisible parameter in constructor
     */
    const IGNORE_INVISIBLE = true;

    /**
     * @var bool
     */
    protected $_ignoreInvisible = true;

    /**
     * @var array
     */
    protected $_filterAttributes;

    /**
     * Form constructor.
     * @param Data $helper
     * @param \Magento\Framework\App\Request\Http $request
     */
    public function __construct (
        Data $helper,
        \Magento\Framework\App\Request\Http $request
    ) {
        $this->helper = $helper;
        $this->request = $request;
    }

    /**
     * @param \Magento\Customer\Model\Metadata\Form $subject
     * @param callable $proceed
     * @return \Magento\Customer\Api\Data\AttributeMetadataInterface[]
     */
    public function aroundGetAllowedAttributes (
        \Magento\Customer\Model\Metadata\Form $subject,
        callable $proceed
    ) {
        $enable = $this->helper->isEnable();
        $enableDob = $this->helper->getDateField();
        $enableDobDefault = $this->helper->getDobFieldDefault();
        $controllerName = $this->request->getFullActionName();
        if ($enable && $enableDob && !$enableDobDefault && $controllerName == "b2b_account_createpost") {
            $attributes = $subject->getAttributes();
            if (!$this->_ignoreInvisible) {
                $this->_ignoreInvisible = self::IGNORE_INVISIBLE;
            }
            if (!$this->_filterAttributes) {
                $this->_filterAttributes = [];
            }
            foreach ($attributes as $attributeCode => $attribute) {
                if ($attributeCode == "dob") {
                    continue;
                }
                if ($this->_ignoreInvisible && !$attribute->isVisible() || in_array(
                        $attribute->getAttributeCode(),
                        $this->_filterAttributes
                    )
                ) {
                    unset($attributes[$attributeCode]);
                }
            }
            return $attributes;
        } else {
            return $proceed();
        }
    }
}
