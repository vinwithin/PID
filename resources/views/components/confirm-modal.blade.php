<div class="modal fade " id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modalId }}Label"><i class="fa-solid fa-circle-info me-2"></i>{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                    <img src="/assets/confirm-img.png" alt="confirm-image" style="max-width: 225px;">
                    <p>{{ $message }}</p>
                </div>
               
            </div>
            <div class="modal-footer d-flex flex-row justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: 200px;">Batal</button>
                <a href="{{ $actionUrl }}" class="btn btn-primary" style="width: 200px;">
                    <i class="fas fa-check"></i> {{ $confirmText }}
                </a>
            </div>
        </div>
    </div>
</div>
