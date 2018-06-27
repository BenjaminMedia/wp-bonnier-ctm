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

        $this->assertInstanceOf(Collection::class, $teasers);
        $this->assertCount(1, $teasers);
        $teaser = $teasers->first();
        $this->assertObjectHasAttribute('id', $teaser);
        $this->assertObjectHasAttribute('title', $teaser);
        $this->assertObjectHasAttribute('body', $teaser);
        $this->assertObjectHasAttribute('image', $teaser);
        $this->assertObjectHasAttribute('video', $teaser);
        $this->assertObjectHasAttribute('campaign_link', $teaser);
        $this->assertInternalType('int', $teaser->id);
        $this->assertInternalType('string', $teaser->title);
        $this->assertInternalType('string', $teaser->body);
        $this->assertInternalType('string', $teaser->image);
        $this->assertInternalType('string', $teaser->video);
        $this->assertInternalType('string', $teaser->campaign_link);

        $this->assertInstanceOf(Collection::class, $byCategory);
        $this->assertCount(1, $byCategory);
        $teaserByCategory = $byCategory->first();
        $this->assertObjectHasAttribute('id', $teaserByCategory);
        $this->assertObjectHasAttribute('title', $teaserByCategory);
        $this->assertObjectHasAttribute('body', $teaserByCategory);
        $this->assertObjectHasAttribute('image', $teaserByCategory);
        $this->assertObjectHasAttribute('video', $teaserByCategory);
        $this->assertObjectHasAttribute('campaign_link', $teaserByCategory);
        $this->assertInternalType('int', $teaserByCategory->id);
        $this->assertInternalType('string', $teaserByCategory->title);
        $this->assertInternalType('string', $teaserByCategory->body);
        $this->assertInternalType('string', $teaserByCategory->image);
        $this->assertInternalType('string', $teaserByCategory->video);
        $this->assertInternalType('string', $teaserByCategory->campaign_link);

        $this->assertInstanceOf(Collection::class, $byTags);
        $this->assertCount(1, $byTags);
        $teaserByTags = $byTags->first();
        $this->assertObjectHasAttribute('id', $teaserByTags);
        $this->assertObjectHasAttribute('title', $teaserByTags);
        $this->assertObjectHasAttribute('body', $teaserByTags);
        $this->assertObjectHasAttribute('image', $teaserByTags);
        $this->assertObjectHasAttribute('video', $teaserByTags);
        $this->assertObjectHasAttribute('campaign_link', $teaserByTags);
        $this->assertInternalType('int', $teaserByTags->id);
        $this->assertInternalType('string', $teaserByTags->title);
        $this->assertInternalType('string', $teaserByTags->body);
        $this->assertInternalType('string', $teaserByTags->image);
        $this->assertInternalType('string', $teaserByTags->video);
        $this->assertInternalType('string', $teaserByTags->campaign_link);

        $this->assertInstanceOf(Collection::class, $byCategoryAndTags);
        $this->assertCount(1, $byCategoryAndTags);
        $teaserByCatAndTags = $byCategoryAndTags->first();
        $this->assertObjectHasAttribute('id', $teaserByCatAndTags);
        $this->assertObjectHasAttribute('title', $teaserByCatAndTags);
        $this->assertObjectHasAttribute('body', $teaserByCatAndTags);
        $this->assertObjectHasAttribute('image', $teaserByCatAndTags);
        $this->assertObjectHasAttribute('video', $teaserByCatAndTags);
        $this->assertObjectHasAttribute('campaign_link', $teaserByCatAndTags);
        $this->assertInternalType('int', $teaserByCatAndTags->id);
        $this->assertInternalType('string', $teaserByCatAndTags->title);
        $this->assertInternalType('string', $teaserByCatAndTags->body);
        $this->assertInternalType('string', $teaserByCatAndTags->image);
        $this->assertInternalType('string', $teaserByCatAndTags->video);
        $this->assertInternalType('string', $teaserByCatAndTags->campaign_link);
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

        $this->assertTrue($teasers->isEmpty());
        $this->assertTrue($byCategory->isEmpty());
        $this->assertTrue($byTags->isEmpty());
        $this->assertTrue($byCategoryAndTags->isEmpty());
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
