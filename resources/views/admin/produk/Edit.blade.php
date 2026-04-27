@extends('admin.layouts.app')
@section('title', 'Edit Produk')
@section('breadcrumb')
  <a href="{{ route('admin.produk.index') }}">Produk</a>
  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
  <span>Edit Produk</span>
@endsection

@section('content')

<div style="max-width:960px;">

  {{-- ── Header ── --}}
  <div style="display:flex;align-items:center;gap:14px;margin-bottom:28px;">
    <a href="{{ route('admin.produk.index') }}" class="btn btn-ghost btn-sm btn-icon">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <div style="min-width:0;flex:1;">
      <div style="font-size:22px;font-weight:800;color:var(--text-1);letter-spacing:-.02em;">Edit Produk</div>
      <div style="font-size:13px;color:var(--text-3);margin-top:3px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $produk->name }}</div>
    </div>
    <a href="{{ route('admin.produk.show', $produk) }}" class="btn btn-ghost btn-sm">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
      Lihat Detail
    </a>
  </div>

  <form method="POST" action="{{ route('admin.produk.update', $produk) }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;">

      {{-- ── Kolom Kiri ── --}}
      <div style="display:flex;flex-direction:column;gap:16px;">

        {{-- Informasi Dasar --}}
        <div class="card" style="padding:24px;">
          <div style="font-size:12px;font-weight:700;color:var(--text-3);text-transform:uppercase;letter-spacing:.07em;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid var(--border-light);">
            Informasi Produk
          </div>

          <div style="margin-bottom:18px;">
            <label class="form-label">Nama Produk <span class="req">*</span></label>
            <input type="text" name="name" value="{{ old('name', $produk->name) }}"
                   class="form-input {{ $errors->has('name') ? 'error' : '' }}" />
            @error('name')<div class="form-error">{{ $message }}</div>@enderror
          </div>

          <div style="margin-bottom:18px;">
            <label class="form-label">Kategori <span class="req">*</span></label>
            <select name="category_id" class="form-select {{ $errors->has('category_id') ? 'error' : '' }}">
              <option value="">— Pilih Kategori —</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id',$produk->category_id)==$cat->id ? 'selected':'' }}>
                  {{ $cat->name }}
                </option>
              @endforeach
            </select>
            @error('category_id')<div class="form-error">{{ $message }}</div>@enderror
          </div>

          <div>
            <label class="form-label">Deskripsi Produk <span class="req">*</span></label>
            <textarea name="description" rows="5"
                      class="form-textarea {{ $errors->has('description') ? 'error' : '' }}">{{ old('description',$produk->description) }}</textarea>
            @error('description')<div class="form-error">{{ $message }}</div>@enderror
          </div>
        </div>

        {{-- Kondisi --}}
        <div class="card" style="padding:24px;">
          <div style="font-size:12px;font-weight:700;color:var(--text-3);text-transform:uppercase;letter-spacing:.07em;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid var(--border-light);">
            Kondisi Barang
          </div>

          <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-bottom:18px;">
            @foreach([
              ['like_new','Like New','Hampir sempurna','#DCFCE7','#A7F3D0'],
              ['good',    'Good',    'Bekas, layak pakai','#CCFBF1','#99F6E4'],
              ['fair',    'Fair',    'Ada cacat minor','#FFEDD5','#FED7AA'],
            ] as [$val,$label,$desc,$bg,$border])
              @php $checked = old('condition',$produk->condition)===$val; @endphp
              <label style="cursor:pointer;position:relative;">
                <input type="radio" name="condition" value="{{ $val }}" {{ $checked?'checked':'' }}
                       class="sr-only condition-radio" data-bg="{{ $bg }}" data-border="{{ $border }}" />
                <div class="condition-card"
                     style="padding:14px;border:2px solid {{ $checked?'#10B981':'var(--border)' }};border-radius:9px;text-align:center;transition:all .15s;background:{{ $checked?$bg:'var(--card-bg)' }};">
                  <div style="font-size:13.5px;font-weight:700;color:var(--text-1);margin-bottom:4px;">{{ $label }}</div>
                  <div style="font-size:11.5px;color:var(--text-3);line-height:1.4;">{{ $desc }}</div>
                </div>
              </label>
            @endforeach
          </div>
          @error('condition')<div class="form-error" style="margin-bottom:10px;">{{ $message }}</div>@enderror

          <div>
            <label class="form-label">Catatan Kondisi <span class="hint">(opsional)</span></label>
            <textarea name="condition_notes" rows="2" class="form-textarea">{{ old('condition_notes',$produk->condition_notes) }}</textarea>
          </div>
        </div>

        {{-- Foto Tambahan --}}
        <div class="card" style="padding:24px;">
          <div style="font-size:12px;font-weight:700;color:var(--text-3);text-transform:uppercase;letter-spacing:.07em;margin-bottom:4px;">
            Foto Tambahan
          </div>
          <div style="font-size:12px;color:var(--text-3);margin-bottom:16px;">Centang foto yang ada untuk menghapus, atau tambah foto baru.</div>

          {{-- Foto yang sudah ada --}}
          @if($produk->images && $produk->images->count() > 0)
            <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:8px;margin-bottom:14px;">
              @foreach($produk->images->sortBy('sort_order') as $img)
                <label style="cursor:pointer;position:relative;" title="Centang untuk hapus">
                  <input type="checkbox" name="delete_images[]" value="{{ $img->id }}"
                         class="sr-only delete-img-cb" />
                  <div class="del-img-wrap" style="aspect-ratio:1;border-radius:8px;overflow:hidden;border:2px solid var(--border);transition:all .15s;position:relative;">
                    <img src="{{ Storage::url($img->image_path) }}" style="width:100%;height:100%;object-fit:cover;" />
                    <div class="del-overlay" style="position:absolute;inset:0;background:rgba(239,68,68,0);transition:all .15s;display:flex;align-items:center;justify-content:center;">
                      <svg width="20" height="20" fill="none" stroke="white" viewBox="0 0 24 24" style="opacity:0;transition:opacity .15s;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </div>
                  </div>
                  <div class="del-label" style="text-align:center;font-size:10px;margin-top:3px;color:var(--text-3);font-weight:600;">#{{ $loop->iteration }}</div>
                </label>
              @endforeach
            </div>
            <div style="padding:10px 12px;background:#FFFBEB;border:1px solid #FDE68A;border-radius:7px;font-size:12px;color:#92400E;margin-bottom:14px;">
              ⚠ Centang foto di atas untuk menghapusnya saat perubahan disimpan.
            </div>
          @endif

          {{-- Upload baru --}}
          <div id="gallery-dropzone"
               style="border:2px dashed var(--border);border-radius:10px;padding:20px;text-align:center;cursor:pointer;transition:all .2s;"
               onmouseenter="this.style.borderColor='#10B981';this.style.background='#F0FDF4';"
               onmouseleave="this.style.borderColor='var(--border)';this.style.background='transparent';"
               onclick="document.getElementById('gallery-input').click()">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--text-3);margin:0 auto 8px;display:block;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/></svg>
            <div style="font-size:13px;font-weight:600;color:var(--text-2);margin-bottom:2px;">Tambah Foto Baru</div>
            <div style="font-size:11.5px;color:var(--text-3);">Klik atau seret file di sini</div>
          </div>
          <input type="file" id="gallery-input" name="images[]" multiple accept="image/*" class="sr-only"
                 onchange="previewGallery(this)" />
          <div id="gallery-preview" style="display:none;grid-template-columns:repeat(5,1fr);gap:8px;margin-top:12px;"></div>
        </div>

      </div>

      {{-- ── Kolom Kanan ── --}}
      <div style="display:flex;flex-direction:column;gap:16px;position:sticky;top:20px;">

        {{-- Foto Utama --}}
        <div class="card" style="padding:20px;">
          <div style="font-size:12px;font-weight:700;color:var(--text-3);text-transform:uppercase;letter-spacing:.07em;margin-bottom:4px;">Foto Utama</div>
          <div style="font-size:12px;color:var(--text-3);margin-bottom:12px;">Kosongkan jika tidak diganti</div>

          <div id="main-preview"
               style="aspect-ratio:1;border-radius:10px;overflow:hidden;cursor:pointer;position:relative;border:1.5px solid var(--border);"
               onclick="document.getElementById('main-input').click()">
            @if($produk->image)
              <img src="{{ Storage::url($produk->image) }}" id="main-img" style="width:100%;height:100%;object-fit:cover;" />
              <div style="position:absolute;inset:0;background:rgba(0,0,0,0);transition:background .2s;display:flex;align-items:center;justify-content:center;" id="main-hover">
                <div style="background:rgba(0,0,0,.5);border-radius:8px;padding:6px 12px;color:#fff;font-size:12px;font-weight:600;opacity:0;transition:opacity .2s;" id="main-hover-label">Ganti Foto</div>
              </div>
            @else
              <div style="width:100%;height:100%;background:var(--page-bg);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;">
                <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--text-3);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/></svg>
                <span style="font-size:12px;color:var(--text-3);">Upload foto utama</span>
              </div>
            @endif
          </div>
          <input type="file" id="main-input" name="image" accept="image/*" class="sr-only" onchange="previewMain(this)" />
          @error('image')<div class="form-error" style="margin-top:8px;">{{ $message }}</div>@enderror
        </div>

        {{-- Harga & Logistik --}}
        <div class="card" style="padding:20px;">
          <div style="font-size:12px;font-weight:700;color:var(--text-3);text-transform:uppercase;letter-spacing:.07em;margin-bottom:18px;padding-bottom:12px;border-bottom:1px solid var(--border-light);">
            Harga & Logistik
          </div>

          <div style="margin-bottom:14px;">
            <label class="form-label">Harga (Rp) <span class="req">*</span></label>
            <div style="position:relative;">
              <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:13px;font-weight:600;color:var(--text-3);">Rp</span>
              <input type="number" name="price" value="{{ old('price',(int)$produk->price) }}" min="0" step="500"
                     class="form-input" style="padding-left:36px;" />
            </div>
            @error('price')<div class="form-error">{{ $message }}</div>@enderror
          </div>

          <div style="margin-bottom:14px;">
            <label class="form-label">Berat <span class="req">*</span></label>
            <div style="position:relative;">
              <input type="number" name="weight" value="{{ old('weight',$produk->weight) }}" min="1"
                     class="form-input" style="padding-right:40px;" />
              <span style="position:absolute;right:12px;top:50%;transform:translateY(-50%);font-size:12px;color:var(--text-3);">gram</span>
            </div>
          </div>

          <div>
            <label class="form-label">Stok <span class="req">*</span></label>
            <input type="number" name="stock" value="{{ old('stock',$produk->stock) }}" min="0" max="999"
                   class="form-input" />
          </div>
        </div>

        {{-- Status --}}
        <div class="card" style="padding:20px;">
          <div style="font-size:12px;font-weight:700;color:var(--text-3);text-transform:uppercase;letter-spacing:.07em;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid var(--border-light);">
            Status Produk
          </div>
          <div style="display:flex;flex-direction:column;gap:8px;">
            @foreach([
              ['available','Tersedia',      'Tampil di katalog untuk pembeli','#DCFCE7','#15803D'],
              ['sold',     'Terjual',       'Tandai produk sudah terjual',    '#F1F5F9','#475569'],
              ['hidden',   'Disembunyikan', 'Tidak tampil di katalog',        '#FEE2E2','#B91C1C'],
            ] as [$val,$label,$desc,$bg,$color])
              @php $checked = old('status',$produk->status)===$val; @endphp
              <label style="display:flex;align-items:center;gap:11px;padding:12px 13px;border:1.5px solid {{ $checked?$color:'var(--border)' }};border-radius:8px;cursor:pointer;background:{{ $checked?$bg:'transparent' }};transition:all .15s;"
                     class="status-label" data-bg="{{ $bg }}" data-color="{{ $color }}">
                <input type="radio" name="status" value="{{ $val }}" {{ $checked?'checked':'' }}
                       style="accent-color:#10B981;" class="status-radio" />
                <div>
                  <div style="font-size:13px;font-weight:700;color:var(--text-1);">{{ $label }}</div>
                  <div style="font-size:11.5px;color:var(--text-3);margin-top:1px;">{{ $desc }}</div>
                </div>
              </label>
            @endforeach
          </div>
          @error('status')<div class="form-error" style="margin-top:8px;">{{ $message }}</div>@enderror
        </div>

        {{-- Actions --}}
        <div style="display:flex;flex-direction:column;gap:8px;">
          <button type="submit" class="btn btn-primary" style="justify-content:center;padding:12px;">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Simpan Perubahan
          </button>
          <a href="{{ route('admin.produk.index') }}" class="btn btn-ghost" style="justify-content:center;padding:12px;">
            Batal
          </a>
        </div>

      </div>
    </div>
  </form>
