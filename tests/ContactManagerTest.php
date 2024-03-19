<?php

require_once __DIR__ . '/TestSetup.php';

class ContactManagerTest extends TestSetup{

    protected static $className = 'ContactManager';

    function test__find(){
        // Fetch renvoie un tableau de contacts
        $manager = ContactManager::get();
        $result = $manager->find();
        $this->assertTrue(is_array($result));
        $this->assertTrue(count($result) > 0);
        foreach($result as $contact){
            $this->assertInstanceOf(Contact::class, $contact);

            $this->assertNotEmpty($contact->id);
            $this->assertNotEmpty($contact->name);
            $this->assertNotEmpty($contact->email);
            $this->assertNotEmpty($contact->phone);
        }
    }

    function test__create_delete(){
        // Create renvoie le contact créé avec son id
        $manager = ContactManager::get();
        $result = $manager->create(
            'John',
            'jhon@mail.com',
            '0123456789'
        );

        $this->assertInstanceOf(Contact::class, $result);
        $this->assertNotEmpty($result->id);
        $this->assertEquals('John', $result->name);
        $this->assertEquals('jhon@mail.com', $result->email);
        $this->assertEquals('0123456789', $result->phone);

        // Delete
        $success = $manager->delete($result->id);
        $this->assertTrue($success);
        $this->assertEmpty($manager->find(["id"=> $result->id]));
    }
}