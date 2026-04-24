<?php

declare(strict_types=1);

namespace Ksfraser\Notes\Service;

use Ksfraser\Notes\Entity\Note;

class NoteService
{
    private bool $dbAvailable = false;

    public function __construct()
    {
        $this->dbAvailable = function_exists('db_query') && function_exists('db_escape');
    }

    public function addNote(int $entityId, string $entityType, string $note, string $noteType = 'Comment', ?string $createdBy = null): ?int
    {
        if (!$this->dbAvailable) {
            return null;
        }

        $noteObj = new Note($entityId, $entityType, $note, $noteType);
        if (!$noteObj->isValid()) {
            return null;
        }

        $sql = "INSERT INTO " . TB_PREF . "fa_crm_notes
            (entity_id, entity_type, note_type, note, created_by)
            VALUES (
                " . db_escape($entityId) . ",
                " . db_escape($entityType) . ",
                " . db_escape($noteType) . ",
                " . db_escape($note) . ",
                " . db_escape($createdBy ?? $_SESSION['wa_current_user']->name ?? 'system') . "
            )";

        db_query($sql, "Could not add note");
        return db_insert_id();
    }

    public function getNotes(int $entityId, string $entityType): array
    {
        if (!$this->dbAvailable) {
            return [];
        }

        $sql = "SELECT * FROM " . TB_PREF . "fa_crm_notes
            WHERE entity_id = " . db_escape($entityId) . "
            AND entity_type = " . db_escape($entityType) . "
            ORDER BY created_at DESC";

        $result = db_query($sql, "Could not get notes");
        $notes = [];

        while ($row = db_fetch_assoc($result)) {
            $notes[] = Note::fromArray($row);
        }

        return $notes;
    }

    public function getNoteById(int $noteId): ?Note
    {
        if (!$this->dbAvailable) {
            return null;
        }

        $sql = "SELECT * FROM " . TB_PREF . "fa_crm_notes
            WHERE id = " . db_escape($noteId);

        $result = db_query($sql, "Could not get note");
        $row = db_fetch_assoc($result);

        return $row ? Note::fromArray($row) : null;
    }

    public function updateNote(int $noteId, string $note, ?string $noteType = null): bool
    {
        if (!$this->dbAvailable) {
            return false;
        }

        $sets = ["note = " . db_escape($note)];
        if ($noteType !== null) {
            $sets[] = "note_type = " . db_escape($noteType);
        }

        $sql = "UPDATE " . TB_PREF . "fa_crm_notes SET
            " . implode(', ', $sets) . "
            WHERE id = " . db_escape($noteId);

        db_query($sql, "Could not update note");
        return true;
    }

    public function deleteNote(int $noteId): bool
    {
        if (!$this->dbAvailable) {
            return false;
        }

        $sql = "DELETE FROM " . TB_PREF . "fa_crm_notes
            WHERE id = " . db_escape($noteId);

        db_query($sql, "Could not delete note");
        return true;
    }

    public function searchNotes(string $keyword, ?string $entityType = null, int $limit = 50): array
    {
        if (!$this->dbAvailable) {
            return [];
        }

        $sql = "SELECT * FROM " . TB_PREF . "fa_crm_notes
            WHERE note LIKE " . db_escape('%' . $keyword . '%');

        if ($entityType !== null) {
            $sql .= " AND entity_type = " . db_escape($entityType);
        }

        $sql .= " ORDER BY created_at DESC LIMIT " . db_escape($limit);

        $result = db_query($sql, "Could not search notes");
        $notes = [];

        while ($row = db_fetch_assoc($result)) {
            $notes[] = Note::fromArray($row);
        }

        return $notes;
    }

    public function getNotesByType(string $entityType, string $noteType, int $limit = 50): array
    {
        if (!$this->dbAvailable) {
            return [];
        }

        $sql = "SELECT * FROM " . TB_PREF . "fa_crm_notes
            WHERE entity_type = " . db_escape($entityType) . "
            AND note_type = " . db_escape($noteType) . "
            ORDER BY created_at DESC LIMIT " . db_escape($limit);

        $result = db_query($sql, "Could not get notes");
        $notes = [];

        while ($row = db_fetch_assoc($result)) {
            $notes[] = Note::fromArray($row);
        }

        return $notes;
    }

    public function getEntityNoteCounts(): array
    {
        if (!$this->dbAvailable) {
            return [];
        }

        $sql = "SELECT entity_type, entity_id, COUNT(*) as note_count
            FROM " . TB_PREF . "fa_crm_notes
            GROUP BY entity_type, entity_id";

        $result = db_query($sql, "Could not get note counts");
        $counts = [];

        while ($row = db_fetch_assoc($result)) {
            $key = $row['entity_type'] . '_' . $row['entity_id'];
            $counts[$key] = $row['note_count'];
        }

        return $counts;
    }
}