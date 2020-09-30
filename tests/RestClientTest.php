<?php

namespace MailerLiteApi\Tests;

use MailerLiteApi\Common\RestClient;
use MailerLiteApi\Common\ApiConstants;

use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

/**
 * Class RestClientTest
 *
 * @package MailerLiteApi\Tests
 */
class RestClientTest extends MlTestCase
{

    protected $client;

    protected function setUp(): void
    {
        $guzzle = new GuzzleClient();
        $adapter = new GuzzleAdapter($guzzle);

        $this->client = new RestClient('https://httpbin.org/', null, $adapter);
    }

    /** @test **/
    public function get_method()
    {
        $response = $this->client->get('get');

        $this->assertEquals(200, $response['status_code']);
    }

    /** @test **/
    public function mailerlite_sdk_user_agent()
    {
        $response = $this->client->get('user-agent');

        $userAgent = 'user-agent';

        $this->assertEquals(ApiConstants::SDK_USER_AGENT . '/' . ApiConstants::SDK_VERSION, $response['body']->$userAgent);
    }

    /** @test **/
    public function post_method()
    {
        $formData = [
            'foo' => 'bar',
            'fiz' => 'biz'
        ];

        $response = $this->client->post('post', $formData);

        $this->assertEquals(json_encode($formData), $response['body']->data);
    }

    /** @test **/
    public function put_method()
    {
        $formData = [
            'foo' => 'bar',
            'fiz' => 'biz'
        ];

        $response = $this->client->put('put', $formData);

        $this->assertEquals(json_encode($formData), $response['body']->data);
    }

    /** @test **/
    public function delete_method()
    {
        $response = $this->client->delete('delete');

        $this->assertEquals('', $response['body']->data);
    }

    /** @test **/
    public function error_internal_server()
    {
        $this->expectException('Exception');

        $this->client->get('status/500');
    }

    /** @test **/
    public function error_400()
    {
        $this->expectException('Exception');

        $this->client->get('status/400');
    }
}
