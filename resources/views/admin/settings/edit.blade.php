@extends('admin.layouts.app')

@section('title', 'Settings')
@section('page-title', 'Settings')

@section('content')

<div class="settings-page">

    {{-- Header --}}
    <div class="settings-page-header">

        <div>
            <span class="settings-eyebrow">
                SYSTEM CONFIGURATION
            </span>

            <h1>
                Settings
            </h1>

            <p>
                Manage your store configuration and preferences
            </p>
        </div>

        <div class="settings-status">
            <i class="bi bi-shield-check"></i>
            Admin Settings
        </div>

    </div>


    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method('PUT')


        <div class="settings-card">

            {{-- =====================================================
                 TABS
            ====================================================== --}}

            <div class="settings-tabs-wrapper">

                <div class="settings-tabs" id="settingsTabs" role="tablist">

                    <button class="settings-tab active" data-bs-toggle="tab" data-bs-target="#general" type="button">
                        <i class="bi bi-building"></i>
                        <span>General</span>
                    </button>

                    <button class="settings-tab" data-bs-toggle="tab" data-bs-target="#store" type="button">
                        <i class="bi bi-shop"></i>
                        <span>Store</span>
                    </button>

                    <button class="settings-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button">
                        <i class="bi bi-headset"></i>
                        <span>Contact</span>
                    </button>

                    <button class="settings-tab" data-bs-toggle="tab" data-bs-target="#social" type="button">
                        <i class="bi bi-share"></i>
                        <span>Social</span>
                    </button>

                    <button class="settings-tab" data-bs-toggle="tab" data-bs-target="#system" type="button">
                        <i class="bi bi-sliders"></i>
                        <span>System</span>
                    </button>

                </div>

            </div>


            {{-- =====================================================
                 TAB CONTENT
            ====================================================== --}}

            <div class="settings-content">

                <div class="tab-content">


                    {{-- =================================================
                         GENERAL
                    ================================================== --}}

                    <div class="tab-pane fade show active" id="general">

                        <div class="settings-section-heading">

                            <div class="settings-section-icon blue">
                                <i class="bi bi-building"></i>
                            </div>

                            <div>

                                <h3>
                                    General Settings
                                </h3>

                                <p>
                                    Basic information about your store
                                </p>

                            </div>

                        </div>


                        <div class="row g-3">

                            {{-- Site Name --}}
                            <div class="col-md-6">

                                <label class="settings-label">
                                    Site Name
                                </label>

                                <input type="text" name="site_name" class="settings-input" value="{{ old('site_name', setting('site_name')) }}" placeholder="Enter site name">

                            </div>


                            {{-- Site Logo --}}
                            <div class="col-md-6">

                                <label class="settings-label">
                                    Site Logo
                                </label>

                                <input type="file" name="site_logo" class="settings-input settings-file">

                            </div>


                            {{-- Description --}}
                            <div class="col-12">

                                <label class="settings-label">
                                    Site Description
                                </label>

                                <textarea name="site_description" rows="4" class="settings-input settings-textarea" placeholder="Write a short description about your store...">{{ old('site_description', setting('site_description')) }}</textarea>

                            </div>


                            {{-- Favicon --}}
                            <div class="col-md-6">

                                <label class="settings-label">
                                    Favicon
                                </label>

                                <input type="file" name="site_favicon" class="settings-input settings-file">

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         STORE
                    ================================================== --}}

                    <div class="tab-pane fade" id="store">

                        <div class="settings-section-heading">

                            <div class="settings-section-icon green">
                                <i class="bi bi-shop"></i>
                            </div>

                            <div>

                                <h3>
                                    Store Settings
                                </h3>

                                <p>
                                    Configure pricing, currency and shipping
                                </p>

                            </div>

                        </div>


                        <div class="row g-3">

                            {{-- Currency --}}
                            <div class="col-md-4">

                                <label class="settings-label">
                                    Currency
                                </label>

                                <select name="currency" class="settings-input settings-select">

                                    <option value="EGP" @selected(setting('currency')=='EGP' )>
                                        EGP
                                    </option>

                                    <option value="USD" @selected(setting('currency')=='USD' )>
                                        USD
                                    </option>

                                    <option value="SAR" @selected(setting('currency')=='SAR' )>
                                        SAR
                                    </option>

                                </select>

                            </div>


                            {{-- Currency Symbol --}}
                            <div class="col-md-4">

                                <label class="settings-label">
                                    Currency Symbol
                                </label>

                                <input type="text" name="currency_symbol" class="settings-input" value="{{ old('currency_symbol', setting('currency_symbol')) }}" placeholder="EGP">

                            </div>


                            {{-- Shipping --}}
                            <div class="col-md-4">

                                <label class="settings-label">
                                    Shipping Cost
                                </label>

                                <input type="number" step="0.01" min="0" name="shipping_cost" class="settings-input" value="{{ old('shipping_cost', setting('shipping_cost', 0)) }}">

                            </div>


                            {{-- Tax --}}
                            <div class="col-md-4">

                                <label class="settings-label">
                                    Tax Percentage
                                </label>

                                <div class="settings-input-group">

                                    <input type="number" step="0.01" min="0" name="tax_percentage" class="settings-input" value="{{ old('tax_percentage', setting('tax_percentage', 0)) }}">

                                    <span>%</span>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         CONTACT
                    ================================================== --}}

                    <div class="tab-pane fade" id="contact">

                        <div class="settings-section-heading">

                            <div class="settings-section-icon purple">
                                <i class="bi bi-headset"></i>
                            </div>

                            <div>

                                <h3>
                                    Contact Information
                                </h3>

                                <p>
                                    Information customers can use to contact you
                                </p>

                            </div>

                        </div>


                        <div class="row g-3">

                            {{-- Email --}}
                            <div class="col-md-6">

                                <label class="settings-label">
                                    Email Address
                                </label>

                                <input type="email" name="email" class="settings-input" value="{{ old('email', setting('email')) }}" placeholder="support@example.com">

                            </div>


                            {{-- Phone --}}
                            <div class="col-md-6">

                                <label class="settings-label">
                                    Phone Number
                                </label>

                                <input type="text" name="phone" class="settings-input" value="{{ old('phone', setting('phone')) }}" placeholder="+20 100 000 0000">

                            </div>


                            {{-- Address --}}
                            <div class="col-12">

                                <label class="settings-label">
                                    Store Address
                                </label>

                                <textarea name="address" rows="4" class="settings-input settings-textarea" placeholder="Enter store address...">{{ old('address', setting('address')) }}</textarea>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         SOCIAL
                    ================================================== --}}

                    <div class="tab-pane fade" id="social">

                        <div class="settings-section-heading">

                            <div class="settings-section-icon pink">
                                <i class="bi bi-share"></i>
                            </div>

                            <div>

                                <h3>
                                    Social Media
                                </h3>

                                <p>
                                    Connect your store with social platforms
                                </p>

                            </div>

                        </div>


                        <div class="row g-3">

                            {{-- Facebook --}}
                            <div class="col-md-6">

                                <label class="settings-label">
                                    <i class="bi bi-facebook"></i>
                                    Facebook
                                </label>

                                <input type="url" name="facebook" class="settings-input" value="{{ old('facebook', setting('facebook')) }}" placeholder="https://facebook.com/...">

                            </div>


                            {{-- Instagram --}}
                            <div class="col-md-6">

                                <label class="settings-label">
                                    <i class="bi bi-instagram"></i>
                                    Instagram
                                </label>

                                <input type="url" name="instagram" class="settings-input" value="{{ old('instagram', setting('instagram')) }}" placeholder="https://instagram.com/...">

                            </div>


                            {{-- LinkedIn --}}
                            <div class="col-md-6">

                                <label class="settings-label">
                                    <i class="bi bi-linkedin"></i>
                                    LinkedIn
                                </label>

                                <input type="url" name="linkedin" class="settings-input" value="{{ old('linkedin', setting('linkedin')) }}" placeholder="https://linkedin.com/...">

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         SYSTEM
                    ================================================== --}}

                    <div class="tab-pane fade" id="system">

                        <div class="settings-section-heading">

                            <div class="settings-section-icon orange">
                                <i class="bi bi-sliders"></i>
                            </div>

                            <div>

                                <h3>
                                    System Settings
                                </h3>

                                <p>
                                    Control system-wide store behavior
                                </p>

                            </div>

                        </div>


                        <div class="settings-option">

                            <div class="settings-option-icon">
                                <i class="bi bi-tools"></i>
                            </div>

                            <div class="settings-option-content">

                                <strong>
                                    Maintenance Mode
                                </strong>

                                <span>
                                    Temporarily disable the storefront while you perform maintenance.
                                </span>

                            </div>

                            <div class="form-check form-switch settings-switch">

                                <input class="form-check-input" type="checkbox" name="maintenance_mode" value="1" @checked(setting('maintenance_mode'))>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 FOOTER
            ====================================================== --}}

            <div class="settings-footer">

                <div class="settings-save-info">

                    <i class="bi bi-info-circle"></i>

                    <span>
                        Changes will be applied immediately.
                    </span>

                </div>

                <button type="submit" class="settings-save-btn">

                    <i class="bi bi-check-lg"></i>

                    Save Settings

                </button>

            </div>

        </div>

    </form>

