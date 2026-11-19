@extends('layouts.portal')
@section('title', 'Border Tax Entry')
@section('content')

        <div class="hero-banner">
            {{-- Left: apna logo --}}
            <div class="hero-side">
                <svg width="150" height="52" viewBox="0 0 150 52" xmlns="http://www.w3.org/2000/svg" aria-label="Beniwal Parivahan logo">
                    <rect x="0" y="4" width="44" height="44" rx="10" fill="#1d4ed8"/>
                    <text x="22" y="37" text-anchor="middle" font-family="Segoe UI, Arial" font-weight="800" font-size="28" fill="#fff">B</text>
                    <text x="54" y="27" font-family="Segoe UI, Arial" font-weight="800" font-size="17" fill="#0b1f4d">BENIWAL</text>
                    <text x="54" y="44" font-family="Segoe UI, Arial" font-weight="700" font-size="13" fill="#1d4ed8" letter-spacing="1">PARIVAHAN</text>
                </svg>
            </div>

            {{-- Center: title --}}
            <div class="hero-title">
                <h2>BENIWAL PARIVAHAN</h2>
                <p>Transport Vendor Management</p>
            </div>

            {{-- Right: truck icon + tagline --}}
            <div class="hero-side hero-side-right">
                <svg width="110" height="52" viewBox="0 0 110 52" xmlns="http://www.w3.org/2000/svg" aria-label="Truck">
                    <rect x="2" y="12" width="56" height="28" rx="3" fill="#1d4ed8"/>
                    <path d="M60 20h22l12 10v10H60z" fill="#0b1f4d"/>
                    <rect x="66" y="24" width="12" height="8" fill="#dbeafe"/>
                    <circle cx="22" cy="42" r="6" fill="#0f172a"/><circle cx="22" cy="42" r="2.5" fill="#fff"/>
                    <circle cx="78" cy="42" r="6" fill="#0f172a"/><circle cx="78" cy="42" r="2.5" fill="#fff"/>
                    <path d="M2 49h106" stroke="#93c5fd" stroke-width="2" stroke-dasharray="6 5"/>
                </svg>
                <span class="hero-tag">Safe &middot; Simple &middot; On Time</span>
            </div>
        </div>
        
    <div class="panel">
        <div class="panel-head">Select State and Service</div>
        <div class="panel-body">
            <form class="select-grid" method="GET" action="{{ route('vendor.entries.create') }}">
                <div class="field">
                    <label for="state">Visiting State</label>
                    <select id="state" name="state" required>
                        <option value="">--- Select State ---</option>
                        @foreach (config('states') as $state)
                            <option value="{{ $state }}">{{ $state }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label for="service">Service Name</label>
                    <select id="service" name="service" required>
                        <option value="">--- Select Service Name ---</option>
                        <option>Vehicle Tax Collection (Other State)</option>
                        <option>Vehicle Tax Collection (NCR)</option>
                    </select>
                </div>

                <div class="select-action">
                    <button type="submit" class="btn">Continue</button>
                </div>
            </form>
        </div>
    </div>

    <div class="panel">
        <div class="panel-head">How it works</div>
        <div class="panel-body">
            <ol class="steps">
                <li>Select the state you are travelling to from the <strong>Visiting State</strong> list.</li>
                <li>Select the service from the <strong>Service Name</strong> list:
                    <ol type="i">
                        <li>Choose <strong>Vehicle Tax Collection (Other State)</strong> if you do not have an NCR permit.</li>
                        <li>Choose <strong>Vehicle Tax Collection (NCR)</strong> if you have an NCR permit.</li>
                    </ol>
                </li>
                <li>Click <strong>Continue</strong> to open the vehicle details form.</li>
                <li>Enter the vehicle number and fill in the vehicle and owner details.</li>
                <li>Enter the tax amount you paid and the receipt number.</li>
                <li>Save the entry. It will appear in your entries list.</li>
            </ol>
            <p class="note">Note: Tax is paid only on the official government portal. This page is used to record your entries.</p>
        </div>
    </div>
@endsection