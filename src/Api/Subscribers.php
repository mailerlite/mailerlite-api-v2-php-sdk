<?php

namespace MailerLiteApi\Api;

use MailerLiteApi\Common\ApiAbstract;

class Subscribers extends ApiAbstract {

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

}