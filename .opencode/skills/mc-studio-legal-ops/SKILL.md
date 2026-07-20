---
name: mc-studio-legal-ops
description: Framework for MC Studio's venture-studio engagements with startups, run jointly with Aikya Legal (Okutta & Wairi Advocates, "OW"). Use this skill whenever the user mentions MC Studio, Aikya Legal/HUSTLE/GROW/LEAD tiers, the Legal Health Check, OW Advocates, the Sita Sector Program, finder's fees or due diligence fees on startup investment, IBM QA testing revenue, the cash forecast/compensation model, or any of the six Sita Sector priority sectors (fintech, healthtech, edtech, agritech, retail & ecommerce, energy & manufacturing). Also trigger for questions about which pricing tier or compliance checklist applies to a startup, how finder's/DD fees are calculated, or how team compensation and profit share are computed. Always check the references/ files here before answering — they hold the live, source-of-truth figures (pricing, formulas, checklist items) rather than relying on memory.
---

# MC Studio × Aikya Legal Ops

## What this is

MC Studio is a Nairobi-based venture studio (Silver IBM Business Partner) offering startup
support, compliance, and product QA testing. **Okutta & Wairi Advocates ("OW")**, trading
as **Aikya Legal**, is the affiliated law firm that handles the legal side of the portfolio
within Kenya and represents the group cross-border within EMEA. The **Sita Sector Program** is
MC Studio's initiative targeting startups in six priority sectors: **fintech, healthtech,
edtech, agritech, retail & ecommerce, and energy & manufacturing.**

Every engagement starts the same way regardless of sector: a **Legal Health Check (KSh 25,000)**,
which routes the startup into one of three Aikya tiers (**HUSTLE → GROW → LEAD**), and — where
MC Studio is tracking the startup for prospective investors — into the **finder's fee / due
diligence fee** pipeline, with OW acting as dossier holder.

## Core references (read before answering)

| File | Use it for |
|---|---|
| `references/aikya-tiers-pricing.md` | Tier eligibility, what's included, pricing, add-ons |
| `references/legal-health-check.md` | The diagnostic checklist that determines tier & risk flags |
| `references/six-sector-compliance.md` | Sector-specific regulators/compliance angles for the 6 Sita Sector industries |
| `references/finders-fee-due-diligence.md` | How the 5% finder's fee and OW due-diligence fee are calculated |
| `references/cash-forecast-compensation.md` | Revenue model, payroll, commissions, profit share formulas |
| `references/compass-schema.md` | The AIKYA Compass (Airtable) data model: engagement/payment status flows, Lotus payment fields, grace-period and disbursement SLA formulas, LHC scoring rubric, investor consent gate, and the 12 automations that run on top of it |

Treat the figures in these files as the current live numbers. If the user says a number has
changed (e.g., a new tier price, a new sector added), update the relevant reference file rather
than only answering inline — these files are meant to stay "live."

## Workflow: routing a new startup

1. **Run/record the Legal Health Check** (`references/legal-health-check.md`). Each unanswered
   or "Non-Compliant" item is a risk flag — don't just tally a score, name the specific gaps
   (e.g., "no shareholders agreement," "not registered as a Data Controller").
2. **Identify the sector** (one of the six Sita Sector industries) and pull the relevant compliance
   angle from `references/six-sector-compliance.md` — this changes what matters most in the
   checklist (e.g., a fintech startup's DPA/CBK exposure outweighs a retail startup's).
3. **Match to a tier** using headcount, funding stage, and revenue bands in
   `references/aikya-tiers-pricing.md` — not just company age.
4. **If MC Studio is also tracking the startup for investors**, apply the finder's fee / DD fee
   logic in `references/finders-fee-due-diligence.md`.
5. **If asked about revenue, payroll, commissions, or profit share** for MC Studio itself
   (not the client startup), use `references/cash-forecast-compensation.md` and show the
   formula, not just the output number.
6. **If asked about the portfolio tracker itself** — engagement/payment status, grace periods,
   the 72-hour SLA, the 4-business-day disbursement deadline, deemed approval, Lotus payment
   fields, the LHC scoring rubric, or the investor consent gate — use
   `references/compass-schema.md`. This is the operational data model behind the Aikya Compass,
   distinct from the pricing/compliance substance in the other reference files.

## Language & framing note

Aikya Legal's external-facing materials use a mountaineering/journey metaphor (Trailhead,
Base Camp, Summit, Sherpa, etc. — see the tier names HUSTLE/GROW/LEAD). Keep that voice for
anything client-facing (proposals, brochures, onboarding copy). Internal ops docs (health
checks, cash forecasts, compliance matrices) can stay plain and operational — don't force the
metaphor into a spreadsheet or checklist.

## Keeping this skill "live"

This skill was built from a snapshot of MC Studio's playbook, pricing brochure, health-check
form, cash forecast model, and Compass schema (`references/compass-schema.md`) — including its
Lotus payment fields, grace-period/SLA formulas, and automations. If the underlying Airtable
base changes (a new automation, a renamed status, a changed grace-period length), update that
file rather than only answering inline. Sector-specific regulatory detail
(`six-sector-compliance.md`) is a starting framework, not exhaustive law — regulations in
Kenya/EAC change, so treat it as a checklist of *areas to verify*, and search for current
regulatory status (KRA, CBK, CAK, DPC, EPRA, etc.) rather than assuming the reference file is
still accurate on specifics like thresholds or filing fees.
