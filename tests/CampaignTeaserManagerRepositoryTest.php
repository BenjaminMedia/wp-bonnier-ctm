<?php

namespace Tests\Bonnier\WP\CTM;

use Bonnier\WP\CTM\Repositories\CampaignTeaserManagerRepository;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use Tests\Bonnier\WP\CTM\Factories\Factory;

class CampaignTeaserManagerRepositoryTest extends TestCase
{
    public function testGetTeasersReturnsCollectionContainingData()
    {
        $client = Factory::getGuzzleClient([], 4);

        $repository = new CampaignTeaserManagerRepository($client, 'da', 'GDS');

        $tags = new Collection([
            'a',
            'b',
            'c'
        ]);

        $teasers = $repository->getTeasers();
        $byCategory = $repository->getTeasersByCategory('test');
        $byTags = $repository->getTeasersByTags($tags);
        $byCategoryAndTags = $repository->getTeasersByCategoryAndTags(
            'test',
            $tags
        );
        $data = json_decode(
            Factory::getValidCTMResponse()->getBody()->getContents(),
            JSON_OBJECT_AS_ARRAY
        );

        $this->assertInstanceOf(Collection::class, $teasers);
        $this->assertCount(1, $teasers);
        $this->assertArrayHasKey('id', $teasers->first());
        $this->assertArrayHasKey('title', $teasers->first());
        $this->assertArrayHasKey('body', $teasers->first());
        $this->assertArrayHasKey('image', $teasers->first());
        $this->assertArrayHasKey('video', $teasers->first());
        $this->assertArrayHasKey('campaign_link', $teasers->first());
        $this->assertInternalType('int', $teasers->first()['id']);
        $this->assertInternalType('string', $teasers->first()['title']);
        $this->assertInternalType('string', $teasers->first()['body']);
        $this->assertInternalType('string', $teasers->first()['image']);
        $this->assertInternalType('string', $teasers->first()['video']);
        $this->assertInternalType('string', $teasers->first()['campaign_link']);

        $this->assertInstanceOf(Collection::class, $byCategory);
        $this->assertCount(1, $byCategory);
        $this->assertArrayHasKey('id', $byCategory->first());
        $this->assertArrayHasKey('title', $byCategory->first());
        $this->assertArrayHasKey('body', $byCategory->first());
        $this->assertArrayHasKey('image', $byCategory->first());
        $this->assertArrayHasKey('video', $byCategory->first());
        $this->assertArrayHasKey('campaign_link', $byCategory->first());
        $this->assertInternalType('int', $byCategory->first()['id']);
        $this->assertInternalType('string', $byCategory->first()['title']);
        $this->assertInternalType('string', $byCategory->first()['body']);
        $this->assertInternalType('string', $byCategory->first()['image']);
        $this->assertInternalType('string', $byCategory->first()['video']);
        $this->assertInternalType('string', $byCategory->first()['campaign_link']);

        $this->assertInstanceOf(Collection::class, $byTags);
        $this->assertCount(1, $byTags);
        $this->assertArrayHasKey('id', $byTags->first());
        $this->assertArrayHasKey('title', $byTags->first());
        $this->assertArrayHasKey('body', $byTags->first());
        $this->assertArrayHasKey('image', $byTags->first());
        $this->assertArrayHasKey('video', $byTags->first());
        $this->assertArrayHasKey('campaign_link', $byTags->first());
        $this->assertInternalType('int', $byTags->first()['id']);
        $this->assertInternalType('string', $byTags->first()['title']);
        $this->assertInternalType('string', $byTags->first()['body']);
        $this->assertInternalType('string', $byTags->first()['image']);
        $this->assertInternalType('string', $byTags->first()['video']);
        $this->assertInternalType('string', $byTags->first()['campaign_link']);

        $this->assertInstanceOf(Collection::class, $byCategoryAndTags);
        $this->assertCount(1, $byCategoryAndTags);
        $this->assertArrayHasKey('id', $byCategoryAndTags->first());
        $this->assertArrayHasKey('title', $byCategoryAndTags->first());
        $this->assertArrayHasKey('body', $byCategoryAndTags->first());
        $this->assertArrayHasKey('image', $byCategoryAndTags->first());
        $this->assertArrayHasKey('video', $byCategoryAndTags->first());
        $this->assertArrayHasKey('campaign_link', $byCategoryAndTags->first());
        $this->assertInternalType('int', $byCategoryAndTags->first()['id']);
        $this->assertInternalType('string', $byCategoryAndTags->first()['title']);
        $this->assertInternalType('string', $byCategoryAndTags->first()['body']);
        $this->assertInternalType('string', $byCategoryAndTags->first()['image']);
        $this->assertInternalType('string', $byCategoryAndTags->first()['video']);
        $this->assertInternalType('string', $byCategoryAndTags->first()['campaign_link']);
    }

    public function testEmptyResponseReturnsEmptyCollection()
    {
        $responses = [];
        for ($i = 0; $i < 4; $i++) {
            $responses[] = Factory::getEmptyCTMResponse();
        }
        $client = Factory::getGuzzleClient($responses);

        $repository = new CampaignTeaserManagerRepository($client, 'da', 'GDS');

        $tags = new Collection([
            'a',
            'b',
            'c'
        ]);

        $teasers = $repository->getTeasers();
        $byCategory = $repository->getTeasersByCategory('test');
        $byTags = $repository->getTeasersByTags($tags);
        $byCategoryAndTags = $repository->getTeasersByCategoryAndTags(
            'test',
            $tags
        );

        $emptyCollection = new Collection();

        $this->assertEquals($emptyCollection, $teasers);
        $this->assertEquals($emptyCollection, $byCategory);
        $this->assertEquals($emptyCollection, $byTags);
        $this->assertEquals($emptyCollection, $byCategoryAndTags);
    }

    public function testInvalidRequestReturnsNull()
    {
        $responses = [];
        for ($i = 0; $i < 4; $i++) {
            $responses[] = Factory::getInvalidCTMResponse();
        }
        $client = Factory::getGuzzleClient($responses);

        $repository = new CampaignTeaserManagerRepository($client, '', 'GDS');

        $tags = new Collection([
            'a',
            'b',
            'c'
        ]);

        $teasers = $repository->getTeasers();
        $byCategory = $repository->getTeasersByCategory('test');
        $byTags = $repository->getTeasersByTags($tags);
        $byCategoryAndTags = $repository->getTeasersByCategoryAndTags(
            'test',
            $tags
        );

        $this->assertNull($teasers);
        $this->assertNull($byCategory);
        $this->assertNull($byTags);
        $this->assertNull($byCategoryAndTags);
    }
}
