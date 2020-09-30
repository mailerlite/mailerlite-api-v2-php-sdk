<?php

namespace MailerLiteApi\Api;

use MailerLiteApi\Common\ApiAbstract;

/**
 * Class Fields
 *
 * @package MailerLiteApi\Api
 */
class Fields extends ApiAbstract {

    protected $endpoint = 'fields';

    public function getAccountFields() {

        $response = $this->restClient->get($this->endpoint);

        return $response['body'];
    }

}
