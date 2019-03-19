<?php

namespace MailerLiteApi\Api;

use MailerLiteApi\Common\ApiAbstract;

class Fields extends ApiAbstract {

    protected $endpoint = 'fields';

    public function getAccountFields() {

        $response = $this->restClient->get($this->endpoint);

        return $response['body'];
    }

}