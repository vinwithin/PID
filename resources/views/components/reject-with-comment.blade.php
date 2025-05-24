@props(['modalId', 'actionUrl', 'title', 'value'])

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog modal-xl"> {{-- <- Tambahkan modal-xl di sini --}}
        <form action="{{ $actionUrl }}" method="post">
            @csrf
  
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="{{ $modalId }}Label">{{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="comment" class="form-label">Komentar Penolakan</label>
                        <textarea name="komentar" class="form-control" id="comment" rows="8" required placeholder="Tuliskan alasan penolakan...">{{ $value }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Laporan</button>
                </div>
            </div>
        </form>
    </div>
</div>
