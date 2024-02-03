<?php
/**
 * Aceextensions Extensions
 *
 * @category   Aceextensions
 * @package    Aceextensions_B2bRegistration
 * @author     Durga Shankar Gupta (dsguptas@gmail.com)
 * @copyright  Copyright (c) 2019 Aceextensions Extensions ( http://aceextensions.com )
 */

namespace Aceextensions\B2bRegistration\Controller;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Router implements \Magento\Framework\App\RouterInterface
{
    /**
     * @var \Magento\Framework\App\ActionFactory
     */
    protected $actionFactory;

    /**
     * @var \Aceextensions\B2bRegistration\Helper\Data
     */
    private $helper;

    /**
     * @param \Magento\Framework\App\ActionFactory $actionFactory
     * @param \Aceextensions\B2bRegistration\Helper\Data $helper
     */
    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        \Aceextensions\B2bRegistration\Helper\Data $helper
    ) {
        $this->actionFactory = $actionFactory;
        $this->helper = $helper;
    }

    /**
     * @param RequestInterface $request
     *
     * @return ActionInterface|null
     */
    public function match(RequestInterface $request): ?ActionInterface
    {
        $action = null;
        $enable = $this->helper->isEnable();
        if ($enable) {
            $bbUrl = $this->helper->getB2bUrl();
            $urlRequest = $request->getOriginalPathInfo();
            $urlRequest = str_replace('/', '', $urlRequest);
            $urlRequest = str_replace('.html', '', $urlRequest);
            if ($bbUrl == $urlRequest) {
                $request->setModuleName('b2b')->setControllerName('account')->setActionName('create');

                return $this->actionFactory->create(\Magento\Framework\App\Action\Forward::class);
            }
        }
        return $action;
    }
}
