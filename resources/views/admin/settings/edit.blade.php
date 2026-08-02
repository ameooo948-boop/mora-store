@extends('admin.layouts.app')

@section('title', 'Settings')

@section('page-title', 'Settings')

@section('content')

<div class="container-fluid">

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">

        @csrf

        @method('PUT')

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white">

                <ul class="nav nav-tabs card-header-tabs" id="settingsTabs" role="tablist">

                    <li class="nav-item">

                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#general" type="button">

                            General

                        </button>

                    </li>

                    <li class="nav-item">

                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#store" type="button">

                            Store

                        </button>

                    </li>

                    <li class="nav-item">

                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#contact" type="button">

                            Contact

                        </button>

                    </li>

                    <li class="nav-item">

                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#social" type="button">

                            Social

                        </button>

                    </li>

                    <li class="nav-item">

                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#system" type="button">

                            System

                        </button>

                    </li>

                </ul>

            </div>

            <div class="card-body">

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="general">

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Site Name

                                </label>

                                <input type="text" name="site_name" class="form-control" value="{{ old('site_name', setting('site_name')) }}">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Site Logo

                                </label>

                                <input type="file" name="site_logo" class="form-control">

                            </div>

                            <div class="col-12 mb-3">

                                <label class="form-label">

                                    Description

                                </label>

                                <textarea name="site_description" rows="4" class="form-control">{{ old('site_description', setting('site_description')) }}</textarea>

                            </div>

                            <div class="col-md-6">

                                <label class="form-label">

                                    Favicon

                                </label>

                                <input type="file" name="site_favicon" class="form-control">

                            </div>

                        </div>

                    </div>

                    <div class="tab-pane fade" id="store">

                        <div class="row">

                            <div class="col-md-4 mb-3">

                                <label class="form-label">

                                    Currency

                                </label>

                                <select name="currency" class="form-select">

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

                            <div class="col-md-4 mb-3">

                                <label class="form-label">

                                    Currency Symbol

                                </label>

                                <input type="text" name="currency_symbol" class="form-control" value="{{ old('currency_symbol', setting('currency_symbol')) }}">

                            </div>

                            <div class="col-md-4 mb-3">

                                <label class="form-label">

                                    Shipping Cost

                                </label>

                                <input type="number" step="0.01" min="0" name="shipping_cost" class="form-control" value="{{ old('shipping_cost', setting('shipping_cost',0)) }}">

                            </div>

                            <div class="col-md-4">

                                <label class="form-label">

                                    Tax %

                                </label>

                                <input type="number" step="0.01" min="0" name="tax_percentage" class="form-control" value="{{ old('tax_percentage', setting('tax_percentage',0)) }}">

                            </div>

                        </div>

                    </div>

                    <div class="tab-pane fade" id="contact">

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Email

                                </label>

                                <input type="email" name="email" class="form-control" value="{{ old('email', setting('email')) }}">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Phone

                                </label>

                                <input type="text" name="phone" class="form-control" value="{{ old('phone', setting('phone')) }}">

                            </div>

                            <div class="col-12">

                                <label class="form-label">

                                    Address

                                </label>

                                <textarea name="address" rows="4" class="form-control">{{ old('address', setting('address')) }}</textarea>

                            </div>

                        </div>

                    </div>

                    <div class="tab-pane fade" id="social">

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Facebook

                                </label>

                                <input type="url" name="facebook" class="form-control" value="{{ old('facebook', setting('facebook')) }}">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Instagram

                                </label>

                                <input type="url" name="instagram" class="form-control" value="{{ old('instagram', setting('instagram')) }}">

                            </div>

                            <div class="col-md-6">

                                <label class="form-label">

                                    LinkedIn

                                </label>

                                <input type="url" name="linkedin" class="form-control" value="{{ old('linkedin', setting('linkedin')) }}">

                            </div>

                        </div>

                    </div>

                    <div class="tab-pane fade" id="system">

                        <div class="form-check form-switch">

                            <input class="form-check-input" type="checkbox" name="maintenance_mode" value="1" @checked(setting('maintenance_mode'))>

                            <label class="form-check-label">

                                Enable Maintenance Mode

                            </label>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card-footer bg-white text-end">

                <button class="btn btn-primary">

                    <i class="bi bi-check-circle me-2"></i>

                    Save Settings

                </button>

            </div>

        </div>

    </form>

</div>

@endsection
