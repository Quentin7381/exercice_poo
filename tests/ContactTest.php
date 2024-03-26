<?php

require_once __DIR__ . '/TestSetup.php';

class ContactTest extends TestSetup
{

    protected static $className = 'Contact';

    function test_gettersWorks()
    {
        $contact = new Contact(
            1,
            'Doe',
            'jhon.doe@mail.com',
            '0123456789'
        );

        $this->assertEquals(1, $contact->id);
        $this->assertEquals('Doe', $contact->name);
        $this->assertEquals('jhon.doe@mail.com', $contact->email);
        $this->assertEquals('0123456789', $contact->phone);
    }

    function test_setIsImpossible()
    {
        $contact = new Contact(
            1,
            'Doe',
            'jhon.doe@mail.com',
            '0123456789'
        );

        $keys = ['id', 'name', 'email', 'phone'];
        foreach ($keys as $key) {
            try {
                $contact->$key = 'something';
                $this->fail('Exception not thrown');
            } catch (Throwable $e) {
                $this->assertStringStartsWith('Cannot access protected property', $e->getMessage());
            }
        }
    }

}