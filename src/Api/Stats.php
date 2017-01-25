<?php

namespace MailerLiteApi\Api;

use MailerLiteApi\Common\ApiAbstract;

class Stats extends ApiAbstract {

    protected $endpoint = 'stats';

    public function get($fields = [])
    {
        $params = $this->prepareParams();

        if (!empty($fields) && is_array($fields) && $fields != ['*']) {
            $params['fields'] = $fields;
        }

        $response = $this->restClient->get($this->endpoint, $params);

        return $response['body'];
    }

}