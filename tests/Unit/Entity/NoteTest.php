<?php

use PHPUnit\Framework\TestCase;
use Ksfraser\Notes\Entity\Note;

class NoteTest extends TestCase
{
    public function testCanCreateNote(): void
    {
        $note = new Note(1, 'debtor', 'Test note content', 'Comment');
        
        $this->assertEquals(1, $note->getEntityId());
        $this->assertEquals('debtor', $note->getEntityType());
        $this->assertEquals('Test note content', $note->getNote());
        $this->assertEquals('Comment', $note->getNoteType());
    }
    
    public function testValidTypes(): void
    {
        $types = Note::getValidTypes();
        
        $this->assertContains('Comment', $types);
        $this->assertContains('Internal', $types);
        $this->assertContains('Public', $types);
    }
    
    public function testValidEntityTypes(): void
    {
        $types = Note::getValidEntityTypes();
        
        $this->assertContains('debtor', $types);
        $this->assertContains('contact', $types);
        $this->assertContains('opportunity', $types);
        $this->assertContains('ticket', $types);
        $this->assertContains('call_log', $types);
    }
    
    public function testIsValid(): void
    {
        $validNote = new Note(1, 'debtor', 'Valid note', 'Comment');
        $this->assertTrue($validNote->isValid());
        
        $invalidNote = new Note(null, 'debtor', 'Note', 'Comment');
        $this->assertFalse($invalidNote->isValid());
    }
    
    public function testToArray(): void
    {
        $note = new Note(5, 'contact', 'Test note', 'Internal');
        $note->id = 10;
        $note->createdBy = 'admin';
        
        $arr = $note->toArray();
        
        $this->assertEquals(10, $arr['id']);
        $this->assertEquals(5, $arr['entity_id']);
        $this->assertEquals('contact', $arr['entity_type']);
        $this->assertEquals('Internal', $arr['note_type']);
    }
    
    public function testFromArray(): void
    {
        $data = [
            'id' => 1,
            'entity_id' => 10,
            'entity_type' => 'opportunity',
            'note_type' => 'Public',
            'note' => 'From array note',
            'created_by' => 'user1',
        ];
        
        $note = Note::fromArray($data);
        
        $this->assertEquals(1, $note->id);
        $this->assertEquals(10, $note->entityId);
        $this->assertEquals('opportunity', $note->entityType);
        $this->assertEquals('From array note', $note->note);
    }
    
    public function testFluentInterface(): void
    {
        $note = (new Note())
            ->setEntityId(1)
            ->setEntityType('debtor')
            ->setNote('Updated note')
            ->setNoteType('Internal')
            ->setCreatedBy('admin');
        
        $this->assertEquals(1, $note->getEntityId());
        $this->assertEquals('debtor', $note->getEntityType());
        $this->assertEquals('Updated note', $note->getNote());
    }
}