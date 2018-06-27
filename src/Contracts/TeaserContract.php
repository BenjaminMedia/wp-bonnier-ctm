<?php

namespace Bonnier\WP\CTM\Contracts;

interface TeaserContract
{
    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @return null|string
     */
    public function getTitle(): ?string;

    /**
     * @return null|string
     */
    public function getBody(): ?string;

    /**
     * @return null|string
     */
    public function getImage(): ?string;

    /**
     * @return null|string
     */
    public function getVideo(): ?string;

    /**
     * @return null|string
     */
    public function getLink(): ?string;
}
