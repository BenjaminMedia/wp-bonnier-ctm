<?php

namespace Bonnier\WP\CTM\Models;

use Bonnier\WP\CTM\Contracts\TeaserContract;

class Teaser implements TeaserContract
{
    protected $teaser;

    public function __construct(array $teaser)
    {
        $this->teaser = $teaser;
    }

    public function getId(): int
    {
        return $this->teaser['id'] ?? 0;
    }

    public function getTitle(): string
    {
        return $this->teaser['title'] ?? '';
    }

    public function getBody(): string
    {
        return $this->teaser['body'] ?? '';
    }

    public function getImage(): string
    {
        return $this->teaser['image'] ?? '';
    }

    public function getVideo(): string
    {
        return $this->teaser['video'] ?? '';
    }

    public function getLink(): string
    {
        return $this->teaser['campaign_link'] ?? '';
    }
}
