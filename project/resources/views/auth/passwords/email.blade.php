@extends('layouts.auth')
@section('title', __('headings.auth.account_recover'))

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h4>@lang('headings.auth.account_recover')</h4>
    </div>

    <div class="card-body">
        <p class="mb-3">@lang('phrases.auth.account_recover')</p>
        <form method="POST" action="{{ route('password.email') }}" class="needs-validation" novalidate="">
            @csrf

            @if (session('status'))
                <div class="alert alert-success mb-0">
                    <i class="far fa-lightbulb fa-fw mr-1"></i>{{ session('status') }}
                </div>
            @else
                <div class="form-group floating-addon">
                    <label for="email">
                        @lang('labels.common.email')
                    </label>
                    <div class="input-group {{ has_error_class('email') }}">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-at"></i>
                            </span>
                        </div>
                        <input type="email" name="email" tabindex="1" autofocus required
                            class="form-control {{ has_error_class('email') }}"
                            placeholder="@lang('placeholders.auth.email')"
                            value="{{old('email', $user->email ?? '')}}">
                    </div>
                    @errorblock('email')
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="3">
                        @lang('buttons.auth.send_redefinition_link')
                    </button>
                </div>
            @endif
        </form>
    </div>
    <div class="card-footer bg-whitesmoke text-center p-3">
        <a class="small" href="{{ route('login') }}">
            <i class="fas fa-arrow-left mr-1 fa-fw"></i>
            @lang('links.auth.back_to_login')
        </a>
    </div>
</div>
@endsection
