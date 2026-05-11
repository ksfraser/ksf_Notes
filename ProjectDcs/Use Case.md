# Use Cases - ksf_Notes

## UC-NT-001: Create Note on Customer
**Actor**: Sales Rep, Support Agent

**Flow**:
1. Navigate to customer in ksf_CRM
2. Click "Add Note"
3. Enter note content:
   - Title
   - Body (rich text)
   - Tags (optional)
4. Optionally attach files
5. Save
6. System:
   - Links note to customer
   - Shows in customer timeline
   - Shares with team (if configured)

---

## UC-NT-002: Create Project Note
**Actor**: Project Manager, Team Member

**Flow**:
1. Navigate to project (ksf_ProjectManagement)
2. Click "Add Note"
3. Enter:
   - Title (e.g., "Kickoff Meeting Notes")
   - Content
   - Tags
4. Link to specific task (optional)
5. Save
6. Note appears in:
   - Project notes section
   - Linked task (if applicable)
   - Team members notified

---

## UC-NT-003: Share Note with Team
**Actor**: Note Author

**Flow**:
1. Create or open note
2. Click "Share"
3. Select users or teams
4. Set permissions:
   - Read only
   - Can comment
   - Can edit
5. Save
6. Shared users:
   - See note in their notes list
   - Receive notification
   - Can add comments

---

## UC-NT-004: Convert Note to KB Article
**Actor**: Knowledge Manager

**Trigger**: Note marked as useful

**Flow**:
1. Note has many views/likes
2. Author or KM clicks "Publish to Knowledge Base"
3. System:
   - Creates KB article copy
   - Adds KB metadata:
     - Category
     - Keywords
     - Related articles
   - Sets status to 'Draft'
4. Author reviews/publishes article
5. Article now searchable in KB
6. Can link to tickets (ksf_SupportTickets)

---

## UC-NT-005: Search Notes
**Actor**: Any User

**Flow**:
1. Navigate to Notes > Search
2. Enter search terms:
   - Full text search
   - Filter by:
     - Author
     - Date range
     - Tags
     - Entity (customer, project, ticket)
3. View results:
   - Relevance sorted
   - Preview snippet
   - Entity link
4. Click to open note

---

## UC-NT-006: Add Comment to Note
**Actor**: User (with access)

**Flow**:
1. Open shared note
2. Click "Add Comment"
3. Enter comment text
4. Save
5. System:
   - Notifies note author
   - Shows comment thread
   - Logs activity

---

## UC-NT-007: Link Note to Support Ticket
**Actor**: Support Agent

**Flow**:
1. Open ticket (ksf_SupportTickets)
2. Click "Add Note"
3. Enter resolution notes
4. Optionally link to KB article
5. Save
6. Note visible in:
   - Ticket thread
   - Customer timeline (via ticket)
   - KB article (if linked)

---

## UC-NT-008: Note Version History
**Actor**: Note Author, Admin

**Flow**:
1. Open note
2. Click "History"
3. View versions:
   - Date/time
   - Author
   - Changes summary
4. Can:
   - View older version
   - Restore older version
   - Compare versions

---

## UC-NT-009: Attach Document to Note
**Actor**: User

**Flow**:
1. Create/edit note
2. Click "Attach File"
3. Select from:
   - Upload new file
   - Select from Documents (ksf_Documents)
4. File linked to note
5. Click to preview/download

---

## UC-NT-010: Note Template Usage
**Actor**: Admin, User

**Admin Flow - Create Template**:
1. Create note with standard structure
2. Save as template
3. Name and categorize template

**User Flow - Use Template**:
1. New Note > From Template
2. Select template
3. Pre-filled structure
4. Fill in details
5. Save as note

*Document Version: 1.0.0*
*Last Updated: 2026-05-11*