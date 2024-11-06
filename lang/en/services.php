<?php

return [
    'v1' => [
        'create' => [
            'success' => 'Service will be created in the background',
            'failure' => 'You must verify before creating service',
        ],
        'show' => [
            'failure' => 'You are not allowed to view this service',
        ],
        'update' => [
            'success' => 'We will update your service in the background',
            'failure' => 'You must verify before update a service ou do not own',
        ],
        'delete' => [
            'success' => 'Service will be deleted shortly',
            'failure' => 'You are not authorize to delete this service',
        ],
    ],
];
