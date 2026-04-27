@extends('admin.layouts.app')
@section('title', 'Kelola Produk')
@section('breadcrumb')<span>Produk</span>@endsection

@section('content')

{{-- ── Page Header ── --}}
<div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;">
  <div>
    <div style="font-size:22px;font-weight:800;color:var(--text-1);letter-spacing:-.02em;">Produk</div>
    <div style="font-size:13px;color:var(--text-3);margin-top:3px;">{{ $produk->total() }} produk ditemukan</div>
  </div>
  <a href="{{ route('admin.produk.create') }}" class="btn btn-primary">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
    Tambah Produk
  </a>
</div>

{{-- ── Filter Bar ── --}}
<div class="card" style="padding:16px;margin-bottom:20px;">
  <form method="GET" style="display:flex;flex-wrap:wrap;gap:12px;align-items:flex-end;">
    <div style="flex:1;min-width:200px;">
      <label class="form-label">Cari Produk</label>
      <div style="position:relative;">
        <svg style="position:absolute;left:11px;top:50%;transform:translateY(-50%);width:15px;height:15px;color:var(--text-3);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama produk..."
               class="form-input" style="padding-left:36px;" />
      </div>
    </div>
    <div style="min-width:160px;">
      <label class="form-label">Kategori</label>
      <select name="category" class="form-select">
        <option value="">Semua Kategori</option>
        @foreach($categories as $cat)
          <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
      </select>
    </div>
    <div style="min-width:140px;">
      <label class="form-label">Status</label>
      <select name="status" class="form-select">
        <option value="">Semua Status</option>
        <option value="available" {{ request('status')==='available' ? 'selected' : '' }}>Tersedia</option>
        <option value="sold"      {{ request('status')==='sold'      ? 'selected' : '' }}>Terjual</option>
        <option value="hidden"    {{ request('status')==='hidden'    ? 'selected' : '' }}>Disembunyikan</option>
      </select>
    </div>
    <div style="display:flex;gap:8px;">
      <button type="submit" class="btn btn-primary">Filter</button>
      @if(request()->hasAny(['search','category','status']))
        <a href="{{ route('admin.produk.index') }}" class="btn btn-ghost">Reset</a>
      @endif
    </div>
  </form>
</div>

