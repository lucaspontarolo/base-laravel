@extends('layouts.error')
@section('title', '404')

@section('content')
<div class="page-error">
    <div class="page-inner">
        <h1 class="text-warning">404</h1>
        <div class="page-description">
            <p class="mb-2">
                @if ($exception->getPrevious() instanceof \Illuminate\Database\Eloquent\ModelNotFoundException)
                    @lang('phrases.errors.titles.registry-not-found')
                @else
                    @lang('phrases.errors.titles.page-not-found')
                @endif
            </p>

            <p class="small">
                @lang('phrases.errors.messages.link-is-broken')
            </p>

            @include('errors._partials.return_buttons')
        </div>
    </div>
</div>
@endsection
