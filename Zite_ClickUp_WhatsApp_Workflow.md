# Zite + ClickUp → Report Cards → WhatsApp Workflow

Reference for standing up the October 2026 intake pipeline (replicable each cohort).

## Pipeline

```
ClickUp (weekly kanban) → Zite (structured DB) → Report Card generator → Meta WhatsApp Cloud API
```

Zite is the system of record; ClickUp stays the facilitator-facing tracker; WhatsApp is delivery only (requires a separate automation — Zite has no native messaging).

## Step 1 — Create the Zite database

Actual tool call:

```json
{
  "tool": "Zite:create_database",
  "input": {
    "name": "IBM Curriculum — October 2026 Intake",
    "tables": [
      {
        "name": "Students",
        "fields": [
          { "type": "single_line_text", "name": "Student Name" },
          { "type": "phone_number", "name": "WhatsApp Phone (E.164)" },
          { "type": "single_select", "name": "Pathway", "template": { "options": [
            { "value": "bi", "label": "Business Intelligence" },
            { "value": "cyber", "label": "Cybersecurity" },
            { "value": "ds", "label": "Data Science" },
            { "value": "pd", "label": "Product Development" }
          ]}},
          { "type": "single_select", "name": "Intake", "template": { "options": [
            { "value": "jul2026", "label": "July 2026" },
            { "value": "oct2026", "label": "October 2026" }
          ]}},
          { "type": "url", "name": "ClickUp Profile URL" }
        ]
      },
      {
        "name": "WeeklyProgress",
        "fields": [
          { "type": "linked_record", "name": "Student", "template": { "tableId": "<Students table ID>" } },
          { "type": "number", "name": "Week No", "template": { "decimalPlaces": 0 } },
          { "type": "single_select", "name": "Phase", "template": { "options": [
            { "value": "p1", "label": "Phase 1" }, { "value": "p2", "label": "Phase 2" }, { "value": "p3", "label": "Phase 3" }
          ]}},
          { "type": "single_select", "name": "Status", "template": { "options": [
            { "value": "not_started", "label": "Not Started" }, { "value": "in_progress", "label": "In Progress" },
            { "value": "submitted", "label": "Submitted" }, { "value": "reviewed", "label": "Reviewed" }, { "value": "complete", "label": "Complete" }
          ]}},
          { "type": "long_text", "name": "Facilitator Comment" },
          { "type": "url", "name": "ClickUp Card URL" }
        ]
      },
      {
        "name": "ReportCards",
        "fields": [
          { "type": "linked_record", "name": "Student", "template": { "tableId": "<Students table ID>" } },
          { "type": "single_select", "name": "Phase", "template": { "options": [
            { "value": "p1", "label": "Phase 1" }, { "value": "p2", "label": "Phase 2" }, { "value": "p3", "label": "Phase 3" }
          ]}},
          { "type": "date", "name": "Generated Date" },
          { "type": "number", "name": "Score", "template": { "decimalPlaces": 1 } },
          { "type": "url", "name": "PDF Link" }
        ]
      },
      {
        "name": "MessageLog",
        "fields": [
          { "type": "linked_record", "name": "Student", "template": { "tableId": "<Students table ID>" } },
          { "type": "single_select", "name": "Message Type", "template": { "options": [
            { "value": "nudge", "label": "Weekly Nudge" }, { "value": "report_card", "label": "Report Card" }, { "value": "grace_alert", "label": "Grace Deadline Alert" }
          ]}},
          { "type": "datetime", "name": "Sent Date" },
          { "type": "single_select", "name": "Delivery Status", "template": { "options": [
            { "value": "sent", "label": "Sent" }, { "value": "delivered", "label": "Delivered" }, { "value": "failed", "label": "Failed" }
          ]}}
        ]
      }
    ]
  }
}
```

Run once; note the returned `baseId` and each `tableId` — you'll need them for every call below. `linked_record` fields require the real `Students` tableId once it's returned, so create `Students` first (or create all four, then patch the linked-record fields with `update_field`).

## Step 2 — Populate a student (per sign-up)

```json
{
  "tool": "Zite:create_record",
  "input": {
    "baseId": "<baseId>",
    "tableId": "<Students tableId>",
    "record": {
      "Student Name": "Jane Wanjiru",
      "WhatsApp Phone (E.164)": "+254700000000",
      "Pathway": "cyber",
      "Intake": "oct2026",
      "ClickUp Profile URL": "https://app.clickup.com/..."
    }
  }
}
```

## Step 3 — Weekly sync from ClickUp (facilitator or automation)

```json
{
  "tool": "Zite:bulk_create_records",
  "input": {
    "baseId": "<baseId>",
    "tableId": "<WeeklyProgress tableId>",
    "records": [
      { "Student": ["<student recordId>"], "Week No": 4, "Phase": "p2", "Status": "in_progress", "ClickUp Card URL": "https://app.clickup.com/t/..." }
    ]
  }
}
```

## Step 4 — Generate report card

Use `Zite:aggregate_records` (or `query_records`) to roll up `WeeklyProgress` by student + phase, feed the result into the docx/pdf skill template (built earlier), then log it:

```json
{
  "tool": "Zite:create_record",
  "input": {
    "baseId": "<baseId>",
    "tableId": "<ReportCards tableId>",
    "record": { "Student": ["<student recordId>"], "Phase": "p2", "Generated Date": "2026-11-22", "Score": 8.5, "PDF Link": "https://.../reportcard.pdf" }
  }
}
```

## Step 5 — WhatsApp delivery (outside Zite)

Zite has no messaging tool — trigger a small automation (Zapier/Make/script) on new `ReportCards` rows:
1. Read the row → get linked `Student.WhatsApp Phone`
2. Call Meta WhatsApp Cloud API `POST /messages` with a **pre-approved message template** (Meta requires template approval for business-initiated messages)
3. Write the result back via `Zite:create_record` into `MessageLog`

## October 2026 replicability

- Duplicate this database, rename to "IBM Curriculum — October 2026 Intake", keep identical field names/types across all four tables.
- Report-card generation and WhatsApp template logic reference field *names*, not intake-specific values — so no code changes, only re-pointing `baseId`/`tableId` per new intake.
