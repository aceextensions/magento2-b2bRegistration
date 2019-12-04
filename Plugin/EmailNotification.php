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

use Magento\Customer\Api\Data\CustomerInterface;
use Ace\B2bRegistration\Helper\Data;
use Magento\Customer\Model\EmailNotification as EmailNotificationDefault;

class EmailNotification
{
    const XML_PATH_REGISTER_EMAIL_TEMPLATE = 'customer/create_account/email_template';
    const XML_PATH_REGISTER_NO_PASSWORD_EMAIL_TEMPLATE = 'customer/create_account/email_no_password_template';
    const XML_PATH_CONFIRM_EMAIL_TEMPLATE = 'customer/create_account/email_confirmation_template';
    const XML_PATH_CONFIRMED_EMAIL_TEMPLATE = 'customer/create_account/email_confirmed_template';

    const TEMPLATE_TYPES = [
        EmailNotificationDefault::NEW_ACCOUNT_EMAIL_REGISTERED => self::XML_PATH_REGISTER_EMAIL_TEMPLATE,
        EmailNotificationDefault::NEW_ACCOUNT_EMAIL_REGISTERED_NO_PASSWORD => self::XML_PATH_REGISTER_NO_PASSWORD_EMAIL_TEMPLATE,
        EmailNotificationDefault::NEW_ACCOUNT_EMAIL_CONFIRMED => self::XML_PATH_CONFIRMED_EMAIL_TEMPLATE,
        EmailNotificationDefault::NEW_ACCOUNT_EMAIL_CONFIRMATION => self::XML_PATH_CONFIRM_EMAIL_TEMPLATE,
    ];

    /**
     * EmailNotification constructor.
     * @param Data $helper
     */
    public function __construct (
        Data $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * @param EmailNotificationDefault $subject
     * @param callable $proceed
     * @param CustomerInterface $customer
     * @param string $type
     * @param string $backUrl
     * @param int $storeId
     * @param null $sendemailStoreId
     * @return bool
     */
    public function aroundNewAccount (
        \Magento\Customer\Model\EmailNotification $subject,
        callable $proceed,
        \Magento\Customer\Api\Data\CustomerInterface $customer,
        $type = \Magento\Customer\Model\EmailNotificationInterface::NEW_ACCOUNT_EMAIL_REGISTERED,
        $backUrl = '',
        $storeId = 0,
        $sendemailStoreId = null
    ) {
        $enable = $this->helper->isEnable();
        $isAutoApproval = $this->helper->isAutoApproval();
        if ($type == EmailNotificationDefault::NEW_ACCOUNT_EMAIL_REGISTERED && $enable && !$isAutoApproval) {
            return false;
        } else {
            return $proceed($customer, $type, $backUrl, $storeId, $sendemailStoreId);
        }
    }
}
