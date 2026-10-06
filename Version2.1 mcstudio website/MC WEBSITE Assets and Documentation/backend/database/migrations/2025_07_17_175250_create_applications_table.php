<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            // Personal Information
            $table->string('firstName');
            $table->string('lastName');
            $table->date('dateOfBirth');
            $table->string('gender');
            $table->string('nationalId');
            $table->string('phoneNumber');
            $table->string('email')->nullable();
            // Address Information
            $table->string('district');
            $table->string('subcounty');
            $table->string('parish')->nullable();
            $table->string('village');
            // Cooperative/Group Information
            $table->string('cooperativeName');
            $table->string('membershipNumber')->nullable();
            $table->string('position')->nullable();
            $table->string('registrationNumber')->nullable();
            // Agricultural Information
            $table->string('primaryCrop');
            $table->string('otherCrop')->nullable();
            $table->decimal('farmSize', 8, 2);
            $table->integer('annualProduction')->nullable();
            $table->integer('farmingExperience')->nullable();
            // Financial Information
            $table->bigInteger('loanAmount');
            $table->string('loanPurpose');
            $table->bigInteger('monthlyIncome')->nullable();
            $table->string('bankAccount');
            // Consent and Declarations
            $table->boolean('dataConsent');
            $table->boolean('creditCheck');
            $table->boolean('termsAccept');
            $table->boolean('accurateInfo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
