@extends('layouts.app')
@section('title', __('headings.client-users.show'))

@section('page-header')
    <h1>
        <i class="fas fa-user-alt fa-fw mr-2 text-muted"></i>
        @lang('headings.client-users.show')
    </h1>
    <breadcrumb>
        <breadcrumb-item href="{{ route('home') }}">
            @lang('breadcrumb.common.home')
        </breadcrumb-item>

        <breadcrumb-item href="{{ route('admin.client-users.index') }}">
            @lang('breadcrumb.users-client.index')
        </breadcrumb-item>

        <breadcrumb-item active>
            @lang('breadcrumb.common.show')
        </breadcrumb-item>
    </breadcrumb>
@endsection

@section('content')
<div class="card card-secondary">
    <div class="card-body pb-0">
        <div class="form-row">
            <div class="form-group col-sm-6">
                <label>@lang('labels.common.name')</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-user"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control" value="{{ $user->name ?? '' }}" disabled>
                </div>
            </div>

            <div class="form-group col-sm-6">
                <label>@lang('labels.common.email')</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-at"></i>
                        </span>
                    </div>
                    <input type="email" class="form-control" value="{{ $user->email ?? '' }}" disabled>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-sm-6">
                <label>@lang('labels.common.created_at')</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control" value="{{ format_date($user->created_at) ?? '' }}" disabled>
                </div>
            </div>

            <div class="form-group col-sm-6">
                <label>@lang('labels.common.updated_at')</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control" value="{{ format_date($user->updated_at) ?? '' }}" disabled>
                </div>
            </div>
        </div>

        <div class="card-footer">
            @include('shared.show_buttons', [
                'urlBack' => route('admin.client-users.index'),
                'urlEdit' => route('admin.client-users.edit', $user->id)
            ])
        </div>
    </div>
</div>
@endsection
