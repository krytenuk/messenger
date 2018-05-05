<?php

namespace FwsMessanger\View\Service\Helper;

use Zend\ServiceManager\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use FwsMessanger\View\Helper\Messanger;

/**
 * MessangerFactory
 *
 * @author Garry Childs (Freedom Web Services)
 */
class MessangerFactory implements FactoryInterface
{

    /**
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array $options
     * @return Messanger
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new Messanger($container->get('ControllerPluginManager')->get('fwsMessanger'), $container->get('config'));
    }

    /**
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param string $normalizedName
     * @param string $requestedName
     * @return Messanger
     */
    public function createService(ServiceLocatorInterface $serviceLocator, $normalizedName = NULL, $requestedName = NULL)
    {
        return $this($serviceLocator->getServiceLocator(), $requestedName);
    }

}
