<?php


namespace MailerLiteApi\Api;

use MailerLiteApi\Common\ApiAbstract;

class WooCommerce extends ApiAbstract
{
    protected $endpoint = 'woocommerce';

    public function setConsumerData( $consumerKey, $consumerSecret, $store, $apiKey, $currency )
    {

        $endpoint = $this->endpoint . '/consumer_data';

        $params = array_merge($this->prepareParams(), ['consumer_key' => $consumerKey, 'consumer_secret' => $consumerSecret, 'store' => $store, 'api_key' => $apiKey, 'currency' => $currency] );

        $response = $this->restClient->post( $endpoint, $params );

        return $response['body'];
    }

    public function setWebhooks($shop)
    {
        $endpoint = $this->endpoint.'/webhooks';

        $params = array_merge($this->prepareParams(), ['shop' => $shop] );

        return $this->restClient->post( $endpoint, $params );
    }

    public function saveOrder($orderData, $shop)
    {
        $endpoint = 'woocommerce/alternative_save_order';

        $params = array_merge($this->prepareParams(), ['order_data' => $orderData, 'shop' => $shop] );
        return $this->restClient->post( $endpoint, $params );
    }

    public function toggleShopConnection($shop, $activeState)
    {
        $shopName = parse_url($shop, PHP_URL_HOST);
        $endpoint = 'woocommerce/toggle_shop_connection';

        $params = array_merge($this->prepareParams(), ['active_state' => $activeState, 'shop' => $shopName] );
        return $this->restClient->post( $endpoint, $params );
    }

    public function sendCartData($shopUrl, $cartData) {
        $endpoint = 'woocommerce/save_cart';

        $params = array_merge($this->prepareParams(), ['cart_data' => $cartData, 'shop' => $shopUrl] );
        return $this->restClient->post( $endpoint, $params );
    } 

    public function sendSubscriberData($data) {
        $endpoint = 'woocommerce/save_subscriber';

        $params = array_merge($this->prepareParams(), ['data'=>$data] );
        $response = $this->restClient->post( $endpoint, $params );
        
        if (isset($response['body'])){
            return $response['body'];
        } else {
            return false;
        }
    }

    public function sendOrderProcessingData($data) {
        $endpoint = 'woocommerce/order_processing';

        $params = array_merge($this->prepareParams(), ['data'=>$data] );
        $this->restClient->post( $endpoint, $params );

        return true;
    }
}