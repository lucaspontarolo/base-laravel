<div class="text-center">
    <a href="{{ $urlBack ?? URL::previous() }}" class="btn btn-light shadow-sm">
        <i class="fas fa-undo fa-sm text-gray-600"></i> @lang('buttons.common.back')
    </a>
    <button class="btn btn-success shadow-sm ml-1" type="submit">
        <i class="fas fa-save fa-sm text-white-50"></i> @lang('buttons.common.save')
    </button>
</div>
