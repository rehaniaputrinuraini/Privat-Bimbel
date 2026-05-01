@extends('layouts.app')

@section('title', 'Transaksi Penggajian')

@section('content')
<div style="width: 100%;">

    {{-- HEADER --}}
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0;">Transaksi Penggajian</h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Kelola Gaji Tentor</p>
    </div>

    @if(session('success'))
        <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;">{{ session('success') }}</div>
    @endif

    {{-- FILTER --}}
    <div style="background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-bottom: 20px;">
        <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
            <select id="filterBulan" onchange="filterGaji()"
                    style="flex: 1; min-width: 130px; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 13px; font-family: 'Poppins', sans-serif; outline: none; cursor: pointer;">
                <option value="">Pilih Bulan</option>
                @for($i=1; $i<=12; $i++)
                    <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>{{ Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                @endfor
            </select>
            <select id="filterTahun" onchange="filterGaji()"
                    style="flex: 1; min-width: 100px; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 13px; font-family: 'Poppins', sans-serif; outline: none; cursor: pointer;">
                <option value="">Pilih Tahun</option>
                @for($i=date('Y'); $i>=2020; $i--)
                    <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>
    </div>

    {{-- TABEL --}}
    <div style="background: white; border-radius: 20px; overflow-x: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px; white-space: nowrap; font-family: 'Poppins', sans-serif;">
            <thead><tr style="background: #F3E8FF;">
                <th style="padding: 15px; text-align: center;">No</th>
                <th style="padding: 15px;">Nama Tentor</th>
                <th style="padding: 15px;">Mapel</th>
                <th style="padding: 15px; text-align: center;">Grade</th>
                <th style="padding: 15px; text-align: center;">Sesi</th>
                <th style="padding: 15px; text-align: right;">Honor/Sesi</th>
                <th style="padding: 15px; text-align: right;">Total Honor</th>
                <th style="padding: 15px; text-align: right;">Makan</th>
                <th style="padding: 15px; text-align: right;">Transport</th>
                <th style="padding: 15px; text-align: right;">Total</th>
                <th style="padding: 15px; text-align: center;">Status</th>
                <th style="padding: 15px; text-align: center;">Aksi</th>
            </tr></thead>
            <tbody id="tableBody">
                @forelse($penggajian as $index => $item)
                <tr style="border-bottom: 1px solid #F3F4F6;">
                    <td style="padding: 15px; text-align: center;">{{ $penggajian->firstItem() + $index }}</td>
                    <td style="padding: 15px;">{{ $item->nama }}</td>
                    <td style="padding: 15px;">{{ $item->mapel }}</td>
                    <td style="padding: 15px; text-align: center;">{{ $item->grade }}</td>
                    <td style="padding: 15px; text-align: center;">{{ $item->jumlah_sesi }}</td>
                    <td style="padding: 15px; text-align: right;">Rp {{ number_format($item->honor_per_sesi, 0, ',', '.') }}</td>
                    <td style="padding: 15px; text-align: right;">Rp {{ number_format($item->total_honor, 0, ',', '.') }}</td>
                    <td style="padding: 15px; text-align: right;">Rp {{ number_format($item->uang_makan, 0, ',', '.') }}</td>
                    <td style="padding: 15px; text-align: right;">Rp {{ number_format($item->uang_transport, 0, ',', '.') }}</td>
                    <td style="padding: 15px; text-align: right; font-weight: 700; color: #4D0B87;">Rp {{ number_format($item->total_gaji, 0, ',', '.') }}</td>
                    <td style="padding: 15px; text-align: center;">
                        @if($item->sudah_dibayar)
                            <span style="background:#D1FAE5;color:#065F46;padding:4px 10px;border-radius:20px;font-size:11px;">Sudah Dibayar</span>
                        @else
                            <span style="background:#FEF3C7;color:#92400E;padding:4px 10px;border-radius:20px;font-size:11px;">Belum Dibayar</span>
                        @endif
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        @if(!$item->sudah_dibayar)
                            <button onclick="bayarGaji('{{ $item->id_pegawai }}', '{{ $item->nama }}', {{ $item->total_gaji }}, {{ $item->jumlah_sesi }})"
                                    style="background:#10B981;color:white;padding:6px 12px;border-radius:6px;border:none;cursor:pointer;font-size:12px;">
                                <i class="fas fa-money-bill-wave"></i> Bayar
                            </button>
                        @else
                            <span style="color:#10B981;">✅</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="12" style="padding: 50px; text-align: center; color: #9CA3AF;">Pilih bulan dan tahun untuk melihat data gaji</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px; margin-bottom: 40px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <select id="pageSelect" onchange="changePage(this.value)"
                    style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer; font-family: 'Poppins', sans-serif;">
                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 baris</option>
                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 baris</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 baris</option>
            </select>
            <span style="color: #374151; font-size: 13px;">Menampilkan {{ $penggajian->firstItem() ?? 0 }} - {{ $penggajian->lastItem() ?? 0 }} dari {{ $penggajian->total() ?? 0 }} data</span>
        </div>
        <div style="display: flex; gap: 5px;">
            @if ($penggajian->onFirstPage())
                <button disabled style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:#F3F4F6;color:#9CA3AF;"><i class="fas fa-angle-double-left"></i></button>
                <button disabled style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:#F3F4F6;color:#9CA3AF;"><i class="fas fa-angle-left"></i></button>
            @else
                <a href="{{ $penggajian->url(1) }}&per_page={{ request('per_page', 10) }}&bulan={{ $bulan }}&tahun={{ $tahun }}" style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:white;color:#374151;display:flex;align-items:center;justify-content:center;text-decoration:none;"><i class="fas fa-angle-double-left"></i></a>
                <a href="{{ $penggajian->previousPageUrl() }}&per_page={{ request('per_page', 10) }}&bulan={{ $bulan }}&tahun={{ $tahun }}" style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:white;color:#374151;display:flex;align-items:center;justify-content:center;text-decoration:none;"><i class="fas fa-angle-left"></i></a>
            @endif
            @php $start = max(1, $penggajian->currentPage() - 2); $end = min($penggajian->lastPage(), $penggajian->currentPage() + 2); @endphp
            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $penggajian->currentPage())
                    <button style="width:35px;height:35px;border-radius:8px;background:#4D0B87;color:white;border:none;font-weight:600;">{{ $i }}</button>
                @else
                    <a href="{{ $penggajian->url($i) }}&per_page={{ request('per_page', 10) }}&bulan={{ $bulan }}&tahun={{ $tahun }}" style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:white;color:#374151;display:flex;align-items:center;justify-content:center;text-decoration:none;">{{ $i }}</a>
                @endif
            @endfor
            @if ($penggajian->hasMorePages())
                <a href="{{ $penggajian->nextPageUrl() }}&per_page={{ request('per_page', 10) }}&bulan={{ $bulan }}&tahun={{ $tahun }}" style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:white;color:#374151;display:flex;align-items:center;justify-content:center;text-decoration:none;"><i class="fas fa-angle-right"></i></a>
            @else
                <button disabled style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:#F3F4F6;color:#9CA3AF;"><i class="fas fa-angle-right"></i></button>
            @endif
        </div>
    </div>

</div>

{{-- MODAL KONFIRMASI BAYAR --}}
<div id="modalBayar" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center; font-family: 'Poppins', sans-serif;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 380px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15);">
        <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-money-bill-wave"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Konfirmasi Pembayaran Gaji</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0; line-height: 1.5;" id="pesanBayar"></p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button onclick="tutupModalBayar()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Batal</button>
            <button onclick="konfirmasiBayar()" style="flex: 1; padding: 10px; border-radius: 10px; border: none; background: #10B981; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Bayar</button>
        </div>
    </div>
