<?php

namespace App\Helpers;

class ApiRoutesHelper
{
    public static function all(): array
    {
        return [
            [
                'type' => 'GET',
                'title' => 'Get a user',
                'description' => 'Get a user by their ID.',
                'route' => config('app.url') . '/api/user/{{ user_id }}',
                'params' => [
                    [
                        'slug' => 'user_id',
                        'default' => 1,
                        'description' => 'The ID of the user to retrieve.',
                    ],
                ],
            ],
            [
                'type' => 'POST',
                'title' => 'Create a battle request',
                'description' => 'Create a battle request for the user the api key is from.',
                'route' => config('app.url') . '/api/request-battle',
                'params' => [],
            ],
            [
                'type' => 'GET',
                'title' => 'Get availabilities',
                'description' => 'Get all the availabilities from the user the api key is from.',
                'route' => config('app.url') . '/api/availabilities',
                'params' => [],
            ],
            [
                'type' => 'POST',
                'title' => 'Add an availability',
                'description' => 'Add an availability for the user the api key is from.',
                'route' => config('app.url') . '/api/availability/add?start_date={{ start_date }}&end_date={{ end_date }}',
                'params' => [
                    [
                        'slug' => 'start_date',
                        'default' => '2025-02-01',
                        'description' => 'The start date of the availability.',
                    ],
                    [
                        'slug' => 'end_date',
                        'default' => '2025-02-10',
                        'description' => 'The end date of the availability.',
                    ],
                ],
            ],
            [
                'type' => 'GET',
                'title' => 'Get leaderboard',
                'description' => 'Get the leaderboard.',
                'route' => config('app.url') . '/api/leaderboard',
                'params' => [],
            ],
            [
                'type' => 'GET',
                'title' => 'Get user statistics',
                'description' => 'Get the statistics for a user.',
                'route' => config('app.url') . '/api/user/{{ user_id }}/statistics',
                'params' => [
                    [
                        'slug' => 'user_id',
                        'default' => 1,
                        'description' => 'The ID of the user to retrieve statistics for.',
                    ],
                ],
            ],
            [
                'type' => 'GET',
                'title' => 'Get user battles',
                'description' => 'Get the battles for a user.',
                'route' => config('app.url') . '/api/user/{{ user_id }}/battles',
                'params' => [
                    [
                        'slug' => 'user_id',
                        'default' => 1,
                        'description' => 'The ID of the user to retrieve battles for.',
                    ],
                ],
            ],
            [
                'type' => 'GET',
                'title' => 'Get a battle',
                'description' => 'Get a battle by its ID.',
                'route' => config('app.url') . '/api/battle/{{ battle_id }}',
                'params' => [
                    [
                        'slug' => 'battle_id',
                        'default' => 1,
                        'description' => 'The ID of the battle to retrieve.',
                    ],
                ],
            ],
        ];
    }
}
