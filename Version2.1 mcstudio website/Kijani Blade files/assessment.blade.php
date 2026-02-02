@extends('layouts.app')

@section('title', 'Legal Health Check – Assessment')

@section('primary-cta')
    <span class="hidden md:inline text-sm text-gray-500">Step 1 of 7</span>
@endsection

@section('content')
<section class="bg-gray-50 py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[280px,minmax(0,1fr)]">
            {{-- Progress sidebar --}}
            <aside class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-sm font-semibold text-gray-900 mb-4">Assessment Progress</h2>
                <ol class="space-y-3 text-sm">
                    @foreach ([
                        'Company Information',
                        'Corporate Structure',
                        'Employment & HR',
                        'Data Protection',
                        'Intellectual Property',
                        'Tax & Compliance',
                        'Review & Submit',
                    ] as $index => $label)
                        @php $step = $index + 1; $active = $step === 1; @endphp
                        <li class="flex items-center gap-3">
                            <div class="flex h-7 w-7 items-center justify-center rounded-full border
                                {{ $active ? 'bg-blue-600 border-blue-600 text-white' : 'border-gray-300 text-gray-600' }}">
                                {{ $step }}
                            </div>
                            <span class="{{ $active ? 'font-semibold text-gray-900' : 'text-gray-600' }}">
                                {{ $label }}
                            </span>
                        </li>
                    @endforeach
                </ol>
            </aside>

            {{-- Form card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                <h1 class="text-xl font-semibold text-gray-900">Company Information</h1>
                <p class="mt-2 text-sm text-gray-600">
                    Please provide basic details about your company.
                </p>

                <form action="#" method="POST" class="mt-6 space-y-6">
                    @csrf
                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Company Name</label>
                            <input type="text" name="company_name" placeholder="e.g., Acme Innovations Ltd"
                                   class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Industry</label>
                            <select name="industry"
                                    class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                <option value="">Select industry</option>
                                <option>FinTech</option>
                                <option>HealthTech</option>
                                <option>Retail</option>
                                <option>SaaS</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Country of Operation</label>
                            <input type="text" name="country" placeholder="e.g., Kenya"
                                   class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Number of Employees</label>
                            <select name="employees"
                                    class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                <option value="">Select range</option>
                                <option>1–10</option>
                                <option>11–50</option>
                                <option>51–200</option>
                                <option>201+</option>
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Company Registration Number</label>
                            <input type="text" name="registration_number" placeholder="e.g., PVT-2023-001234"
                                   class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit"
                                class="inline-flex items-center rounded-full bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                            Save &amp; Continue
                            <span class="ml-2 text-base">→</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection