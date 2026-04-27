@extends('admin.layouts.app')
@section('title', 'Detail Pesanan')
@section('breadcrumb')
  <a href="{{ route('admin.pesanan.index') }}">Pesanan</a>
  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
  <span>{{ $pesanan->order_code }}</span>
@endsection

@section('content')

@php
  $statusMap = [
    'pending'    => ['Pending',    'badge-yellow', '#FEF9C3', '#854D0E'],
    'processing' => ['Diproses',   'badge-teal',   '#CCFBF1', '#0F766E'],
    'shipped'    => ['Dikirim',    'badge-purple', '#F3E8FF', '#7E22CE'],
    'completed'  => ['Selesai',    'badge-green',  '#DCFCE7', '#15803D'],
    'cancelled'  => ['Dibatalkan', 'badge-red',    '#FEE2E2', '#B91C1C'],
  ];
  [$sl, $sc, $sbg, $scolor] = $statusMap[$pesanan->status] ?? [$pesanan->status,'badge-gray','#F1F5F9','#475569'];
  $isFinal = in_array($pesanan->status, ['completed','cancelled']);
@endphp

{{-- ── Header ── --}}
<div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;">
  <div style="display:flex;align-items:center;gap:14px;">
    <a href="{{ route('admin.pesanan.index') }}" class="btn btn-ghost btn-sm btn-icon">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <div>
      <div style="font-size:22px;font-weight:800;color:var(--text-1);letter-spacing:-.02em;">Detail Pesanan</div>
      <div class="font-mono" style="font-size:12.5px;color:var(--text-3);margin-top:2px;">{{ $pesanan->order_code }}</div>
    </div>
  </div>
  <span class="badge {{ $sc }}" style="font-size:12px;padding:5px 14px;">{{ $sl }}</span>
</div>

