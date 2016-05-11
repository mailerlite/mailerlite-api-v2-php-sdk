<?php

use MailerLiteApi\Mailerlite;
use MailerLiteApi\Api\Groups;

class GroupsTest extends PHPUnit_Framework_TestCase
{
    protected $groupsApi;

    protected function setUp()
    {
        $this->groupsApi = (new Mailerlite('fc7b8c5b32067bcd47cafb5f475d2fe9'))->groups();
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
        $group = $this->groupsApi->find(2590376);

        $this->assertTrue(is_numeric($group->id) && isset($group->name));
    }

    /** @test **/
    public function check_group_subscribers_data()
    {
        $subscribers = $this->groupsApi->getSubscribers(2590376);

        $this->assertTrue(isset($subscribers[0]->id) && isset($subscribers[0]->email));
    }

    /** @test **/
    public function check_group_subscribers_unsubscribed_data()
    {
        $subscribers = $this->groupsApi->getSubscribers(2590376, 'unsubscribed');

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
        $subscribers = $this->groupsApi->getSubscribers(2590376, null, ['limit' => 2]);

        $this->assertEquals(2, count($subscribers));
    }

    /** @test **/
    public function check_groups_count()
    {
        $groupsCount = $this->groupsApi->count();

        $this->assertTrue(array_key_exists('count', $groupsCount) && is_numeric($groupsCount->count));
    }

    /** @test **/
    public function create_group()
    {
        $group = $this->groupsApi->create(['name' => 'test group']);

        $this->assertEquals($group->name, 'test group');
    }

    /** @test **/
    public function update_group()
    {
        $group = $this->groupsApi->update(3884615, ['name' => 'test group updated']);

        $this->assertEquals($group->name, 'test group updated');
    }

    /** @test **/
    public function add_subscriber()
    {
        $subscriberData = [
            'email' => 'testtesttest@mailerlite.com',
            'name' => 'testing testing'
        ];

        $addedSubscriber = $this->groupsApi->addSubscriber(3884615, $subscriberData);

        $this->assertEquals($addedSubscriber->email, $subscriberData['email']);
    }

    /** @test **/
    public function remove_subscriber()
    {
        $subscriberData = [
            'email' => 'deletingtest@mailerlite.com',
            'name' => 'testing deleting'
        ];

        $addedSubscriber = $this->groupsApi->addSubscriber(3884615, $subscriberData);

        $this->assertEquals($addedSubscriber->email, $subscriberData['email']);

        $deleted = $this->groupsApi->removeSubscriber(3884615, $addedSubscriber->id);

        $this->assertEquals($deleted, '');
    }

    /** @test **/
    public function import_subscribers()
    {
        $subscribersData = [
            [
                'email' => 'batch1@mailerlite.com'
            ],
            [
                'email' => 'batch2@mailerlite.com'
            ]
        ];

        $addedSubscribers = $this->groupsApi->importSubscribers(3884615, $subscribersData);

        $this->assertTrue(isset($addedSubscribers->imported));
    }

}