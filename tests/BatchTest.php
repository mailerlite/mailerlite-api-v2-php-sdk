<?php

namespace MailerLiteApi\Tests;

use MailerLiteApi\Common\BatchRequest;
use MailerLiteApi\Exceptions\MailerLiteSdkException;
use MailerLiteApi\MailerLite;

/**
 * Class BatchTest
 *
 * @package MailerLiteApi\Tests
 */
class BatchTest extends MlTestCase
{

    /** @var \MailerLiteApi\Api\Batch */
    protected $api;

    protected function setUp(): void
    {
        $this->api = (new MailerLite(API_KEY))->batch();
    }

    /** @test * */
    public function at_least_one_request_is_provided_exception()
    {
        $this->expectException(MailerLiteSdkException::class);
        $this->api->send([]);
    }

    /** @test * */
    public function provided_requests_must_be_batch_request_class()
    {
        $this->expectException(MailerLiteSdkException::class);
        $this->api->send([
            new \stdClass(),
        ]);
    }

    /** @test * */
    public function send_batch()
    {
        $requests = [];
        $batchOne = (new BatchRequest())
            ->setMethod(BatchRequest::METHOD_POST)
            ->setPath('/api/v2/subscribers')
            ->setBody([
                'email' => BATCH_TEST_EMAIL1,
            ]);

        $batchTwo = (new BatchRequest())
            ->setMethod(BatchRequest::METHOD_POST)
            ->setPath('/api/v2/subscribers')
            ->setBody([
                'email' => BATCH_TEST_EMAIL2,
            ]);

        $requests[] = $batchOne;
        $requests[] = $batchTwo;

        $result = $this->api->send($requests);

        $this->assertTrue($result[0]->body->email == $batchOne->getBody()['email']);
        $this->assertTrue($result[1]->body->email == $batchTwo->getBody()['email']);
    }
}
