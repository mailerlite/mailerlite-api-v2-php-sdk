<?php

namespace MailerLiteApi\Common;

/**
 * Class BatchRequest
 *
 * @package MailerLiteApi\Common
 */
class BatchRequest
{

    const METHOD_GET = 'GET';

    const METHOD_POST = 'POST';

    const METHOD_PUT = 'PUT';

    const METHOD_DELETE = 'DELETE';

    /** @var string $method */
    protected $method = self::METHOD_GET;

    /** @var string $path */
    protected $path = '';

    /** @var null|array $body */
    protected $body = null;

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param  string  $method
     *
     * @return BatchRequest
     */
    public function setMethod(string $method): BatchRequest
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param  string  $path
     *
     * @return BatchRequest
     */
    public function setPath(string $path): BatchRequest
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return null
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param  null|array  $body
     *
     * @return BatchRequest
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [
            'method' => $this->getMethod(),
            'path'   => $this->getPath(),
        ];

        if ($body = $this->getBody()) {
            $array['body'] = $body;
        }

        return $array;
    }

}
