<?php

return [
    'client' => [
        'hosts' => explode(',', env('ELASTICSEARCH_HOSTS')),
    ],
    'parameters' => [
        'search_range' => '1000',
        'search_unit' => 'km',
        'posts' => [
            'mappings' => [
                ['field' => 'id', 'type' => 'integer'],
                ['field' => 'profile_id', 'type' => 'integer'],
                ['field' => 'activity', 'type' => 'double'],
                ['field' => 'body', 'type' => 'text'],
                ['field' => 'image', 'type' => 'text'],
                ['field' => 'created_at', 'type' => 'date'],
                ['field' => 'updated_at', 'type' => 'date'],
                ['field' => 'location', 'type' => 'geo_point'],
            ]
        ],
        'profiles' => [
            'mappings' => [
                ['field' => 'id', 'type' => 'integer'],
                ['field' => 'user_id', 'type' => 'integer'],
                ['field' => 'username', 'type' => 'text', 'keyword' => true],
                ['field' => 'name', 'type' => 'text', 'keyword' => true],
                ['field' => 'bio', 'type' => 'text'],
                ['field' => 'avatar', 'type' => 'text'],
                ['field' => 'created_at', 'type' => 'date'],
                ['field' => 'email_verified_at', 'type' => 'date'],
                ['field' => 'updated_at', 'type' => 'date'],
                ['field' => 'deleted_at', 'type' => 'date'],
                ['field' => 'location', 'type' => 'geo_point'],
            ]
        ]
    ]
];
