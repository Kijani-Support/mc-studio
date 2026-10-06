<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'nullable|string',
            'education' => 'required|string',
            'experience' => 'required|string',
            'current_role' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'languages' => 'nullable|array',
            'languages.*' => 'string',
            'cloud_platforms' => 'nullable|array',
            'cloud_platforms.*' => 'string',
            'ai_experience' => 'required|string',
            'availability' => 'required|string',
            'motivation' => 'required|string',
            'specialization' => 'required|string',
            'additional_info' => 'nullable|string',
            'laptop_access' => 'required|string',
            'internet_quality' => 'nullable|string',
        ]);

        $lead = new Lead();
        $lead->first_name = $validated['first_name'];
        $lead->last_name = $validated['last_name'];
        $lead->email = $validated['email'];
        $lead->phone = $validated['phone'];
        $lead->address = $validated['address'] ?? null;
        $lead->education = $validated['education'];
        $lead->experience = $validated['experience'];
        $lead->current_role = $validated['current_role'] ?? null;
        $lead->company = $validated['company'] ?? null;
        $lead->languages = isset($validated['languages']) ? json_encode($validated['languages']) : null;
        $lead->cloud_platforms = isset($validated['cloud_platforms']) ? json_encode($validated['cloud_platforms']) : null;
        $lead->ai_experience = $validated['ai_experience'];
        $lead->availability = $validated['availability'];
        $lead->motivation = $validated['motivation'];
        $lead->specialization = $validated['specialization'];
        $lead->additional_info = $validated['additional_info'] ?? null;
        $lead->laptop_access = $validated['laptop_access'];
        $lead->internet_quality = $validated['internet_quality'] ?? null;
        $lead->save();

        return redirect()->back()->with('success', 'Thank you for your application! We will get back to you soon.');
    }
} 