</div>

<style>
  .sr-only { position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0,0,0,0); }
</style>

@endsection

@push('scripts')
<script>
  // ── Preview foto utama ──────────────────────────────
  function previewMain(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
      const wrap = document.getElementById('main-preview');
      wrap.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;" />`;
      wrap.style.border = '1.5px solid #10B981';
    };
    reader.readAsDataURL(input.files[0]);
  }

  // ── Hover pada foto utama --
  const mainHover = document.getElementById('main-hover');
  const mainLabel = document.getElementById('main-hover-label');
  if (mainHover) {
    document.getElementById('main-preview').addEventListener('mouseenter', () => {
      mainHover.style.background = 'rgba(0,0,0,.35)';
      mainLabel.style.opacity = '1';
    });
    document.getElementById('main-preview').addEventListener('mouseleave', () => {
      mainHover.style.background = 'rgba(0,0,0,0)';
      mainLabel.style.opacity = '0';
    });
  }

  // ── Preview foto tambahan ───────────────────────────
  function previewGallery(input) {
    const wrap = document.getElementById('gallery-preview');
    wrap.innerHTML = '';
    if (!input.files || input.files.length === 0) { wrap.style.display='none'; return; }
    wrap.style.display = 'grid';
    Array.from(input.files).slice(0,5).forEach(file => {
      const reader = new FileReader();
      reader.onload = e => {
        const div = document.createElement('div');
        div.style.cssText = 'aspect-ratio:1;border-radius:8px;overflow:hidden;border:1px solid #A7F3D0;background:var(--page-bg);';
        div.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;" />`;
        wrap.appendChild(div);
      };
      reader.readAsDataURL(file);
    });
  }

  // ── Drag & Drop gallery ─────────────────────────────
  const dz = document.getElementById('gallery-dropzone');
  dz.addEventListener('dragover', e => { e.preventDefault(); dz.style.borderColor='#10B981'; dz.style.background='#F0FDF4'; });
  dz.addEventListener('dragleave', () => { dz.style.borderColor='var(--border)'; dz.style.background='transparent'; });
  dz.addEventListener('drop', e => {
    e.preventDefault(); dz.style.borderColor='var(--border)'; dz.style.background='transparent';
    const input = document.getElementById('gallery-input');
    input.files = e.dataTransfer.files;
    previewGallery(input);
  });

  // ── Delete foto yang ada ────────────────────────────
  document.querySelectorAll('.delete-img-cb').forEach(cb => {
    cb.addEventListener('change', () => {
      const wrap   = cb.closest('label').querySelector('.del-img-wrap');
      const overlay= cb.closest('label').querySelector('.del-overlay');
      const icon   = overlay.querySelector('svg');
      const label  = cb.closest('label').querySelector('.del-label');
      if (cb.checked) {
        wrap.style.borderColor = '#EF4444';
        overlay.style.background = 'rgba(239,68,68,.55)';
        icon.style.opacity = '1';
        label.style.color = '#B91C1C';
        label.textContent = 'Hapus';
      } else {
        wrap.style.borderColor = 'var(--border)';
        overlay.style.background = 'rgba(239,68,68,0)';
        icon.style.opacity = '0';
        label.style.color = 'var(--text-3)';
      }
    });
  });

  // ── Condition radio highlight ───────────────────────
  document.querySelectorAll('.condition-radio').forEach(radio => {
    radio.addEventListener('change', () => {
      document.querySelectorAll('.condition-radio').forEach(r => {
        r.nextElementSibling.style.borderColor = 'var(--border)';
        r.nextElementSibling.style.background = 'var(--card-bg)';
      });
      if (radio.checked) {
        radio.nextElementSibling.style.borderColor = '#10B981';
        radio.nextElementSibling.style.background = radio.dataset.bg;
      }
    });
  });

  // ── Status radio highlight ──────────────────────────
  document.querySelectorAll('.status-radio').forEach(radio => {
    radio.addEventListener('change', () => {
      document.querySelectorAll('.status-label').forEach(l => {
        l.style.borderColor = 'var(--border)'; l.style.background = 'transparent';
      });
      if (radio.checked) {
        const label = radio.closest('.status-label');
        label.style.borderColor = label.dataset.color;
        label.style.background = label.dataset.bg;
      }
    });
  });
</script>
@endpush