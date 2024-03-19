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

}