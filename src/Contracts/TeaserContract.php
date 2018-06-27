<?php

namespace Bonnier\WP\CTM\Contracts;


interface TeaserContract
{
    public function getId(): ?int;

    public function getTitle(): ?string;

    public function getBody(): ?string;

    public function getImage(): ?string;

    public function getVideo(): ?string;

    public function getLink(): ?string;
}
