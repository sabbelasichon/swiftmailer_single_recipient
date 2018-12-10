<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Swiftmailer single recipient configuration',
    'description' => 'Swiftmailer single recipient configuration during development',
    'category' => 'misc',
    'author' => 'Sebastian Schreiber',
    'author_email' => 'breakpoint@schreibersebastian.de',
    'state' => 'beta',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-8.7.99',
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Ssch\\SwiftmailerSingleRecipient\\' => 'Classes',
        ],
    ],
    'autoload-dev' => [
        'psr-4' => [
            'Ssch\\SwiftmailerSingleRecipient\\Tests\\' => 'Tests',
        ],
    ],
];
