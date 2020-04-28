<?php

namespace Aceextensions\B2bRegistration\Observer;

use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Module\ModuleList;
use Magento\TestFramework\ObjectManager;

/**
 * Class AceextensionsModuleTest
 * @package Aceextensions\B2bRegistration\Observer
 */
class AceextensionsModuleTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var string
     */
    private $moduleName = 'Aceextensions_B2bRegistration';


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