<x-dashboard title="{{ $title }}">
    <div class="card">
        @if ($status !== 'CONNECTED' && !session('qr') && !session('otp'))
            <div class="card-body">
                <h3 class="card-title">Whatsapp Connector</h3>
                <form action="{{ route('waha.connect') }}" method="post">
                    @csrf
                    <div class="form-label">
                        Metode Koneksi
                    </div>
                    {{ session('qr') }}
                    <div>
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="method" value="qr" required>
                            <span class="form-check-label">QR Code</span>
                        </label>
                    </div>
                    <div>
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="method" value="otp" required>
                            <span class="form-check-label">OTP</span>
                        </label>
                    </div>
                    <div class="mb-3" style="display: none;">
                        <label for="phone" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" name="nomor"
                            placeholder="Masukkan nomor telepon dengan kode negara, contoh: 6281234567890">
                    </div>
                    <button type="submit" class="btn btn-primary">Hubungkan</button>
                </form>
            </div>
        @endif

        @session('qr')
            <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
                <div class="card shadow-lg" style="max-width: 420px; width: 100%; border-radius: 12px;">
                    <div class="card-body text-center p-4">
                        <h3 class="mb-2">Koneksikan WhatsApp</h3>
                        <p class="text-muted mb-4">
                            Scan QR Code ini menggunakan aplikasi WhatsApp di ponsel Anda
                        </p>

                        <div class="d-flex justify-content-center mb-3"
                            style="padding: 16px; background: #f8f9fa; borderRadius: 8px;">
                            <img style="max-height: 200px; max-width: 200px;"
                                src="data:image/jpeg;base64, {{ session('qr')['data'] }}" alt="QR">
                        </div>

                        <form action="{{ route('waha.connect.method') }}" method="post">
                            @csrf
                            <input type="hidden" name="method" value="qr">
                            <button class="btn btn-outline-teal" type="submit">
                                Refresh QR
                            </button>
                        </form>

                        <small class="text-muted d-block my-2">
                            Buka WhatsApp di ponsel &gt; Perangkat tertaut &gt; Tautkan perangkat atau
                        </small>

                        <form action="{{ route('waha.connect.method') }}" method="post">
                            @csrf
                            <input type="hidden" name="method" value="otp">
                            <input type="text" name="nomor" class="form-control"
                                placeholder="Masukkan nomor WhatsApp anda" required>
                            <button class="btn btn-outline btn-info w-100 mt-3" type="submit">
                                Hubungkan dengan OTP
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endsession

        @session('otp')
            <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
                <div class="card shadow-lg" style="max-width: 420px; width: 100%; border-radius: 12px;">
                    <div class="card-body text-center p-4">
                        <p>Masukkan kode {{ session('otp')['code'] }} pada aplikasi WhatsApp anda</p>

                        <form action="{{ route('waha.connect.method') }}" method="post">
                            @csrf
                            <input type="hidden" name="method" value="otp">
                            <input type="text" name="nomor" class="form-control"
                                placeholder="Masukkan nomor WhatsApp anda" value="{{ session('nomor') }}">
                            <button class="btn btn-outline btn-info w-100 mt-3" type="submit">
                                Kirim Ulang OTP
                            </button>
                        </form>

                        <p class="my-3">atau</p>

                        <form action="{{ route('waha.connect.method') }}" method="post">
                            @csrf
                            <input type="hidden" name="method" value="qr">
                            <button class="btn btn-outline-teal" type="submit">
                                Scan QR Code
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endsession
    </div>

    <script>
        document.querySelectorAll('input[name="method"]').forEach((elem) => {
            elem.addEventListener("change", function(event) {
                const value = event.target.value;
                const phoneInput = document.querySelector('input[name="nomor"]');
                if (value === "otp") {
                    phoneInput.parentElement.style.display = "block";
                } else {
                    phoneInput.parentElement.style.display = "none";
                }
            });
        });
    </script>
</x-dashboard>
