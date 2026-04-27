@extends('admin.layouts.app')
@section('title', 'Detail Produk')
@section('breadcrumb')
  <a href="{{ route('admin.produk.index') }}">Produk</a>
  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
  <span>Detail Produk</span>
@endsection

@section('content')

@php
  $stMap = [
    'available' => ['Tersedia',      'badge-green', '#DCFCE7', '#15803D'],
    'sold'      => ['Terjual',       'badge-gray',  '#F1F5F9', '#475569'],
    'hidden'    => ['Disembunyikan', 'badge-red',   '#FEE2E2', '#B91C1C'],
  ];
  [$sl, $sc] = $stMap[$produk->status] ?? [$produk->status, 'badge-gray'];

  $condMap = [
    'like_new' => ['Like New', 'badge-green'],
    'good'     => ['Good',     'badge-teal'],
    'fair'     => ['Fair',     'badge-orange'],
  ];
  [$cl, $cc] = $condMap[$produk->condition] ?? [$produk->condition, 'badge-gray'];
@endphp

{{-- ── Header ── --}}
<div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;">
  <div style="display:flex;align-items:center;gap:14px;">
    <a href="{{ route('admin.produk.index') }}" class="btn btn-ghost btn-sm btn-icon">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <div>
      <div style="font-size:22px;font-weight:800;color:var(--text-1);letter-spacing:-.02em;">Detail Produk</div>
      <div style="font-size:12.5px;color:var(--text-3);margin-top:2px;">#{{ $produk->id }}</div>
    </div>
  </div>
  <div style="display:flex;align-items:center;gap:8px;">
    <a href="{{ route('admin.produk.edit', $produk) }}" class="btn btn-primary">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
      Edit Produk
    </a>
  </div>
</div>

