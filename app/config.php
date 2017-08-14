<?php
/**
 * configuration file for application
 */
return [
    'show_errors' => '1',
    'log_errors' => '1',
    'db' => [
        'host' => 'localhost',
        'db' => 'mini_mvc',
        'user' => 'root',
        'password' => ''
    ],
    'page_not_found_route' => ['pattern' => '/error404',
        'module' => 'Common',
        'controller' => 'Index',
        'action' => 'error404',
    ],

    'routes' => [
        ['pattern' => '/',
            'module' => 'Students',
            'controller' => 'Index',
            'action' => 'index',
        ],
        ['pattern' => '/students',
            'module' => 'Students',
            'controller' => 'Index',
            'action' => 'index',
        ],
        ['pattern' => '/students/create',
            'module' => 'Students',
            'controller' => 'Index',
            'action' => 'edit',
        ],
        ['pattern' => '/students/save',
            'module' => 'Students',
            'controller' => 'Index',
            'action' => 'edit',
        ],
        ['pattern' => '/students/edit/{id:\d+}',
            'module' => 'Students',
            'controller' => 'Index',
            'action' => 'edit',
        ],
        ['pattern' => '/students/view/{id:\d+}',
            'module' => 'Students',
            'controller' => 'Index',
            'action' => 'view'
        ],
        ['pattern' => '/students/delete/{id:\d+}',
            'module' => 'Students',
            'controller' => 'Index',
            'action' => 'delete'
        ],
    ]
];