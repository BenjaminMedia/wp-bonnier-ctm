<?php

namespace Tests\Bonnier\WP\CTM;


use Bonnier\WP\CTM\Models\Teaser;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class TeaserTest extends TestCase
{
    public function testCorrectlyConvertsArray()
    {
        $faker = Factory::create();
        $data = [
            'id' => $faker->randomDigitNotNull,
            'title' => $faker->sentence(3),
            'body' => $faker->text(),
            'image' => $faker->imageUrl(),
            'video' => $faker->url,
            'campaign_link' => $faker->url,
        ];

        $teaser = new Teaser($data);

        $this->assertEquals($data['id'], $teaser->getId());
        $this->assertEquals($data['title'], $teaser->getTitle());
        $this->assertEquals($data['body'], $teaser->getBody());
        $this->assertEquals($data['image'], $teaser->getImage());
        $this->assertEquals($data['video'], $teaser->getVideo());
        $this->assertEquals($data['campaign_link'], $teaser->getLink());
    }

    public function testCanHandleNullValues()
    {
        $teaser = new Teaser([
            'id' => null,
            'title' => null,
            'body' => null,
            'image' => null,
            'video' => null,
            'campaign_link' => null,
        ]);

        $this->assertEquals(0, $teaser->getId());
        $this->assertEquals('', $teaser->getTitle());
        $this->assertEquals('', $teaser->getBody());
        $this->assertEquals('', $teaser->getImage());
        $this->assertEquals('', $teaser->getVideo());
        $this->assertEquals('', $teaser->getLink());
    }

    public function testCanHandleEmptyArray()
    {
        $teaser = new Teaser([]);

        $this->assertEquals(0, $teaser->getId());
        $this->assertEquals('', $teaser->getTitle());
        $this->assertEquals('', $teaser->getBody());
        $this->assertEquals('', $teaser->getImage());
        $this->assertEquals('', $teaser->getVideo());
        $this->assertEquals('', $teaser->getLink());
    }
}