</div>

<script>
    let bayarData = {};

    function filterGaji() {
        const bulan = document.getElementById('filterBulan').value;
        const tahun = document.getElementById('filterTahun').value;
        if (bulan && tahun) {
            window.location.href = `?bulan=${bulan}&tahun=${tahun}`;
        }
    }

    function bayarGaji(id, nama, total, sesi) {
        bayarData = { id, nama, total, sesi };
        document.getElementById('pesanBayar').innerHTML = `Bayar gaji <strong>${nama}</strong> sebesar <strong>Rp ${new Intl.NumberFormat('id-ID').format(total)}</strong> untuk <strong>${sesi} sesi</strong>?`;
        document.getElementById('modalBayar').style.display = 'flex';
    }

    function tutupModalBayar() { document.getElementById('modalBayar').style.display = 'none'; }

    function konfirmasiBayar() {
        const btn = document.querySelector('#modalBayar button:last-child');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        const bulan = document.getElementById('filterBulan').value;
        const tahun = document.getElementById('filterTahun').value;

        fetch(`{{ route($role . '.penggajian.bayar', '') }}/${bayarData.id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                bulan: bulan,
                tahun: tahun,
                total_gaji: bayarData.total,
                jumlah_sesi: bayarData.sesi
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message);
                btn.disabled = false;
                btn.innerHTML = 'Ya, Bayar';
            }
        });
    }

    document.getElementById('modalBayar').addEventListener('click', function(e) { if (e.target === this) tutupModalBayar(); });

    function changePage(perPage) {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', perPage);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }
</script>
@endsection