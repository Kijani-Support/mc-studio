<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        // Personal Information
        'firstName', 'lastName', 'dateOfBirth', 'gender', 'nationalId', 'phoneNumber', 'email',
        // Address Information
        'district', 'subcounty', 'parish', 'village',
        // Cooperative/Group Information
        'cooperativeName', 'membershipNumber', 'position', 'registrationNumber',
        // Agricultural Information
        'primaryCrop', 'otherCrop', 'farmSize', 'annualProduction', 'farmingExperience',
        // Financial Information
        'loanAmount', 'loanPurpose', 'monthlyIncome', 'bankAccount',
        // Consent and Declarations
        'dataConsent', 'creditCheck', 'termsAccept', 'accurateInfo',
    ];
}
