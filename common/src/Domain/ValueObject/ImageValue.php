<?php

namespace Common\Domain\ValueObject;

class ImageValue extends ValueObject
{
    /**
     * @var string
     */
    protected string $url;

    /**
     * @var string
     */
    protected string $filename;

    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url      = parse_url($url, PHP_URL_PATH);
        $this->filename = basename($url);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $url
     * @return $this
     */
    public static function fromUrl(string $url): static
    {
        return new static($url);
    }
}