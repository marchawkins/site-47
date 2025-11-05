<?php

return [
    // 'panel' =>[
    //     'install' => true
    //  ]
    'debug' => false,

    'routes' => [
        [
            'pattern' => 'sitemap.xml',
            'action'  => function() {
                $pages = site()->pages()->index();

                // fetch the pages to ignore from the config settings,
                // if nothing is set, we ignore the error page
                $ignore = kirby()->option('sitemap.ignore', ['error']);

                $content = snippet('sitemap', compact('pages', 'ignore'), true);

                // return response with correct header type
                return new Kirby\Cms\Response($content, 'application/xml');
            }
        ],
        [
            'pattern' => 'sitemap',
            'action'  => function() {
                return go('sitemap.xml', 301);
            }
        ],
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
    'sitemap.ignore' => ['error'],
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
