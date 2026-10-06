<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use Illuminate\Support\Facades\Log;

class ApplicationController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                // Personal Information
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'dateOfBirth' => 'required|date',
                'gender' => 'required|string',
                'nationalId' => 'required|string',
                'phoneNumber' => 'required|string',
                'email' => 'nullable|email',
                // Address Information
                'district' => 'required|string',
                'subcounty' => 'required|string',
                'parish' => 'nullable|string',
                'village' => 'required|string',
                // Cooperative/Group Information
                'cooperativeName' => 'required|string',
                'membershipNumber' => 'nullable|string',
                'position' => 'nullable|string',
                'registrationNumber' => 'nullable|string',
                // Agricultural Information
                'primaryCrop' => 'required|string',
                'otherCrop' => 'nullable|string',
                'farmSize' => 'required|numeric',
                'annualProduction' => 'nullable|integer',
                'farmingExperience' => 'nullable|integer',
                // Financial Information
                'loanAmount' => 'required|numeric',
                'loanPurpose' => 'required|string',
                'monthlyIncome' => 'nullable|numeric',
                'bankAccount' => 'required|string',
                // Consent and Declarations
                'dataConsent' => 'required|boolean',
                'creditCheck' => 'required|boolean',
                'termsAccept' => 'required|boolean',
                'accurateInfo' => 'required|boolean',
            ]);

            Log::info('Validated application data:', $validated);

            $app = Application::create($validated);
            Log::info('Application created:', ['id' => $app->id]);

            return redirect()->back()->with('success', 'Thank you for your application! We will review your information and contact you soon.');
        } catch (\Exception $e) {
            Log::error('Application submission failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'There was a problem saving your application. Please try again or contact support.');
        }
    }
}
