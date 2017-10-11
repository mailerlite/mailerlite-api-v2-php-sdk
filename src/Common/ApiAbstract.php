<?php

namespace MailerLiteApi\Common;

use ArrayAccess;
use Exception;
use GuzzleHttp\Psr7\Request;
use MailerLiteApi\Common\Collection;
use MailerLiteApi\Common\RestClient;

abstract class ApiAbstract {

    protected $restClient;

    protected $endpoint;

    private $_limit = null;

    private $_offset = null;

    private $_order = null;

    private $_where = null;

    public function __construct(RestClient $restClient)
    {
        $this->restClient = $restClient;
    }

    /**
     * Get collection of items
     * @param  array $fields
     * @return [type]
     */
    public function get($fields = ['*'])
    {
        $params = $this->prepareParams();

        if ( ! empty($fields) && is_array($fields) && $fields != ['*']) {
            $params['fields'] = $fields;
        }

        $response = $this->restClient->get($this->endpoint, $params);

        $entities = $this->generateCollection($response['body']);

        return $entities;
    }

    /**
     * Get single item
     *
     * @param  int|string $id Id can be Subscribers ID or his email address
     * @return [type]
     */
    public function find($id)
    {
        if (empty($id)) {
            throw new \Exception('ID must be set');
        }

        $response = $this->restClient->get($this->endpoint . '/' . $id);

        return $response['body'];
    }

    /**
     * Create new item
     *
     * @param  array $data
     * @return [type]
     */
    public function create($data)
    {
        $response = $this->restClient->post($this->endpoint, $data);
        return $response['body'];
    }

    /**
     * Update an item
     *
     * @param  int   $id
     * @param  array $data
     * @return [type]
     */
    public function update($id, $data)
    {
        $response = $this->restClient->put($this->endpoint . '/' . $id, $data);

        return $response['body'];
    }

    /**
     * Delete an item
     *
     * @param  int $id
     * @return [type]
     */
    public function delete($id)
    {
        $response = $this->restClient->delete($this->endpoint . '/' . $id);

        return $response['body'];
    }

    /**
     * Return only count of items
     *
     * @return [type]
     */
    public function count()
    {
        $response = $this->restClient->get($this->endpoint . '/count');

        return $response['body'];
    }

    /**
     * Set size of limit in query
     *
     * @param  [type] $limit
     * @return [type]
     */
    public function limit($limit)
    {
        $this->_limit = $limit;

        return $this;
    }

    /**
     * Set size of offset in query
     *
     * @param [type] $offset
     */
    public function offset($offset)
    {
        $this->_offset = $offset;

        return $this;
    }

    /**
     * Set an order in of items in query
     *
     * @param  [type] $field
     * @param  string $order
     * @return [type]
     */
    public function orderBy($field, $order = 'ASC')
    {
        $this->_orders[$field] = $order;

        return $this;
    }

    /**
     * Set where conditions
     *
     * @param  [type] $column
     * @param  [type] $operator
     * @param  [type] $value
     * @param  string $boolean
     * @return [type]
     */
    public function where(
        $column,
        $operator = null,
        $value = null,
        $boolean = 'and'
    ) {
        if (is_array($column)) {
            $this->_where = $column;
        }

        return $this;
    }

    /**
     * Return collection of objects
     *
     * @param  [type] $items
     * @return [type]
     */
    public function generateCollection($items)
    {
        if ( ! is_array($items)) {
            $items = [$items];
        }

        return new Collection($items);
    }

    /**
     * Prepare query parameters
     *
     * @return [type]
     */
    protected function prepareParams()
    {
        $params = [];

        if ( ! empty($this->_where) && is_array($this->_where)) {
            $params['filters'] = $this->_where;
        }

        if ( ! empty($this->_offset)) {
            $params['offset'] = $this->_offset;
        }

        if ( ! empty($this->_limit)) {
            $params['limit'] = $this->_limit;
        }

        if ( ! empty($this->_orders) && is_array($this->_orders)) {
            foreach ($this->_orders as $field => $order) {
                $params['order_by'][$field] = $order;
            }
        }

        return $params;
    }

}
