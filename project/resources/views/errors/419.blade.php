@extends('layouts.error')
@section('title', '404')

@section('content')
<div class="page-error">
    <div class="page-inner">
        <h1 class="">419</h1>
        <div class="page-description">
            <p class="mb-2">
                @lang('phrases.errors.titles.page-expired')
            </p>

            <p class="small">
                @lang('phrases.errors.messages.page-expired')
            </p>

            @include('errors._partials.return_buttons')
        </div>
    </div>
</div>
@endsection
