<?php

declare(strict_types=1);

namespace Ksfraser\Notes\Entity;

class Note
{
    public ?int $id = null;
    public ?int $entityId = null;
    public ?string $entityType = null;
    public ?string $noteType = 'Comment';
    public ?string $note = null;
    public ?string $createdBy = null;
    public ?string $createdAt = null;
    public ?string $updatedAt = null;

    public function __construct(
        ?int $entityId = null,
        ?string $entityType = null,
        ?string $note = null,
        ?string $noteType = 'Comment'
    ) {
        $this->entityId = $entityId;
        $this->entityType = $entityType;
        $this->note = $note;
        $this->noteType = $noteType;
    }

    public function setEntityId(int $id): self
    {
        $this->entityId = $id;
        return $this;
    }

    public function getEntityId(): ?int
    {
        return $this->entityId;
    }

    public function setEntityType(string $type): self
    {
        $this->entityType = $type;
        return $this;
    }

    public function getEntityType(): ?string
    {
        return $this->entityType;
    }

    public function setNoteType(string $type): self
    {
        $this->noteType = $type;
        return $this;
    }

    public function getNoteType(): ?string
    {
        return $this->noteType;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;
        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setCreatedBy(string $createdBy): self
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'entity_id' => $this->entityId,
            'entity_type' => $this->entityType,
            'note_type' => $this->noteType,
            'note' => $this->note,
            'created_by' => $this->createdBy,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }

    public static function fromArray(array $data): self
    {
        $note = new self();
        $note->id = $data['id'] ?? null;
        $note->entityId = $data['entity_id'] ?? null;
        $note->entityType = $data['entity_type'] ?? null;
        $note->noteType = $data['note_type'] ?? 'Comment';
        $note->note = $data['note'] ?? null;
        $note->createdBy = $data['created_by'] ?? null;
        $note->createdAt = $data['created_at'] ?? null;
        $note->updatedAt = $data['updated_at'] ?? null;
        return $note;
    }

    public static function getValidTypes(): array
    {
        return ['Comment', 'Internal', 'Public', 'Private', 'System'];
    }

    public static function getValidEntityTypes(): array
    {
        return [
            'debtor',
            'contact',
            'opportunity',
            'ticket',
            'call_log',
            'lead',
            'quote',
            'invoice',
            'order',
        ];
    }

    public function isValid(): bool
    {
        return $this->entityId !== null
            && $this->entityType !== null
            && $this->note !== null
            && in_array($this->entityType, self::getValidEntityTypes(), true)
            && in_array($this->noteType, self::getValidTypes(), true);
    }
}