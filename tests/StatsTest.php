<?php

namespace MailerLiteApi\Tests;

use MailerLiteApi\MailerLite;
use MailerLiteApi\Api\Stats;

class StatsTest extends MlTestCase
{
    protected $campaignsApi;

    protected function setUp()
    {
        $this->statsApi = (new MailerLite(API_KEY))->stats();
    }

    /** @test **/
    public function get_stats()
    {
        // see drafts
        $stats = $this->statsApi->get();

        $this->assertTrue(is_object($stats));
        $this->assertTrue(isset($stats->unsubscribed));
        $this->assertTrue(isset($stats->subscribed));
    }

}