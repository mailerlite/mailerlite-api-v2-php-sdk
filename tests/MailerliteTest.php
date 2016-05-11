<?php

use MailerLiteApi\Mailerlite;

class MailerliteTest extends PHPUnit_Framework_TestCase
{
    /** @test **/
    public function invalid_api_key()
    {
        $this->setExpectedException('\\MailerLiteApi\\Exceptions\\MailerliteSdkException');

        $ml = new Mailerlite();
    }
}