<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-{{ $centered ?? 'centered' }} modal-{{ $size }}">
        <div class="modal-content">
            <div class="modal-header bg-logo-dark text-light">
                <h1 class="modal-title fs-5 fw-bold">{{ $title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>