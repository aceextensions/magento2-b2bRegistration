<?php
/**
 * Aceextensions Extensions
 *
 * @category   Aceextensions
 * @package    Aceextensions_B2bRegistration
 * @author     Durga Shankar Gupta (dsguptas@gmail.com)
 * @copyright  Copyright (c) 2019 Aceextensions Extensions ( http://aceextensions.com )
 */

namespace Aceextensions\B2bRegistration\Plugin;

use Aceextensions\B2bRegistration\Helper\Data;

class Registration
{
    /**
     * @var Data
     */
    protected $helper;

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
     * @param \Magento\Customer\Model\Registration $subject
     * @param bool $result
     * @return bool
     */
    public function afterIsAllowed (\Magento\Customer\Model\Registration $subject, $result)
    {
        $enable = $this->helper->isEnable();
        $disableRegularForm = $this->helper->disableRegularForm();
        if ($enable && $disableRegularForm) {
            $result = false;
            return $result;
        }
        return $result;
    }
}
