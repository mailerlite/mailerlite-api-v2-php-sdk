<?php

namespace MailerLiteApi\Api;

use MailerLiteApi\Common\ApiAbstract;
use MailerLiteApi\Exceptions\MailerLiteSdkException;

/**
 * Class Campaigns
 *
 * @package MailerLiteApi\Api
 */
class Campaigns extends ApiAbstract {

    protected $endpoint = 'campaigns';

    /**
     * Add custom html to campaign
     *
     * @param int   $campaignId
     * @param array $contentData
     * @return [type]
     */
    public function addContent(int $campaignId, array $contentData)
    {
        if ( ! array_key_exists('html', $contentData)) {
            throw new MailerLiteSdkException("HTML must be provided");
        }
        if ( ! array_key_exists('plain', $contentData)) {
            throw new MailerLiteSdkException("Plain text must be provided");
        }

        $endpoint = $this->endpoint . '/' . $campaignId . '/content';

        $response = $this->restClient->put($endpoint, $contentData);

        return $response['body'];
    }

    /**
     * Trigger action: send
     *
     * @param  int $campaignId
     * @param  array $settingsData
     * @return [type]
     */
    public function send($campaignId, $settingsData = [])
    {
        $endpoint = $this->endpoint . '/' . $campaignId . '/actions/send';

        $response = $this->restClient->post($endpoint, $settingsData);

        return $response['body'];
    }

    /**
     * Trigger action: cancel
     *
     * @param  int $campaignId
     * @return [type]
     */
    public function cancel($campaignId)
    {
        $endpoint = $this->endpoint . '/' . $campaignId . '/actions/cancel';

        $response = $this->restClient->post($endpoint);

        return $response['body'];
    }

    /**
     * Get collection of items
     * @param  array $fields
     * @return \MailerLiteApi\Common\Collection
     */
    public function get($type = 'sent', $fields = ['*'])
    {
        // filter anything that is not an available type
        $type = in_array($type, ['sent', 'draft', 'outbox']) ? $type : 'sent';

        $params = $this->prepareParams();

        if ( ! empty($fields) && is_array($fields) && $fields != ['*']) {
            $params['fields'] = $fields;
        }

        $response = $this->restClient->get($this->endpoint . '/' . $type, $params);

        $entities = $this->generateCollection($response['body']);

        return $entities;
    }
}
