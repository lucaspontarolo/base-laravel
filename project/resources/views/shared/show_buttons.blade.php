<div class="text-center">
    <a class="btn btn-light" href="{{ $urlBack ?? URL::previous() }}">
        <i class="fas fa-undo fa-fw"></i>
        @lang('buttons.common.back')
    </a>

    @if (isset($urlEdit))
        <a class="btn btn-warning" href="{{ $urlEdit }}">
            <i class="fas fa-pencil-alt fa-fw"></i>
            @lang('buttons.common.edit')
        </a>
    @endif
</div>
