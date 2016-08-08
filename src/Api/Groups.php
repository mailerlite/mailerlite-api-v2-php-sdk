<?php

namespace MailerLiteApi\Api;

use MailerLiteApi\Common\ApiAbstract;

class Groups extends ApiAbstract {

    protected $endpoint = 'groups';

    /**
     * Get subscribers from group
     * @param  int    $groupId
     * @param  string $type
     * @param  array  $params
     * @return [type]
     */
    public function getSubscribers($groupId, $type = null, $params = [])
    {
        $endpoint = $this->endpoint . '/' . $groupId . '/subscribers';

        if ($type !== null) {
            $endpoint .=  '/' . $type;
        }

        $params = array_merge($this->prepareParams(), $params);

        $response = $this->restClient->get($endpoint, $params);

        return $response['body'];
    }

    /**
     * Add single subscriber to group
     *
     * @param int   $groupId
     * @param array $subscriberData
     * @param array $params
     * @return [type]
     */
    public function addSubscriber($groupId, $subscriberData = [], $params = [])
    {
        $endpoint = $this->endpoint . '/' . $groupId . '/subscribers';

        $response = $this->restClient->post($endpoint, $subscriberData);

        return $response['body'];
    }

    /**
     * Remove subscriber from group
     *
     * @param  int $groupId
     * @param  int $subscriberId
     * @return [type]
     */
    public function removeSubscriber($groupId, $subscriberId)
    {
        $endpoint = $this->endpoint . '/' . $groupId . '/subscribers/' . $subscriberId;

        $response = $this->restClient->delete($endpoint);

        return $response['body'];
    }

    /**
     * Batch add subscribers to group
     *
     * @param  int $groupId
     * @param  array $subscribers
     * @param  array $options
     * @return [type]
     */
    public function importSubscribers(
        $groupId,
        $subscribers,
        $options = [
            'resubscribe' => false,
            'autoresponders' => false
        ]
    ) {
        $endpoint = $this->endpoint . '/' . $groupId . '/subscribers/import';

        $response = $this->restClient->post($endpoint, array_merge(['subscribers' => $subscribers], $options));

        return $response['body'];
    }
}