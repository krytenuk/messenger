<?php
return array(
    'controller_plugins' => array(
        'invokables' => array(
            'fwsMessanger' => 'FwsMessanger\Controller\Plugin\Messanger',
        ),
    ),
    'view_helpers' => array(
        'factories' => array(
            'fwsFlashMessenger' => 'FwsMessanger\View\Service\Helper\FlashMessengerFactory',
            'fwsMessenger' => 'FwsMessanger\View\Service\Helper\MessangerFactory',
        ),
    ),
);

