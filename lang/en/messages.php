<?php

return [
    'exceptions' => [
        'models' => [
            'group' => [
                'circular_membership' => 'Circular membership detected: Group [:target.id[:target.name]] cannot be added to [:source.id[:source.name]]',
            ],
        ],
    ],
];
