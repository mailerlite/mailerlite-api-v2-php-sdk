<?php

namespace MailerLiteApi\Tests;

use MailerLiteApi\MailerLite;
use MailerLiteApi\Resources\Fields;

class SubscribersTest extends MlTestCase
{
    protected $groupsApi;

    protected $subscribersApi;

    protected $testGroup;

    protected $testSubscriber;

    protected function setUp()
    {
        $ml = new MailerLite(API_KEY);
        $this->groupsApi = $ml->groups();
        $this->subscribersApi = $ml->subscribers();

        $this->testGroup = $this->createGroup();
        $this->testSubscriber = $this->addSubscriber($this->testGroup->id);
    }

    protected function tearDown()
    {
        $this->groupsApi->delete($this->testGroup->id);
    }

    /** @test **/
    public function get_subscriber_by_email()
    {
        $subscriber = $this->subscribersApi->find($this->testSubscriber->email);

        $this->assertEquals($subscriber->email, $this->testSubscriber->email);
    }

    /** @test **/
    public function get_subscriber_by_id()
    {
        $subscriber = $this->subscribersApi->find($this->testSubscriber->id);

        $this->assertEquals($subscriber->id, $this->testSubscriber->id);
    }

    /** @test **/
    public function update_subscriber()
    {
        $subscriberData = [
            'type' => 'unsubscribed'
        ];

        $subscriber = $this->subscribersApi->update($this->testSubscriber->id, $subscriberData);

        $this->assertEquals($subscriber->type, 'unsubscribed');

        $subscriber = $this->subscribersApi->update($this->testSubscriber->id, ['type' => 'active']);
    }

    /** @test **/
    public function search_for_a_subscriber()
    {
        $subscribers = $this->subscribersApi->search('demo@mailerlite.com');

        $this->assertTrue(count($subscribers) > 0);
    }

}