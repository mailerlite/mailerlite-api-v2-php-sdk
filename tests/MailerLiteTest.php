<?php

namespace MailerLiteApi\Tests;

use MailerLiteApi\MailerLite;

/**
 * Class MailerLiteTest
 *
 * @package MailerLiteApi\Tests
 */
class MailerLiteTest extends MlTestCase
{
    /** @test **/
    public function invalid_api_key()
    {
        $this->expectException('\\MailerLiteApi\\Exceptions\\MailerLiteSdkException');

        $ml = new MailerLite();
    }
}
