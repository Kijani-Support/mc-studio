@extends('layouts.app')

@section('title', 'Legal Health Check')

@section('primary-cta')
    <a href="{{ route('legal.healthcheck.assessment') }}"
       class="inline-flex items-center rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
        Start Assessment
    </a>
@endsection

@section('content')
<section class="bg-blue-50 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Hero --}}
        <div class="grid gap-8 md:grid-cols-2 items-center">
            <div>
                <p class="text-sm font-semibold text-blue-700 uppercase tracking-wide">
                    What is a <span class="text-blue-900">Legal Health Check?</span>
                </p>
                <h1 class="mt-3 text-3xl sm:text-4xl font-bold text-gray-900">
                    Proactive Legal Clarity for Your Business Growth
                </h1>
                <p class="mt-4 text-sm sm:text-base text-gray-600">
                    A Legal Health Check is a comprehensive assessment of your business’s legal standing.
                    It identifies potential risks, ensures compliance, and provides actionable insights
                    to strengthen your operations and protect your assets.
                </p>
                <div class="mt-6">
                    <a href="{{ route('legal.healthcheck.assessment') }}"
                       class="inline-flex items-center rounded-full bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                        Start Your Free Assessment
                    </a>
                </div>
            </div>
            <div class="flex justify-center">
                {{-- Replace with your image --}}
                <div class="w-full max-w-md rounded-2xl overflow-hidden shadow-lg bg-white">
                    <img src="{{ asset('images/legal-health-hero.jpg') }}" alt="Legal Health Check" class="w-full h-64 object-cover">
                </div>
            </div>
        </div>

        {{-- Process steps --}}
        <div class="mt-16">
            <h2 class="text-2xl font-semibold text-gray-900 text-center">
                The Legal Health Check Process
            </h2>
            <div class="mt-8 grid gap-6 md:grid-cols-4">
                @foreach ([
                    ['Step 1: Company Information', 'Provide essential details about your business, its structure, and key operations.'],
                    ['Step 2: Comprehensive Assessment', 'Answer targeted questions across key legal domains, from contracts and employment to data privacy and IP.'],
                    ['Step 3: Expert Review', 'Our legal specialists analyze your responses, identifying risks and opportunities based on current regulations.'],
                    ['Step 4: Personalized Report', 'Receive a detailed report with your health score, risk analysis, and tailored recommendations.'],
                ] as [$title, $desc])
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-5 py-6">
                        <h3 class="text-sm font-semibold text-gray-900">{{ $title }}</h3>
                        <p class="mt-3 text-sm text-gray-600">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Outcomes / Journeys & Tiers --}}
        <div class="mt-16">
            <h2 class="text-2xl font-semibold text-gray-900 text-center">
                How Your Legal Health Score Is Calculated
            </h2>
            <div class="mt-8 grid gap-6 md:grid-cols-4">
                @foreach ([
                    [
                        'Journey 1: Not Yet Registered',
                        'If your business is not yet formally registered, your Legal Health Check will surface key foundation gaps and your score is calculated out of 50%. This shows how prepared you are for registration.'
                    ],
                    [
                        'Journey 2: Registered Business',
                        'If your company is already registered, you can unlock the full 100% score. We assess your structures, contracts, IP, data protection and compliance for a complete view of legal health.'
                    ],
                    [
                        'Revenue‑Based Service Tiers',
                        'Registered businesses are further grouped into service tiers based on monthly/annual revenue so you can see which Aikya legal plan fits you best.'
                    ],
                    [
                        'Tier Thresholds (KES)',
                        'Min Revenue: KES 417,000 pm (Annual ≥ KES 5,000,000); Min Revenue: KES 834,000 pm (Annual ≥ KES 10,000,000); Min Revenue: KES 9,584,000 pm (Annual ≥ KES 100,000,000).'
                    ],
                ] as [$title, $desc])
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-5 py-6">
                        <h3 class="text-sm font-semibold text-gray-900">{{ $title }}</h3>
                        <p class="mt-3 text-sm text-gray-600">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- CTA --}}
        <div class="mt-16 bg-blue-600 rounded-2xl px-8 py-10 text-center text-white">
            <h2 class="text-2xl font-semibold">Ready to Secure Your Business Future?</h2>
            <p class="mt-3 text-sm sm:text-base text-blue-100 max-w-2xl mx-auto">
                Take the first step towards robust legal health. Start your free assessment today and build a resilient legal foundation for lasting success.
            </p>
            <div class="mt-6">
                <a href="{{ route('legal.healthcheck.assessment') }}"
                   class="inline-flex items-center rounded-full bg-white px-6 py-2.5 text-sm font-semibold text-blue-700 hover:bg-blue-50">
                    Start Your Free Assessment Now
                </a>
            </div>
        </div>
    </div>
</section>
@endsection