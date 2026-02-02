@extends('layouts.app')

@section('title', 'Legal Health Check – Results')

@section('primary-cta')
    <a href="#" class="inline-flex items-center rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
        Activate Your Account
    </a>
@endsection

@section('content')
<section class="bg-gray-50 py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        {{-- Score header --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-6 py-6 flex flex-wrap items-center gap-6">
            <div>
                <div class="text-4xl font-bold text-blue-700">82</div>
                <div class="text-sm font-semibold text-gray-700 mt-1">Legal Health Score</div>
            </div>
            <div class="flex-1 flex items-center justify-center sm:justify-start gap-4">
                <div class="text-sm">
                    <div class="text-gray-500 text-xs">Risk Level</div>
                    <div class="mt-1 inline-flex items-center rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                        Low
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3 ml-auto">
                <a href="#"
                   class="inline-flex items-center rounded-full border border-gray-300 px-4 py-2 text-xs font-semibold text-gray-800 hover:bg-gray-50">
                    Download PDF Report
                </a>
                <a href="#"
                   class="inline-flex items-center rounded-full bg-blue-600 px-4 py-2 text-xs font-semibold text-white hover:bg-blue-700">
                    Book Consultation
                </a>
            </div>
        </div>

        {{-- Breakdown cards --}}
        <section>
            <h2 class="text-lg font-semibold text-gray-900 mb-4">
                Your Legal Health Breakdown
            </h2>
            <div class="grid gap-4 md:grid-cols-3">
                @foreach ([
                    ['Corporate Structure', 'Good', 'Your foundational documents are robust and up to date.'],
                    ['Employment & HR', 'Moderate Risk', 'Some gaps exist in employment contracts and policies.'],
                    ['Data Protection', 'Good', 'Strong data privacy measures are in place.'],
                    ['Intellectual Property', 'Moderate Risk', 'Trademarks and patents require strategic review.'],
                    ['Contracts & Agreements', 'Good', 'Operating agreements are generally sound and well‑structured.'],
                    ['Regulatory Compliance', 'High Risk', 'Significant updates needed to align with new regulations.'],
                ] as [$title, $status, $desc])
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-5 py-5">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-900">{{ $title }}</h3>
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-semibold
                                {{ str_contains($status, 'Good') ? 'bg-green-50 text-green-700' :
                                   (str_contains($status, 'Moderate') ? 'bg-amber-50 text-amber-700' :
                                   'bg-red-50 text-red-700') }}">
                                {{ $status }}
                            </span>
                        </div>
                        <p class="mt-3 text-xs text-gray-600">
                            {{ $desc }}
                        </p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Priority actions --}}
        <section>
            <h2 class="text-lg font-semibold text-gray-900 mb-4">
                Priority Actions for Improvement
            </h2>
            <div class="space-y-3">
                @foreach ([
                    ['Update Employment Contracts', 'Revise all standard employment agreements to comply with current labor legislation.', 'Review Templates'],
                    ['Conduct IP Audit for Global Markets', 'Assess existing IP to identify gaps and develop protection strategies.', 'Start Audit'],
                    ['Consult on Regulatory Changes', 'Schedule a meeting with a legal expert to discuss recent regulatory changes.', 'Book Consultation'],
                ] as [$title, $desc, $cta])
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-5 py-4 flex flex-wrap items-center gap-4">
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-gray-900">{{ $title }}</h3>
                            <p class="mt-1 text-xs text-gray-600">{{ $desc }}</p>
                        </div>
                        <a href="#"
                           class="inline-flex items-center rounded-full border border-gray-300 px-4 py-2 text-xs font-semibold text-gray-800 hover:bg-gray-50">
                            {{ $cta }}
                        </a>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Recommended tier --}}
        <section>
            <h2 class="text-lg font-semibold text-gray-900 mb-4">
                Your Recommended Path Forward
            </h2>
            <div class="bg-blue-50 rounded-2xl border border-blue-100 px-6 py-6 flex flex-col gap-3 sm:flex-row sm:items-center">
                <div class="flex-1">
                    <p class="text-xs font-semibold uppercase text-blue-700 tracking-wide">
                        Recommended Tier
                    </p>
                    <h3 class="mt-1 text-xl font-semibold text-gray-900">
                        Aikya Growth Tier
                    </h3>
                    <p class="mt-2 text-xs sm:text-sm text-gray-700 max-w-xl">
                        Designed for scaling businesses, this tier provides ongoing legal support, proactive compliance
                        reviews, and strategic advice for expansion into new markets.
                    </p>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('services.legal.tiers') }}"
                       class="inline-flex items-center rounded-full bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                        Book Consultation
                    </a>
                </div>
            </div>
        </section>
    </div>
</section>
@endsection