# MC Studio Data Schema - Laravel Implementation Guide

**Version:** 1.0  
**Framework:** Laravel 10.x / 11.x  
**Database:** PostgreSQL 15+  
**Date:** February 4, 2026

---

## TABLE OF CONTENTS

1. [Project Structure](#project-structure)
2. [Database Migrations](#database-migrations)
3. [Eloquent Models](#eloquent-models)
4. [Model Relationships](#model-relationships)
5. [Enums & Value Objects](#enums--value-objects)
6. [Service Classes](#service-classes)
7. [API Resources](#api-resources)
8. [File Storage](#file-storage)
9. [Vector Database Integration](#vector-database-integration)
10. [Code Examples](#code-examples)

---

## 1. PROJECT STRUCTURE

```
app/
├── Enums/
│   ├── BusinessStage.php
│   ├── Sector.php
│   ├── LegalTier.php
│   ├── RiskLevel.php
│   └── DocumentType.php
│
├── Models/
│   ├── Startup.php
│   ├── LegalHealthCheck.php
│   ├── ServiceEngagement.php
│   ├── QAProject.php
│   ├── InvestmentDeal.php
│   ├── Document.php
│   ├── Contact.php
│   ├── TeamMember.php
│   ├── Partner.php
│   └── Communication.php
│
├── Services/
│   ├── FileNamingService.php
│   ├── VectorSearchService.php
│   ├── LegalHealthCheckService.php
│   ├── DocumentGenerationService.php
│   └── RevenueCalculationService.php
│
├── Http/
│   ├── Controllers/
│   │   ├── StartupController.php
│   │   ├── LegalHealthCheckController.php
│   │   └── DocumentController.php
│   ├── Resources/
│   │   ├── StartupResource.php
│   │   ├── LegalHealthCheckResource.php
│   │   └── DocumentResource.php
│   └── Requests/
│       ├── StoreStartupRequest.php
│       └── StoreLegalHealthCheckRequest.php
│
├── Observers/
│   ├── StartupObserver.php
│   └── DocumentObserver.php
│
└── Traits/
    ├── HasFileNaming.php
    └── HasVectorEmbeddings.php

database/
├── migrations/
│   ├── 2026_01_01_000001_create_startups_table.php
│   ├── 2026_01_01_000002_create_legal_health_checks_table.php
│   ├── 2026_01_01_000003_create_service_engagements_table.php
│   ├── 2026_01_01_000004_create_qa_projects_table.php
│   ├── 2026_01_01_000005_create_investment_deals_table.php
│   ├── 2026_01_01_000006_create_documents_table.php
│   ├── 2026_01_01_000007_create_contacts_table.php
│   ├── 2026_01_01_000008_create_team_members_table.php
│   ├── 2026_01_01_000009_create_partners_table.php
│   └── 2026_01_01_000010_create_communications_table.php
│
├── factories/
│   ├── StartupFactory.php
│   └── LegalHealthCheckFactory.php
│
└── seeders/
    └── SectorComplianceSeeder.php
```

---

## 2. DATABASE MIGRATIONS

### 2.1 Startups Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('startups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();
            $table->string('company_name');
            $table->string('legal_entity_name')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('business_structure')->nullable(); // Ltd, LLP, Sole Proprietor
            
            // Contact Info (JSONB)
            $table->jsonb('contact_info')->nullable();
            
            // Classification
            $table->string('sector'); // Enum in application layer
            $table->jsonb('industry_tags')->nullable();
            $table->string('stage'); // Enum in application layer
            $table->integer('employee_count')->nullable();
            $table->date('founding_date')->nullable();
            $table->date('incorporation_date')->nullable();
            
            // Financial Data (JSONB for flexibility)
            $table->jsonb('financial_data')->nullable();
            
            // Legal Tier
            $table->jsonb('legal_tier')->nullable();
            
            // Legal Health
            $table->uuid('current_health_check_id')->nullable();
            $table->integer('overall_health_score')->nullable();
            $table->timestamp('last_assessment_date')->nullable();
            $table->string('risk_level')->nullable();
            $table->jsonb('category_scores')->nullable();
            
            // Compliance Status
            $table->jsonb('compliance_status')->nullable();
            
            // Intellectual Property
            $table->jsonb('intellectual_property')->nullable();
            
            // Team Info
            $table->jsonb('team_info')->nullable();
            
            // Hub Partner Program
            $table->string('hub_partner')->nullable(); // IBM Research Centre, Power Learn Project, Baraza Media Lab
            $table->string('hub_cohort')->nullable();
            $table->date('hub_enrollment_date')->nullable();
            $table->string('hub_status')->nullable();
            
            // IBM Partnership
            $table->integer('ibm_qa_projects_completed')->default(0);
            $table->integer('ibm_qa_projects_active')->default(0);
            $table->decimal('ibm_total_revenue_kes', 15, 2)->default(0);
            $table->string('ibm_status')->nullable();
            
            // Investor Readiness
            $table->jsonb('investor_readiness')->nullable();
            
            // Documents Checklist
            $table->jsonb('documents_checklist')->nullable();
            
            // Engagement History
            $table->date('first_contact_date')->nullable();
            $table->string('acquisition_source')->nullable();
            $table->integer('legal_health_checks_completed')->default(0);
            $table->integer('consultations_completed')->default(0);
            $table->decimal('lifetime_value_kes', 15, 2)->default(0);
            $table->timestamp('last_interaction_date')->nullable();
            
            // Team Assignment
            $table->uuid('assigned_bd_rep_id')->nullable();
            $table->uuid('assigned_trail_guide_id')->nullable();
            
            // Status & Tags
            $table->string('status')->default('active'); // active, inactive, archived
            $table->jsonb('tags')->nullable();
            $table->text('notes')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('slug');
            $table->index('sector');
            $table->index('stage');
            $table->index('status');
            $table->index(['sector', 'stage']);
            $table->index('assigned_bd_rep_id');
            $table->index('hub_partner');
            
            // Full-text search index for PostgreSQL
            // Run after migration: 
            // DB::statement("CREATE INDEX startups_search_idx ON startups USING gin(to_tsvector('english', company_name || ' ' || COALESCE((contact_info->>'email')::text, '')))");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('startups');
    }
};
```

### 2.2 Legal Health Checks Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('legal_health_checks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('startup_id');
            $table->timestamp('assessment_date')->useCurrent();
            $table->boolean('completed')->default(false);
            $table->integer('completion_percentage')->default(0);
            
            // Respondent Info
            $table->jsonb('respondent_info')->nullable();
            
            // Section Scores (each as JSONB for flexibility)
            $table->jsonb('section_1_business_structure')->nullable();
            $table->jsonb('section_2_employment')->nullable();
            $table->jsonb('section_3_commercial')->nullable();
            $table->jsonb('section_4_data_protection')->nullable();
            $table->jsonb('section_5_intellectual_property')->nullable();
            $table->jsonb('section_6_regulatory')->nullable();
            $table->jsonb('section_7_additional_info')->nullable();
            
            // Scoring
            $table->integer('overall_score')->nullable();
            $table->decimal('weighted_score', 5, 2)->nullable();
            $table->jsonb('category_weights')->nullable();
            
            // Recommendations
            $table->string('recommended_tier')->nullable(); // HUSTLE, GROW, LEAD
            $table->jsonb('priority_actions')->nullable();
            $table->decimal('estimated_setup_cost_kes', 10, 2)->nullable();
            $table->jsonb('critical_gaps')->nullable();
            $table->jsonb('quick_wins')->nullable();
            
            // Follow-up
            $table->boolean('consultation_scheduled')->default(false);
            $table->timestamp('consultation_date')->nullable();
            $table->uuid('assigned_trail_guide_id')->nullable();
            $table->boolean('quote_sent')->default(false);
            $table->boolean('converted_to_client')->default(false);
            $table->timestamp('conversion_date')->nullable();
            
            // Metadata
            $table->string('source')->nullable(); // Website, In-Person, Email, Event
            $table->string('version')->default('1.0');
            $table->integer('time_to_complete_minutes')->nullable();
            
            $table->timestamps();
            $table->timestamp('completed_at')->nullable();
            
            // Foreign Keys
            $table->foreign('startup_id')->references('id')->on('startups')->onDelete('cascade');
            $table->foreign('assigned_trail_guide_id')->references('id')->on('team_members')->nullOnDelete();
            
            // Indexes
            $table->index('startup_id');
            $table->index('completed');
            $table->index('recommended_tier');
            $table->index('assessment_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('legal_health_checks');
    }
};
```

### 2.3 Service Engagements Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_engagements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('startup_id');
            $table->string('service_type'); // Legal Retainer, QA Testing, etc.
            
            // Retainer Details
            $table->string('tier')->nullable(); // HUSTLE, GROW, LEAD
            $table->decimal('monthly_fee_kes', 10, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('contract_months')->nullable();
            $table->boolean('auto_renewal')->default(false);
            $table->string('contract_status')->default('active'); // active, paused, cancelled, expired
            
            // Scope of Work
            $table->jsonb('scope_of_work')->nullable();
            
            // Team Assignment
            $table->uuid('lead_partner_id')->nullable();
            $table->uuid('trail_guide_id')->nullable();
            $table->jsonb('assigned_associates')->nullable(); // Array of user IDs
            $table->uuid('bd_rep_id')->nullable();
            
            // Billing
            $table->string('billing_cycle')->default('monthly'); // monthly, quarterly, annual, one-time
            $table->string('payment_method')->nullable();
            $table->date('last_invoice_date')->nullable();
            $table->date('next_invoice_date')->nullable();
            $table->string('payment_status')->default('current'); // current, overdue, defaulted
            $table->integer('days_overdue')->default(0);
            $table->decimal('total_invoiced_kes', 15, 2)->default(0);
            $table->decimal('total_paid_kes', 15, 2)->default(0);
            $table->decimal('outstanding_balance_kes', 15, 2)->default(0);
            
            // Deliverables & Satisfaction
            $table->jsonb('deliverables')->nullable();
            $table->jsonb('client_satisfaction')->nullable();
            $table->integer('nps_score')->nullable();
            
            // Add-on Services
            $table->jsonb('add_on_services')->nullable();
            $table->decimal('total_add_on_revenue_kes', 15, 2)->default(0);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign Keys
            $table->foreign('startup_id')->references('id')->on('startups')->onDelete('cascade');
            $table->foreign('lead_partner_id')->references('id')->on('team_members')->nullOnDelete();
            $table->foreign('trail_guide_id')->references('id')->on('team_members')->nullOnDelete();
            $table->foreign('bd_rep_id')->references('id')->on('team_members')->nullOnDelete();
            
            // Indexes
            $table->index('startup_id');
            $table->index('service_type');
            $table->index('tier');
            $table->index('contract_status');
            $table->index('payment_status');
            $table->index(['start_date', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_engagements');
    }
};
```

### 2.4 Documents Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('startup_id');
            $table->uuid('engagement_id')->nullable();
            
            // Document Info
            $table->string('document_name');
            $table->string('document_type'); // Contract, Agreement, Policy, etc.
            $table->string('document_category')->nullable();
            $table->string('version')->default('1.0');
            $table->string('language')->default('English');
            
            // File Details
            $table->string('filename');
            $table->string('file_path');
            $table->bigInteger('file_size_bytes')->nullable();
            $table->string('file_format'); // PDF, DOCX, etc.
            $table->string('checksum_sha256')->nullable();
            
            // Classification
            $table->string('confidentiality')->default('internal'); // public, internal, confidential, highly_confidential
            $table->integer('retention_years')->default(7);
            $table->boolean('legal_privilege')->default(false);
            $table->boolean('client_facing')->default(false);
            
            // Parties
            $table->uuid('prepared_by_id')->nullable();
            $table->uuid('reviewed_by_id')->nullable();
            $table->uuid('approved_by_id')->nullable();
            $table->boolean('signed_by_startup')->default(false);
            $table->boolean('signed_by_mc_studio')->default(false);
            $table->boolean('signed_by_ow')->default(false);
            $table->jsonb('other_signatories')->nullable();
            
            // Dates
            $table->date('creation_date')->nullable();
            $table->date('execution_date')->nullable();
            $table->date('effective_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->date('last_review_date')->nullable();
            $table->date('next_review_date')->nullable();
            
            // Status
            $table->string('status')->default('draft'); // draft, under_review, approved, executed, expired, superseded, archived
            $table->string('execution_status')->default('not_applicable'); // pending_signature, partially_signed, fully_executed
            $table->string('validity')->default('valid'); // valid, expired, terminated, void
            
            // Relationships
            $table->jsonb('related_document_ids')->nullable();
            $table->uuid('supersedes_id')->nullable();
            $table->uuid('superseded_by_id')->nullable();
            
            // Compliance
            $table->boolean('requires_registration')->default(false);
            $table->string('registered_with')->nullable();
            $table->string('registration_number')->nullable();
            $table->date('registration_date')->nullable();
            $table->boolean('stamp_duty_paid')->default(false);
            $table->decimal('stamp_duty_amount_kes', 10, 2)->nullable();
            
            // Metadata
            $table->uuid('uploaded_by_id')->nullable();
            $table->jsonb('tags')->nullable();
            $table->text('notes')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign Keys
            $table->foreign('startup_id')->references('id')->on('startups')->onDelete('cascade');
            $table->foreign('engagement_id')->references('id')->on('service_engagements')->nullOnDelete();
            $table->foreign('prepared_by_id')->references('id')->on('team_members')->nullOnDelete();
            $table->foreign('reviewed_by_id')->references('id')->on('team_members')->nullOnDelete();
            $table->foreign('approved_by_id')->references('id')->on('team_members')->nullOnDelete();
            $table->foreign('uploaded_by_id')->references('id')->on('team_members')->nullOnDelete();
            
            // Indexes
            $table->index('startup_id');
            $table->index('document_type');
            $table->index('status');
            $table->index('confidentiality');
            $table->index('file_path');
            $table->index('expiration_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
```

### 2.5 Additional Tables (Simplified)

```php
// QA Projects Table
Schema::create('qa_projects', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->uuid('startup_id');
    $table->string('project_name');
    $table->string('project_code')->unique();
    $table->string('status')->default('scoping');
    $table->date('start_date')->nullable();
    $table->date('end_date')->nullable();
    $table->jsonb('team_assignment')->nullable();
    $table->jsonb('financials')->nullable();
    $table->jsonb('deliverables')->nullable();
    $table->jsonb('quality_metrics')->nullable();
    $table->timestamps();
    $table->timestamp('completed_at')->nullable();
});

// Investment Deals Table
Schema::create('investment_deals', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->uuid('startup_id');
    $table->string('deal_name');
    $table->string('deal_type');
    $table->decimal('target_amount_kes', 15, 2)->nullable();
    $table->decimal('actual_amount_kes', 15, 2)->nullable();
    $table->string('status');
    $table->jsonb('mc_studio_role')->nullable(); // finder fees, DD fees
    $table->jsonb('investors')->nullable();
    $table->timestamps();
});

// Contacts Table
Schema::create('contacts', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('first_name');
    $table->string('last_name');
    $table->string('email')->unique();
    $table->string('phone')->nullable();
    $table->string('person_type'); // Founder, Employee, Investor, etc.
    $table->uuid('startup_id')->nullable();
    $table->jsonb('startup_relationship')->nullable();
    $table->timestamps();
});

// Team Members Table
Schema::create('team_members', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('employee_id')->unique();
    $table->string('first_name');
    $table->string('last_name');
    $table->string('email')->unique();
    $table->string('department');
    $table->string('role');
    $table->jsonb('compensation')->nullable();
    $table->jsonb('specialization')->nullable();
    $table->jsonb('performance')->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});

// Partners Table
Schema::create('partners', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('name');
    $table->string('partner_type');
    $table->jsonb('organization_info')->nullable();
    $table->jsonb('partnership_details')->nullable();
    $table->string('status')->default('active');
    $table->timestamps();
});

// Communications Table
Schema::create('communications', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->uuid('startup_id');
    $table->uuid('contact_id')->nullable();
    $table->string('type'); // Email, Call, Meeting, etc.
    $table->string('direction'); // Inbound, Outbound
    $table->string('subject')->nullable();
    $table->text('summary')->nullable();
    $table->timestamp('scheduled_date')->nullable();
    $table->timestamp('actual_date')->nullable();
    $table->jsonb('participants')->nullable();
    $table->jsonb('follow_up')->nullable();
    $table->timestamps();
});
```

---

## 3. ELOQUENT MODELS

### 3.1 Startup Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\Sector;
use App\Enums\BusinessStage;
use App\Enums\LegalTier;
use App\Traits\HasFileNaming;

class Startup extends Model
{
    use HasFactory, HasUuids, SoftDeletes, HasFileNaming;

    protected $fillable = [
        'slug',
        'company_name',
        'legal_entity_name',
        'registration_number',
        'business_structure',
        'contact_info',
        'sector',
        'industry_tags',
        'stage',
        'employee_count',
        'founding_date',
        'incorporation_date',
        'financial_data',
        'legal_tier',
        'current_health_check_id',
        'overall_health_score',
        'last_assessment_date',
        'risk_level',
        'category_scores',
        'compliance_status',
        'intellectual_property',
        'team_info',
        'hub_partner',
        'hub_cohort',
        'hub_enrollment_date',
        'hub_status',
        'ibm_qa_projects_completed',
        'ibm_qa_projects_active',
        'ibm_total_revenue_kes',
        'ibm_status',
        'investor_readiness',
        'documents_checklist',
        'first_contact_date',
        'acquisition_source',
        'legal_health_checks_completed',
        'consultations_completed',
        'lifetime_value_kes',
        'last_interaction_date',
        'assigned_bd_rep_id',
        'assigned_trail_guide_id',
        'status',
        'tags',
        'notes',
    ];

    protected $casts = [
        'contact_info' => 'array',
        'industry_tags' => 'array',
        'financial_data' => 'array',
        'legal_tier' => 'array',
        'category_scores' => 'array',
        'compliance_status' => 'array',
        'intellectual_property' => 'array',
        'team_info' => 'array',
        'investor_readiness' => 'array',
        'documents_checklist' => 'array',
        'tags' => 'array',
        'hub_enrollment_date' => 'date',
        'founding_date' => 'date',
        'incorporation_date' => 'date',
        'last_assessment_date' => 'datetime',
        'first_contact_date' => 'date',
        'last_interaction_date' => 'datetime',
        'lifetime_value_kes' => 'decimal:2',
        'ibm_total_revenue_kes' => 'decimal:2',
        'sector' => Sector::class,
        'stage' => BusinessStage::class,
    ];

    // Relationships
    public function legalHealthChecks(): HasMany
    {
        return $this->hasMany(LegalHealthCheck::class);
    }

    public function currentHealthCheck(): HasOne
    {
        return $this->hasOne(LegalHealthCheck::class, 'id', 'current_health_check_id');
    }

    public function serviceEngagements(): HasMany
    {
        return $this->hasMany(ServiceEngagement::class);
    }

    public function activeEngagement(): HasOne
    {
        return $this->hasOne(ServiceEngagement::class)
            ->where('contract_status', 'active')
            ->latest();
    }

    public function qaProjects(): HasMany
    {
        return $this->hasMany(QAProject::class);
    }

    public function investmentDeals(): HasMany
    {
        return $this->hasMany(InvestmentDeal::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function communications(): HasMany
    {
        return $this->hasMany(Communication::class);
    }

    public function assignedBdRep(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class, 'assigned_bd_rep_id');
    }

    public function assignedTrailGuide(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class, 'assigned_trail_guide_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeBySector($query, Sector $sector)
    {
        return $query->where('sector', $sector);
    }

    public function scopeByStage($query, BusinessStage $stage)
    {
        return $query->where('stage', $stage);
    }

    public function scopeHighRisk($query)
    {
        return $query->whereIn('risk_level', ['High', 'Critical']);
    }

    public function scopeHubParticipants($query)
    {
        return $query->whereNotNull('hub_partner');
    }

    public function scopeWithActiveTier($query, LegalTier $tier)
    {
        return $query->whereJsonContains('legal_tier->current_tier', $tier->value)
            ->whereJsonContains('legal_tier->contract_status', 'Active');
    }

    // Accessors
    public function getCurrentTierAttribute(): ?LegalTier
    {
        return isset($this->legal_tier['current_tier']) 
            ? LegalTier::from($this->legal_tier['current_tier']) 
            : null;
    }

    public function getMonthlyRetainerAttribute(): ?float
    {
        return $this->legal_tier['monthly_retainer_kes'] ?? null;
    }

    // Mutators
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = \Str::slug($value);
    }

    // Helper Methods
    public function calculateHealthScore(): int
    {
        // Logic to calculate overall health score from category scores
        if (!$this->category_scores) {
            return 0;
        }

        $weights = [
            'corporate_structure' => 0.20,
            'employment_hr' => 0.15,
            'data_protection' => 0.20,
            'intellectual_property' => 0.15,
            'contracts_agreements' => 0.15,
            'regulatory_compliance' => 0.15,
        ];

        $totalScore = 0;
        foreach ($weights as $category => $weight) {
            $totalScore += ($this->category_scores[$category] ?? 0) * $weight;
        }

        return (int) round($totalScore);
    }

    public function updateLifetimeValue(): void
    {
        $this->lifetime_value_kes = $this->serviceEngagements()
            ->sum('total_paid_kes');
        $this->save();
    }

    public function getFilePrefix(): string
    {
        return 'STARTUP';
    }
}
```

### 3.2 LegalHealthCheck Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\LegalTier;
use App\Traits\HasFileNaming;

class LegalHealthCheck extends Model
{
    use HasFactory, HasUuids, HasFileNaming;

    protected $fillable = [
        'startup_id',
        'assessment_date',
        'completed',
        'completion_percentage',
        'respondent_info',
        'section_1_business_structure',
        'section_2_employment',
        'section_3_commercial',
        'section_4_data_protection',
        'section_5_intellectual_property',
        'section_6_regulatory',
        'section_7_additional_info',
        'overall_score',
        'weighted_score',
        'category_weights',
        'recommended_tier',
        'priority_actions',
        'estimated_setup_cost_kes',
        'critical_gaps',
        'quick_wins',
        'consultation_scheduled',
        'consultation_date',
        'assigned_trail_guide_id',
        'quote_sent',
        'converted_to_client',
        'conversion_date',
        'source',
        'version',
        'time_to_complete_minutes',
        'completed_at',
    ];

    protected $casts = [
        'assessment_date' => 'datetime',
        'completed' => 'boolean',
        'respondent_info' => 'array',
        'section_1_business_structure' => 'array',
        'section_2_employment' => 'array',
        'section_3_commercial' => 'array',
        'section_4_data_protection' => 'array',
        'section_5_intellectual_property' => 'array',
        'section_6_regulatory' => 'array',
        'section_7_additional_info' => 'array',
        'category_weights' => 'array',
        'priority_actions' => 'array',
        'critical_gaps' => 'array',
        'quick_wins' => 'array',
        'consultation_scheduled' => 'boolean',
        'consultation_date' => 'datetime',
        'quote_sent' => 'boolean',
        'converted_to_client' => 'boolean',
        'conversion_date' => 'datetime',
        'completed_at' => 'datetime',
        'weighted_score' => 'decimal:2',
        'estimated_setup_cost_kes' => 'decimal:2',
        'recommended_tier' => LegalTier::class,
    ];

    // Relationships
    public function startup(): BelongsTo
    {
        return $this->belongsTo(Startup::class);
    }

    public function assignedTrailGuide(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class, 'assigned_trail_guide_id');
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('completed', true);
    }

    public function scopePending($query)
    {
        return $query->where('completed', false);
    }

    public function scopeConverted($query)
    {
        return $query->where('converted_to_client', true);
    }

    // Methods
    public function calculateScore(): void
    {
        $sections = [
            'section_1_business_structure',
            'section_2_employment',
            'section_3_commercial',
            'section_4_data_protection',
            'section_5_intellectual_property',
            'section_6_regulatory',
        ];

        $weights = $this->category_weights ?? [
            'corporate_structure' => 0.20,
            'employment_hr' => 0.15,
            'data_protection' => 0.20,
            'intellectual_property' => 0.15,
            'contracts_agreements' => 0.15,
            'regulatory_compliance' => 0.15,
        ];

        $totalScore = 0;
        $sectionScores = [];

        foreach ($sections as $section) {
            $sectionData = $this->$section ?? [];
            $sectionScores[$section] = $sectionData['score'] ?? 0;
        }

        // Map sections to weights
        $mappedScores = [
            'corporate_structure' => $sectionScores['section_1_business_structure'] ?? 0,
            'employment_hr' => $sectionScores['section_2_employment'] ?? 0,
            'contracts_agreements' => $sectionScores['section_3_commercial'] ?? 0,
            'data_protection' => $sectionScores['section_4_data_protection'] ?? 0,
            'intellectual_property' => $sectionScores['section_5_intellectual_property'] ?? 0,
            'regulatory_compliance' => $sectionScores['section_6_regulatory'] ?? 0,
        ];

        foreach ($weights as $category => $weight) {
            $totalScore += ($mappedScores[$category] ?? 0) * $weight;
        }

        $this->overall_score = (int) round($totalScore);
        $this->weighted_score = $totalScore;
        
        // Recommend tier based on score
        $this->recommended_tier = $this->recommendTier($totalScore);
        
        $this->save();
    }

    protected function recommendTier(float $score): LegalTier
    {
        if ($score >= 80) {
            return LegalTier::HUSTLE; // Good foundation, basic needs
        } elseif ($score >= 50) {
            return LegalTier::GROW; // Some gaps, scaling needs
        } else {
            return LegalTier::LEAD; // Significant issues, complex needs
        }
    }

    public function getFilePrefix(): string
    {
        return 'LHC';
    }
}
```

### 3.3 Document Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use App\Enums\DocumentType;
use App\Traits\HasFileNaming;

class Document extends Model
{
    use HasFactory, HasUuids, SoftDeletes, HasFileNaming;

    protected $fillable = [
        'startup_id',
        'engagement_id',
        'document_name',
        'document_type',
        'document_category',
        'version',
        'language',
        'filename',
        'file_path',
        'file_size_bytes',
        'file_format',
        'checksum_sha256',
        'confidentiality',
        'retention_years',
        'legal_privilege',
        'client_facing',
        'prepared_by_id',
        'reviewed_by_id',
        'approved_by_id',
        'signed_by_startup',
        'signed_by_mc_studio',
        'signed_by_ow',
        'other_signatories',
        'creation_date',
        'execution_date',
        'effective_date',
        'expiration_date',
        'last_review_date',
        'next_review_date',
        'status',
        'execution_status',
        'validity',
        'related_document_ids',
        'supersedes_id',
        'superseded_by_id',
        'requires_registration',
        'registered_with',
        'registration_number',
        'registration_date',
        'stamp_duty_paid',
        'stamp_duty_amount_kes',
        'uploaded_by_id',
        'tags',
        'notes',
    ];

    protected $casts = [
        'legal_privilege' => 'boolean',
        'client_facing' => 'boolean',
        'signed_by_startup' => 'boolean',
        'signed_by_mc_studio' => 'boolean',
        'signed_by_ow' => 'boolean',
        'other_signatories' => 'array',
        'creation_date' => 'date',
        'execution_date' => 'date',
        'effective_date' => 'date',
        'expiration_date' => 'date',
        'last_review_date' => 'date',
        'next_review_date' => 'date',
        'related_document_ids' => 'array',
        'requires_registration' => 'boolean',
        'registration_date' => 'date',
        'stamp_duty_paid' => 'boolean',
        'stamp_duty_amount_kes' => 'decimal:2',
        'tags' => 'array',
        'document_type' => DocumentType::class,
    ];

    // Relationships
    public function startup(): BelongsTo
    {
        return $this->belongsTo(Startup::class);
    }

    public function engagement(): BelongsTo
    {
        return $this->belongsTo(ServiceEngagement::class);
    }

    public function preparedBy(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class, 'prepared_by_id');
    }

    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class, 'reviewed_by_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class, 'approved_by_id');
    }

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class, 'uploaded_by_id');
    }

    // Scopes
    public function scopeByType($query, DocumentType $type)
    {
        return $query->where('document_type', $type);
    }

    public function scopeExpiringSoon($query, int $days = 30)
    {
        return $query->whereBetween('expiration_date', [now(), now()->addDays($days)]);
    }

    public function scopeExecuted($query)
    {
        return $query->where('status', 'executed');
    }

    // Methods
    public function getDownloadUrl(): string
    {
        return Storage::url($this->file_path);
    }

    public function isExpired(): bool
    {
        return $this->expiration_date && $this->expiration_date->isPast();
    }

    public function isFullySigned(): bool
    {
        return $this->signed_by_startup && 
               ($this->signed_by_mc_studio || $this->signed_by_ow);
    }

    public function getFilePrefix(): string
    {
        return 'DOC';
    }

    // Generate standardized filename
    public function generateFilename(): string
    {
        $startup = $this->startup;
        $typeSlug = \Str::slug($this->document_type->value);
        $date = now()->format('Y-m-d');
        
        return "{$this->getFilePrefix()}_{$startup->slug}_{$typeSlug}_v{$this->version}_{$date}.{$this->file_format}";
    }
}
```

---

## 4. MODEL RELATIONSHIPS

### 4.1 Complete Relationship Map

```php
// Startup has many relationships
Startup::find($id)->legalHealthChecks; // HasMany
Startup::find($id)->serviceEngagements; // HasMany
Startup::find($id)->qaProjects; // HasMany
Startup::find($id)->investmentDeals; // HasMany
Startup::find($id)->documents; // HasMany
Startup::find($id)->contacts; // HasMany
Startup::find($id)->communications; // HasMany
Startup::find($id)->assignedBdRep; // BelongsTo TeamMember
Startup::find($id)->assignedTrailGuide; // BelongsTo TeamMember

// LegalHealthCheck belongs to Startup
LegalHealthCheck::find($id)->startup; // BelongsTo

// ServiceEngagement relationships
ServiceEngagement::find($id)->startup; // BelongsTo
ServiceEngagement::find($id)->leadPartner; // BelongsTo TeamMember
ServiceEngagement::find($id)->trailGuide; // BelongsTo TeamMember
ServiceEngagement::find($id)->bdRep; // BelongsTo TeamMember
ServiceEngagement::find($id)->documents; // HasMany

// Document relationships
Document::find($id)->startup; // BelongsTo
Document::find($id)->engagement; // BelongsTo
Document::find($id)->preparedBy; // BelongsTo TeamMember

// TeamMember relationships (inverse)
TeamMember::find($id)->assignedStartups; // HasMany Startup (as BD rep)
TeamMember::find($id)->guidedStartups; // HasMany Startup (as trail guide)
TeamMember::find($id)->preparedDocuments; // HasMany Document
TeamMember::find($id)->qaProjects; // HasMany QAProject
```

---

## 5. ENUMS & VALUE OBJECTS

### 5.1 Enums

```php
<?php

namespace App\Enums;

enum Sector: string
{
    case FINTECH = 'Fintech';
    case HEALTHTECH = 'HealthTech';
    case EDTECH = 'EdTech';
    case AGRITECH = 'AgriTech';
    case RETAIL = 'Retail/Ecommerce';
    case ENERGY = 'Energy/Manufacturing';

    public function complianceRequirements(): array
    {
        return match($this) {
            self::FINTECH => [
                'regulatory_bodies' => ['CBK', 'KRA', 'ODPC'],
                'key_licenses' => ['Money Remittance License', 'Payment Service Provider'],
                'compliance_focus' => ['AML/CFT', 'Data Protection', 'Consumer Protection'],
            ],
            self::HEALTHTECH => [
                'regulatory_bodies' => ['PPB', 'KMPDB', 'ODPC'],
                'key_licenses' => ['Pharmacy License', 'Telemedicine License'],
                'compliance_focus' => ['Patient Privacy', 'Medical Data', 'Professional Standards'],
            ],
            // ... other sectors
            default => [],
        };
    }
}

enum BusinessStage: string
{
    case IDEA = 'Idea';
    case PRE_SEED = 'Pre-Seed';
    case SEED = 'Seed';
    case SERIES_A = 'Series A';
    case SERIES_B = 'Series B';
    case SERIES_C_PLUS = 'Series C+';
    case GROWTH = 'Growth';
    case MATURE = 'Mature';
}

enum LegalTier: string
{
    case HUSTLE = 'HUSTLE';
    case GROW = 'GROW';
    case LEAD = 'LEAD';

    public function monthlyFee(): int
    {
        return match($this) {
            self::HUSTLE => 25000,
            self::GROW => 50000,
            self::LEAD => 150000,
        };
    }

    public function typicalProfile(): array
    {
        return match($this) {
            self::HUSTLE => [
                'employees' => '1-10',
                'revenue_kes' => '<5M',
                'stage' => [BusinessStage::IDEA, BusinessStage::PRE_SEED, BusinessStage::SEED],
            ],
            self::GROW => [
                'employees' => '10-50',
                'revenue_kes' => '20M-200M',
                'stage' => [BusinessStage::SERIES_A, BusinessStage::SERIES_B],
            ],
            self::LEAD => [
                'employees' => '50+',
                'revenue_kes' => '500M+',
                'stage' => [BusinessStage::SERIES_B, BusinessStage::SERIES_C_PLUS, BusinessStage::GROWTH],
            ],
        };
    }
}

enum RiskLevel: string
{
    case LOW = 'Low';
    case MODERATE = 'Moderate';
    case HIGH = 'High';
    case CRITICAL = 'Critical';
}

enum DocumentType: string
{
    case CONTRACT = 'Contract';
    case AGREEMENT = 'Agreement';
    case POLICY = 'Policy';
    case TEMPLATE = 'Template';
    case REPORT = 'Report';
    case CERTIFICATE = 'Certificate';
    case LICENSE = 'License';
    case REGISTRATION = 'Registration';
    case CORRESPONDENCE = 'Correspondence';
    case OTHER = 'Other';
}
```

---

## 6. SERVICE CLASSES

### 6.1 FileNamingService

```php
<?php

namespace App\Services;

use App\Models\Startup;
use App\Models\Document;
use Carbon\Carbon;

class FileNamingService
{
    public function generateStartupFilename(Startup $startup, string $category, ?string $date = null): string
    {
        $date = $date ?? Carbon::now()->format('Y-m-d');
        return "STARTUP_{$startup->slug}_{$category}_{$date}";
    }

    public function generateLegalHealthCheckFilename(Startup $startup, string $status, ?string $date = null): string
    {
        $date = $date ?? Carbon::now()->format('Y-m-d');
        return "LHC_{$startup->slug}_{$date}_{$status}";
    }

    public function generateDocumentFilename(Document $document): string
    {
        $startup = $document->startup;
        $typeSlug = \Str::slug($document->document_type->value);
        $date = Carbon::now()->format('Y-m-d');
        
        return "DOC_{$startup->slug}_{$typeSlug}_v{$document->version}_{$date}.{$document->file_format}";
    }

    public function generateEngagementFilename(Startup $startup, string $tier, string $category, ?string $date = null): string
    {
        $date = $date ?? Carbon::now()->format('Y-m-d');
        return "ENG_{$startup->slug}_{$tier}_{$category}_{$date}";
    }

    public function generateQAProjectFilename(Startup $startup, string $projectCode, string $category, ?string $date = null): string
    {
        $date = $date ?? Carbon::now()->format('Y-m-d');
        return "QA_{$startup->slug}_{$projectCode}_{$category}_{$date}";
    }
}
```

### 6.2 LegalHealthCheckService

```php
<?php

namespace App\Services;

use App\Models\LegalHealthCheck;
use App\Models\Startup;
use App\Enums\LegalTier;

class LegalHealthCheckService
{
    public function createAssessment(Startup $startup, array $data): LegalHealthCheck
    {
        $lhc = new LegalHealthCheck([
            'startup_id' => $startup->id,
            'assessment_date' => now(),
            'respondent_info' => $data['respondent_info'] ?? [],
            'section_1_business_structure' => $data['section_1'] ?? [],
            'section_2_employment' => $data['section_2'] ?? [],
            'section_3_commercial' => $data['section_3'] ?? [],
            'section_4_data_protection' => $data['section_4'] ?? [],
            'section_5_intellectual_property' => $data['section_5'] ?? [],
            'section_6_regulatory' => $data['section_6'] ?? [],
            'section_7_additional_info' => $data['section_7'] ?? [],
            'source' => $data['source'] ?? 'Website',
        ]);

        $lhc->save();
        
        // Calculate scores
        $this->scoreAssessment($lhc);
        
        // Generate recommendations
        $this->generateRecommendations($lhc);
        
        return $lhc->fresh();
    }

    protected function scoreAssessment(LegalHealthCheck $lhc): void
    {
        $sectionScores = [
            'section_1_business_structure' => $this->scoreSectionOne($lhc->section_1_business_structure),
            'section_2_employment' => $this->scoreSectionTwo($lhc->section_2_employment),
            'section_3_commercial' => $this->scoreSectionThree($lhc->section_3_commercial),
            'section_4_data_protection' => $this->scoreSectionFour($lhc->section_4_data_protection),
            'section_5_intellectual_property' => $this->scoreSectionFive($lhc->section_5_intellectual_property),
            'section_6_regulatory' => $this->scoreSectionSix($lhc->section_6_regulatory),
        ];

        // Update each section with its score
        foreach ($sectionScores as $section => $score) {
            $sectionData = $lhc->$section;
            $sectionData['score'] = $score;
            $lhc->$section = $sectionData;
        }

        $lhc->save();
        $lhc->calculateScore();
    }

    protected function scoreSectionOne(array $data): int
    {
        $score = 0;
        $maxScore = 9; // 9 questions

        if ($data['business_registered'] ?? false) $score++;
        if ($data['considered_incorporation'] ?? false) $score++;
        if ($data['scaling_outside_kenya'] ?? false) $score++;
        if ($data['formal_structure'] ?? false) $score++;
        if ($data['founders_agreement'] ?? false) $score++;
        if ($data['shareholders_agreement'] ?? false) $score++;
        if (($data['financing_considered'] ?? null) !== null) $score++;
        if ($data['licenses_permits'] ?? false) $score++;
        if ($data['governance_structure'] ?? false) $score++;

        return (int) (($score / $maxScore) * 100);
    }

    // Similar scoring methods for other sections...

    protected function generateRecommendations(LegalHealthCheck $lhc): void
    {
        $priorityActions = [];
        $criticalGaps = [];
        $quickWins = [];

        // Business Structure
        if (!($lhc->section_1_business_structure['business_registered'] ?? false)) {
            $criticalGaps[] = 'Company not registered';
            $priorityActions[] = [
                'action' => 'Register business entity',
                'priority' => 'High',
                'estimated_cost_kes' => 15000,
            ];
        }

        if (!($lhc->section_1_business_structure['shareholders_agreement'] ?? false)) {
            $quickWins[] = 'Create shareholders agreement (template available)';
        }

        // Data Protection
        if (!($lhc->section_4_data_protection['registered_as_controller_processor'] ?? false)) {
            $criticalGaps[] = 'Not registered with ODPC';
            $priorityActions[] = [
                'action' => 'Register as Data Controller/Processor',
                'priority' => 'High',
                'estimated_cost_kes' => 5000,
            ];
        }

        $lhc->priority_actions = $priorityActions;
        $lhc->critical_gaps = $criticalGaps;
        $lhc->quick_wins = $quickWins;
        
        // Calculate total estimated cost
        $totalCost = collect($priorityActions)->sum('estimated_cost_kes');
        $lhc->estimated_setup_cost_kes = $totalCost;

        $lhc->save();
    }
}
```

---

## 7. API RESOURCES

### 7.1 StartupResource

```php
<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StartupResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'company_name' => $this->company_name,
            'sector' => $this->sector,
            'stage' => $this->stage,
            'contact_info' => $this->contact_info,
            'legal_tier' => [
                'current_tier' => $this->current_tier?->value,
                'monthly_retainer_kes' => $this->monthly_retainer,
                'status' => $this->legal_tier['contract_status'] ?? null,
            ],
            'health_score' => [
                'overall_score' => $this->overall_health_score,
                'risk_level' => $this->risk_level,
                'last_assessment' => $this->last_assessment_date,
                'category_scores' => $this->category_scores,
            ],
            'hub_partner' => [
                'partner' => $this->hub_partner,
                'cohort' => $this->hub_cohort,
            ],
            'metrics' => [
                'employee_count' => $this->employee_count,
                'lifetime_value_kes' => $this->lifetime_value_kes,
                'consultations_completed' => $this->consultations_completed,
            ],
            'team_assignment' => [
                'bd_rep' => new TeamMemberResource($this->whenLoaded('assignedBdRep')),
                'trail_guide' => new TeamMemberResource($this->whenLoaded('assignedTrailGuide')),
            ],
            'latest_health_check' => new LegalHealthCheckResource($this->whenLoaded('currentHealthCheck')),
            'active_engagement' => new ServiceEngagementResource($this->whenLoaded('activeEngagement')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
```

---

## 8. FILE STORAGE

### 8.1 Filesystem Configuration (config/filesystems.php)

```php
'disks' => [
    's3_mc_studio' => [
        'driver' => 's3',
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION'),
        'bucket' => env('AWS_BUCKET'),
        'url' => env('AWS_URL'),
        'endpoint' => env('AWS_ENDPOINT'),
        'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        'throw' => false,
    ],
],
```

### 8.2 File Storage Service

```php
<?php

namespace App\Services;

use App\Models\Document;
use App\Models\Startup;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DocumentStorageService
{
    public function storeDocument(
        UploadedFile $file, 
        Startup $startup, 
        string $documentType,
        array $metadata = []
    ): Document {
        $filename = $this->generateFilename($file, $startup, $documentType);
        $path = $this->getStoragePath($startup, $documentType);
        
        // Store file
        $filePath = Storage::disk('s3_mc_studio')->putFileAs(
            $path,
            $file,
            $filename
        );

        // Create document record
        $document = Document::create([
            'startup_id' => $startup->id,
            'document_name' => $metadata['name'] ?? $file->getClientOriginalName(),
            'document_type' => $documentType,
            'filename' => $filename,
            'file_path' => $filePath,
            'file_size_bytes' => $file->getSize(),
            'file_format' => $file->getClientOriginalExtension(),
            'checksum_sha256' => hash_file('sha256', $file->getRealPath()),
            'uploaded_by_id' => auth()->id(),
            ...$metadata,
        ]);

        return $document;
    }

    protected function generateFilename(UploadedFile $file, Startup $startup, string $documentType): string
    {
        $typeSlug = \Str::slug($documentType);
        $date = now()->format('Y-m-d');
        $extension = $file->getClientOriginalExtension();
        
        return "DOC_{$startup->slug}_{$typeSlug}_{$date}.{$extension}";
    }

    protected function getStoragePath(Startup $startup, string $documentType): string
    {
        return "startups/{$startup->slug}/" . \Str::slug($documentType);
    }
}
```

---

## 9. VECTOR DATABASE INTEGRATION

### 9.1 Vector Service (using Pinecone)

```php
<?php

namespace App\Services;

use App\Models\Startup;
use App\Models\Document;
use Illuminate\Support\Facades\Http;

class VectorSearchService
{
    protected string $apiKey;
    protected string $environment;
    protected string $indexName;

    public function __construct()
    {
        $this->apiKey = config('services.pinecone.api_key');
        $this->environment = config('services.pinecone.environment');
        $this->indexName = config('services.pinecone.index_name');
    }

    public function embedStartup(Startup $startup): void
    {
        $text = $this->prepareStartupText($startup);
        $embedding = $this->getEmbedding($text);
        
        $this->upsertVector(
            id: "startup_{$startup->id}",
            vector: $embedding,
            metadata: [
                'startup_id' => $startup->id,
                'company_name' => $startup->company_name,
                'slug' => $startup->slug,
                'sector' => $startup->sector->value,
                'stage' => $startup->stage->value,
                'tier' => $startup->current_tier?->value,
                'health_score' => $startup->overall_health_score,
                'employee_count' => $startup->employee_count,
                'embedding_type' => 'business_description',
            ]
        );
    }

    protected function prepareStartupText(Startup $startup): string
    {
        return implode(' ', [
            $startup->company_name,
            $startup->sector->value,
            $startup->stage->value,
            $startup->legal_tier['description'] ?? '',
            implode(' ', $startup->industry_tags ?? []),
        ]);
    }

    protected function getEmbedding(string $text): array
    {
        // Use OpenAI API to get embeddings
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.openai.api_key'),
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/embeddings', [
            'model' => 'text-embedding-ada-002',
            'input' => $text,
        ]);

        return $response->json()['data'][0]['embedding'];
    }

    protected function upsertVector(string $id, array $vector, array $metadata): void
    {
        Http::withHeaders([
            'Api-Key' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post("https://{$this->indexName}-{$this->environment}.svc.pinecone.io/vectors/upsert", [
            'vectors' => [
                [
                    'id' => $id,
                    'values' => $vector,
                    'metadata' => $metadata,
                ]
            ]
        ]);
    }

    public function searchSimilarStartups(string $query, array $filters = [], int $topK = 10): array
    {
        $queryEmbedding = $this->getEmbedding($query);
        
        $response = Http::withHeaders([
            'Api-Key' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post("https://{$this->indexName}-{$this->environment}.svc.pinecone.io/query", [
            'vector' => $queryEmbedding,
            'filter' => $filters,
            'topK' => $topK,
            'includeMetadata' => true,
        ]);

        return $response->json()['matches'] ?? [];
    }
}
```

---

## 10. CODE EXAMPLES

### 10.1 Creating a Startup with Legal Health Check

```php
use App\Models\Startup;
use App\Services\LegalHealthCheckService;
use App\Enums\Sector;
use App\Enums\BusinessStage;

// Create startup
$startup = Startup::create([
    'company_name' => 'QuantumLeap Innovations',
    'slug' => 'quantumleap',
    'sector' => Sector::FINTECH,
    'stage' => BusinessStage::SEED,
    'contact_info' => [
        'email' => 'info@quantumleap.co.ke',
        'phone' => '+254712345678',
        'website' => 'https://quantumleap.co.ke',
    ],
    'employee_count' => 5,
    'acquisition_source' => 'IBM Research Centre',
    'hub_program_participant' => true,
    'hub_program_cohort' => 'Cohort 2',
    'assigned_bd_rep_id' => $bdRep->id,
]);

// Create legal health check
$lhcService = new LegalHealthCheckService();
$lhc = $lhcService->createAssessment($startup, [
    'respondent_info' => [
        'name' => 'John Smith',
        'title' => 'CEO',
        'email' => 'john@quantumleap.co.ke',
    ],
    'section_1' => [
        'business_registered' => false,
        'considered_incorporation' => true,
        'founders_agreement' => false,
        // ... other answers
    ],
    // ... other sections
    'source' => 'Website',
]);

// Update startup with health check results
$startup->update([
    'current_health_check_id' => $lhc->id,
    'overall_health_score' => $lhc->overall_score,
    'risk_level' => $lhc->overall_score < 50 ? 'High' : 'Moderate',
    'last_assessment_date' => now(),
]);
```

### 10.2 Querying with Eloquent

```php
// Find all high-risk Fintech startups in GROW tier
$startups = Startup::query()
    ->bySector(Sector::FINTECH)
    ->withActiveTier(LegalTier::GROW)
    ->highRisk()
    ->with(['assignedBdRep', 'currentHealthCheck'])
    ->get();

// Get monthly recurring revenue by tier
$mrrByTier = Startup::query()
    ->whereJsonContains('legal_tier->contract_status', 'Active')
    ->get()
    ->groupBy(fn($startup) => $startup->current_tier?->value)
    ->map(fn($group) => $group->sum('monthly_retainer'));

// Find startups needing legal health check follow-up
$needsFollowUp = LegalHealthCheck::query()
    ->completed()
    ->where('consultation_scheduled', false)
    ->where('overall_score', '<', 60)
    ->with('startup')
    ->get();

// Documents expiring in next 30 days
$expiringDocs = Document::query()
    ->expiringSoon(30)
    ->with('startup')
    ->orderBy('expiration_date')
    ->get();
```

### 10.3 Using API Resources

```php
use App\Http\Resources\StartupResource;

// Controller method
public function show(Startup $startup)
{
    $startup->load([
        'currentHealthCheck',
        'activeEngagement',
        'assignedBdRep',
        'assignedTrailGuide',
    ]);

    return new StartupResource($startup);
}

// Returns:
{
    "id": "uuid",
    "slug": "quantumleap",
    "company_name": "QuantumLeap Innovations",
    "sector": "Fintech",
    "stage": "Seed",
    "legal_tier": {
        "current_tier": "HUSTLE",
        "monthly_retainer_kes": 25000,
        "status": "Active"
    },
    "health_score": {
        "overall_score": 65,
        "risk_level": "Moderate",
        "last_assessment": "2026-02-04T10:00:00Z"
    }
}
```

---

## SUMMARY

This Laravel implementation provides:

✅ **Database Migrations** - Complete schema with proper foreign keys and indexes  
✅ **Eloquent Models** - Rich models with relationships, scopes, and helper methods  
✅ **Enums** - Type-safe enumerations for sectors, tiers, stages  
✅ **Service Classes** - Business logic separated from controllers  
✅ **API Resources** - Consistent API responses  
✅ **File Storage** - S3-based document management with naming conventions  
✅ **Vector Search** - Pinecone integration for semantic search  
✅ **Best Practices** - Following Laravel conventions and PSR standards

**Next Steps:**
1. Run migrations: `php artisan migrate`
2. Create seeders for test data
3. Implement controllers and routes
4. Add validation using Form Requests
5. Set up queues for embeddings generation
6. Implement event listeners for automatic file naming
7. Add tests (Feature and Unit)

