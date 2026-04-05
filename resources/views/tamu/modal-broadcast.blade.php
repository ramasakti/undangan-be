<div class="modal fade" id="modal-broadcast">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Broadcast WhatsApp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label class="form-label">Pesan</label>
                <textarea class="form-control" id="pesan-broadcast" rows="5"
                    placeholder="Halo {nama}, silakan buka undangan berikut https://intan-rama.simskul.id"></textarea>

                <small class="text-muted">
                    Gunakan variabel: <b>{nama}</b>
                </small>
            </div>

            <div class="modal-footer">
                <button class="btn btn-teal" id="kirim-broadcast">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-send">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M10 14l11 -11" />
                        <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" />
                    </svg>
                    Kirim Broadcast
                </button>
            </div>
        </div>
    </div>
</div>
