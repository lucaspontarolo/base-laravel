@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card border-0">
            <div class="card-header border-0">
                <h3 class="text-center txt-primary">
                    @lang('auth.verify.email')
                </h3>
            </div>

            <div class="card-body text-center">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        @lang('auth.verify.resent')
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @lang('auth.verify.proceed')
                @lang('auth.verify.not_received'),
                <a href="{{ route('verification.resend') }}">
                    @lang('auth.verify.click_here')
                </a>.
            </div>
        </div>
    </div>
@endsection
