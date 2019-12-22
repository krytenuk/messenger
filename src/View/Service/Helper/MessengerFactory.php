<?php

namespace FwsMessenger\View\Service\Helper;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\I18n\Translator\TranslatorInterface;
use FwsMessenger\View\Helper\Messenger as MessengerViewHelper;
use FwsMessenger\Controller\Plugin\Messenger as PluginMessenger;

/**
 * MessangerFactory
 *
 * @author Garry Childs <info@freedomwebservices.net>
 */
class MessengerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ContainerInterface $container
     * @param string $name
     * @param null|array $options
     * @return FlashMessenger
     */
    public function __invoke(ContainerInterface $container, $name, array $options = null)
    {
        $config = $container->get('config');
        
        $helper = new MessengerViewHelper();
        $helper->setPluginMessenger($container->get('ControllerPluginManager')->get(PluginMessenger::class))
                ->setTranslator($container->get(TranslatorInterface::class));

        if (isset($config['view_helper_config']['fwsmessenger'])) {
            $configHelper = $config['view_helper_config']['fwsmessenger'];
            if (isset($configHelper['message_open_format'])) {
                $helper->setMessageOpenFormat($configHelper['message_open_format']);
            }
            if (isset($configHelper['message_separator_string'])) {
                $helper->setMessageSeparatorString($configHelper['message_separator_string']);
            }
            if (isset($configHelper['message_close_string'])) {
                $helper->setMessageCloseString($configHelper['message_close_string']);
            }
        }

        return $helper;
    }

}