<div style="display:grid;grid-template-columns:340px 1fr;gap:20px;align-items:start;">

  {{-- ── Kolom Kiri: Foto ── --}}
  <div style="display:flex;flex-direction:column;gap:12px;">

    {{-- Foto Utama --}}
    <div class="card" style="overflow:hidden;">
      <div style="aspect-ratio:1;background:var(--page-bg);">
        @if($produk->image)
          <img src="{{ Storage::url($produk->image) }}" alt="{{ $produk->name }}"
               style="width:100%;height:100%;object-fit:cover;" />
        @else
          <div style="width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;">
            <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--border);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <span style="font-size:12px;color:var(--text-3);">Belum ada foto</span>
          </div>
        @endif
      </div>
    </div>

    {{-- Foto Tambahan --}}
    @if($produk->images->count() > 0)
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;">
        @foreach($produk->images->sortBy('sort_order') as $img)
          <div style="aspect-ratio:1;border-radius:8px;overflow:hidden;border:1px solid var(--border);background:var(--page-bg);">
            <img src="{{ Storage::url($img->image_path) }}" style="width:100%;height:100%;object-fit:cover;" />
          </div>
        @endforeach
      </div>
    @endif

    {{-- Danger Zone --}}
    <div class="card" style="padding:18px;border-color:#FECACA;">
      <div style="font-size:12px;font-weight:700;color:var(--danger);letter-spacing:.04em;text-transform:uppercase;margin-bottom:8px;">Danger Zone</div>
      <p style="font-size:12.5px;color:var(--text-3);margin-bottom:14px;line-height:1.5;">Tindakan ini tidak dapat dibatalkan. Semua foto akan ikut terhapus dari server.</p>
      <button onclick="confirmDelete('{{ route('admin.produk.destroy', $produk) }}','{{ addslashes($produk->name) }}')"
              class="btn btn-danger btn-sm" style="width:100%;justify-content:center;">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        Hapus Produk Ini
      </button>
    </div>

  </div>

  {{-- ── Kolom Kanan: Detail ── --}}
  <div style="display:flex;flex-direction:column;gap:16px;">

    {{-- Info Utama --}}
    <div class="card" style="padding:24px;">
      <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:6px;">
        <div style="font-size:12px;font-weight:600;color:var(--text-3);text-transform:uppercase;letter-spacing:.05em;">
          {{ $produk->category->name ?? '—' }}
        </div>
        <span class="badge {{ $sc }}">{{ $sl }}</span>
      </div>
      <h1 style="font-size:22px;font-weight:800;color:var(--text-1);letter-spacing:-.02em;margin-bottom:14px;line-height:1.25;">
        {{ $produk->name }}
      </h1>
      <div style="font-size:28px;font-weight:800;color:var(--text-1);letter-spacing:-.03em;margin-bottom:20px;">
        Rp {{ number_format($produk->price, 0, ',', '.') }}
      </div>

      {{-- Stats Row --}}
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1px;background:var(--border);border:1px solid var(--border);border-radius:10px;overflow:hidden;margin-bottom:20px;">
        @foreach([
          ['Kondisi', '<span class="badge '.$cc.'">'.$cl.'</span>'],
          ['Stok', '<span style="font-size:18px;font-weight:800;color:'.($produk->stock===0?'var(--danger)':'var(--text-1)').';">'.$produk->stock.'</span>'],
          ['Berat', '<span style="font-size:18px;font-weight:800;color:var(--text-1);">'.$produk->weight.'<span style="font-size:13px;font-weight:500;color:var(--text-3);"> g</span></span>'],
        ] as [$statLabel, $statVal])
          <div style="background:var(--card-bg);padding:16px;text-align:center;">
            <div style="font-size:11px;font-weight:600;color:var(--text-3);letter-spacing:.05em;text-transform:uppercase;margin-bottom:8px;">{{ $statLabel }}</div>
            <div>{!! $statVal !!}</div>
          </div>
        @endforeach
      </div>

      {{-- Deskripsi --}}
      <div style="margin-bottom:{{ $produk->condition_notes ? '16px' : '0' }};">
        <div style="font-size:11px;font-weight:700;color:var(--text-3);text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">Deskripsi Produk</div>
        <p style="font-size:13.5px;color:var(--text-2);line-height:1.7;white-space:pre-line;">{{ $produk->description }}</p>
      </div>

      {{-- Catatan Kondisi --}}
      @if($produk->condition_notes)
        <div style="padding:14px 16px;background:#ECFDF5;border:1px solid #A7F3D0;border-radius:8px;">
          <div style="font-size:11px;font-weight:700;color:#065F46;text-transform:uppercase;letter-spacing:.06em;margin-bottom:5px;">⚠ Catatan Kondisi</div>
          <p style="font-size:13px;color:#047857;line-height:1.6;margin:0;">{{ $produk->condition_notes }}</p>
        </div>
      @endif
    </div>

    {{-- Meta Info --}}
    <div class="card" style="padding:20px;">
      <div class="card-title" style="margin-bottom:16px;">Informasi Sistem</div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;font-size:13px;">
        @foreach([
          ['ID Produk', '#'.$produk->id],
          ['Slug', $produk->slug],
          ['Dibuat', $produk->created_at->format('d M Y, H:i')],
          ['Diperbarui', $produk->updated_at->format('d M Y, H:i')],
        ] as [$metaLabel, $metaVal])
          <div>
            <div style="font-size:11px;font-weight:600;color:var(--text-3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:5px;">{{ $metaLabel }}</div>
            <div style="font-weight:600;color:var(--text-1);font-family:{{ $metaLabel==='Slug' ? 'monospace' : 'inherit' }};font-size:{{ $metaLabel==='Slug' ? '12px' : '13px' }};word-break:break-all;">{{ $metaVal }}</div>
          </div>
        @endforeach
      </div>
    </div>

  </div>
</div>

{{-- Delete Modal --}}
<div class="modal-overlay" id="delete-modal">
  <div class="modal-box">
    <div style="width:48px;height:48px;background:#FEE2E2;border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
      <svg width="22" height="22" fill="none" stroke="#B91C1C" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
    </div>
    <div style="text-align:center;font-size:17px;font-weight:800;color:var(--text-1);margin-bottom:8px;">Hapus Produk?</div>
    <p id="delete-modal-desc" style="text-align:center;font-size:13px;color:var(--text-2);margin-bottom:24px;line-height:1.55;"></p>
    <div style="display:flex;gap:10px;">
      <button onclick="closeModal('delete-modal')" class="btn btn-ghost" style="flex:1;justify-content:center;">Batal</button>
      <form id="delete-form" method="POST" style="flex:1;">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger" style="width:100%;justify-content:center;">Hapus Sekarang</button>
      </form>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  function confirmDelete(url, name) {
    document.getElementById('delete-form').action = url;
    document.getElementById('delete-modal-desc').textContent =
      `Produk "${name}" akan dihapus permanen beserta semua fotonya.`;
    openModal('delete-modal');
  }
  function openModal(id)  { document.getElementById(id).classList.add('open'); }
  function closeModal(id) { document.getElementById(id).classList.remove('open'); }
  document.querySelectorAll('.modal-overlay').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
  });
</script>
@endpush