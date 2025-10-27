<?php

return [
    // 'panel' =>[
    //     'install' => true
    //  ]
    'debug' => true,
    'mauricerenck.komments.debug' => false,
    'mauricerenck.komments.storage.type' => 'markdown',
    'notifications.email.enable' => true,
    'notifications.email.sender' => 'no-reply@marchawkins.com',
    'notifications.email.emailReceiverList' => 'marchawkins@gmail.com',
    'ready' => function ($kirby) {
        return [
            'pechente.kirby-admin-bar' => [
                'active' => $kirby->user() !== null
            ]
        ];
    }
];

?>
