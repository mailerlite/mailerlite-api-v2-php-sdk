<?php

namespace MailerLiteApi\Common;

use Http\Client\HttpClient;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

class RestClient {

    public $httpClient;

    public $apiKey;

    public $baseUrl;

    public $requestFactory;

    public $streamFactory;

    /**
     * @param  string  $baseUrl
     * @param  string  $apiKey
     * @param  \Http\Client\HttpClient|null  $httpClient
     */
    public function __construct($baseUrl, $apiKey, HttpClient $httpClient = null)
    {
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
        $this->httpClient = $httpClient;
    }

    /**
     * Execute GET request
     *
     * @param  string $endpointUri
     * @param  array $queryString
     * @return [type]
     */
    public function get($endpointUri, $queryString = [])
    {
        return $this->send('GET', $endpointUri . '?' . http_build_query($queryString));
    }

    /**
     * Execute POST request
     *
     * @param  string $endpointUri
     * @param  array  $data
     * @return [type]
     */
    public function post($endpointUri, $data = [])
    {
        return $this->send('POST', $endpointUri, $data);
    }

    /**
     * Execute PUT request
     *
     * @param  string $endpointUri
     * @param  array  $putData
     * @return [type]
     */
    public function put($endpointUri, $putData = [])
    {
        return $this->send('PUT', $endpointUri, $putData);
    }

    /**
     * Execute DELETE request
     *
     * @param  string $endpointUri
     * @return [type]
     */
    public function delete($endpointUri)
    {
        return $this->send('DELETE', $endpointUri);
    }

    /**
     * Execute HTTP request
     *
     * @param  string $method
     * @param  string $endpointUri
     * @param  string $body
     * @param  array $headers
     * @return [type]
     */
    protected function send($method, $endpointUri, $body = null, array $headers = [])
    {

        $headers = array_merge($headers, self::getDefaultHeaders());
        $endpointUrl = $this->baseUrl . $endpointUri;

        $request = $this->getRequestFactory()->createRequest($method, $endpointUrl);

        if ($body) {
            $stream  = $this->getStreamFactory()
                            ->createStream(json_encode($body));
            $request = $request->withBody($stream);
        }

        foreach ($headers as $name => $value) {
            $request = $request->withAddedHeader($name, $value);
        }

        $response = $this->getHttpClient()->sendRequest(
            $request
        );

        return $this->handleResponse($response);
    }

    /**
     * Handle HTTP response
     *
     * @param  ResponseInterface $response
     * @return [type]
     */
    protected function handleResponse(ResponseInterface $response)
    {
        $status = $response->getStatusCode();

        $data = (string) $response->getBody();
        $jsonResponseData = json_decode($data, false);
        $body = $data && $jsonResponseData === null ? $data : $jsonResponseData;

        return ['status_code' => $status, 'body' => $body];
    }

    /**
     * @return ClientInterface
     */
    protected function getHttpClient()
    {
        if (is_null($this->httpClient)) {
            $this->httpClient = Psr18ClientDiscovery::find();
        }

        return $this->httpClient;
    }

    /**
     * @return HttpClient
     */
    protected function getRequestFactory(): RequestFactoryInterface
    {
        if (null === $this->requestFactory) {
            $this->requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        }

        return $this->requestFactory;
    }

    private function getStreamFactory(): StreamFactoryInterface
    {
        if (null === $this->streamFactory) {
            $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        }

        return $this->streamFactory;
    }

    /**
     * @return array
     */
    protected function getDefaultHeaders() {
        $headers = [
            'User-Agent'          => ApiConstants::SDK_USER_AGENT.'/'.ApiConstants::SDK_VERSION,
            'Content-Type'        => 'application/json',
        ];

        // Only adding it when provided. Not required for RestClientTest
        if ($this->apiKey) {
            $headers['X-MailerLite-ApiKey'] = $this->apiKey;
        }

        return $headers;
    }
}
