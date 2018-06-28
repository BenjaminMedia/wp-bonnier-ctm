<?php

namespace Tests\Bonnier\WP\CTM;

use Bonnier\WP\CTM\Models\Teaser;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class TeaserTest extends TestCase
{
    public function testCorrectlyConvertsObject()
    {
        $faker = Factory::create();
        $data = new \stdClass();
        $data->id = $faker->randomDigitNotNull;
        $data->title = $faker->sentence(3);
        $data->body = $faker->text();
        $data->image = $faker->imageUrl();
        $data->video = $faker->url;
        $data->inline = $faker->boolean;
        $data->campaign_link = $faker->url;

        $teaser = new Teaser($data);

        $this->assertEquals($data->id, $teaser->getId());
        $this->assertEquals($data->title, $teaser->getTitle());
        $this->assertEquals($data->body, $teaser->getBody());
        $this->assertEquals($data->image, $teaser->getImage());
        $this->assertEquals($data->video, $teaser->getVideo());
        $this->assertEquals($data->inline, $teaser->isInline());
        $this->assertEquals($data->campaign_link, $teaser->getLink());
    }

    public function testCanHandleNullValues()
    {
        $data = new \stdClass();
        $data->id = null;
        $data->title = null;
        $data->body = null;
        $data->image = null;
        $data->video = null;
        $data->inline = null;
        $data->campaign_link = null;

        $teaser = new Teaser($data);

        $this->assertNull($teaser->getId());
        $this->assertNull($teaser->getTitle());
        $this->assertNull($teaser->getBody());
        $this->assertNull($teaser->getImage());
        $this->assertNull($teaser->getVideo());
        $this->assertFalse($teaser->isInline());
        $this->assertNull($teaser->getLink());
    }

    public function testCanHandleEmptyObject()
    {
        $teaser = new Teaser(new \stdClass());

        $this->assertNull($teaser->getId());
        $this->assertNull($teaser->getTitle());
        $this->assertNull($teaser->getBody());
        $this->assertNull($teaser->getImage());
        $this->assertNull($teaser->getVideo());
        $this->assertFalse($teaser->isInline());
        $this->assertNull($teaser->getLink());
    }
}
