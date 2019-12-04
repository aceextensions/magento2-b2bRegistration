<?php
/**
 * Ace Extensions
 *
 * @category   Ace
 * @package    Ace_B2bRegistration
 * @author     Durga Shankar Gupta (dsguptas@gmail.com)
 * @copyright  Copyright (c) 2019 Ace Extensions ( http://aceextensions.com )
 */

namespace Ace\B2bRegistration\Block\Adminhtml\Edit\Tab\View;

use Ace\B2bRegistration\Model\Config\Source\CustomerAttribute;

class Status extends \Magento\Customer\Block\Adminhtml\Edit\Tab\View\PersonalInfo
{
    /**
     * Get customer status
     * @return string $value
     */
    public function getStatus ()
    {
        $customerStatus = $this->getCustomer()->getCustomAttribute('b2b_activasion_status');
        if ($customerStatus) {
            $customerValue = $customerStatus->getValue();
            switch ($customerValue) {
                case CustomerAttribute::B2B_PENDING:
                    $customerValue = __("B2B Pending");
                    break;
                case CustomerAttribute::B2B_APPROVAL:
                    $customerValue = __("B2B Approval");
                    break;
                case CustomerAttribute::B2B_REJECT:
                    $customerValue = __("B2B Reject");
                    break;
                default:
                    $customerValue = __("Normal Account");
            }
        } else {
            $customerValue = __("Normal Account");
        }
        return $customerValue;
    }
}
