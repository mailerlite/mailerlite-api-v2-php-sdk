<?php

namespace MailerLiteApi;

use Http\Client\HttpClient;

use MailerLiteApi\Common\ApiConstants;
use MailerLiteApi\Common\RestClient;
use MailerLiteApi\Exceptions\MailerLiteSdkException;

class MailerLite {

    /**
     * @var null | string
     */
    protected $apiKey;

    /**
     * @var RestClient
     */
    protected $restClient;

    /**
     * @param string|null $apiKey
     * @param HttpClient $client
     */
    public function __construct(
        $apiKey = null,
        HttpClient $httpClient = null
    ) {
        if (is_null($apiKey)) {
            throw new MailerLiteSdkException("API key is not provided");
        }

        $this->apiKey = $apiKey;

        $this->restClient = new RestClient(
            $this->getBaseUrl(),
            $apiKey,
            $httpClient
        );
    }

    /**
     * @return \MailerLiteApi\Api\Groups
     */
    public function groups()
    {
        return new \MailerLiteApi\Api\Groups($this->restClient);
    }

    /**
     * @return \MailerLiteApi\Api\Fields
     */
    public function fields()
    {
        return new \MailerLiteApi\Api\Fields($this->restClient);
    }

    /**
     * @return \MailerLiteApi\Api\Subscribers
     */
    public function subscribers()
    {
        return new \MailerLiteApi\Api\Subscribers($this->restClient);
    }

    /**
     * @return \MailerLiteApi\Api\Campaigns
     */
    public function campaigns()
    {
        return new \MailerLiteApi\Api\Campaigns($this->restClient);
    }

    /**
     * @param  string $version
     * @return string
     */
    public function getBaseUrl($version = ApiConstants::VERSION)
    {
        return ApiConstants::BASE_URL . $version . '/';
    }

}