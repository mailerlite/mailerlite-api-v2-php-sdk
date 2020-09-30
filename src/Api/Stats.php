<?php

namespace MailerLiteApi\Api;

use MailerLiteApi\Common\ApiAbstract;

/**
 * Class Stats
 *
 * @package MailerLiteApi\Api
 */
class Stats extends ApiAbstract {

    protected $endpoint = 'stats';

    public function get($fields = [])
    {
        $response = $this->restClient->get($this->endpoint, []);

        return $response['body'];
    }

    public function getHistorical($timestamp)
    {
        $response = $this->restClient->get($this->endpoint, ['timestamp' => $timestamp]);

        return $response['body'];
    }

}
