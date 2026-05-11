# Architecture - ksf_Notes

## Document Information
- **Module**: ksf_Notes
- **Version**: 1.0.0
- **Date**: 2026-05-11
- **Status**: Proposed

## 1. Directory Structure

```
ksf_Notes/
├── src/Ksfraser/Notes/
│   ├── NoteService.php
│   ├── Contract/
│   │   └── NoteRepositoryInterface.php
│   ├── Entity/
│   │   ├── Note.php
│   │   ├── NoteComment.php
│   │   ├── NoteShare.php
│   │   └── NoteVersion.php
│   └── Exception/
└── composer.json
```

## 2. Core Design

### Note Entity
```php
class Note {
    private string $id;
    private ?string $entityType;  // customer, project, ticket
    private ?string $entityId;
    private string $title;
    private string $body;
    private string $authorId;
    private array $tags;
}
```

## 3. Integration Points

| Module | Integration |
|--------|-------------|
| ksf_CRM | Customer notes |
| ksf_ProjectManagement | Project notes |
| ksf_SupportTickets | Ticket notes |
| ksf_Documents | File attachments |

---

*Document Version: 1.0.0*
*Last Updated: 2026-05-11*