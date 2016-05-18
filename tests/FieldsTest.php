<?php

namespace MailerLiteApi\Tests;

use MailerLiteApi\MailerLite;
use MailerLiteApi\Api\Fields;

class FieldsTest extends MlTestCase
{
    protected $fieldsApi;

    protected function setUp()
    {
        $this->fieldsApi = (new MailerLite(API_KEY))->fields();
    }

    /** @test **/
    public function check_fields_data()
    {
        $fields = $this->fieldsApi->get();

        $this->assertTrue(is_numeric($fields[0]->id) && isset($fields[0]->title));
    }

    /** @test **/
    public function create_field()
    {
        $field = $this->fieldsApi->create(['title' => 'test field', 'type' => 'TEXT']);

        $this->assertTrue($field->title == 'test field' && $field->type == 'TEXT');

        $this->fieldsApi->delete($field->id);
    }

}