<?php
/**
 * Ace Extensions
 *
 * @category   Ace
 * @package    Ace_B2bRegistration
 * @author     Durga Shankar Gupta (dsguptas@gmail.com)
 * @copyright  Copyright (c) 2019 Ace Extensions ( http://aceextensions.com )
 */

namespace Ace\B2bRegistration\Model\Config\Source;

class CustomerAttribute implements \Magento\Framework\Option\ArrayInterface
{
    const NORMAL_ACCOUNT = 0;
    const B2B_PENDING = 1;
    const B2B_APPROVAL = 2;
    const B2B_REJECT = 3;

    /**
     * @var $options
     */
    protected $options;

    /**
     * @return array
     */
    public function toOptionArray ()
    {
        if ($this->options !== null) {
            return $this->options;
        }

        $options[] = [
            'label' => __('Normal Account'),
            'value' => self::NORMAL_ACCOUNT,
        ];
        $options[] = [
            'label' => __('B2B Pending'),
            'value' => self::B2B_PENDING,
        ];
        $options[] = [
            'label' => __('B2B Approval'),
            'value' => self::B2B_APPROVAL,
        ];
        $options[] = [
            'label' => __('B2B Reject'),
            'value' => self::B2B_REJECT,
        ];

        $this->options = $options;

        return $this->options;
    }
}