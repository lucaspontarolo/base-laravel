<template>
  @foreach (['success', 'error', 'warning', 'info'] as $flashType)
    @if(session()->has($flashType))
      @foreach(session($flashType) as $message)
        <div class="alert alert-{{ $flashType }} alert-dismissible show fade" role="alert">
          <div class="alert-body">
            <button class="close" data-dismiss="alert">
              <span>×</span>
            </button>
            <i class="far fa-lightbulb fa-fw mr-1"></i>{{ $message }}
          </div>
        </div>
      @endforeach
    @endif
  @endforeach
</template>