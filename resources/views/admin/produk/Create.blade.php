@extends('admin.layouts.app')
@section('title', 'Tambah Produk')
@section('breadcrumb')
  <a href="{{ route('admin.produk.index') }}">Produk</a>
  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
  <span>Tambah Produk</span>
@endsection

@section('content')

<div style="max-width:960px;">

  {{-- ── Header ── --}}
  <div style="display:flex;align-items:center;gap:14px;margin-bottom:28px;">
    <a href="{{ route('admin.produk.index') }}" class="btn btn-ghost btn-sm btn-icon">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <div>
      <div style="font-size:22px;font-weight:800;color:var(--text-1);letter-spacing:-.02em;">Tambah Produk</div>
      <div style="font-size:13px;color:var(--text-3);margin-top:3px;">Isi semua informasi produk dengan lengkap dan akurat.</div>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data">
    @csrf

    <div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;">

      {{-- ── Kolom Kiri ── --}}
      <div style="display:flex;flex-direction:column;gap:16px;">

        {{-- Informasi Dasar --}}
        <div class="card" style="padding:24px;">
          <div style="font-size:12px;font-weight:700;color:var(--text-3);text-transform:uppercase;letter-spacing:.07em;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid var(--border-light);">
            Informasi Produk
          </div>

          {{-- Nama --}}
          <div style="margin-bottom:18px;">
            <label class="form-label">Nama Produk <span class="req">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}"
                   placeholder="contoh: Kemeja Flanel Merah Size M"
                   class="form-input {{ $errors->has('name') ? 'error' : '' }}" />
            @error('name')
              <div class="form-error">
                <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                {{ $message }}
              </div>
            @enderror
          </div>

          {{-- Kategori --}}
          <div style="margin-bottom:18px;">
            <label class="form-label">Kategori <span class="req">*</span></label>
            <select name="category_id" class="form-select {{ $errors->has('category_id') ? 'error' : '' }}">
              <option value="">— Pilih Kategori —</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
              @endforeach
            </select>
            @error('category_id')<div class="form-error">{{ $message }}</div>@enderror
          </div>

          {{-- Deskripsi --}}
          <div>
            <label class="form-label">Deskripsi Produk <span class="req">*</span></label>
            <textarea name="description" rows="5"
                      placeholder="Deskripsikan produk secara detail — merek, ukuran, warna, kelengkapan, riwayat penggunaan, dll."
                      class="form-textarea {{ $errors->has('description') ? 'error' : '' }}">{{ old('description') }}</textarea>
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
              ['like_new','Like New','Hampir sempurna, tidak ada cacat berarti','#DCFCE7','#15803D','#A7F3D0'],
              ['good',    'Good',    'Bekas pakai, masih layak dan fungsional', '#CCFBF1','#0F766E','#99F6E4'],
              ['fair',    'Fair',    'Ada cacat minor, perlu dicermati',         '#FFEDD5','#9A3412','#FED7AA'],
            ] as [$val,$label,$desc,$bg,$color,$border])
              <label style="cursor:pointer;position:relative;">
                <input type="radio" name="condition" value="{{ $val }}"
                       {{ old('condition') === $val ? 'checked' : '' }}
                       class="sr-only condition-radio" data-bg="{{ $bg }}" data-border="{{ $border }}" />
                <div class="condition-card" style="padding:14px;border:2px solid var(--border);border-radius:9px;text-align:center;transition:all .15s;background:var(--card-bg);">
                  <div style="font-size:13.5px;font-weight:700;color:var(--text-1);margin-bottom:4px;">{{ $label }}</div>
                  <div style="font-size:11.5px;color:var(--text-3);line-height:1.4;">{{ $desc }}</div>
                </div>
              </label>
            @endforeach
          </div>
          @error('condition')<div class="form-error" style="margin-bottom:10px;">{{ $message }}</div>@enderror

          <div>
            <label class="form-label">Catatan Kondisi <span class="hint">(opsional — deskripsikan kekurangan secara jujur)</span></label>
            <textarea name="condition_notes" rows="2"
                      placeholder="contoh: ada goresan kecil di sudut, semua fungsi normal..."
                      class="form-textarea">{{ old('condition_notes') }}</textarea>
            @error('condition_notes')<div class="form-error">{{ $message }}</div>@enderror
          </div>
        </div>

        {{-- Foto Tambahan --}}
        <div class="card" style="padding:24px;">
          <div style="font-size:12px;font-weight:700;color:var(--text-3);text-transform:uppercase;letter-spacing:.07em;margin-bottom:4px;">
            Foto Tambahan
          </div>
          <div style="font-size:12px;color:var(--text-3);margin-bottom:16px;">Maksimal 5 foto pendukung (JPG/PNG/WEBP, maks. 3 MB/foto)</div>

          <div id="gallery-dropzone"
               style="border:2px dashed var(--border);border-radius:10px;padding:28px;text-align:center;cursor:pointer;transition:all .2s;"
               onmouseenter="this.style.borderColor='#10B981';this.style.background='#F0FDF4';"
               onmouseleave="this.style.borderColor='var(--border)';this.style.background='transparent';"
               onclick="document.getElementById('gallery-input').click()">
            <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--text-3);margin:0 auto 10px;display:block;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <div style="font-size:13.5px;font-weight:600;color:var(--text-2);margin-bottom:4px;">Klik atau seret foto ke sini</div>
            <div style="font-size:12px;color:var(--text-3);">Bisa pilih lebih dari satu file sekaligus</div>
          </div>
          <input type="file" id="gallery-input" name="images[]" multiple accept="image/*" class="sr-only"
                 onchange="previewGallery(this)" />
          <div id="gallery-preview" style="display:none;grid-template-columns:repeat(5,1fr);gap:8px;margin-top:12px;"></div>

          @error('images')<div class="form-error" style="margin-top:8px;">{{ $message }}</div>@enderror
          @error('images.*')<div class="form-error" style="margin-top:8px;">{{ $message }}</div>@enderror
        </div>

      </div>

      {{-- ── Kolom Kanan ── --}}
      <div style="display:flex;flex-direction:column;gap:16px;position:sticky;top:20px;">

        {{-- Foto Utama --}}
        <div class="card" style="padding:20px;">
          <div style="font-size:12px;font-weight:700;color:var(--text-3);text-transform:uppercase;letter-spacing:.07em;margin-bottom:4px;">Foto Utama <span style="color:var(--danger);">*</span></div>
          <div style="font-size:12px;color:var(--text-3);margin-bottom:12px;">JPG/PNG/WEBP, maks. 3 MB</div>

          <div id="main-preview"
               style="aspect-ratio:1;border:2px dashed var(--border);border-radius:10px;overflow:hidden;cursor:pointer;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;transition:all .2s;background:var(--page-bg);"
               onmouseenter="this.style.borderColor='#10B981';" onmouseleave="this.style.borderColor='var(--border)';"
               onclick="document.getElementById('main-input').click()">
            <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--text-3);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/></svg>
            <span style="font-size:12.5px;color:var(--text-3);text-align:center;padding:0 12px;">Klik untuk upload<br>foto utama</span>
          </div>
          <input type="file" id="main-input" name="image" accept="image/*" class="sr-only"
                 onchange="previewMain(this)" />
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
              <input type="number" name="price" value="{{ old('price') }}" placeholder="0" min="0" step="500"
                     class="form-input {{ $errors->has('price') ? 'error' : '' }}" style="padding-left:36px;" />
            </div>
            @error('price')<div class="form-error">{{ $message }}</div>@enderror
          </div>

          <div style="margin-bottom:14px;">
            <label class="form-label">Berat <span class="req">*</span></label>
            <div style="position:relative;">
              <input type="number" name="weight" value="{{ old('weight') }}" placeholder="contoh: 500" min="1"
                     class="form-input {{ $errors->has('weight') ? 'error' : '' }}" style="padding-right:40px;" />
              <span style="position:absolute;right:12px;top:50%;transform:translateY(-50%);font-size:12px;color:var(--text-3);">gram</span>
            </div>
            @error('weight')<div class="form-error">{{ $message }}</div>@enderror
          </div>

          <div>
            <label class="form-label">Stok <span class="req">*</span></label>
            <input type="number" name="stock" value="{{ old('stock', 1) }}" min="0" max="999"
                   class="form-input" />
            @error('stock')<div class="form-error">{{ $message }}</div>@enderror
          </div>
        </div>

        {{-- Status --}}
        <div class="card" style="padding:20px;">
          <div style="font-size:12px;font-weight:700;color:var(--text-3);text-transform:uppercase;letter-spacing:.07em;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid var(--border-light);">
            Status Produk
          </div>
          <div style="display:flex;flex-direction:column;gap:8px;">
            @foreach([
              ['available','Tersedia','Tampil di katalog untuk pembeli','#DCFCE7','#15803D'],
              ['hidden',   'Disembunyikan','Tidak tampil di katalog sementara','#FEE2E2','#B91C1C'],
            ] as [$val,$label,$desc,$bg,$color])
              @php $checked = old('status','available') === $val; @endphp
              <label style="display:flex;align-items:center;gap:11px;padding:12px 13px;border:1.5px solid {{ $checked ? $color : 'var(--border)' }};border-radius:8px;cursor:pointer;background:{{ $checked ? $bg : 'transparent' }};transition:all .15s;"
                     class="status-label" data-bg="{{ $bg }}" data-color="{{ $color }}">
                <input type="radio" name="status" value="{{ $val }}" {{ $checked ? 'checked' : '' }}
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
            Simpan Produk
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
  .condition-radio:checked ~ .condition-card {
    border-color: #10B981;
    background: #F0FDF4;
  }
