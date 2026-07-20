# Legal Health Check (LHC) — Diagnostic Checklist

## Overview

The Legal Health Check is the **entry point** for every MC Studio × Aikya Legal engagement. Cost: **KSh 25,000**. It assesses a startup across six weighted categories that sum to a `Total_LHC_Score` (0–100) and determines the recommended tier and risk level.

## Scoring Rubric

| Category | Weight | Max Score |
|---|---|---|
| 1. Corporate Structure | 20% | 20 |
| 2. Employment & HR | 15% | 15 |
| 3. Data Protection & Privacy | 20% | 20 |
| 4. Intellectual Property | 15% | 15 |
| 5. Contracts & Agreements | 15% | 15 |
| 6. Regulatory Compliance | 15% | 15 |
| **Total** | **100%** | **100** |

## Risk Levels

| Score Range | Risk Level | Action |
|---|---|---|
| ≥ 75 | **Low Risk** | Startup is well-structured; minor gaps only. Typically routes to GROW or LEAD. |
| 50–74 | **Moderate Risk** | Several gaps requiring remediation before scale. Typically routes to HUSTLE or GROW. |
| < 50 | **High Risk** | Critical gaps (missing incorporation, no data protection, no contracts). Remediation plan required before retainer. |

## Recommended Tier (by Revenue)

| Annual Revenue (KES) | Recommended Tier |
|---|---|
| ≥ 500,000,000 | LEAD |
| ≥ 20,000,000 | GROW |
| < 20,000,000 | HUSTLE |

## Detailed Checklist

### Section 1: Corporate Structure (20 pts)

| # | Item | Compliant? | Notes |
|---|---|---|---|
| 1.1 | Company registered under the Companies Act (CAP 486) | ☐ Yes ☐ No | Verify with Registrar of Companies |
| 1.2 | Valid Certificate of Incorporation | ☐ Yes ☐ No | Must match current company name |
| 1.3 | Shareholders Agreement in place | ☐ Yes ☐ No | Especially important for multi-founder |
| 1.4 | Cap table documented and current | ☐ Yes ☐ No | Include all issued shares, options, warrants |
| 1.5 | Directors registered and up to date | ☐ Yes ☐ No | Verify with eCitizen / CR12 |
| 1.6 | Business Permit / Single Business Permit current | ☐ Yes ☐ No | County-specific |
| 1.7 | KRA PIN Certificate (Company) | ☐ Yes ☐ No | |
| 1.8 | Registered address / physical office verified | ☐ Yes ☐ No | |

### Section 2: Employment & HR (15 pts)

| # | Item | Compliant? | Notes |
|---|---|---|---|
| 2.1 | Written employment contracts for all staff | ☐ Yes ☐ No | Per Employment Act 2007 |
| 2.2 | NSSF registration & contributions current | ☐ Yes ☐ No | |
| 2.3 | NHIF registration & contributions current | ☐ Yes ☐ No | |
| 2.4 | PAYE registration & monthly filings | ☐ Yes ☐ No | |
| 2.5 | HR policy manual / employee handbook | ☐ Yes ☐ No | |
| 2.6 | Independent contractor agreements (if applicable) | ☐ Yes ☐ No | Ensure not misclassified as employees |
| 2.7 | Intern/volunteer agreements (if applicable) | ☐ Yes ☐ No | |

### Section 3: Data Protection & Privacy (20 pts)

| # | Item | Compliant? | Notes |
|---|---|---|---|
| 3.1 | Registered as a Data Controller with ODPC | ☐ Yes ☐ No | Mandatory under Data Protection Act 2019 |
| 3.2 | Privacy Policy published (website/app) | ☐ Yes ☐ No | Must be accessible to users |
| 3.3 | Data Protection Impact Assessment (DPIA) completed | ☐ Yes ☐ No | Required if processing sensitive data |
| 3.4 | Consent management mechanism in place | ☐ Yes ☐ No | Opt-in, not pre-ticked |
| 3.5 | Data retention and deletion policy documented | ☐ Yes ☐ No | |
| 3.6 | Data breach response plan documented | ☐ Yes ☐ No | 72-hour reporting requirement |
| 3.7 | Cross-border data transfer mechanism (if applicable) | ☐ Yes ☐ No | Adequacy decision or SCCs |
| 3.8 | Data Processing Agreements with third-party processors | ☐ Yes ☐ No | |

### Section 4: Intellectual Property (15 pts)

| # | Item | Compliant? | Notes |
|---|---|---|---|
| 4.1 | IP Assignment Agreement with founders | ☐ Yes ☐ No | Ensures company owns founder-created IP |
| 4.2 | IP Assignment Agreement with employees/contractors | ☐ Yes ☐ No | |
| 4.3 | Trademark registration(s) for brand name/logo | ☐ Yes ☐ No | KIPI registration |
| 4.4 | Patent / utility model filings (if applicable) | ☐ Yes ☐ No | |
| 4.5 | Domain name ownership in company name | ☐ Yes ☐ No | Not in founder's personal name |
| 4.6 | Trade secrets / confidentiality measures in place | ☐ Yes ☐ No | |

### Section 5: Contracts & Agreements (15 pts)

| # | Item | Compliant? | Notes |
|---|---|---|---|
| 5.1 | Standard Terms of Service / Terms of Use | ☐ Yes ☐ No | For digital products |
| 5.2 | Client/customer contracts in place | ☐ Yes ☐ No | Written, signed |
| 5.3 | Supplier/vendor agreements in place | ☐ Yes ☐ No | |
| 5.4 | SLA / Service Level commitments documented | ☐ Yes ☐ No | |
| 5.5 | Non-Disclosure Agreement(s) in use | ☐ Yes ☐ No | Standard form |
| 5.6 | Partnership / joint venture agreements (if applicable) | ☐ Yes ☐ No | |

### Section 6: Regulatory Compliance (15 pts)

| # | Item | Compliant? | Notes |
|---|---|---|---|
| 6.1 | Sector-specific licenses obtained (per sector) | ☐ Yes ☐ No | See `six-sector-compliance.md` |
| 6.2 | Tax compliance — all filings up to date | ☐ Yes ☐ No | Installment tax, VAT, withholding |
| 6.3 | KRA tax compliance certificate (if tendering) | ☐ Yes ☐ No | |
| 6.4 | Sector-specific regulatory filings (CBK, EPRA, etc.) | ☐ Yes ☐ No | Per sector matrix |
| 6.5 | Environmental compliance (NEMA) if applicable | ☐ Yes ☐ No | |

## LHC Form URL

The LHC is submitted via: `https://mcstudio.co.ke/legalhealthcheck/assess`

## Conversion

When `LHC_Converted` is set to `true` in the Aikya Compass, the system auto-creates a Portfolio_Client record and fires the onboarding automation.
