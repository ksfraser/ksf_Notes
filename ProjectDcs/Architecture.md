# Architecture - ksf_Notes

## Document Information
- **Module**: ksf_Notes
- **Version**: 1.0.0
- **Date**: 2026-05-11
- **Status**: Implemented
- **Author**: KSFII Development Team

---

## 1. Module Overview

ksf_Notes provides a flexible note-taking system that integrates with CRM, Projects, and other modules for capturing and sharing information.

### 1.1 Namespace
```php
Ksfraser\Notes\
```

### 1.2 Layer Pattern
```
ksf_Notes/                 → Business Logic
    ├── Entity/            → Domain entities
    ├── Service/           → Business services
    ├── Repository/        → Data access interfaces
    └── Exception/         → Domain exceptions
```

---

## 2. Core Entities

### 2.1 Note (Aggregate Root)

```php
class Note {
    private string $id;
    private string $title;
    private string $content;           // Rich text / HTML
    private ?string $authorId;
    private NoteType $type;            // note, kb_article, comment
    private ?string $parentNoteId;    // For comments/replies
    private bool $isPublic;
    private bool $isPinned;
    private array $tags;
    private array $attachments;
    private NoteStatus $status;
    private ?\DateTime $publishedAt;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;
    
    // Entity Links (polymorphic)
    private ?string $linkedEntityType;
    private ?string $linkedEntityId;
    
    // Methods
    public function addComment(string $authorId, string $content): Note;
    public function attachFile(string $filePath): self;
    public function publish(): self;
    public function archive(): self;
    public function convertToKBArticle(): KBArticle;
    public function getComments(): array;
}
```

### 2.2 NoteLink

```php
class NoteLink {
    private string $id;
    private string $noteId;
    private string $entityType;       // customer, project, task, ticket
    private string $entityId;
    private string $linkedBy;
    private \DateTime $linkedAt;
}
```

---

## 3. Service Layer

### 3.1 NoteService

| Method | Description |
|--------|-------------|
| `createNote(array $data): Note` | Create new note |
| `getNote(string $id): ?Note` | Retrieve note |
| `updateNote(string $id, array $data): Note` | Update note |
| `deleteNote(string $id): bool` | Soft delete |
| `addComment(string $noteId, array $data): Note` | Add comment |
| `linkToEntity(string $noteId, string $entityType, string $entityId): NoteLink` | Link note |
| `getNotesByEntity(string $entityType, string $entityId): array` | Get linked notes |
| `searchNotes(string $query): array` | Full-text search |
| `getTags(): array` | Get all tags |
| `convertToArticle(string $noteId): KBArticle` | Convert to KB |

---

## 4. State Machine

### 4.1 Note Status

```
Draft ──> Published ──> Archived
  │                    │
  └── (unpublish) ─────┘
```

---

## 5. Integration Architecture

### 5.1 Provided Services

| Consumer | Interface | Data |
|----------|-----------|------|
| ksf_CRM | NoteServiceInterface | Customer notes |
| ksf_ProjectManagement | NoteServiceInterface | Project notes |
| ksf_SupportTickets | NoteServiceInterface | Ticket notes |
| ksf_FA_Notes | NoteServiceInterface | Note sync |

### 5.2 Consumed Services

| Provider | Interface | Data |
|---------|-----------|------|
| ksf_CRM | CustomerServiceInterface | Customer link |
| ksf_ProjectManagement | ProjectServiceInterface | Project link |
| ksf_SupportTickets | TicketServiceInterface | Ticket link |

---

## 6. Error Handling

### 6.1 Exception Hierarchy

```
\Exception
└── KsfNotesException (base)
    ├── NoteNotFoundException
    ├── NotePermissionException
    └── NoteValidationException
```

---

*Document Version: 1.0.0*
*Last Updated: 2026-05-11*