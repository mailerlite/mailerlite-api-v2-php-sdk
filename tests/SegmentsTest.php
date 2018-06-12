<?php

namespace MailerLiteApi\Tests;

use MailerLiteApi\MailerLite;
use MailerLiteApi\Api\Segments;

class SegmentsTest extends MlTestCase
{
    protected $segmentsApi;

    protected $testSegment;

    protected function setUp()
    {
        $this->segmentsApi = (new MailerLite(API_KEY))->segments();
    }

    /** @test **/
    public function get_segments()
    {
        $segments = $this->segmentsApi->get();

        $this->assertContains('Demo segment', (array) $segments->first()->data[0]);
    }
}