{{-- resources/views/services/legal-tiers.blade.php --}}
@extends('layouts.app')

@section('title', 'Aikya Hustle: Founder Tier Legal Service')

@section('primary-cta')
    <a href="#" class="inline-flex items-center rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700">
        Activate Your Account
    </a>
@endsection

@section('content')
<section class="bg-gray-50 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Hero --}}
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">
                Aikya Hustle: Founder Tier Legal Service
            </h1>
            <p class="mt-4 text-base sm:text-lg text-gray-600">
                Gain a competitive edge with expert legal guidance tailored for dynamic startups.
                Our Founder Tier provides essential support to navigate the complexities of launching
                and growing your business with confidence.
            </p>
        </div>

        {{-- Section heading --}}
        <div class="mt-10 text-center">
            <h2 class="text-2xl font-semibold text-gray-900">
                Find Your Perfect Legal Partnership
            </h2>
        </div>

        {{-- Pricing cards --}}
        <div class="mt-8 grid gap-6 md:grid-cols-3">
            {{-- Hustle Tier --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 flex flex-col">
                <div class="px-6 pt-6 pb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Aikya Hustle</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Ideal for early‑stage founders seeking foundational legal support to kickstart their venture.
                    </p>

                    <div class="mt-6">
                        <div class="text-xs font-semibold uppercase text-gray-500">From</div>
                        <div class="mt-1 flex items-baseline gap-1">
                            <span class="text-3xl font-bold text-blue-700">KSh</span>
                            <span class="text-4xl font-bold text-blue-700">25,000</span>
                            <span class="text-sm text-gray-500">/month</span>
                        </div>
                    </div>

                    <ul class="mt-6 space-y-2 text-sm text-gray-700">
                        <li class="flex gap-2">
                            <span class="mt-1 h-4 w-4 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px]">✓</span>
                            <span>Legal strategy & roadmap</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-1 h-4 w-4 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px]">✓</span>
                            <span>Contract drafting (up to 5/month)</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-1 h-4 w-4 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px]">✓</span>
                            <span>IP protection guidance</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-1 h-4 w-4 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px]">✓</span>
                            <span>Regulatory compliance check</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-1 h-4 w-4 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px]">✓</span>
                            <span>Access to legal templates</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-1 h-4 w-4 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px]">✓</span>
                            <span>Monthly founder check‑in (1 hr)</span>
                        </li>
                    </ul>
                </div>

                <div class="mt-auto border-t px-6 py-4 space-y-2">
                    <button class="w-full inline-flex justify-center rounded-full bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                        Subscribe Now
                    </button>
                    <button class="w-full inline-flex justify-center rounded-full border border-gray-300 px-4 py-2.5 text-sm font-semibold text-gray-800 hover:bg-gray-50">
                        Contact Sales
                    </button>
                </div>
            </div>

            {{-- Growth Tier (center, highlighted) --}}
            <div class="relative bg-white rounded-2xl shadow-xl border-2 border-blue-600 ring-2 ring-blue-100 flex flex-col">
                <div class="absolute -top-3 right-6">
                    <span class="rounded-full bg-blue-600 px-3 py-1 text-xs font-semibold text-white shadow">
                        Recommended
                    </span>
                </div>
                <div class="px-6 pt-6 pb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Growth Tier</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Designed for scaling startups needing comprehensive legal coverage to support rapid expansion.
                    </p>

                    <div class="mt-6">
                        <div class="text-xs font-semibold uppercase text-gray-500">From</div>
                        <div class="mt-1 flex items-baseline gap-1">
                            <span class="text-3xl font-bold text-blue-700">KSh</span>
                            <span class="text-4xl font-bold text-blue-700">50,000</span>
                            <span class="text-sm text-gray-500">/month</span>
                        </div>
                    </div>

                    <ul class="mt-6 space-y-2 text-sm text-gray-700">
                        <li class="flex gap-2">
                            <span class="mt-1 h-4 w-4 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px]">✓</span>
                            <span>All Founder Tier benefits</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-1 h-4 w-4 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px]">✓</span>
                            <span>Advanced contract negotiation (up to 10/month)</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-1 h-4 w-4 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px]">✓</span>
                            <span>Data privacy policy drafting</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-1 h-4 w-4 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px]">✓</span>
                            <span>HR & employment legal support</span>
                        </li>
                    </ul>
                </div>

                <div class="mt-auto border-t px-6 py-4 space-y-2">
                    <button class="w-full inline-flex justify-center rounded-full bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                        Subscribe Now
                    </button>
                    <button class="w-full inline-flex justify-center rounded-full border border-gray-300 px-4 py-2.5 text-sm font-semibold text-gray-800 hover:bg-gray-50">
                        Contact Sales
                    </button>
                </div>
            </div>

            {{-- Lead Enterprise Tier --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 flex flex-col">
                <div class="px-6 pt-6 pb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Lead Enterprise Tier</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        For established businesses requiring extensive, on‑demand legal services across complex operations.
                    </p>

                    <div class="mt-6">
                        <div class="text-xs font-semibold uppercase text-gray-500">From</div>
                        <div class="mt-1 flex items-baseline gap-1">
                            <span class="text-3xl font-bold text-blue-700">KSh</span>
                            <span class="text-4xl font-bold text-blue-700">150,000</span>
                            <span class="text-sm text-gray-500">/month</span>
                        </div>
                    </div>

                    <ul class="mt-6 space-y-2 text-sm text-gray-700">
                        <li class="flex gap-2">
                            <span class="mt-1 h-4 w-4 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px]">✓</span>
                            <span>All Growth Tier benefits</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-1 h-4 w-4 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px]">✓</span>
                            <span>Unlimited contract drafting & review</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-1 h-4 w-4 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px]">✓</span>
                            <span>M&A legal advisory</span>
                        </li>
                    </ul>
                </div>

                <div class="mt-auto border-t px-6 py-4 space-y-2">
                    <button class="w-full inline-flex justify-center rounded-full bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                        Subscribe Now
                    </button>
                    <button class="w-full inline-flex justify-center rounded-full border border-gray-300 px-4 py-2.5 text-sm font-semibold text-gray-800 hover:bg-gray-50">
                        Contact Sales
                    </button>
                </div>
            </div>
        </div>

        {{-- CTA banner --}}
        <div class="mt-12 bg-blue-50 rounded-2xl px-8 py-10 text-center">
            <h3 class="text-xl font-semibold text-gray-900">
                Ready to Transform Your Legal Operations?
            </h3>
            <p class="mt-3 text-sm sm:text-base text-gray-600 max-w-2xl mx-auto">
                Whether you’re starting, scaling, or leading an enterprise, Modus Chora has a tier to support your legal needs.
                Not seeing exactly what you need? Our team is ready to craft a custom solution.
            </p>
            <div class="mt-6 flex flex-wrap justify-center gap-4">
                <a href="#" class="inline-flex items-center rounded-full bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                    Get a Custom Quote
                </a>
                <a href="{{ route('faq') }}" class="inline-flex items-center rounded-full border border-gray-300 px-6 py-2.5 text-sm font-semibold text-gray-800 hover:bg-gray-50">
                    Explore FAQs
                </a>
            </div>
        </div>
    </div>
</section>
@endsection