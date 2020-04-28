<?php
/**
 * Aceextensions Extensions
 *
 * @category   Aceextensions
 * @package    Aceextensions_B2bRegistration
 * @author     Durga Shankar Gupta (dsguptas@gmail.com)
 * @copyright  Copyright (c) 2019 Aceextensions Extensions ( http://aceextensions.com )
 */

namespace Aceextensions\B2bRegistration\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{

    CONST SYSTEM_PREFIX="b2bregistration";

    CONST SYSTEM_CONFIG_GENERAL_ENABLE=self::SYSTEM_PREFIX.'/general/enable';
    /**
     * Check is module enable
     * @return bool
     */
    public function isEnable ()
    {
        return $this->scopeConfig->isSetFlag(
            self::SYSTEM_CONFIG_GENERAL_ENABLE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get B2b Url
     * @return string
     */
    public function getB2bUrl ()
    {
        $bbUrl = $this->scopeConfig->getValue(
            'b2bregistration/register/b2b_url',
            ScopeInterface::SCOPE_STORE
        );
        return $bbUrl;
    }

    /**
     * Enable Shortcut Link
     * @return bool
     */
    public function isEnableShortcutLink ()
    {
        return $this->scopeConfig->isSetFlag(
            'b2bregistration/register/shortcut_link',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Shortcut Link Text
     * @return string
     */
    public function getShortcutLinkText ()
    {
        $text = $this->scopeConfig->getValue(
            'b2bregistration/register/shortcut_link_text',
            ScopeInterface::SCOPE_STORE
        );
        return $text;
    }

    /**
     * Get Date Field
     * @return bool
     */
    public function getDateField ()
    {
        return $this->scopeConfig->isSetFlag(
            'b2bregistration/register/date',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Tax Field
     * @return bool
     */
    public function getTaxField ()
    {
        return $this->scopeConfig->isSetFlag(
            'b2bregistration/register/tax',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Gender Field
     * @return bool
     */
    public function getGenderField ()
    {
        return $this->scopeConfig->isSetFlag(
            'b2bregistration/register/gender',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Address Field
     * @return bool
     */
    public function getAddressField ()
    {
        return $this->scopeConfig->isSetFlag(
            'b2bregistration/register/address',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Title of Page
     * @return string
     */
    public function getTitle ()
    {
        $text = $this->scopeConfig->getValue(
            'b2bregistration/register/title',
            ScopeInterface::SCOPE_STORE
        );
        return $text;
    }

    /**
     * Get Group Id
     * @return int
     */
    public function getCustomerGroup ()
    {
        $group = $this->scopeConfig->getValue(
            'b2bregistration/register/customer_group',
            ScopeInterface::SCOPE_STORE
        );
        return $group;
    }

    /**
     * Get Enable email to Admin
     * @return bool
     */
    public function isEnableAdminEmail ()
    {
        return $this->scopeConfig->isSetFlag(
            'b2bregistration/admin_notification/admin_notification_enable',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Enable Email to Customer
     * @return bool
     */
    public function isEnableCustomerEmail ()
    {
        return $this->scopeConfig->isSetFlag(
            'b2bregistration/email_setting/customer_email_enable',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Enable Auto Approval
     * @return bool
     */
    public function isAutoApproval ()
    {
        return $this->scopeConfig->isSetFlag(
            'b2bregistration/approval/auto_approval',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Disable Regular Register
     * @return bool
     */
    public function disableRegularForm ()
    {
        return $this->scopeConfig->isSetFlag(
            'b2bregistration/register/regular_registration',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get pending Mess
     * @return string $pendingMess
     */
    public function getPendingMess ()
    {
        $pendingMess = $this->scopeConfig->getValue(
            'b2bregistration/approval/pending_message',
            ScopeInterface::SCOPE_STORE
        );
        return $pendingMess;
    }

    /**
     * Get Email template Id
     * @return string $emailTemplate
     */
    public function getAdminEmailTemplate ()
    {
        $emailTemplate = $this->scopeConfig->getValue(
            'b2bregistration/admin_notification/admin_email_templates',
            ScopeInterface::SCOPE_STORE
        );
        return $emailTemplate;
    }

    /**
     * Get Approval template Id
     * @return string $customerApproveEmailTemplate
     */
    public function getCustomerApproveEmailTemplate ()
    {
        $customerApproveEmailTemplate = $this->scopeConfig->getValue(
            'b2bregistration/email_setting/customer_approve_templates',
            ScopeInterface::SCOPE_STORE
        );
        return $customerApproveEmailTemplate;
    }

    /**
     * Get Reject template Id
     * @return string $customerDisapproveEmailTemplate
     */
    public function getCustomerRejectEmailTemplate ()
    {
        $customerRejectEmailTemplate = $this->scopeConfig->getValue(
            'b2bregistration/email_setting/customer_disapprove_templates',
            ScopeInterface::SCOPE_STORE
        );
        return $customerRejectEmailTemplate;
    }

    /**
     * Get Email Sender in Store
     * @return $emailSender
     */
    public function getAdminEmailSender ()
    {
        $emailSender = $this->scopeConfig->getValue(
            'b2bregistration/admin_notification/admin_email_sender',
            ScopeInterface::SCOPE_STORE
        );
        return $emailSender;
    }

    /**
     * Get Email Recipeints
     * @return $emailAdmin
     */
    public function getAdminEmail ()
    {
        $emailAdmin = $this->scopeConfig->getValue(
            'b2bregistration/admin_notification/admin_recipeints',
            ScopeInterface::SCOPE_STORE
        );
        return $emailAdmin;
    }

    /**
     * Get Email Sender in Store
     * @return $customerEmailSender
     */
    public function getCustomerEmailSender ()
    {
        $customerEmailSender = $this->scopeConfig->getValue(
            'b2bregistration/email_setting/customer_email_sender',
            ScopeInterface::SCOPE_STORE
        );
        return $customerEmailSender;
    }

    /**
     * Get Reject/Disappval Mess
     * @return string
     */
    public function getDisapproveMess ()
    {
        $rejectMess = $this->scopeConfig->getValue(
            'b2bregistration/approval/disapprove_message',
            ScopeInterface::SCOPE_STORE
        );
        return $rejectMess;
    }

    /**
     * Get Prefix Field
     * @return string
     */
    public function getPrefixField ()
    {
        $prefix = $this->scopeConfig->getValue(
            'b2bregistration/register/prefix',
            ScopeInterface::SCOPE_STORE
        );
        return $prefix;
    }

    /**
     * Get Prefix Option
     * @return string
     */
    public function getPrefixOptions ()
    {
        $prefixOptions = $this->scopeConfig->getValue(
            'b2bregistration/register/prefix_options',
            ScopeInterface::SCOPE_STORE
        );
        return $prefixOptions;
    }

    /**
     * Get Suffix Field
     * @return string
     */
    public function getSuffixField ()
    {
        $suffix = $this->scopeConfig->getValue(
            'b2bregistration/register/suffix',
            ScopeInterface::SCOPE_STORE
        );
        return $suffix;
    }

    /**
     * Get Suffix Options
     * @return string
     */
    public function getSuffixOptions ()
    {
        $suffixOptions = $this->scopeConfig->getValue(
            'b2bregistration/register/suffix_options',
            ScopeInterface::SCOPE_STORE
        );
        return $suffixOptions;
    }

    /**
     * Get Middle Field
     * @return int
     */
    public function getMiddleField ()
    {
        $suffix = $this->scopeConfig->getValue(
            'b2bregistration/register/middle',
            ScopeInterface::SCOPE_STORE
        );
        return $suffix;
    }

    /**
     * Get Suffix Field Default Config
     * @return string
     */
    public function getSuffixFieldDefault ()
    {
        $suffixDefault = $this->scopeConfig->getValue(
            'customer/address/suffix_show',
            ScopeInterface::SCOPE_STORE
        );
        return $suffixDefault;
    }

    /**
     * Get Preffix Field Default Config
     * @return string
     */
    public function getPreffixFieldDefault ()
    {
        $prefixDefault = $this->scopeConfig->getValue(
            'customer/address/prefix_show',
            ScopeInterface::SCOPE_STORE
        );
        return $prefixDefault;
    }

    /**
     * Get Dob Field Default Config
     * @return string
     */
    public function getDobFieldDefault ()
    {
        $dobDefault = $this->scopeConfig->getValue(
            'customer/address/dob_show',
            ScopeInterface::SCOPE_STORE
        );
        return $dobDefault;
    }

    /**
     * Get Tax Field Default Config
     * @return string
     */
    public function getTaxFieldDefault ()
    {
        $taxDefault = $this->scopeConfig->getValue(
            'customer/address/taxvat_show',
            ScopeInterface::SCOPE_STORE
        );
        return $taxDefault;
    }

    /**
     * Get Gender Field Default Config
     * @return string
     */
    public function getGenderFieldDefault ()
    {
        $genderDefault = $this->scopeConfig->getValue(
            'customer/address/gender_show',
            ScopeInterface::SCOPE_STORE
        );
        return $genderDefault;
    }

    /**
     * Get Telephone Field Default Config
     * @return string
     */
    public function getTelephoneFieldDefault ()
    {
        $telephoneDefault = $this->scopeConfig->getValue(
            'customer/address/telephone_show',
            ScopeInterface::SCOPE_STORE
        );
        return $telephoneDefault;
    }

    /**
     * Get Company Field Default Config
     * @return string
     */
    public function getCompanyFieldDefault ()
    {
        $companyDefault = $this->scopeConfig->getValue(
            'customer/address/company_show',
            ScopeInterface::SCOPE_STORE
        );
        return $companyDefault;
    }

    /**
     * Get Fax Field Default Config
     * @return string
     */
    public function getFaxFieldDefault ()
    {
        $faxDefault = $this->scopeConfig->getValue(
            'customer/address/fax_show',
            ScopeInterface::SCOPE_STORE
        );
        return $faxDefault;
    }

    /**
     * Get Vat Field Default Config
     * @return string
     */
    public function getVatFieldDefault ()
    {
        $vatDefault = $this->scopeConfig->getValue(
            'customer/create_account/vat_frontend_visibility',
            ScopeInterface::SCOPE_STORE
        );
        return $vatDefault;
    }
}
