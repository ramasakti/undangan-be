<div class="modal" id="edit-tamu-{{ $tamu->id }}" tabindex="-1">
    <div class="modal-dialog" role="document">
        <form action="{{ route('tamu.update', $tamu->id) }}" method="post">
            @method("PUT")
            @csrf 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Tamu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Tamu</label>
                        <input type="text" name="nama_tamu" class="form-control" value="{{ $tamu->nama_tamu }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor WA</label>
                        <input type="text" name="no_wa" class="form-control" value="{{ $tamu->no_wa }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark" data-bs-dismiss="modal">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
