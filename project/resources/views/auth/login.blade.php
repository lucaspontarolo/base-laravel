@extends('layouts.auth')
@section('title', __('headings.auth.login'))

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h4>@lang('headings.auth.login')</h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('login') }}" class="needs-validation">
            @csrf
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

            <div class="form-group floating-addon">
                <label for="password" class="form-control-label">
                    @lang('labels.common.password')
                </label>
                <div class="float-right">
                    <a href="{{ route('password.request') }}" class="text-small"  tabindex="999">
                        @lang('links.auth.forgot_your_password')
                    </a>
                </div>
                <div class="input-group {{ has_error_class('password') }}">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-asterisk"></i>
                        </span>
                    </div>
                    <input type="password" name="password" autocomplete="new-password" tabindex="2" required
                        class="form-control {{ has_error_class('password') }}"
                        placeholder="@lang('placeholders.auth.password')">
                </div>
                @errorblock('password')
            </div>

            <div class="form-group mb-0">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="3">
                    @lang('buttons.common.access')
                </button>
            </div>
        </form>
    </div>
</div>
@endsection