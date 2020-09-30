<?php

namespace MailerLiteApi\Api;

use MailerLiteApi\Common\ApiAbstract;
use MailerLiteApi\Common\BatchRequest;
use MailerLiteApi\Exceptions\MailerLiteSdkException;

/**
 * Class Batch
 *
 * @package MailerLiteApi\Api
 */
class Batch extends ApiAbstract
{

    protected $endpoint = 'batch';

    /**
     * @param  BatchRequest[]  $requests
     *
     * @return \MailerLiteApi\Common\Collection
     */
    public function send(array $requests)
    {
        if ( ! count($requests)) {
            throw new MailerLiteSdkException("Provide at least one request");
        }

        foreach ($requests as &$request) {
            if ( ! is_object($request) || get_class($request) != BatchRequest::class) {
                throw new MailerLiteSdkException("All requests must be of type ".BatchRequest::class);
            }

            $request = $request->toArray();
        }

        $response = $this->restClient->post($this->endpoint, [
            'requests' => $requests,
        ]);

        return $response['body'];
    }

}
