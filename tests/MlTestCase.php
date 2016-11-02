<?php

namespace MailerLiteApi\Tests;

use MailerLiteApi\MailerLite;
use MailerLiteApi\Api\Groups;

class MlTestCase extends \PHPUnit_Framework_TestCase
{
    // helper functions
    protected function createGroup($name = 'New Group')
    {
        return $this->groupsApi->create(['name' => $name]);
    }

    protected function addSubscriber($groupId, $email = null, $type = 'active')
    {
        $subscriberData = [
            'email' => $email ? $email : uniqid() . '@mailerlite-test.dev',
            'type' => $type
        ];

        return $this->groupsApi->addSubscriber($groupId, $subscriberData);
    }

    protected function addSubscribers($groupId, $count = 5)
    {
        $subscribersData = [];

        for ($i = 0; $i < $count; $i++) {
            $subscribersData[] = [
                'email' => uniqid() . '@mailerlite-test.dev'
            ];
        }

        $addedSubscribers = $this->groupsApi->importSubscribers($groupId, $subscribersData);

        return $addedSubscribers->imported;
    }

    protected function assertContainsValue($list, $key, $value)
    {
        return $this->assertTrue($this->containsValue($list, $key, $value));
    }

    protected function assertDoesNotContainValue($list, $key, $value)
    {
        return $this->assertFalse($this->containsValue($list, $key, $value));
    }

    protected function containsValue($list, $key, $value)
    {
        $found = false;

        foreach ($list as $item) {
            if ($item->$key === $value) {
                $found = true;
                break;
            }
        }

        return $found;
    }

}