<?php

namespace Bonnier\WP\CTM\Models;

use Bonnier\WP\CTM\Contracts\TeaserContract;

class Teaser implements TeaserContract
{
    protected $teaser;

    public function __construct(\stdClass $teaser)
    {
        $this->teaser = $teaser;
    }

    public function getId(): ?int
    {
        return $this->teaser->id ?? null;
    }

    public function getTitle(): ?string
    {
        return $this->teaser->title ?? null;
    }

    public function getBody(): ?string
    {
        return $this->teaser->body ?? null;
    }

    public function getImage(): ?string
    {
        return $this->teaser->image ?? null;
    }

    public function getVideo(): ?string
    {
        return $this->teaser->video ?? null;
    }

    public function getLink(): ?string
    {
        return $this->teaser->campaign_link ?? null;
    }
}
