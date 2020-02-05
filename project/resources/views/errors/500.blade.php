@extends('layouts.error')
@section('title', '404')

@section('content')
<div class="page-error">
    <div class="page-inner">
        <h1 class="text-danger">500</h1>
        <div class="page-description">
            <p class="mb-2">
                @lang('phrases.errors.titles.internal-server-error')
            </p>

            <p class="small">
                @lang('phrases.errors.messages.internal-server-error')
            </p>

            @include('errors._partials.return_buttons')
        </div>
    </div>
</div>
@endsection
