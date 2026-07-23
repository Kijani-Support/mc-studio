# MC Studio IBM Curriculum Portal

Next.js app: IBM Verify (login) → role-gated admin/student pages → Zite (data).

**Live Zite database already created:** `MC Studio IBM Curriculum Portal`
https://build.fillout.com/database/e08a78a855130a7d (Users, WeeklyResources, WeeklyProgress, ReportCards)

## Setup
1. `npm install`
2. Copy `.env.local.example` → `.env.local`, fill in:
   - IBM Verify app registration (issuer, client id/secret) — set redirect URI to
     `<your-deployed-url>/api/auth/callback/ibm-verify`
   - Zite API key (Developer settings tab in your Zite account)
3. In the Zite `Users` table, add each facilitator with `Role = Admin` and each
   student with `Role = Student`, matching their IBM Verify login email exactly
   — this is how the app knows who can reach `/admin/*`.
4. `npm run dev` locally, then deploy (Vercel or similar) and update
   `NEXTAUTH_URL` + the IBM Verify redirect URI to the deployed URL.

## How access control works
- `/admin/resources` — facilitators upload weekly items; new rows default to
  `Visibility: Draft` (hidden) until flipped to `Published`.
- `/student/resources` — students only ever see `Visibility: Published` rows.
- `middleware.ts` blocks both routes for anyone not signed in via IBM Verify;
  `/admin/*` additionally requires `Role = Admin` (looked up from Zite on login).

## ClickUp + WhatsApp
This app only handles login + resource visibility. Weekly progress sync from
ClickUp's public view (via Zapier) and WhatsApp report-card delivery (manual,
per your setup) still follow `Zite_ClickUp_WhatsApp_Workflow.md` — they write
into `WeeklyProgress` / `ReportCards` directly via the Zite API, independent
of this app.

## Before first deploy
Confirm the exact Zite REST sub-paths (`lib/zite.ts`) against your account's
live API reference under Developer settings — Zite documents each endpoint
individually rather than a single spec, so table/record path shape should be
double-checked once you have your API key.
