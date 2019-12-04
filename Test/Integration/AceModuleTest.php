<?php

namespace Ace\B2bRegistration\Observer;

use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Module\ModuleList;
use Magento\TestFramework\ObjectManager;

/**
 * Class AceModuleTest
 * @package Ace\B2bRegistration\Observer
 */
class AceModuleTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var string
     */
    private $moduleName = 'Ace_B2bRegistration';


    /**
     * @var ObjectManager
     */
    private $objectManager;


    protected function setUp()
    {
        /** @var  objectManager */
        $this->objectManager = ObjectManager::getInstance();
    }


    public function testTheModuleIsRegistered()
    {
        /** @var  $registrar */
        $registrar = new ComponentRegistrar();
        $paths = $registrar->getPaths(ComponentRegistrar::MODULE);
        $this->assertArrayHasKey($this->moduleName, $paths);
    }


    public function testTheModuleIsKnownAndEnabledInTheTestEnvironment()
    {
        /** @var ModuleList $moduleList */
        $moduleList = $this->objectManager->create(ModuleList::class);
        $message = sprintf('The module "%s" is not enabled in the test environment', $this->moduleName);
        $this->assertTrue($moduleList->has($this->moduleName), $message);
    }

}