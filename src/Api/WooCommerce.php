<?php
/**
 * Created by PhpStorm.
 * User: nikolpetrunova
 * Date: 14/11/2018
 * Time: 11:03
 */

namespace MailerLiteApi\Api;

use MailerLiteApi\Common\ApiAbstract;

class WooCommerce extends ApiAbstract
{
    protected $endpoint = 'woocommerce';

    public function setConsumerData( $consumerKey, $consumerSecret, $store, $apiKey ) {

        $endpoint = $this->endpoint . '/consumer_data';

        $params = array_merge($this->prepareParams(), ['consumer_key' => $consumerKey, 'consumer_secret' => $consumerSecret, 'store' => $store, 'api_key' => $apiKey] );

        $response = $this->restClient->post( $endpoint, $params );

        return $response['body'];
    }
}