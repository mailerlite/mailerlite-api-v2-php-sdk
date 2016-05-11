<?php

use MailerLiteApi\Mailerlite;
use MailerLiteApi\Resources\Fields;

class FieldsTest extends PHPUnit_Framework_TestCase
{
    protected $fieldsApi;

    protected function setUp()
    {
        $this->fieldsApi = (new Mailerlite('fc7b8c5b32067bcd47cafb5f475d2fe9'))->fields();
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