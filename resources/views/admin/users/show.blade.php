@extends('admin.layouts.app')

@section('title', 'User Details')
@section('page-title', 'User Details')

@section('content')

<div class="user-details-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="user-details-header">

        <div>

            <span class="user-details-eyebrow">
                USER MANAGEMENT
            </span>

            <h1>
                User Details
            </h1>

            <p>
                View account information and assigned roles
            </p>

        </div>

        <div class="user-details-actions">

            <a href="{{ route('admin.users.edit', $user) }}" class="user-details-btn edit">
                <i class="bi bi-pencil-square"></i>
                Edit
            </a>

            <a href="{{ route('admin.users.index') }}" class="user-details-btn back">
                <i class="bi bi-arrow-left"></i>
                Back
            </a>

        </div>

    </div>


    {{-- =====================================================
         PROFILE CARD
    ====================================================== --}}

    <div class="user-profile-card">

        <div class="user-profile-main">

            <div class="user-profile-avatar">

                {{ strtoupper(substr($user->name, 0, 1)) }}

            </div>

            <div class="user-profile-info">

                <h2>
                    {{ $user->name }}
                </h2>

                <span>
                    <i class="bi bi-envelope"></i>
                    {{ $user->email }}
                </span>

                <div class="user-profile-roles">

                    @forelse($user->roles as $role)

                    @php

                    $roleClass = match ($role->name) {

                    'admin' => 'admin',

                    'vendor' => 'vendor',

                    'customer',
                    'user' => 'customer',

                    default => 'default',

                    };

                    @endphp

                    <span class="user-details-role {{ $roleClass }}">

                        @if($role->name === 'admin')

                        <i class="bi bi-shield-fill-check"></i>

                        @elseif($role->name === 'vendor')

                        <i class="bi bi-shop"></i>

                        @elseif(in_array($role->name, ['customer', 'user']))

                        <i class="bi bi-person"></i>

                        @else

                        <i class="bi bi-person-badge"></i>

                        @endif

                        {{ ucfirst($role->name) }}

                    </span>

                    @empty

                    <span class="user-details-role default">
                        No Role
                    </span>

                    @endforelse

                </div>

            </div>

        </div>

        <div class="user-profile-id">

            <span>
                USER ID
            </span>

            <strong>
                #{{ $user->id }}
            </strong>

        </div>

    </div>


    {{-- =====================================================
         INFORMATION
    ====================================================== --}}

    <div class="user-details-grid">

        {{-- Account Information --}}

        <div class="user-info-card">

            <div class="user-info-card-header">

                <div class="user-info-title-icon">
                    <i class="bi bi-person"></i>
                </div>

                <div>

                    <strong>
                        Account Information
                    </strong>

                    <span>
                        Basic user information
                    </span>

                </div>

            </div>


            <div class="user-info-body">

                <div class="user-info-item">

                    <span>
                        Full Name
                    </span>

                    <strong>
                        {{ $user->name }}
                    </strong>

                </div>


                <div class="user-info-item">

                    <span>
                        Email Address
                    </span>

                    <strong class="break">
                        {{ $user->email }}
                    </strong>

                </div>


                <div class="user-info-item">

                    <span>
                        User ID
                    </span>

                    <strong>
                        #{{ $user->id }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- Roles --}}

        <div class="user-info-card">

            <div class="user-info-card-header">

                <div class="user-info-title-icon role">
                    <i class="bi bi-shield-check"></i>
                </div>

                <div>

                    <strong>
                        Roles & Permissions
                    </strong>

                    <span>
                        Assigned user roles
                    </span>

                </div>

            </div>


            <div class="user-info-body">

                <div class="user-role-list">

                    @forelse($user->roles as $role)

                    @php

                    $roleClass = match ($role->name) {

                    'admin' => 'admin',

                    'vendor' => 'vendor',

                    'customer',
                    'user' => 'customer',

                    default => 'default',

                    };

                    @endphp

                    <div class="user-role-row">

                        <div class="user-role-row-icon {{ $roleClass }}">

                            @if($role->name === 'admin')

                            <i class="bi bi-shield-fill-check"></i>

                            @elseif($role->name === 'vendor')

                            <i class="bi bi-shop"></i>

                            @elseif(in_array($role->name, ['customer', 'user']))

                            <i class="bi bi-person"></i>

                            @else

                            <i class="bi bi-person-badge"></i>

                            @endif

                        </div>

                        <div>

                            <strong>
                                {{ ucfirst($role->name) }}
                            </strong>

                            <span>
                                Assigned role
                            </span>

                        </div>

                    </div>

                    @empty

                    <div class="user-no-role">

                        <i class="bi bi-shield-x"></i>

                        <span>
                            No role assigned
                        </span>

                    </div>

                    @endforelse

                </div>

            </div>

        </div>


        {{-- Account Dates --}}

        <div class="user-info-card">

            <div class="user-info-card-header">

                <div class="user-info-title-icon date">
                    <i class="bi bi-calendar3"></i>
                </div>

                <div>

                    <strong>
                        Account Timeline
                    </strong>

                    <span>
                        Account activity dates
                    </span>

                </div>

            </div>


            <div class="user-info-body">

                <div class="user-info-item">

                    <span>
                        Created At
                    </span>

                    <strong>
                        {{ $user->created_at->format('M d, Y h:i A') }}
                    </strong>

                </div>


                <div class="user-info-item">

                    <span>
                        Last Updated
                    </span>

                    <strong>
                        {{ $user->updated_at->format('M d, Y h:i A') }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- Account Status --}}

        <div class="user-info-card">

            <div class="user-info-card-header">

                <div class="user-info-title-icon status">
                    <i class="bi bi-activity"></i>
                </div>

                <div>

                    <strong>
                        Account Overview
                    </strong>

                    <span>
                        User account summary
                    </span>

                </div>

            </div>


            <div class="user-info-body">

                <div class="user-overview-row">

                    <div>

                        <span>
                            Account
                        </span>

                        <strong>
                            Active
                        </strong>

                    </div>

                    <span class="user-active-badge">
                        <i class="bi bi-check-circle-fill"></i>
                        Active
                    </span>

                </div>


                <div class="user-overview-row">

                    <div>

                        <span>
                            Role Count
                        </span>

                        <strong>
                            {{ $user->roles->count() }}
                        </strong>

                    </div>

                    <i class="bi bi-shield-check user-overview-icon"></i>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection


