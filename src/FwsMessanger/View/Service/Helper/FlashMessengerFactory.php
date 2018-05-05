<?php

namespace FwsMessanger\View\Service\Helper;

use Zend\ServiceManager\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use FwsMessanger\View\Helper\FlashMessenger;

/**
 * FlashMessengerFactory
 *
 * @author Garry Childs (Freedom Web Services)
 */
class FlashMessengerFactory implements FactoryInterface
{

    /**
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return FlashMessenger
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        // test if we are using Zend\ServiceManager v2 or v3
        if (!method_exists($container, 'configure')) {
            $container = $container->getServiceLocator();
        }

        return new FlashMessenger($container->get('config'));
    }

    /**
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param string $normalizedName
     * @param string $requestedName
     * @return FlashMessenger
     */
    public function createService(ServiceLocatorInterface $serviceLocator, $normalizedName = NULL, $requestedName = NULL)
    {
        return $this($serviceLocator, $requestedName);
    }

}
