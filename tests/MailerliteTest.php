<?php

namespace MailerLiteApi\Tests;

use MailerLiteApi\MailerLite;

class MailerLiteTest extends MlTestCase
{
    /** @test **/
    public function invalid_api_key()
    {
        $this->setExpectedException('\\MailerLiteApi\\Exceptions\\MailerLiteSdkException');

        $ml = new MailerLite();
    }
}