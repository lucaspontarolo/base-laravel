@csrf

<div class="form-row">
    <div class="form-group floating-addon col-sm-6">
        <label for="name">
            @lang('labels.common.name')<span class="text-danger ml-1">*</span>
        </label>
        <div class="input-group {{ has_error_class('name') }}">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="far fa-user"></i>
                </span>
            </div>
            <input type="text" name="name" class="form-control {{ has_error_class('name') }}"
                placeholder="@lang('placeholders.users.name')"
                value="{{ old('name', $user->name ?? '') }}" autofocus>
        </div>
        @errorblock('name')
    </div>

    <div class="form-group floating-addon col-sm-6">
        <label for="email">
            @lang('labels.common.email')<span class="text-danger ml-1">*</span>
        </label>
        <div class="input-group {{ has_error_class('email') }}">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fas fa-at"></i>
                </span>
            </div>
            <input type="email" name="email"
                class="form-control {{ has_error_class('email') }}"
                placeholder="@lang('placeholders.common.email')"
                value="{{old('email', $user->email ?? '')}}">
        </div>
        @errorblock('email')
    </div>
</div>

<div class="form-row">
    <div class="form-group floating-addon col-sm-6">
        <label for="password" class="form-control-label">
            @lang('labels.common.password')@if(!isset($user))<span class="text-danger ml-1">*</span>@endif
        </label>
        <div class="input-group {{ has_error_class('password') }}">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fas fa-asterisk"></i>
                </span>
            </div>
            <input type="password" name="password" autocomplete="new-password"
                class="form-control {{ has_error_class('password') }}"
                placeholder="@lang('placeholders.users.password')">
        </div>
        @errorblock('password')
        <small class="form-text text-muted">@lang('phrases.common.password_caracter')</small>
    </div>

    <div class="form-group floating-addon col-sm-6">
        <label for="password_confirmation">
            @lang('labels.common.password_confirmation') @if(!isset($user))<span class="text-danger ml-1">*</span>@endif
        </label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fas fa-asterisk"></i>
                </span>
            </div>
            <input type="password" name="password_confirmation"
                class="form-control {{ has_error_class('password') }}"
                placeholder="@lang('placeholders.users.password_confirmation')">
        </div>
    </div>
</div>