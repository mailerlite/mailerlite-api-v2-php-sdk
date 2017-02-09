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
        $stats = $this->statsApi->get();

        $this->assertTrue(is_object($stats));

        $this->assertTrue($stats->subscribed > 0);
        $this->assertTrue($stats->unsubscribed > 0);
        $this->assertTrue($stats->campaigns > 0);
        $this->assertTrue($stats->sent_emails > 0);
        $this->assertTrue($stats->open_rate > 0);
        $this->assertTrue($stats->click_rate >= 0);
        $this->assertTrue($stats->bounce_rate > 0);
    }

    /** @test **/
    public function get_stats_in_the_past()
    {
        $stats = $this->statsApi->getHistorical(1);

        $this->assertTrue(is_object($stats));

        $this->assertTrue($stats->unsubscribed === 0);
        $this->assertTrue($stats->subscribed === 0);
        $this->assertTrue($stats->campaigns === 0);
        $this->assertTrue($stats->sent_emails === 0);
        $this->assertTrue($stats->open_rate === 0);
        $this->assertTrue($stats->click_rate === 0);
        $this->assertTrue($stats->bounce_rate === 0);
    }

}