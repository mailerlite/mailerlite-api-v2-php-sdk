<?php


namespace MailerLiteApi\Api;

use MailerLiteApi\Common\ApiAbstract;

class WooCommerce extends ApiAbstract
{
    protected $endpoint = 'woocommerce';

    public function setConsumerData( $consumerKey, $consumerSecret, $store, $apiKey )
    {

        $endpoint = $this->endpoint . '/consumer_data';

        $params = array_merge($this->prepareParams(), ['consumer_key' => $consumerKey, 'consumer_secret' => $consumerSecret, 'store' => $store, 'api_key' => $apiKey] );

        $response = $this->restClient->post( $endpoint, $params );
        if (isset($response['body']->errors)) {
            return $response['body'];
        }
        $this->setWebhooks($store);
        
        return $response['body'];
    }

    public function setWebhooks($shop)
    {
        $endpoint = $this->endpoint.'/webhooks';

        $params = array_merge($this->prepareParams(), ['shop' => $shop] );

        $this->restClient->post( $endpoint, $params );
    }
}