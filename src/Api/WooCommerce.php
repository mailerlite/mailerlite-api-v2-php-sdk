<?php

namespace MailerLiteApi\Api;

use MailerLiteApi\Common\ApiAbstract;

/**
 * Class WooCommerce
 *
 * @package MailerLiteApi\Api
 */
class WooCommerce extends ApiAbstract
{
    protected $endpoint = 'woocommerce';

    public function setConsumerData( $consumerKey, $consumerSecret, $store, $currency, $group_id, $resubscribe, $ignoreList, $create_segments)
    {
        $endpoint = $this->endpoint . '/consumer_data';

        $params = array_merge($this->prepareParams(),
            ['consumer_key' => $consumerKey,
                'consumer_secret' => $consumerSecret,
                'store' => $store,
                'currency' => $currency,
                'group_id' => $group_id,
                'resubscribe' => $resubscribe,
                'ignore_list' => $ignoreList,
                'create_segments' => $create_segments]);

        $response = $this->restClient->post( $endpoint, $params );

        return $response['body'];
    }

    public function saveOrder($orderData, $shop)
    {
        $endpoint = 'woocommerce/alternative_save_order';

        $params = array_merge($this->prepareParams(), ['order_data' => $orderData, 'shop' => $shop] );
        $response = $this->restClient->post( $endpoint, $params );
        if (isset($response['body'])){
            return $response['body'];
        } else {
            return true;
        }
    }

    public function toggleShopConnection($shop, $activeState)
    {
        $shopName = parse_url($shop, PHP_URL_HOST);
        $endpoint = 'woocommerce/toggle_shop_connection';

        $params = array_merge($this->prepareParams(), ['active_state' => $activeState, 'shop' => $shopName] );
        return $this->restClient->post( $endpoint, $params );
    }

    public function sendCartData($shopUrl, $cartData)
    {
        $endpoint = 'woocommerce/save_cart';

        $params = array_merge($this->prepareParams(), ['cart_data' => $cartData, 'shop' => $shopUrl] );
        $response = $this->restClient->post( $endpoint, $params );
        if (isset($response['body'])){
            return $response['body'];
        } else {
            return true;
        }
    }

    public function sendSubscriberData($data)
    {
        $endpoint = 'woocommerce/save_subscriber';

        $params = array_merge($this->prepareParams(), ['data'=>$data] );
        $response = $this->restClient->post( $endpoint, $params );

        if (isset($response['body'])){
            return $response['body'];
        } else {
            return false;
        }
    }

    public function sendOrderProcessingData($data)
    {
        $endpoint = 'woocommerce/order_processing';

        $params = array_merge($this->prepareParams(), ['data'=>$data] );
        $response = $this->restClient->post( $endpoint, $params );

        if (isset($response['body'])){
            return $response['body'];
        } else {
            return true;
        }
    }

    public function getShopSettings($shopUrl)
    {
        $shopName = parse_url($shopUrl, PHP_URL_HOST);
        $endpoint = 'woocommerce/settings/'.$shopName;

        return $this->restClient->get( $endpoint);
    }

    public function validateAccount()
    {
        $endpoint = 'woocommerce/initial_account_settings';
        return $this->restClient->get($endpoint);
    }

    public function syncCustomer($email, $fields, $shopUrl)
    {
        $endpoint = 'woocommerce/sync_customer';
        $params = array_merge($this->prepareParams(), ['email' => $email, 'subscriber_fields' => $fields, 'shop' => $shopUrl] );

        $response = $this->restClient->post( $endpoint, $params );

        if (isset($response['body'])) {
            return $response['body'];
        } else {
            return true;
        }
    }
}
