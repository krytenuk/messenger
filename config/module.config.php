<?php

use FwsMessenger\Controller\Plugin\Messenger as PluginMessenger;
use FwsMessenger\View;
use Laminas\ServiceManager\Factory\InvokableFactory;

return array(
    'controller_plugins' => [
        'factories' => [
            PluginMessenger::class => InvokableFactory::class,
        ],
        'aliases' => [
            'fwsMessenger' => PluginMessenger::class,
        ],
    ],
    'view_helpers' => [
         'factories' => [
             View\Helper\Messenger::class => View\Service\Helper\MessengerFactory::class,
        ],
        'aliases' => [
            'fwsMessenger' => View\Helper\Messenger::class,
        ],
    ],
);

