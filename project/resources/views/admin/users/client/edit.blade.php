@extends('layouts.app')
@section('title', __('headings.client-users.edit'))

@section('page-header')
    <h1>
        <i class="fas fa-users fa-fw mr-2 text-muted"></i>
        @lang('headings.client-users.edit')
    </h1>
    <breadcrumb>
        <breadcrumb-item href="{{ route('home') }}">
            @lang('breadcrumb.common.home')
        </breadcrumb-item>

        <breadcrumb-item href="{{ route('admin.client-users.index') }}">
            @lang('breadcrumb.users-client.index')
        </breadcrumb-item>

        <breadcrumb-item active>
            @lang('breadcrumb.common.edit')
        </breadcrumb-item>
    </breadcrumb>
@endsection

@section('content')
<div class="card card-secondary">
    <form class="form-horizontal" method="POST" action="{{ route('admin.client-users.update', $user->id) }}">
        @method('PUT')
        <div class="card-body pb-0">
            @include('admin.users.client._partials.form')
        </div>
        <div class="card-footer">
            @include('shared.update_buttons', ['urlBack' => route('admin.client-users.index')])
        </div>
    </form>
</div>
@endsection
