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

use Magento\Framework\Module\Manager as ModuleManager;
use Magento\Customer\Model\ResourceModel\Group\Collection;

class Group implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var ModuleManager
     */
    protected $moduleManager;
    /**
     * @var Collection
     */
    protected $customerGroup;

    /**
     * Group constructor.
     * @param ModuleManager $moduleManager
     * @param Collection $customerGroup
     */
    public function __construct (
        ModuleManager $moduleManager,
        Collection $customerGroup
    ) {
        $this->moduleManager = $moduleManager;
        $this->customerGroup = $customerGroup;
    }

    /**
     * @return array
     */
    public function toOptionArray ()
    {
        if (!$this->moduleManager->isEnabled('Magento_Customer')) {
            return [];
        }
        $customerGroups = [];

        $groups = $this->customerGroup->toOptionArray();
        foreach ($groups as $group) {
            if ($group['value'] != 0) {
                $customerGroups[] = [
                    'label' => $group['label'],
                    'value' => $group['value'],
                ];
            }
        }
        return $customerGroups;
    }
}