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
     * @param string $filename
     */
    public function __construct(string $url, string $filename)
    {
        $this->url      = $url;
        $this->filename = $filename;
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
        return new static($url,basename($url));
    }
}