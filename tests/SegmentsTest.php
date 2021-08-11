<?php

namespace MailerLiteApi\Tests;

use MailerLiteApi\MailerLite;

/**
 * Class SegmentsTest
 *
 * @package MailerLiteApi\Tests
 */
class SegmentsTest extends MlTestCase
{
    protected $segmentsApi;

    protected $testSegment;

    protected function setUp(): void
    {
        $this->segmentsApi = (new MailerLite(API_KEY))->segments();
    }

    /** @test **/
    public function get_segments()
    {
        $segments = $this->segmentsApi->get();

        $this->assertContains(SEGMENTS_TEST_NAME1, (array) $segments->first()->data[0]);
    }
}
