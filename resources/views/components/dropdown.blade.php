<div class="dropdown">
    <button class="btn border-2 border-success d-flex justify-start align-items-center dropdown-toggle w-100"
        type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <span>{{ $title }}</span>
        <span class="ms-auto"></span>
    </button>
    <ul class="dropdown-menu w-100">
        <li><a class="dropdown-item text-truncate" href="{{ $route }}">{{ __('All') }}</a></li>
        <li>{{ $slot }}</li>
    </ul>
</div>