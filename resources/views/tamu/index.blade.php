<x-dashboard title="{{ $title }}">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-tamu">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 5l0 14" />
            <path d="M5 12l14 0" />
        </svg>
        Tambah Tamu
    </button>
    @include('tamu.modal-create')
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#import-tamu">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="icon icon-tabler icons-tabler-outline icon-tabler-book-upload">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M14 20h-8a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12v5" />
            <path d="M11 16h-5a2 2 0 0 0 -2 2" />
            <path d="M15 16l3 -3l3 3" />
            <path d="M18 13v9" />
        </svg>
        Import Tamu
    </button>
    @include('tamu.modal-import')
    <button class="btn btn-teal d-none" id="btn-broadcast" data-bs-toggle="modal" data-bs-target="#modal-broadcast">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="icon icon-tabler icons-tabler-outline icon-tabler-brand-whatsapp">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" />
            <path d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1" />
        </svg>
        Broadcast WhatsApp
    </button>
    @include('tamu.modal-broadcast')
    <button class="btn btn-danger d-none" id="btn-massdel" data-bs-toggle="modal" data-bs-target="#modal-massdel">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M4 7l16 0" />
            <path d="M10 11l0 6" />
            <path d="M14 11l0 6" />
            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
        </svg>
        Hapus Tamu
    </button>
    @include('tamu.modal-massdel')

    <div class="table-responsive">
        <table class="table table-vcenter table-nowrap" id="table-tamu">
            <thead>
                <tr>
                    <th>#</th>
                    <th>
                        <input type="checkbox" class="form-check-input" id="check-all">
                    </th>
                    <th>Nama Tamu</th>
                    <th>No WA</th>
                    <th>Uploader</th>
                    <th class="w-1">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tamu as $index => $tamu)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <input type="checkbox" class="check-tamu form-check-input" value="{{ $tamu->id }}"
                                data-nama="{{ $tamu->nama_tamu }}" data-nomor="{{ $tamu->no_wa }}"
                                @disabled($tamu->broadcast_at !== null)>
                        </td>
                        <td>{{ $tamu->nama_tamu }}</td>
                        <td>{{ $tamu->no_wa }}</td>
                        <td>{{ $tamu->uploader->name }}</td>
                        <td>
                            <div class="d-inline">
                                <button class="btn btn-icon btn-info"
                                    onclick="salinLinkUndangan('{{ $tamu->kode_tamu }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-copy">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M7 9.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667l0 -8.666" />
                                        <path
                                            d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" />
                                    </svg>
                                </button>
                                <button class="btn btn-icon btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#edit-tamu-{{ $tamu->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-adjustments-alt">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 8h4v4h-4z" />
                                        <path d="M6 4l0 4" />
                                        <path d="M6 12l0 8" />
                                        <path d="M10 14h4v4h-4z" />
                                        <path d="M12 4l0 10" />
                                        <path d="M12 18l0 2" />
                                        <path d="M16 5h4v4h-4z" />
                                        <path d="M18 4l0 1" />
                                        <path d="M18 9l0 11" />
                                    </svg>
                                </button>
                                <button class="btn btn-icon btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#delete-tamu-{{ $tamu->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7l16 0" />
                                        <path d="M10 11l0 6" />
                                        <path d="M14 11l0 6" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @include('tamu.modal-edit')
                    @include('tamu.modal-delete')
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        const salinLinkUndangan = async (kode_tamu) => {
            const textToCopy = `https://intan-rama.simskul.id?to=${kode_tamu}`
            try {
                await navigator.clipboard.writeText(textToCopy);
                console.log('Text copied to clipboard!');
                alert('Berhasil salin link undangan'); // Optional feedback
            } catch (err) {
                console.error('Failed to copy text: ', err);
                alert('Gagal salin link undangan'); // Optional error feedback
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const table = new DataTable('#table-tamu', {
                columnDefs: [{
                    targets: [1, 5],
                    orderable: false,
                    searchable: false
                }]
            });

            const btnBroadcast = document.getElementById("btn-broadcast");
            const btnMassdel = document.getElementById("btn-massdel");
            const checkAll = document.getElementById("check-all");
            const idTamuInput = document.getElementById("id_tamu");

            function getCheckedIds() {
                let ids = [];
                document.querySelectorAll(".check-tamu:checked").forEach(cb => {
                    ids.push(cb.value);
                });
                return ids;
            }

            function updateState() {
                const ids = getCheckedIds();

                if (ids.length > 0) {
                    btnBroadcast.classList.remove("d-none");
                    btnMassdel.classList.remove("d-none");
                } else {
                    btnBroadcast.classList.add("d-none");
                    btnMassdel.classList.add("d-none");
                }

                // isi ke input modal
                idTamuInput.value = ids;
            }

            // Event delegation (WAJIB karena DataTable)
            document.addEventListener("change", function(e) {
                if (e.target.classList.contains("check-tamu")) {
                    updateState();
                }
            });

            checkAll.addEventListener("change", function() {
                document.querySelectorAll(".check-tamu").forEach(cb => {
                    cb.checked = checkAll.checked;
                });
                updateState();
            });
        });
    </script>
</x-dashboard>
