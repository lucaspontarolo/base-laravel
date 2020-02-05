@extends('layouts.app')
@section('title', __('headings.profile.index'))

@section('page-header')
    <h1>
        <i class="far fa-user fa-fw mr-2 text-muted"></i>
        @lang('headings.profile.index')
    </h1>
    <breadcrumb>
        <breadcrumb-item href="{{ route('home') }}">
            @lang('breadcrumb.common.home')
        </breadcrumb-item>

        <breadcrumb-item active>
            @lang('breadcrumb.profile.index')
        </breadcrumb-item>
    </breadcrumb>
@endsection

@section('content')
    <div class="card card-secondary">
        <form class="form-horizontal" method="POST" action="{{ route('client.profile.update') }}">
            @method('PUT')
            <div class="card-body pb-0">
                @include('client.profile._partials.form')
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button class="btn btn-success shadow-sm ml-1" type="submit">
                        <i class="fas fa-save fa-sm text-white-50"></i> @lang('buttons.common.save')
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