<div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;">

  {{-- ── Kolom Kiri ── --}}
  <div style="display:flex;flex-direction:column;gap:16px;">

    {{-- Items --}}
    <div class="card" style="overflow:hidden;">
      <div class="card-header">
        <div class="card-title">Item Pesanan</div>
        <span style="font-size:12px;color:var(--text-3);">{{ $pesanan->items->count() }} item</span>
      </div>
      <div>
        @foreach($pesanan->items as $item)
          @php
            $condMap = [
              'like_new' => ['Like New','badge-green'],
              'good'     => ['Good',    'badge-blue'],
              'fair'     => ['Fair',    'badge-orange'],
            ];
            [$cl,$cc] = $condMap[$item->product_condition] ?? [$item->product_condition,'badge-gray'];
          @endphp
          <div style="padding:16px 20px;display:flex;gap:14px;align-items:flex-start;border-bottom:1px solid var(--border-light);">
            <div style="width:52px;height:52px;border-radius:8px;overflow:hidden;background:var(--page-bg);border:1px solid var(--border);flex-shrink:0;">
              @if($item->product?->image)
                <img src="{{ Storage::url($item->product->image) }}" style="width:100%;height:100%;object-fit:cover;" />
              @else
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                  <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--text-3);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
              @endif
            </div>
            <div style="flex:1;min-width:0;">
              <div style="font-weight:600;font-size:13.5px;margin-bottom:5px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $item->product_name }}</div>
              <div style="display:flex;align-items:center;gap:8px;">
                <span class="badge {{ $cc }}" style="font-size:10.5px;">{{ $cl }}</span>
                <span style="font-size:12px;color:var(--text-3);">× {{ $item->quantity }}</span>
                <span style="font-size:12px;color:var(--text-3);">@ Rp {{ number_format($item->product_price, 0, ',', '.') }}</span>
              </div>
            </div>
            <div style="text-align:right;flex-shrink:0;">
              <div style="font-weight:700;font-size:14px;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
            </div>
          </div>
        @endforeach
      </div>
      {{-- Summary --}}
      <div style="padding:16px 20px;background:#FAFBFC;">
        <div style="display:flex;justify-content:space-between;font-size:13px;color:var(--text-2);margin-bottom:8px;">
          <span>Subtotal</span>
          <span>Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;font-size:13px;color:var(--text-2);margin-bottom:12px;">
          <span>Ongkos Kirim ({{ strtoupper($pesanan->courier ?? '-') }} {{ $pesanan->courier_service }})</span>
          <span>Rp {{ number_format($pesanan->shipping_cost, 0, ',', '.') }}</span>
        </div>
        @if($pesanan->notes)
          <div style="font-size:12px;color:var(--text-3);padding:10px 12px;background:var(--page-bg);border-radius:7px;margin-bottom:12px;border:1px solid var(--border);">
            📝 {{ $pesanan->notes }}
          </div>
        @endif
        <div style="display:flex;justify-content:space-between;padding-top:12px;border-top:1px solid var(--border);font-weight:800;font-size:15px;color:var(--text-1);">
          <span>Total Pembayaran</span>
          <span>Rp {{ number_format($pesanan->total_amount, 0, ',', '.') }}</span>
        </div>
      </div>
    </div>

    {{-- Payment --}}
    <div class="card" style="padding:20px;">
      <div class="card-title" style="margin-bottom:16px;">Informasi Pembayaran</div>
      @if($pesanan->payment)
        @php
          $payS = [
            'pending' => ['Menunggu',   'badge-yellow'],
            'paid'    => ['Lunas',      'badge-green'],
            'failed'  => ['Gagal',      'badge-red'],
            'expired' => ['Kadaluarsa','badge-gray'],
          ];
          [$pyl,$pyc] = $payS[$pesanan->payment->status] ?? [$pesanan->payment->status,'badge-gray'];
        @endphp
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
          <div>
            <div style="font-size:11px;font-weight:600;color:var(--text-3);letter-spacing:.05em;text-transform:uppercase;margin-bottom:6px;">Status</div>
            <span class="badge {{ $pyc }}">{{ $pyl }}</span>
          </div>
          <div>
            <div style="font-size:11px;font-weight:600;color:var(--text-3);letter-spacing:.05em;text-transform:uppercase;margin-bottom:6px;">Metode</div>
            <div style="font-weight:600;font-size:13px;">{{ $pesanan->payment->payment_method ?? '—' }}</div>
          </div>
          <div>
            <div style="font-size:11px;font-weight:600;color:var(--text-3);letter-spacing:.05em;text-transform:uppercase;margin-bottom:6px;">Transaction ID</div>
            <div class="font-mono" style="font-size:12px;color:var(--text-2);">{{ $pesanan->payment->transaction_id ?? '—' }}</div>
          </div>
          <div>
            <div style="font-size:11px;font-weight:600;color:var(--text-3);letter-spacing:.05em;text-transform:uppercase;margin-bottom:6px;">Waktu Bayar</div>
            <div style="font-size:13px;">{{ $pesanan->payment->paid_at ? $pesanan->payment->paid_at->format('d M Y, H:i') : '—' }}</div>
          </div>
        </div>
      @else
        <div style="text-align:center;padding:20px;color:var(--text-3);font-size:13px;">Belum ada data pembayaran.</div>
      @endif
    </div>

    {{-- Testimonial --}}
    @if($pesanan->testimonial)
      <div class="card" style="padding:20px;">
        <div class="card-title" style="margin-bottom:16px;">Testimoni Pembeli</div>
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
          <div style="display:flex;gap:2px;">
            @for($i=1;$i<=5;$i++)
              <svg width="16" height="16" fill="{{ $i<=$pesanan->testimonial->rating ? '#F59E0B' : '#E2E8F0' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            @endfor
          </div>
          <span style="font-size:13px;font-weight:700;">{{ $pesanan->testimonial->rating }}/5</span>
          @php
            $tstS = ['approved'=>'badge-green','pending'=>'badge-yellow','rejected'=>'badge-red'];
          @endphp
          <span class="badge {{ $tstS[$pesanan->testimonial->status] ?? 'badge-gray' }}" style="font-size:11px;">
            {{ ucfirst($pesanan->testimonial->status) }}
          </span>
        </div>
        <p style="font-size:13.5px;color:var(--text-2);line-height:1.6;margin-bottom:14px;">{{ $pesanan->testimonial->comment }}</p>
        @if($pesanan->testimonial->images->count() > 0)
          <div style="display:flex;flex-wrap:wrap;gap:8px;">
            @foreach($pesanan->testimonial->images->sortBy('sort_order') as $img)
              <div style="width:64px;height:64px;border-radius:8px;overflow:hidden;border:1px solid var(--border);">
                <img src="{{ Storage::url($img->image_path) }}" style="width:100%;height:100%;object-fit:cover;" />
              </div>
            @endforeach
          </div>
        @endif
      </div>
    @endif

  </div>

  {{-- ── Kolom Kanan ── --}}
  <div style="display:flex;flex-direction:column;gap:16px;">

    {{-- Update Status --}}
    <div class="card" style="padding:20px;">
      <div class="card-title" style="margin-bottom:16px;">Update Status</div>
      @if($isFinal)
        <div style="padding:14px;background:var(--page-bg);border:1px solid var(--border);border-radius:8px;text-align:center;font-size:12.5px;color:var(--text-3);">
          Status <strong style="color:var(--text-1);">{{ $sl }}</strong> sudah final.
        </div>
      @else
        <form method="POST" action="{{ route('admin.pesanan.updateStatus', $pesanan->id) }}">
          @csrf @method('PATCH')
          @php
            $nextStatuses = [
              'pending'    => ['processing','cancelled'],
              'processing' => ['shipped',   'cancelled'],
              'shipped'    => ['completed', 'cancelled'],
            ];
            $available = $nextStatuses[$pesanan->status] ?? [];
          @endphp
          <div style="display:flex;flex-direction:column;gap:8px;margin-bottom:14px;">
            @foreach($available as $s)
              @php [$nl,$nc,$nbg,$ncolor] = $statusMap[$s] ?? [$s,'badge-gray','#F1F5F9','#475569']; @endphp
              <label style="display:flex;align-items:center;gap:10px;padding:11px 13px;border:1.5px solid var(--border);border-radius:8px;cursor:pointer;transition:border-color .15s;"
                     onmouseover="this.style.borderColor='{{ $ncolor }}'" onmouseout="this.style.borderColor='var(--border)'">
                <input type="radio" name="status" value="{{ $s }}" style="accent-color:#10B981;" />
                <span class="badge {{ $nc }}" style="font-size:11px;">{{ $nl }}</span>
              </label>
            @endforeach
          </div>
          <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
            Simpan Perubahan
          </button>
        </form>
      @endif
    </div>

    {{-- Pembeli --}}
    <div class="card" style="padding:20px;">
      <div class="card-title" style="margin-bottom:14px;">Pembeli</div>
      <div style="display:flex;align-items:center;gap:11px;">
        <div style="width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,#10B981,#059669);display:flex;align-items:center;justify-content:center;font-weight:800;font-size:15px;color:#fff;flex-shrink:0;">
          {{ strtoupper(substr($pesanan->user?->name ?? '?', 0, 1)) }}
        </div>
        <div style="min-width:0;">
          <div style="font-weight:700;font-size:13.5px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $pesanan->user?->name ?? '—' }}</div>
          <div style="font-size:12px;color:var(--text-3);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $pesanan->user?->email }}</div>
        </div>
      </div>
    </div>

    {{-- Alamat --}}
    <div class="card" style="padding:20px;">
      <div class="card-title" style="margin-bottom:14px;">Alamat Pengiriman</div>
      @if($pesanan->address)
        <div style="font-size:13px;line-height:1.65;color:var(--text-2);">
          <div style="font-weight:700;color:var(--text-1);margin-bottom:2px;">{{ $pesanan->address->recipient_name }}</div>
          <div style="margin-bottom:2px;">{{ $pesanan->address->phone }}</div>
          <div>{{ $pesanan->address->address_detail }}, {{ $pesanan->address->city_name }}, {{ $pesanan->address->province_name }} {{ $pesanan->address->postal_code }}</div>
        </div>
      @else
        <div style="font-size:13px;color:var(--text-3);font-style:italic;">Belum ada alamat.</div>
      @endif
    </div>

    {{-- Pengiriman --}}
    <div class="card" style="padding:20px;">
      <div class="card-title" style="margin-bottom:14px;">Pengiriman</div>
      <div style="display:flex;flex-direction:column;gap:10px;font-size:13px;">
        @foreach([
          ['Kurir', strtoupper($pesanan->courier ?? '—')],
          ['Layanan', $pesanan->courier_service ?? '—'],
          ['Estimasi', $pesanan->shipping_estimate ?? '—'],
          ['Ongkir', 'Rp '.number_format($pesanan->shipping_cost,0,',','.')],
        ] as [$label,$val])
          <div style="display:flex;justify-content:space-between;align-items:center;">
            <span style="color:var(--text-3);">{{ $label }}</span>
            <span style="font-weight:600;color:var(--text-1);">{{ $val }}</span>
          </div>
        @endforeach
      </div>
    </div>

    {{-- Timeline --}}
    <div class="card" style="padding:20px;">
      <div class="card-title" style="margin-bottom:14px;">Timeline</div>
      <div style="display:flex;flex-direction:column;gap:10px;font-size:12.5px;">
        <div style="display:flex;justify-content:space-between;align-items:center;">
          <span style="color:var(--text-3);">Dibuat</span>
          <span style="font-weight:600;">{{ $pesanan->created_at->format('d M Y, H:i') }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;align-items:center;">
          <span style="color:var(--text-3);">Diperbarui</span>
          <span style="font-weight:600;">{{ $pesanan->updated_at->format('d M Y, H:i') }}</span>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection