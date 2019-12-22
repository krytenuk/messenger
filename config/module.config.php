<?php

use FwsMessanger\Controller\Plugin\Messenger as PluginMessenger;
use FwsMessanger\View;
use Zend\ServiceManager\Factory\InvokableFactory;

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
             View\Helper\Messenger::class => View\Service\Helper\MessangerFactory::class,
        ],
        'aliases' => [
            'fwsMessenger' => View\Helper\Messenger::class,
        ],
    ],
);

