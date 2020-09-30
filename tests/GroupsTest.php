<?php

namespace MailerLiteApi\Tests;

use MailerLiteApi\MailerLite;

/**
 * Class GroupsTest
 *
 * @package MailerLiteApi\Tests
 */
class GroupsTest extends MlTestCase
{
    protected $groupsApi;

    protected $testGroup;

    protected $testGroupEmpty;

    protected $testSubscribers;

    protected function setUp(): void
    {
        $this->groupsApi = (new MailerLite(API_KEY))->groups();
        $this->testGroup = $this->createGroup();
        $this->testGroupEmpty = $this->createGroup('Empty Group');
        $this->testSubscribers = $this->addSubscribers($this->testGroup->id);
        $this->addSubscriber($this->testGroup->id, uniqid() . '@mailerlite-test.dev', 'unsubscribed');
    }

    protected function tearDown(): void
    {
        $this->groupsApi->delete($this->testGroup->id);
        $this->groupsApi->delete($this->testGroupEmpty->id);
    }

    /** @test **/
    public function check_groups_data()
    {
        $groups = $this->groupsApi->get();

        $this->assertTrue(is_numeric($groups[0]->id) && isset($groups[0]->name));
    }

    /** @test **/
    public function check_single_group_data()
    {
        $group = $this->groupsApi->find($this->testGroup->id);

        $this->assertTrue(is_numeric($group->id) && isset($group->name));

        $this->groupsApi->delete($this->testGroup->id);
    }

    /** @test **/
    public function check_group_subscribers_data()
    {
        $subscribers = $this->groupsApi->getSubscribers($this->testGroup->id);

        $this->assertTrue(isset($subscribers[0]->id) && isset($subscribers[0]->email));
    }

    /** @test **/
    public function check_group_subscribers_unsubscribed_data()
    {
        $subscribers = $this->groupsApi->getSubscribers($this->testGroup->id, 'unsubscribed');

        $this->assertTrue( ! empty($subscribers));
    }

    /** @test **/
    public function check_groups_data_with_limit()
    {
        $groups = $this->groupsApi->limit(2)->get();

        $this->assertEquals(2, count($groups));
    }

    /** @test **/
    public function check_group_subscribers_data_with_limit()
    {
        $subscribers = $this->groupsApi->getSubscribers($this->testGroup->id, null, ['limit' => 2]);

        $this->assertEquals(2, count($subscribers));
    }

    /** @test **/
    public function check_groups_count()
    {
        $groupsCount = $this->groupsApi->count();

        $this->assertTrue(isset($groupsCount->count) && is_numeric($groupsCount->count));
    }

    /** @test **/
    public function create_group()
    {
        $group = $this->testGroup;

        $this->assertEquals($group->name, 'New Group');
    }

    /** @test **/
    public function update_group()
    {
        $updateData = [
            'name' => 'Awesome Group'
        ];

        $group = $this->groupsApi->update($this->testGroup->id, $updateData);

        $this->assertEquals($group->name, $updateData['name']);
    }

    /** @test **/
    public function add_and_remove_subscriber()
    {
        $subscriber = $this->addSubscriber($this->testGroup->id);

        $addedSubscriber = $this->groupsApi->addSubscriber($this->testGroup->id, $subscriber);

        $this->assertTrue(isset($subscriber->email) && !empty($subscriber));

        $deleted = $this->groupsApi->removeSubscriber($this->testGroup->id, $addedSubscriber->id);

        $this->assertEquals($deleted, '');
    }

    /** @test **/
    public function import_subscribers()
    {
        $addedSubscribers = $this->addSubscribers($this->testGroup->id);

        $this->assertTrue( ! empty($addedSubscribers));
    }

}
