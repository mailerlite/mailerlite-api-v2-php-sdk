<?php

namespace MailerLiteApi\Api;

use MailerLiteApi\Common\ApiAbstract;

/**
 * Class Subscribers
 *
 * @package MailerLiteApi\Api
 */
class Subscribers extends ApiAbstract {

    const TYPE_ACTIVE = 'active';
    const TYPE_UNSUBSCRIBED = 'unsubscribed';
    const TYPE_BOUNCED = 'bounced';
    const TYPE_JUNK = 'junk';
    const TYPE_UNCONFIRMED = 'unconfirmed';

    protected $endpoint = 'subscribers';

    /**
     * Get groups subscriber belongs to
     *
     * @param  int   $subscriberId
     * @param  array $params
     * @return [type]
     */
    public function getGroups($subscriberId, $params = [])
    {
        $endpoint = $this->endpoint . '/' . urlencode($subscriberId) . '/groups';

        $params = array_merge($this->prepareParams(), $params);

        $response = $this->restClient->get($endpoint, $params);

        return $response['body'];
    }

    /**
     * Get activity of subscriber
     *
     * @param  int    $subscriberId
     * @param  string $type
     * @param  array  $params
     * @return [type]
     */
    public function getActivity($subscriberId, $type = null, $params = [])
    {
        $endpoint = $this->endpoint . '/' . urlencode($subscriberId) . '/activity';

        if ($type !== null) {
            $endpoint .= '/' . $type;
        }

        $params = array_merge($this->prepareParams(), $params);

        $response = $this->restClient->get($endpoint, $params);

        return $response['body'];
    }

    /**
     * Seach for a subscriber by email or custom field value
     *
     * @param  string $query
     * @return [type]
     */
    public function search($query)
    {
        $endpoint = $this->endpoint . '/search';

        $params = array_merge($this->prepareParams(), ['query' => $query]);

        $response = $this->restClient->get($endpoint, $params);

        return $response['body'];
    }

    /**
     * Get all subscribers
     *
     * @param  string[]  $fields
     * @param  null|string  $type
     *
     * @return \MailerLiteApi\Common\Collection
     */
    public function get($fields = ['*'], $type = null)
    {
        $params = $this->prepareParams();

        if ( ! empty($fields) && is_array($fields) && $fields != ['*']) {
            $params['fields'] = $fields;
        }

        if ($type !== null) {
            $params['type'] = $type;
        }

        $response = $this->restClient->get($this->endpoint, $params);

        return $this->generateCollection($response['body']);
    }

}
