# Cash Forecast & Compensation Model

## Overview

MC Studio's revenue model combines **retainer income** from Aikya Legal tiers, **finder's fees** from investor introductions, **IBM QA testing revenue**, and **project-based consulting**. This file covers the formulas for revenue, payroll, commissions, and profit share.

## Revenue Streams

### 1. Aikya Legal Retainers

| Tier | Monthly Retainer (KES) | MC Studio Share (est.) |
|---|---|---|
| HUSTLE | 15,000 | ~60% after OW legal fee & Lotus fees |
| GROW | 45,000 | ~60% after OW legal fee & Lotus fees |
| LEAD | 120,000 | ~60% after OW legal fee & Lotus fees |

MC Studio's effective share is the retainer **less**:
- OW Advocates' legal-service component (varies by tier, ~30–35% of retainer)
- Lotus transaction fees (KES 250 per transaction)
- Platform / payment processing costs (~2–3%)

### 2. Finder's Fees

```
Finders_Fee_KES = Total_Investment_KES × 0.05
```

See `finders-fee-due-diligence.md` for full conditions.

### 3. IBM QA Testing Revenue

MC Studio (Silver IBM Business Partner) earns revenue from IBM QA testing and product validation contracts. This revenue is tracked separately from Aikya Legal income.

- Rate: Per IBM SOW (statement of work) — typically project-based
- Invoicing: Monthly or milestone-based per IBM terms
- Margins: Typically 20–35% after delivery costs

### 4. Add-On Services & Project Consulting

One-off services such as:
- Due Diligence Reports (KES 150K–500K)
- M&A Advisory (1–3% of deal value)
- Data Protection Audits (KES 100K)
- SAFE / Convertible Notes (KES 75K)

## Payroll

### Team Roles

| Role | Basis | Est. Monthly (KES) |
|---|---|---|
| Trail Guide (BD / Portfolio Manager) | Salary + Commission | 80,000–150,000 base |
| Legal Ops Coordinator | Salary | 60,000–90,000 |
| QA Testing Lead (IBM projects) | Salary / Contract | 100,000–200,000 |
| Administrative Support | Salary | 40,000–60,000 |
| OW Advocates (legal) | Per-engagement fee | Variable (per Partnership Agreement) |

### Payroll Formula

```
Monthly_Payroll_KES = Σ(All_Staff_Salaries) + Employer_NSSF + Employer_NHIF + PAYE
```

## Commissions

### BD Trail Guide Commission

The Trail Guide earns commission on:
- **New client sign-ups:** 10% of first month's retainer fee
- **Finder's fees:** 15% of MC Studio's finder's fee (i.e., 15% × 5% = 0.75% of total investment)
- **IBM QA contracts sourced:** 5% of contract value

```
Commission_KES = (New_Client_Retainer × 0.10) + (Finders_Fee_KES × 0.15) + (IBM_Contract_Value × 0.05)
```

## Profit Share

Profit share is calculated quarterly (or annually per Partnership Agreement) and distributed to eligible team members.

### Formula

```
Gross_Revenue_KES = Sum of all revenue streams (retainers + finder's fees + IBM + add-ons)
Operating_Costs_KES = Payroll + Lotus fees + Office/Admin + Marketing + Other OpEx
Net_Profit_KES = Gross_Revenue_KES − Operating_Costs_KES

Profit_Share_Pool = Net_Profit_KES × 0.30  (30% of net profit)
```

### Distribution

The 30% profit share pool is distributed among eligible team members based on:
- **Seniority weight** (tenure at MC Studio)
- **Role weight** (revenue-generating roles weighted higher)
- **Performance factor** (0.8–1.2, based on Harmony Pulse Score and KPIs)

```
Individual_Share = Profit_Share_Pool × (Individual_Weight / Σ(All_Eligible_Weights))
```

### Eligibility

- Minimum 6 months continuous service
- Active employment at distribution date
- No active performance improvement plan

## Cash Forecast Model

The cash forecast tracks:
- **Projected monthly revenue** (retainers + IBM + other)
- **Actual revenue collected** (via Lotus)
- **Disbursements to OW** (within 4 business days of payment clearance)
- **Operating expenses** (payroll, admin, marketing)
- **Net cash position** (rolling 6-month projection)

| Metric | Formula |
|---|---|
| Gross MRR | Sum of all active retainer fees |
| Net MRR after OW | Gross MRR × ~0.60 (MC Studio share estimate) |
| Monthly OpEx | Payroll + admin + marketing + misc |
| Cash Burn / Build | Net MRR after OW + other revenue − Monthly OpEx |
| Runway (months) | Current Cash ÷ Monthly Cash Burn (if negative) |

All figures are illustrative and updated per the current Aikya Pricing Brochure and Partnership Agreement V3.
