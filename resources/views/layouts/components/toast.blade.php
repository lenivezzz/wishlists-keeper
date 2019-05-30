<div id="{{ $id }}"
     class="toast {{ $cssClass }}"
     role="alert"
     aria-live="assertive"
     aria-atomic="true"
     data-animation="false"
     data-autohide="false"
>
    <div class="toast-header">
        <strong class="mr-auto">{{ $header }}</strong>
    </div>
    <div class="toast-body">
        {{ $slot }}
    </div>
</div>
