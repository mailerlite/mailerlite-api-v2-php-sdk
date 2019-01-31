<?php


namespace MailerLiteApi\Api;

use MailerLiteApi\Common\ApiAbstract;

class WooCommerce extends ApiAbstract
{
    protected $endpoint = 'woocommerce';
    /**
     * Sends shop data to our api to be saved(or updated) in the db 
     */
    public function setConsumerData( $consumerKey, $consumerSecret, $store, $apiKey, $currency )
    {

        $endpoint = $this->endpoint . '/consumer_data';

        $params = array_merge($this->prepareParams(), ['consumer_key' => $consumerKey, 'consumer_secret' => $consumerSecret, 'store' => $store, 'api_key' => $apiKey, 'currency' => $currency] );

        $response = $this->restClient->post( $endpoint, $params );
        
        return $response['body'];
    }
    /**
     * Currenty not in use as this is meant to save webhooks for created and updated orders
     * however, now we're instead listening for the event in the plugin so no need for webhooks
     */
    public function setWebhooks($shop)
    {
        $endpoint = $this->endpoint.'/webhooks';

        $params = array_merge($this->prepareParams(), ['shop' => $shop] );

        return $this->restClient->post( $endpoint, $params );
    }
    /**
     * Sends the completed order data to the api
     */
    public function saveOrder($orderData, $shop)
    {
        $endpoint = 'woocommerce/alternative_save_order';

        $params = array_merge($this->prepareParams(), ['order_data' => $orderData, 'shop' => $shop] );

        return $this->restClient->post( $endpoint, $params );
    }
    /**
     * Calls api endpoint that will toggle shop's active state
     * in our db
     */
    public function toggleShopConnection($shop, $activeState)
    {
        $shopName = parse_url($shop, PHP_URL_HOST);
        $endpoint = 'woocommerce/toggle_shop_connection';

        $params = array_merge($this->prepareParams(), ['active_state' => $activeState, 'shop' => $shopName] );
        return $this->restClient->post( $endpoint, $params );
    }
}