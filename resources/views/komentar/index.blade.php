<x-dashboard title="{{ $title }}">
    <div class="row">
        @foreach ($komentar as $komen)
            <div class="col-md-3 col-12">
                <div class="card d-flex flex-column">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center mt-auto">
                            <span class="avatar">
                                @php
                                    $nama = explode(' ', $komen->tamu->nama_tamu);
                                    $inisial = '';
                                    foreach ($nama as $nama) {
                                        if (!empty($nama)) {
                                            $inisial .= strtoupper($nama[0]);
                                        }
                                    }
                                @endphp
                                {{ $inisial }}
                            </span>
                            <div class="ms-3">
                                <a href="#" class="text-body">{{ $komen->tamu->nama_tamu }}</a>
                                <div class="text-secondary">
                                    {{ $komen->tamu->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        <div class="text-secondary pt-2">
                            {{ $komen->komentar }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-dashboard>