@push('styles')

<style>
    /* =========================================================
   USER DETAILS
========================================================= */

    .user-details-page {
        width: 100%;
        max-width: 1500px;
        margin: 0 auto;

        color: #344054;
        font-size: 12px;
    }


    /* =========================================================
   HEADER
========================================================= */

    .user-details-header {
        min-height: 62px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        margin-bottom: 12px;
    }

    .user-details-eyebrow {
        display: block;

        margin-bottom: 3px;

        color: #98a2b3;

        font-size: 7px;
        font-weight: 700;

        letter-spacing: 1px;
    }

    .user-details-header h1 {
        margin: 0;

        color: #1d2939;

        font-size: 19px;
        font-weight: 700;
    }

    .user-details-header p {
        margin: 3px 0 0;

        color: #98a2b3;

        font-size: 8px;
    }

    .user-details-actions {
        display: flex;
        gap: 6px;
    }

    .user-details-btn {
        height: 31px;

        padding: 0 11px;

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;

        border-radius: 6px;

        font-size: 8px;
        font-weight: 600;

        text-decoration: none;

        transition: .16s ease;
    }

    .user-details-btn.edit {
        background: #fff5e9;
        color: #b66b16;
        border: 1px solid #f3d8ad;
    }

    .user-details-btn.edit:hover {
        background: #d98a25;
        border-color: #d98a25;
        color: #fff;
    }

    .user-details-btn.back {
        background: #fff;
        color: #667085;
        border: 1px solid #d0d5dd;
    }

    .user-details-btn.back:hover {
        background: #f8fafc;
        color: #344054;
    }


    /* =========================================================
   PROFILE CARD
========================================================= */

    .user-profile-card {
        min-height: 105px;

        padding: 15px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        margin-bottom: 12px;

        background: #fff;

        border: 1px solid #eaecf0;
        border-radius: 8px;
    }

    .user-profile-main {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-profile-avatar {
        width: 64px;
        height: 64px;

        flex: 0 0 64px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 50%;

        background: #eef6ff;
        color: #2878d8;

        font-size: 22px;
        font-weight: 700;
    }

    .user-profile-info h2 {
        margin: 0 0 4px;

        color: #344054;

        font-size: 15px;
        font-weight: 700;
    }

    .user-profile-info>span {
        display: flex;
        align-items: center;
        gap: 5px;

        color: #98a2b3;

        font-size: 8px;
    }

    .user-profile-info>span i {
        font-size: 9px;
    }

    .user-profile-roles {
        display: flex;
        flex-wrap: wrap;

        gap: 4px;

        margin-top: 7px;
    }

    .user-details-role {
        height: 20px;

        padding: 0 7px;

        display: inline-flex;
        align-items: center;
        gap: 4px;

        border-radius: 4px;

        font-size: 6px;
        font-weight: 700;
    }

    .user-details-role i {
        font-size: 7px;
    }

    .user-details-role.admin {
        background: #fff0f0;
        color: #c24141;
    }

    .user-details-role.vendor {
        background: #fff5e9;
        color: #b66b16;
    }

    .user-details-role.customer {
        background: #eef6ff;
        color: #2878d8;
    }

    .user-details-role.default {
        background: #f2f4f7;
        color: #667085;
    }

    .user-profile-id {
        min-width: 75px;

        padding-left: 15px;

        border-left: 1px solid #eaecf0;

        text-align: right;
    }

    .user-profile-id span {
        display: block;

        margin-bottom: 3px;

        color: #98a2b3;

        font-size: 6px;
        font-weight: 700;

        letter-spacing: .5px;
    }

    .user-profile-id strong {
        color: #344054;

        font-size: 12px;
    }


    /* =========================================================
   INFORMATION GRID
========================================================= */

    .user-details-grid {
        display: grid;

        grid-template-columns: repeat(2, minmax(0, 1fr));

        gap: 12px;
    }

    .user-info-card {
        overflow: hidden;

        background: #fff;

        border: 1px solid #eaecf0;
        border-radius: 8px;
    }

    .user-info-card-header {
        min-height: 53px;

        padding: 9px 12px;

        display: flex;
        align-items: center;
        gap: 8px;

        border-bottom: 1px solid #eaecf0;
    }

    .user-info-title-icon {
        width: 29px;
        height: 29px;

        flex: 0 0 29px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 6px;

        background: #eef6ff;
        color: #2878d8;

        font-size: 10px;
    }

    .user-info-title-icon.role {
        background: #f2efff;
        color: #7657c7;
    }

    .user-info-title-icon.date {
        background: #eefaf3;
        color: #2f9b63;
    }

    .user-info-title-icon.status {
        background: #fff5e9;
        color: #c47a1c;
    }

    .user-info-card-header strong {
        display: block;

        color: #344054;

        font-size: 9px;
        font-weight: 700;
    }

    .user-info-card-header span {
        display: block;

        margin-top: 2px;

        color: #98a2b3;

        font-size: 6px;
    }


    /* =========================================================
   INFO BODY
========================================================= */

    .user-info-body {
        padding: 4px 12px;
    }

    .user-info-item {
        min-height: 46px;

        padding: 8px 0;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;

        border-bottom: 1px solid #f2f4f7;
    }

    .user-info-item:last-child {
        border-bottom: 0;
    }

    .user-info-item>span {
        color: #98a2b3;

        font-size: 7px;
        font-weight: 600;
    }

    .user-info-item strong {
        max-width: 65%;

        color: #475467;

        font-size: 8px;
        font-weight: 600;

        text-align: right;
    }

    .user-info-item strong.break {
        overflow-wrap: anywhere;
    }


    /* =========================================================
   ROLE LIST
========================================================= */

    .user-role-list {
        padding: 5px 0;
    }

    .user-role-row {
        min-height: 48px;

        display: flex;
        align-items: center;

        gap: 8px;

        border-bottom: 1px solid #f2f4f7;
    }

    .user-role-row:last-child {
        border-bottom: 0;
    }

    .user-role-row-icon {
        width: 29px;
        height: 29px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 6px;

        font-size: 10px;
    }

    .user-role-row-icon.admin {
        background: #fff0f0;
        color: #c24141;
    }

    .user-role-row-icon.vendor {
        background: #fff5e9;
        color: #b66b16;
    }

    .user-role-row-icon.customer {
        background: #eef6ff;
        color: #2878d8;
    }

    .user-role-row-icon.default {
        background: #f2f4f7;
        color: #667085;
    }

    .user-role-row strong {
        display: block;

        color: #475467;

        font-size: 8px;
    }

    .user-role-row span {
        display: block;

        margin-top: 2px;

        color: #98a2b3;

        font-size: 6px;
    }

    .user-no-role {
        min-height: 75px;

        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;

        color: #98a2b3;

        font-size: 8px;
    }

    .user-no-role i {
        font-size: 12px;
    }


    /* =========================================================
   ACCOUNT OVERVIEW
========================================================= */

    .user-overview-row {
        min-height: 49px;

        padding: 7px 0;

        display: flex;
        align-items: center;
        justify-content: space-between;

        border-bottom: 1px solid #f2f4f7;
    }

    .user-overview-row:last-child {
        border-bottom: 0;
    }

    .user-overview-row>div span {
        display: block;

        color: #98a2b3;

        font-size: 7px;
    }

    .user-overview-row>div strong {
        display: block;

        margin-top: 2px;

        color: #475467;

        font-size: 8px;
    }

    .user-active-badge {
        height: 21px;

        padding: 0 7px;

        display: inline-flex;
        align-items: center;
        gap: 4px;

        border-radius: 4px;

        background: #eefaf3;
        color: #2f9b63;

        font-size: 6px;
        font-weight: 700;
    }

    .user-active-badge i {
        font-size: 7px;
    }

    .user-overview-icon {
        color: #98a2b3;

        font-size: 12px;
    }


    /* =========================================================
   RESPONSIVE
========================================================= */

    @media (max-width: 850px) {

        .user-details-grid {
            grid-template-columns: 1fr;
        }

        .user-profile-card {
            align-items: flex-start;
            gap: 15px;
        }

    }

    @media (max-width: 600px) {

        .user-details-header {
            align-items: flex-start;
            flex-direction: column;
            gap: 10px;
        }

        .user-profile-card {
            flex-direction: column;
        }

        .user-profile-id {
            width: 100%;

            padding: 8px 0 0;

            border-left: 0;
            border-top: 1px solid #eaecf0;

            text-align: left;
        }

    }

</style>

@endpush
