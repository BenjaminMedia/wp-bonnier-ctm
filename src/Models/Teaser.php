<?php

namespace Bonnier\WP\CTM\Models;

use Bonnier\WP\CTM\Contracts\TeaserContract;

class Teaser implements TeaserContract
{
    protected $teaser;

    /**
     * Teaser constructor.
     * @param \stdClass $teaser
     */
    public function __construct(\stdClass $teaser)
    {
        $this->teaser = $teaser;
    }

    /**
     * Campaign Teaser Manager ID
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->teaser->id ?? null;
    }

    /**
     * Title of teaser
     *
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->teaser->title ?? null;
    }

    /**
     * Body text in Markdown
     *
     * @return null|string
     */
    public function getBody(): ?string
    {
        return $this->teaser->body ?? null;
    }

    /**
     * URL to image
     *
     * @return null|string
     */
    public function getImage(): ?string
    {
        return $this->teaser->image ?? null;
    }

    /**
     * URL to video
     *
     * @return null|string
     */
    public function getVideo(): ?string
    {
        return $this->teaser->video ?? null;
    }

    /**
     * URL to where the teaser needs to link
     *
     * @return null|string
     */
    public function getLink(): ?string
    {
        return $this->teaser->campaign_link ?? null;
    }
}
