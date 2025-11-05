<?php

return [
    // 'panel' =>[
    //     'install' => true
    //  ]
    //'debug' => true,

    'routes' => [
        [
            'pattern' => '(:any)',
            'action'  => function($uid) {
                $page = page($uid);
                if (!$page) $page = page('slashes/' . $uid);
                if (!$page) $page = site()->errorPage();
                return site()->visit($page);
            }
        ],
        [
            'pattern' => 'slashes/(:any)',
            'action'  => function($uid) {
                go($uid);
            }
        ]
    ],

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