</style>

@endsection

@push('scripts')
<script>
  // ── Preview foto utama ──────────────────────────────
  function previewMain(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
      const el = document.getElementById('main-preview');
      el.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;" />`;
      el.style.border = '2px solid #10B981';
    };
    reader.readAsDataURL(input.files[0]);
  }

  // ── Preview foto tambahan ───────────────────────────
  function previewGallery(input) {
    const wrap = document.getElementById('gallery-preview');
    wrap.innerHTML = '';
    if (!input.files || input.files.length === 0) { wrap.style.display = 'none'; return; }
    wrap.style.display = 'grid';
    Array.from(input.files).slice(0,5).forEach(file => {
      const reader = new FileReader();
      reader.onload = e => {
        const div = document.createElement('div');
        div.style.cssText = 'aspect-ratio:1;border-radius:8px;overflow:hidden;border:1px solid var(--border);background:var(--page-bg);';
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
    e.preventDefault();
    dz.style.borderColor='var(--border)'; dz.style.background='transparent';
    const input = document.getElementById('gallery-input');
    input.files = e.dataTransfer.files;
    previewGallery(input);
  });

  // ── Condition radio highlight ───────────────────────
  document.querySelectorAll('.condition-radio').forEach(radio => {
    if (radio.checked) {
      const card = radio.nextElementSibling;
      card.style.borderColor = '#10B981';
      card.style.background = radio.dataset.bg;
    }
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
        l.style.borderColor = 'var(--border)';
        l.style.background = 'transparent';
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