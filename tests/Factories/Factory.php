<?php

namespace Tests\Bonnier\WP\CTM\Factories;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class Factory
{
    /**
     * @param array $responses Array of Guzzle Response objects
     * @param int $queueSize The size of the mocked queue
     * @return Client
     */
    public static function getGuzzleClient(array $responses = [], $queueSize = 1): Client
    {
        if (empty($responses)) {
            for ($i = 0; $i < $queueSize; $i++) {
                array_push($responses, self::getValidCTMResponse());
            }
        }

        $mock = new MockHandler($responses);
        $handler = HandlerStack::create($mock);
        return new Client(['handler' => $handler]);
    }

    /**
     * @param int $count Amount of teasers to generate
     * @return array
     */
    public static function getTeaserDataArray($count = 1)
    {
        $faker = \Faker\Factory::create();
        $data = [];
        for ($i = 0; $i < $count; $i++) {
            $data[] = [
                'id' => $faker->randomDigitNotNull,
                'title' => $faker->sentence(3),
                'body' => $faker->text(),
                'image' => $faker->imageUrl(),
                'video' => $faker->url,
                'campaign_link' => $faker->url,
            ];
        }
        return $data;
    }

    /**
     * @return Response
     */
    public static function getValidCTMResponse(): Response
    {
        $data = [
            'data' => self::getTeaserDataArray(),
            'meta' => [
                'pagination' => [
                    'total' => 1,
                    'count' => 1,
                    'per_page' => 30,
                    'current_page' => 1,
                    'total_pages' => 1,
                    'links' => []
                ],
            ],
        ];

        return new Response(200, [], json_encode($data));
    }

    /**
     * @return Response
     */
    public static function getEmptyCTMResponse(): Response
    {
        $data = [
            'data' => [],
            'meta' => [
                'pagination' => [
                    'total' => 0,
                    'count' => 0,
                    'per_page' => 30,
                    'current_page' => 1,
                    'total_pages' => 1,
                    'links' => []
                ],
            ],
        ];
        return new Response(200, [], json_encode($data));
    }

    /**
     * @return Response
     */
    public static function getInvalidCTMResponse(): Response
    {
        $data = [
            'message' => 'The given data was invalid.',
            'errors' => [
                'locale' => [
                    'The locale field is required.',
                ]
            ],
        ];

        return new Response(422, [], json_encode($data));
    }
}