</div>

@endsection

@push('styles')

<style>
    /* =========================================================
   SETTINGS PAGE
========================================================= */

    .settings-page {

        width: 100%;
        max-width: 1500px;

        margin: 0 auto;

        color: #344054;

        font-size: 12px;
    }


    /* =========================================================
   HEADER
========================================================= */

    .settings-page-header {

        min-height: 62px;

        display: flex;

        align-items: center;

        justify-content: space-between;

        margin-bottom: 12px;

    }

    .settings-eyebrow {

        display: block;

        margin-bottom: 3px;

        color: #98a2b3;

        font-size: 7px;

        font-weight: 700;

        letter-spacing: 1px;

    }

    .settings-page-header h1 {

        margin: 0;

        color: #1d2939;

        font-size: 19px;

        font-weight: 700;

    }

    .settings-page-header p {

        margin: 3px 0 0;

        color: #98a2b3;

        font-size: 8px;

    }

    .settings-status {

        height: 29px;

        padding: 0 9px;

        display: inline-flex;

        align-items: center;

        gap: 5px;

        border: 1px solid #d9e8ff;

        border-radius: 5px;

        background: #f5f9ff;

        color: #2878d8;

        font-size: 7px;

        font-weight: 700;

    }

    .settings-status i {

        font-size: 9px;

    }


    /* =========================================================
   MAIN CARD
========================================================= */

    .settings-card {

        overflow: hidden;

        background: #fff;

        border: 1px solid #eaecf0;

        border-radius: 8px;

    }


    /* =========================================================
   TABS
========================================================= */

    .settings-tabs-wrapper {

        padding: 0 14px;

        background: #fff;

        border-bottom: 1px solid #eaecf0;

    }

    .settings-tabs {

        min-height: 52px;

        display: flex;

        align-items: stretch;

        gap: 3px;

    }

    .settings-tab {

        position: relative;

        min-width: 90px;

        padding: 0 12px;

        display: inline-flex;

        align-items: center;

        justify-content: center;

        gap: 6px;

        border: 0;

        background: transparent;

        color: #98a2b3;

        font-size: 8px;

        font-weight: 600;

        cursor: pointer;

        transition: .15s ease;

    }

    .settings-tab i {

        font-size: 10px;

    }

    .settings-tab:hover {

        color: #475467;

        background: #fafbfc;

    }

    .settings-tab.active {

        color: #2878d8;

    }

    .settings-tab.active::after {

        content: '';

        position: absolute;

        bottom: -1px;

        left: 12px;

        right: 12px;

        height: 2px;

        border-radius: 2px 2px 0 0;

        background: #2878d8;

    }


    /* =========================================================
   CONTENT
========================================================= */

    .settings-content {

        padding: 17px;

        min-height: 310px;

    }


    /* =========================================================
   SECTION HEADING
========================================================= */

    .settings-section-heading {

        display: flex;

        align-items: center;

        gap: 8px;

        margin-bottom: 16px;

        padding-bottom: 12px;

        border-bottom: 1px solid #f2f4f7;

    }

    .settings-section-icon {

        width: 31px;
        height: 31px;

        flex: 0 0 31px;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 6px;

        font-size: 11px;

    }

    .settings-section-icon.blue {

        background: #eef6ff;
        color: #2878d8;

    }

    .settings-section-icon.green {

        background: #eefaf3;
        color: #2f9b63;

    }

    .settings-section-icon.purple {

        background: #f3efff;
        color: #7657c7;

    }

    .settings-section-icon.pink {

        background: #fff0f5;
        color: #d05b85;

    }

    .settings-section-icon.orange {

        background: #fff5e9;
        color: #c47a1c;

    }

    .settings-section-heading h3 {

        margin: 0;

        color: #344054;

        font-size: 10px;

        font-weight: 700;

    }

    .settings-section-heading p {

        margin: 2px 0 0;

        color: #98a2b3;

        font-size: 6px;

    }


    /* =========================================================
   LABELS
========================================================= */

    .settings-label {

        display: block;

        margin-bottom: 5px;

        color: #475467;

        font-size: 7px;

        font-weight: 700;

    }

    .settings-label i {

        margin-right: 3px;

        font-size: 8px;

    }


    /* =========================================================
   INPUTS
========================================================= */

    .settings-input {

        width: 100%;

        height: 34px;

        padding: 0 10px;

        border: 1px solid #d0d5dd;

        border-radius: 5px;

        background: #fff;

        color: #344054;

        font-size: 8px;

        outline: none;

        transition: .15s ease;

    }

    .settings-input::placeholder {

        color: #98a2b3;

    }

    .settings-input:hover {

        border-color: #b8c0cc;

    }

    .settings-input:focus {

        border-color: #84adff;

        box-shadow: 0 0 0 2px rgba(47, 128, 237, .07);

    }

    .settings-textarea {

        height: auto;

        min-height: 88px;

        padding-top: 9px;

        resize: vertical;

    }

    .settings-file {

        padding: 7px 9px;

        cursor: pointer;

    }

    .settings-select {

        cursor: pointer;

    }


    /* =========================================================
   INPUT GROUP
========================================================= */

    .settings-input-group {

        position: relative;

    }

    .settings-input-group .settings-input {

        padding-right: 28px;

    }

    .settings-input-group>span {

        position: absolute;

        top: 50%;

        right: 9px;

        transform: translateY(-50%);

        color: #98a2b3;

        font-size: 8px;

        font-weight: 600;

    }


    /* =========================================================
   SYSTEM OPTION
========================================================= */

    .settings-option {

        min-height: 74px;

        padding: 13px;

        display: flex;

        align-items: center;

        gap: 10px;

        border: 1px solid #eaecf0;

        border-radius: 7px;

        background: #fafbfc;

    }

    .settings-option-icon {

        width: 34px;
        height: 34px;

        flex: 0 0 34px;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 7px;

        background: #fff5e9;

        color: #c47a1c;

        font-size: 12px;

    }

    .settings-option-content {

        flex: 1;

    }

    .settings-option-content strong {

        display: block;

        color: #344054;

        font-size: 8px;

        font-weight: 700;

    }

    .settings-option-content span {

        display: block;

        max-width: 600px;

        margin-top: 3px;

        color: #98a2b3;

        font-size: 6px;

        line-height: 1.5;

    }


    /* =========================================================
   SWITCH
========================================================= */

    .settings-switch {

        margin: 0;

    }

    .settings-switch .form-check-input {

        width: 34px;

        height: 18px;

        margin: 0;

        cursor: pointer;

    }

    .settings-switch .form-check-input:focus {

        box-shadow: none;

    }


    /* =========================================================
   FOOTER
========================================================= */

    .settings-footer {

        min-height: 54px;

        padding: 10px 16px;

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 10px;

        background: #fafbfc;

        border-top: 1px solid #eaecf0;

    }

    .settings-save-info {

        display: flex;

        align-items: center;

        gap: 5px;

        color: #98a2b3;

        font-size: 6px;

    }

    .settings-save-info i {

        color: #98a2b3;

        font-size: 8px;

    }

    .settings-save-btn {

        height: 30px;

        padding: 0 12px;

        display: inline-flex;

        align-items: center;

        justify-content: center;

        gap: 5px;

        border: 1px solid #2878d8;

        border-radius: 5px;

        background: #2878d8;

        color: #fff;

        font-size: 7px;

        font-weight: 700;

        cursor: pointer;

        transition: .15s ease;

    }

    .settings-save-btn:hover {

        background: #1f6bc4;

        border-color: #1f6bc4;

    }

    .settings-save-btn i {

        font-size: 8px;

    }


    /* =========================================================
   RESPONSIVE
========================================================= */

    @media (max-width: 768px) {

        .settings-page-header {

            align-items: flex-start;

            flex-direction: column;

            gap: 9px;

        }

        .settings-tabs-wrapper {

            overflow-x: auto;

        }

        .settings-tabs {

            min-width: max-content;

        }

        .settings-content {

            padding: 12px;

        }

        .settings-footer {

            align-items: flex-start;

            flex-direction: column;

        }

        .settings-save-btn {

            width: 100%;

        }

    }

</style>

@endpush
