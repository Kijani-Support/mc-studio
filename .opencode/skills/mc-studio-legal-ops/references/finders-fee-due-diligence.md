# Finder's Fees & Due Diligence Fees

## Overview

Where MC Studio is tracking a startup for prospective investors, the engagement enters a **finder's fee / due diligence fee** pipeline. OW Advocates acts as **dossier holder** — the startup's legal and compliance documentation is prepared, verified, and shared with investors under a controlled consent gate.

## Finder's Fee (MC Studio)

MC Studio earns a **5% finder's fee** on any investment closed with a startup that was introduced through the MC Studio × Aikya Legal pipeline.

```
Finders_Fee_KES = Total_Investment_KES × 0.05
```

### Conditions

- The finder's fee applies only where MC Studio has an active engagement (HUSTLE/GROW/LEAD retainer or LHC completed) and the startup has signed the **Investor Consent** authorising MC Studio to share their dossier.
- The fee is **one-time, per investment round** (not per investor).
- It is **payable on close** (i.e., when the term sheet is executed and funds are disbursed to the startup).
- MC Studio's **Investor Dossier Manager** interface in the Aikya Compass tracks the pipeline: Prospecting → NDA Signed → Dossier Shared → DD Underway → Term Sheet → Closed.

### Consent Gate

**No dossier may be shared with an investor without recorded client consent.**

In the Aikya Compass (T7 · Investors), the field `Dossier_Shared` **cannot** be set to `true` unless `Client_Consent_Date` is populated. This enforces:
- Workflow Doc §7
- Data Protection Act 2019 §4.2

## Due Diligence Fee (OW Advocates)

OW Advocates charges a **due diligence fee** on the investor-side legal work — reviewing the startup's legal documentation and preparing a due diligence report for the prospective investor.

- **DD Fee** is set per the Aikya Pricing Schedule (typically KES 150,000–500,000 per engagement depending on scope).
- The DD fee **goes directly to OW**, not MC Studio.
- Tracked separately via `DD_Fee_Status`: Pending → Invoiced by OW → Lotus Request Sent → Cleared / Disputed

## Fee Flow Summary

| Party | Fee Type | Rate / Amount | Paid By | Trigger |
|---|---|---|---|---|
| MC Studio | Finder's Fee | 5% of total investment | Investor / Startup (per agreement) | Deal close |
| OW Advocates | DD Fee | Per pricing schedule (KES 150K–500K) | Investor | DD engagement |

## Tracking in Aikya Compass

**T7 · Investors** table fields relevant to fee tracking:

| Field | Description |
|---|---|
| `Total_Investment_KES` | Total investment amount in the round |
| `Finders_Fee_KES` | Formula: `Total_Investment_KES × 0.05` |
| `Finders_Fee_Status` | Pending → Invoiced → Lotus Request Sent → Cleared |
| `DD_Fee_KES` | Set per pricing schedule |
| `DD_Fee_Status` | Pending → Invoiced by OW → Lotus Request Sent → Cleared / Disputed |
| `Client_Consent_Date` | Required before `Dossier_Shared` can be set |
| `Investment_Status` | Prospecting → NDA Signed → Dossier Shared → DD Underway → Term Sheet → Closed / Withdrawn |

Automation **#09 Finder's Fee Payment Trigger** creates the Lotus payment request for the 5% fee on deal close.

Automation **#08 Investor Consent Gate** blocks dossier sharing without recorded client consent.
