# AIKYA Compass — Airtable Portfolio Schema

Source: `AIKYA_Compass_Airtable_Schema.xlsx` (MC Studio × OW Advocates, Sita Sector Program
Programme). This is the data model behind **The Aikya Compass** referenced in the Playbook —
the system of record that tracks every portfolio startup from Legal Health Check (LHC) through
active engagement, payment, and (where relevant) investor introduction.

Use this file when a question is about **operational tracking mechanics** — what field holds
what, how a status flows, how a grace period or disbursement deadline is calculated, what an
automation does — rather than pricing or compliance substance (those live in
`aikya-tiers-pricing.md`, `legal-health-check.md`, and `six-sector-compliance.md`).

## Table of contents
- [Table map & key relationships](#table-map--key-relationships)
- [T1 · Portfolio_Clients](#t1--portfolio_clients)
- [T2 · Engagements](#t2--engagements)
- [T3 · Milestones](#t3--milestones)
- [T4 · Payments (Lotus)](#t4--payments-lotus)
- [T5 · Agreements](#t5--agreements)
- [T6 · Legal_Health_Checks](#t6--legal_health_checks)
- [T7 · Investors](#t7--investors)
- [T8 · Automations_Log](#t8--automations_log)
- [Grace periods & disbursement SLA — the numbers that matter](#grace-periods--disbursement-sla--the-numbers-that-matter)
- [Automations (12)](#automations-12)
- [Interfaces (7)](#interfaces-7)
- [Sample data](#sample-data)

## Table map & key relationships

| Table | Purpose |
|---|---|
| T1 · Portfolio_Clients | Master startup registry — one record per portfolio company |
| T2 · Engagements | Each OW legal engagement scoped to a client + sector |
| T3 · Milestones | Delivery milestones, with 7-day grace periods baked in |
| T4 · Payments | Lotus payment flow (deposits, balances, disbursements) |
| T5 · Agreements | Signed-agreement tracker linked to Engagements |
| T6 · Legal_Health_Checks | LHC submissions from the website `/legalhealthcheck/assess` |
| T7 · Investors | Investor pipeline — finder's fee and DD fee tracking |
| T8 · Automations_Log | Audit log auto-written by every automation trigger |

Relationships: `Portfolio_Clients → Engagements` (1‑to‑many); `Engagements → Milestones`,
`Engagements → Payments`, `Engagements → Agreements` (each 1‑to‑many); `Legal_Health_Checks →
Portfolio_Clients` (1‑to‑1, on conversion); `Portfolio_Clients ↔ Investors` (many‑to‑many).

Governing documents referenced throughout the schema: **Partnership Agreement V3** (MC Studio ↔
OW), an **Amendment Memo** covering the Lotus payment channel (§3A) and Appendix A fee schedule,
sector-specific **Engagement Agreements**, the **Aikya Playbook**, and the **Pricing Brochure**.
Treat these as the underlying legal source; this schema just operationalizes them.

## T1 · Portfolio_Clients

Master record per startup. Key fields: `Client_ID` (MCS-#), `Company_Name`, `Sector` (one of
the six Sita Sector industries), `Aikya_Tier` (HUSTLE/GROW/LEAD), `Programme_Status` (Lead → LHC
Completed → Engaged → Active Retainer → Paused/Churned/Investor Ready), `Country_HQ`,
`Annual_Revenue_KES`, `Employee_Count`, `LHC_Score` (rolled up from T6), `Assigned_Trail_Guide`
(MC Studio side), `OW_Assigned_Advocate` (OW side), `Harmony_Pulse_Score` (1–10, quarterly),
`Lotus_Contact_Ref` / `Lotus_Payment_Method` (M-PESA / Pesalink / Bank Transfer / Paybill /
Till), and rollups `Total_Fees_Invoiced_KES`, `Total_Fees_Paid_KES`, and a formula
`Outstanding_Balance_KES = Total_Fees_Invoiced_KES − Total_Fees_Paid_KES` (alerts if > 0 and
past due).

`Programme_Status` is the master pipeline stage — changes to it notify the BD team.

## T2 · Engagements

One record per scoped piece of legal work; drives milestone, payment, and timeline
automations. `Engagement_Type`: Legal Consult Retainer, Legal Support Retainer, Legal Health
Check, Add-On Service, Due Diligence, M&A Advisory, ESOP Setup, Data Protection Audit,
Cross-Border Referral. `Engagement_Status` runs: Scoping → Deposit Pending → Active →
Pre-Completion Grace → Completed–Awaiting Payment → Post-Completion Grace → Payment Received →
Disbursed to OW → Closed (with On Hold / Disputed as side states).

Fee formulas (per Partnership V3 Clause 3/5 + Amendment Appendix A):
- `Total_Fee_KES = Base_Fee_KES × Duration_Months + Lotus_Txn_Fee_KES`
- `Deposit_Required_KES = Total_Fee_KES × 0.5 + 250` (50% deposit + flat KES 250 Lotus fee)
- `Balance_Due_KES = Total_Fee_KES − Deposit_Paid_KES`

Timing formulas (see the grace-period section below for what these mean in practice):
`Pre_Grace_Start = Expected_End_Date − 7`; `Post_Grace_Deadline = Actual_Completion_Date + 7`;
`Disbursement_Due_Date = Payment_Cleared_Date + 4`; `72hr_SLA_Deadline = Start_Date + 3` (72-hour
SLA for OW to begin work, per V3 Clause 4.1).

`Finder_Fee_Applicable` flags an engagement as investor-linked, which is what creates the
corresponding T7 Investor record.

## T3 · Milestones

One row per planned/actual delivery event per engagement. `Milestone_Type`: Deposit, Scope
Confirmed, Work Commenced, Draft Delivered, Client Review, Pre-Grace Window, Completion,
Post-Grace Deadline, Payment Cleared, Disbursed to OW, Deemed Approved, Quarterly Review,
Harmony Pulse. `Days_Variance` is negative if early, positive if late. `Grace_Period_Flag`
suppresses late-penalty treatment for anything that falls inside a grace window.
`Responsible_Party`: MC Studio, OW Advocates, Client, or Both.

## T4 · Payments (Lotus)

Every inbound (client → MC Studio) and outbound (MC Studio → OW) transaction through the
**Lotus** payment API. `Payment_Type`: Deposit (50%), Balance Payment, Full Payment, Finder's
Fee (5%), DD Fee, Add-On Fee, Refund, Lotus Txn Fee. `Payment_Direction`: Inbound (Client→MC
Studio), Outbound (MC Studio→OW), Internal Transfer. `Lotus_Method`: M-PESA C2B, M-PESA B2C,
Pesalink, Bank Transfer, Paybill, Till, Bulk Payment. `Payment_Status`: Request Sent → Pending
Clearance → Cleared → (Failed/Reversed/Refunded).

Disbursement timing: `Disbursement_Due = Cleared_Date + 4` (business days, inbound only, per
V3 Clause 5.1 as amended); `Days_to_Disburse = Disbursed_Date − Cleared_Date`, flagged if > 4.

## T5 · Agreements

Document/signature tracker per engagement. `Agreement_Type` covers Sector Engagement Agreement,
Partnership Agreement V3, Amendment Addendum, NDA, Shareholders Agreement, Employment Contract,
ESOP Agreement, Data Processing Agreement, IP Assignment, Lease Agreement, SAFE Note,
Convertible Note, Due Diligence Report, Other. `Document_Status`: Draft → Sent for Signature →
Partially Signed → Fully Executed → (Expired/Superseded/Disputed). `Fully_Executed =
AND(Client_Signed, OW_Signed)` and triggers work commencement. `Days_to_Expiry` drives a
30-day-out expiry alert.

## T6 · Legal_Health_Checks

One record per LHC submission from the website. Scored across six weighted categories that sum
to `Total_LHC_Score` (0–100): Corporate Structure (20%), Employment & HR (15%), Data Protection
(20%), Intellectual Property (15%), Contracts & Agreements (15%), Regulatory Compliance (15%).
This is the scoring rubric behind the plain checklist in `legal-health-check.md`.

- `Risk_Level = Low Risk (≥75) / Moderate Risk (≥50) / High Risk (<50)`
- `Recommended_Tier`: LEAD if `Annual_Revenue_KES ≥ 500,000,000`; GROW if `≥ 20,000,000`;
  otherwise HUSTLE — the same revenue bands used in `aikya-tiers-pricing.md`.

`LHC_Converted` (checkbox) is what fires the LHC → Client automation and creates the T1 record.
`Fundraising` (checkbox) flags a lead for the investor pipeline.

## T7 · Investors

Investor pipeline and fee tracker. `Investment_Status`: Prospecting → NDA Signed → Dossier
Shared → DD Underway → Term Sheet → Closed (or Withdrawn). Critical control:
**`Dossier_Shared` cannot be set to true without `Client_Consent_Date` populated** — a hard
consent gate before any non-privileged dossier goes to an investor (Workflow Doc §7 + Data
Protection Act 2019 §4.2).

- `Finders_Fee_KES = Total_Investment_KES × 0.05` — the 5% finder's fee described in
  `finders-fee-due-diligence.md`, here as a live formula rather than an illustrative figure.
- `DD_Fee_KES` is set per the pricing schedule and **goes directly to OW**, tracked separately
  via `DD_Fee_Status` (Pending → Invoiced by OW → Lotus Request Sent → Cleared/Disputed).

## T8 · Automations_Log

Append-only audit trail. Every automation below writes a row here (`Automation_Name`,
`Trigger_Event`, `Record_Affected`, `Table_Affected`, `Action_Taken`, `Agreement_Clause`,
`Status`, `Error_Message`). This is the audit trail to point to for payment disputes or
compliance review — if a fee, disbursement, or deemed-approval event is disputed, T8 is the
source of truth for *when* and *why* the system acted.

## Grace periods & disbursement SLA — the numbers that matter

These four numbers recur across T2–T4 and are the ones most likely to come up in a question:

1. **72-hour SLA** — OW must begin work within 72 hours of an engagement's `Start_Date`
   (V3 Clause 4.1).
2. **7-day pre-completion grace** — starts 7 days before `Expected_End_Date`; this is when a
   Lotus payment request is issued ahead of expected completion.
3. **7-day post-completion grace / deemed approval** — if the client hasn't responded within
   7 days of `Actual_Completion_Date`, the deliverable is **deemed approved** automatically
   (V3 Clause 5.1).
4. **4-business-day disbursement** — once a client payment is `Cleared` via Lotus, MC Studio
   must disburse OW's share within 4 business days (V3 Clause 5.1 as amended); breaching this
   triggers an overdue-disbursement escalation.

Deposits are **50% of `Total_Fee_KES` plus a flat KES 250 Lotus transaction fee**, due before
work starts.

## Automations (12)

All are Airtable "Run a Script" automations; each writes to T8 on completion. Grouped by what
they do rather than by number, since the number is just build order:

- **Conversion:** `01` LHC → Client Conversion (T6 `LHC_Converted`→true creates the T1 record);
  `10` LHC Score Update & Risk Badge (recalculates and syncs score on any change to a `Score_*`
  field).
- **Timeline / grace periods:** `02` Grace Period Notifier (daily; flags pre/post grace windows,
  issues Lotus payment requests); `03` OW Work Completion Trigger (sets
  `Actual_Completion_Date`, starts post-grace countdown); `05` Deemed Approval Auto-Set (daily;
  auto-approves after the 7-day post-grace window lapses with no client response).
- **Payments:** `04` Client Approval Handler (triggers the Lotus balance-payment request); `06`
  Disbursement Due Alert (fires when a payment clears); `07` Overdue Disbursement Escalation
  (daily; escalates anything past the 4-business-day disbursement SLA).
- **Investors:** `08` Investor Consent Gate (blocks dossier sharing without recorded client
  consent); `09` Finder's Fee Payment Trigger (creates the Lotus request for the 5% fee on deal
  close).
- **Compliance / cadence:** `11` Agreement Expiry Alert (30 days before expiry); `12` Harmony
  Pulse Quarterly Reminder (1 Jan/Apr/Jul/Oct, to all active retainer clients).

## Interfaces (7)

Built in Airtable's Interface Designer, one per user role:

| Interface | Primary user | What it's for |
|---|---|---|
| BD Onboarding Dashboard | MC Studio BD | LHC→client conversion rate, pipeline kanban by `Programme_Status` |
| Startup Portal | Portfolio client (read-only, own record) | LHC score, engagement timeline, document vault, next payment due |
| OW Advocates Work Queue | OW Advocates | Active engagements sorted by `72hr_SLA_Deadline`; mark work complete |
| Payment Command Centre | MC Studio Finance | Pending/overdue disbursements, MRR collected, mark disbursed |
| Investor Dossier Manager | MC Studio BD / OW | Kanban by `Investment_Status`; consent gate before dossier sharing |
| Compliance Health Monitor | MC Studio + OW | LHC score ring chart, risk badge, agreement expiry |
| Aikya Cadence Planner | All | Calendar of milestones, Harmony Pulse and Base Camp review due dates |

## Sample data

Six seed records (one per Sita Sector, `SAMPLE_DATA` sheet) — useful as realistic worked
examples if asked to illustrate the model end to end: PayGo Kenya (Fintech, HUSTLE), MediLink
East Africa (HealthTech, GROW), HarvestAI (AgriTech, HUSTLE, LHC Completed only), LearnSpark
Technologies (EdTech, GROW — handles minor data, DPIA/KNEC flagged as critical), Duka Digital
Marketplace (Retail & Commerce, HUSTLE), BioFuel Systems EA (Energy & Manufacturing, LEAD —
EPRA generation licence, NEMA EIA, Partner-level OW review).

A parallel `TIMELINE_TRACKER` sheet exists as a standalone Excel fallback for the grace-period
math above, for use until the Airtable base is actually live.
