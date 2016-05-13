<?php

namespace MailerLiteApi\Tests;

use MailerLiteApi\Mailerlite;

class MailerliteTest extends MlTestCase
{
    /** @test **/
    public function invalid_api_key()
    {
        $this->setExpectedException('\\MailerLiteApi\\Exceptions\\MailerliteSdkException');

        $ml = new Mailerlite();
    }
}