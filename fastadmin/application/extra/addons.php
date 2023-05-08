<?php

return [
    'autoload' => false,
    'hooks' => [
        'app_init' => [
            'crontab',
            'log',
        ],
        'config_init' => [
            'cropper',
            'simditor',
            'summernote',
        ],
        'upgrade' => [
            'simditor',
        ],
        'wipecache_after' => [
            'tinymce',
        ],
        'set_tinymce' => [
            'tinymce',
        ],
    ],
    'route' => [
        '/example$' => 'example/index/index',
        '/example/d/[:name]' => 'example/demo/index',
        '/example/d1/[:name]' => 'example/demo/demo1',
        '/example/d2/[:name]' => 'example/demo/demo2',
    ],
    'priority' => [],
    'domain' => '',
];
