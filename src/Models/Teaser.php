<?php

namespace Bonnier\WP\CTM\Models;

use JsonSerializable;
use Bonnier\WP\CTM\Contracts\TeaserContract;

class Teaser implements TeaserContract, JsonSerializable
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
     * Display teaser inline
     *
     * @return bool
     */
    public function isInline(): bool
    {
        return boolval($this->teaser->inline ?? null);
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

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'body' => $this->getBody(),
            'image' => $this->getImage(),
            'video' => $this->getVideo(),
            'inline' => $this->isInline(),
            'link' => $this->getLink()
        ];
    }
}
