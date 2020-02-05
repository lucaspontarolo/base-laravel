@extends('layouts.auth')
@section('title', __('headings.auth.password_reset'))

@section('content')

<div class="card card-primary">
    <div class="card-header">
        <h4>@lang('headings.auth.password_reset')</h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('password.change') }}" class="needs-validation" novalidate="">
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

                <div class="form-group floating-addon">
                    <label for="password">
                        @lang('labels.common.password')
                    </label>
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

                <div class="form-group floating-addon">
                    <label for="password_confirmation">
                        @lang('labels.common.password_confirmation')
                    </label>
                    <div class="input-group {{ has_error_class('password_confirmation') }}">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-asterisk"></i>
                            </span>
                        </div>
                        <input type="password" name="password_confirmation" autocomplete="new-password" tabindex="2" required
                            class="form-control {{ has_error_class('password') }}"
                            placeholder="@lang('placeholders.users.password_confirmation')">
                    </div>
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="3">
                        @lang('buttons.auth.redefine_password')
                    </button>
                </div>

                <input type="hidden" name="token" value="{{ $token }}">
            @endif
        </form>
    </div>
</div>
@endsection
