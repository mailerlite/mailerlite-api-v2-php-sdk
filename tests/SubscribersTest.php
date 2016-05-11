<?php

use MailerLiteApi\Mailerlite;
use MailerLiteApi\Resources\Fields;

class SubscribersTest extends PHPUnit_Framework_TestCase
{
    protected $subscribersApi;

    protected function setUp()
    {
        $this->subscribersApi = (new Mailerlite('fc7b8c5b32067bcd47cafb5f475d2fe9'))->subscribers();
    }

    /** @test **/
    public function get_subscriber_by_email()
    {
        $subscriber = $this->subscribersApi->find('testtesttest@mailerlite.com');

        $this->assertEquals($subscriber->email, 'testtesttest@mailerlite.com');
    }

    /** @test **/
    public function get_subscriber_by_id()
    {
        $subscriber = $this->subscribersApi->find(1413018993);

        $this->assertEquals($subscriber->id, 1413018993);
    }

    /** @test **/
    public function update_subscriber()
    {
        $subscriberData = [
            'type' => 'unsubscribed'
        ];

        $subscriber = $this->subscribersApi->update(1413018993, $subscriberData);

        $this->assertEquals($subscriber->type, 'unsubscribed');

        $subscriber = $this->subscribersApi->update(1413018993, ['type' => 'active']);
    }

    /** @test **/
    public function search_for_a_subscriber()
    {
        $subscribers = $this->subscribersApi->search('subscriber updated');

        $this->assertTrue(count($subscribers) > 0);
    }

}