<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - Bimbel Privat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; overflow: hidden; }
        /* Menghilangkan spinner pada input number */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    </style>
</head>
<body style="background-color: #F9FAFB;">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            
            <div class="flex items-center justify-center gap-3 mb-8">
                <img src="{{ asset('images/logo/foto_logo.png') }}" alt="Logo" class="h-12 w-auto">
                <h2 class="text-3xl font-bold" style="color: #4D0B87;">Bimbel Privat</h2>
            </div>

            <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-purple-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-key text-3xl" style="color: #4D0B87;"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Verifikasi Kode OTP</h3>
                    <p class="text-gray-500 text-sm mt-2 leading-relaxed">
                        Masukkan 6 digit kode yang kami kirimkan ke <br>
                        <span class="font-semibold text-gray-700">{{ session('otp_email') }}</span>
                    </p>
                </div>

                {{-- Ganti otp.verify menjadi otp.check --}}
                <form method="POST" action="{{ route('otp.check') }}" id="otp-form">
                    @csrf

                    {{-- Alert Error --}}
                    @if ($errors->any())
                        <div class="bg-red-50 text-red-700 p-3 rounded-xl mb-4 text-sm border border-red-100">
                            <i class="fas fa-exclamation-circle mr-2"></i> {{ $errors->first() }}
                        </div>
                    @endif

                    {{-- Alert Status Sukses --}}
                    @if (session('status'))
                        <div class="bg-green-50 text-green-700 p-3 rounded-xl mb-4 text-sm border border-green-100">
                            <i class="fas fa-check-circle mr-2"></i> {{ session('status') }}
                        </div>
                    @endif

                    <div class="flex justify-between gap-2 mb-8">
                        @for ($i = 1; $i <= 6; $i++)
                            <input type="text" 
                                   inputmode="numeric"
                                   name="otp_digit[]" 
                                   maxlength="1" 
                                   class="w-12 h-14 text-center text-2xl font-bold border-2 border-gray-200 rounded-xl focus:border-[#4D0B87] focus:ring-0 outline-none transition-all" 
                                   oninput="this.value=this.value.replace(/[^0-9]/g,''); moveNext(this)" 
                                   onkeydown="moveBack(event)" 
                                   required>
                        @endfor
                    </div>

                    <button type="submit" 
                            class="w-full text-white py-4 rounded-2xl font-bold text-lg hover:opacity-90 transition shadow-lg active:scale-95" 
                            style="background-color: #4D0B87;">
                        VERIFIKASI
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-500 mb-2">Tidak menerima kode?</p>
                    <form method="POST" action="{{ route('otp.send') }}">
                        @csrf
                        <input type="hidden" name="email" value="{{ session('otp_email') }}">
                        <button type="submit" class="text-sm font-bold text-[#4D0B87] hover:underline">
                            Kirim Ulang Kode
                        </button>
                    </form>
                    
                    <div class="mt-8 pt-6 border-t border-gray-50">
                        <a href="{{ route('login') }}" class="text-xs font-semibold text-gray-400 hover:text-[#4D0B87] transition-colors">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi pindah ke kotak selanjutnya
        function moveNext(current) {
            if (current.value.length >= 1) {
                const next = current.nextElementSibling;
                if (next) next.focus();
            }
        }

        // Fungsi kembali ke kotak sebelumnya saat hapus
        function moveBack(event) {
            if (event.key === "Backspace" && !event.target.value) {
                const prev = event.target.previousElementSibling;
                if (prev) prev.focus();
            }
        }

        // Menggabungkan 6 digit menjadi 1 input 'otp' sebelum dikirim
        document.getElementById('otp-form').addEventListener('submit', function(e) {
            let otpValue = '';
            const inputs = document.querySelectorAll('input[name="otp_digit[]"]');
            
            inputs.forEach(input => {
                otpValue += input.value;
            });

            // Tambahkan hidden input untuk dikirim ke controller
            let hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'otp'; // Nama ini harus sesuai dengan $request->otp di Controller
            hiddenInput.value = otpValue;
            this.appendChild(hiddenInput);
        });
    </script>
</body>
</html>