{{-- ── Table ── --}}
<div class="card" style="overflow:hidden;">

  {{-- Skeleton --}}
  <div id="skeleton-content">
    <div style="overflow-x:auto;">
      <table class="data-table">
        <thead>
          <tr>
            <th style="width:40px;">#</th>
            <th>Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Kondisi</th>
            <th>Stok</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @for($s = 0; $s < 6; $s++)
            <tr class="skeleton-row">
              <td><span class="skeleton-block sk-line" style="width:20px;"></span></td>
              <td>
                <div style="display:flex;align-items:center;gap:10px;">
                  <span class="skeleton-block sk-avatar"></span>
                  <div>
                    <span class="skeleton-block sk-line" style="width:140px;margin-bottom:6px;"></span>
                    <span class="skeleton-block sk-line" style="width:60px;height:10px;"></span>
                  </div>
                </div>
              </td>
              <td><span class="skeleton-block sk-line" style="width:90px;"></span></td>
              <td><span class="skeleton-block sk-line" style="width:80px;"></span></td>
              <td><span class="skeleton-block sk-badge"></span></td>
              <td><span class="skeleton-block sk-line" style="width:20px;"></span></td>
              <td><span class="skeleton-block sk-badge"></span></td>
              <td><span class="skeleton-block sk-btn"></span></td>
            </tr>
          @endfor
        </tbody>
      </table>
    </div>
  </div>

  {{-- Real Content --}}
  <div id="real-content">
    <div style="overflow-x:auto;">
      <table class="data-table">
        <thead>
          <tr>
            <th style="width:40px;">#</th>
            <th>Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Kondisi</th>
            <th>Stok</th>
            <th>Status</th>
            <th style="text-align:right;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($produk as $p)
            @php
              $condMap = [
                'like_new' => ['Like New', 'badge-green'],
                'good'     => ['Good',     'badge-blue'],
                'fair'     => ['Fair',     'badge-orange'],
              ];
              [$cl, $cc] = $condMap[$p->condition] ?? [$p->condition, 'badge-gray'];
              $stMap = [
                'available' => ['Tersedia',      'badge-green'],
                'sold'      => ['Terjual',       'badge-gray'],
                'hidden'    => ['Disembunyikan', 'badge-red'],
              ];
              [$sl, $sc] = $stMap[$p->status] ?? [$p->status, 'badge-gray'];
            @endphp
            <tr>
              <td style="color:var(--text-3);font-size:12px;">{{ $produk->firstItem() + $loop->index }}</td>
              <td>
                <div style="display:flex;align-items:center;gap:11px;">
                  <div style="width:40px;height:40px;border-radius:8px;overflow:hidden;background:var(--page-bg);border:1px solid var(--border);flex-shrink:0;">
                    @if($p->image)
                      <img src="{{ Storage::url($p->image) }}" alt="{{ $p->name }}" style="width:100%;height:100%;object-fit:cover;" />
                    @else
                      <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--text-3);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                      </div>
                    @endif
                  </div>
                  <div style="min-width:0;">
                    <div style="font-weight:600;font-size:13px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:200px;">{{ $p->name }}</div>
                    <div style="font-size:11.5px;color:var(--text-3);margin-top:1px;">{{ $p->weight }}g</div>
                  </div>
                </div>
              </td>
              <td style="font-size:12.5px;color:var(--text-2);">{{ $p->category->name ?? '—' }}</td>
              <td style="font-weight:700;font-size:13px;">Rp {{ number_format($p->price, 0, ',', '.') }}</td>
              <td><span class="badge {{ $cc }}">{{ $cl }}</span></td>
              <td>
                <span style="font-weight:700;font-size:13px;color:{{ $p->stock === 0 ? 'var(--danger)' : 'var(--text-1)' }};">
                  {{ $p->stock }}
                </span>
              </td>
              <td><span class="badge {{ $sc }}">{{ $sl }}</span></td>
              <td>
                <div style="display:flex;align-items:center;gap:4px;justify-content:flex-end;">
                  <a href="{{ route('admin.produk.show', $p) }}" class="btn btn-ghost btn-sm btn-icon" title="Detail">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                  </a>
                  <a href="{{ route('admin.produk.edit', $p) }}" class="btn btn-ghost btn-sm btn-icon" title="Edit">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                  </a>
                  <button onclick="confirmDelete('{{ route('admin.produk.destroy', $p) }}', '{{ addslashes($p->name) }}')"
                          class="btn btn-danger btn-sm btn-icon" title="Hapus">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                  </button>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" style="text-align:center;padding:60px 16px;">
                <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--border);margin:0 auto 12px;display:block;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <div style="font-weight:600;font-size:13.5px;color:var(--text-2);margin-bottom:4px;">Tidak ada produk ditemukan</div>
                <div style="font-size:12.5px;color:var(--text-3);margin-bottom:16px;">Coba ubah filter atau tambah produk baru.</div>
                <a href="{{ route('admin.produk.create') }}" class="btn btn-primary btn-sm">+ Tambah Produk</a>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($produk->hasPages())
      <div style="padding:14px 20px;border-top:1px solid var(--border-light);">
        {{ $produk->links() }}
      </div>
    @endif
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
      `Produk "${name}" akan dihapus permanen beserta semua foto. Tindakan ini tidak dapat dibatalkan.`;
    openModal('delete-modal');
  }
  function openModal(id) { document.getElementById(id).classList.add('open'); }
  function closeModal(id) { document.getElementById(id).classList.remove('open'); }
  document.querySelectorAll('.modal-overlay').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
  });
</script>
@endpush