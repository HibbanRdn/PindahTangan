@extends('admin.layouts.app')
@section('title', 'Detail Pesanan')
@section('breadcrumb')
  <a href="{{ route('admin.pesanan.index') }}" class="hover:text-gray-900 transition-colors">Pesanan</a>
  <svg class="w-3 h-3 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
  </svg>
  <span class="text-gray-900 font-semibold">{{ $pesanan->order_code }}</span>
@endsection

@section('content')

<div class="max-w-5xl">

  {{-- ── Header ── --}}
  <div class="flex items-center justify-between gap-4 mb-6">
    <div class="flex items-center gap-4">
      <a href="{{ route('admin.pesanan.index') }}"
         class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 text-gray-500 hover:text-gray-900 hover:bg-gray-50 transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
      </a>
      <div>
        <h1 class="text-2xl font-black text-gray-900 tracking-tight">Detail Pesanan</h1>
        <p class="text-gray-400 text-sm font-mono mt-0.5">{{ $pesanan->order_code }}</p>
      </div>
    </div>

    {{-- FIX: Status badge map sesuai enum DB orders: pending, processing, shipped, completed, cancelled --}}
    @php
      $statusMap = [
        'pending'    => ['label' => 'Pending',    'class' => 'bg-yellow-100 text-yellow-700'],
        'processing' => ['label' => 'Diproses',   'class' => 'bg-indigo-100 text-indigo-700'],
        'shipped'    => ['label' => 'Dikirim',    'class' => 'bg-purple-100 text-purple-700'],
        'completed'  => ['label' => 'Selesai',    'class' => 'bg-emerald-100 text-emerald-700'],
        'cancelled'  => ['label' => 'Dibatalkan', 'class' => 'bg-red-100 text-red-600'],
      ];
      $st       = $statusMap[$pesanan->status] ?? ['label' => $pesanan->status, 'class' => 'bg-gray-100 text-gray-600'];
      $isFinal  = in_array($pesanan->status, ['completed', 'cancelled']);
    @endphp
    <span class="px-4 py-1.5 rounded-full text-xs font-black {{ $st['class'] }}">
      {{ $st['label'] }}
    </span>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── Kolom Kiri (2/3) ── --}}
    <div class="lg:col-span-2 space-y-5">

      {{-- Item Pesanan --}}
      <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
          <h2 class="text-sm font-black text-gray-900 uppercase tracking-widest">Item Pesanan</h2>
        </div>

        <div class="divide-y divide-gray-50">
          @foreach($pesanan->items as $item)
            <div class="px-6 py-4 flex gap-4 items-start">
              <div class="w-14 h-14 rounded-xl bg-gray-100 overflow-hidden shrink-0">
                @if($item->product?->image)
                  <img src="{{ Storage::url($item->product->image) }}"
                       alt="{{ $item->product_name }}"
                       class="w-full h-full object-cover" />
                @else
                  <div class="w-full h-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                  </div>
                @endif
              </div>

              <div class="flex-1 min-w-0">
                <p class="font-bold text-gray-900 line-clamp-1">{{ $item->product_name }}</p>
                <div class="flex flex-wrap gap-2 mt-1">
                  @php
                    $condMap = [
                      'like_new' => ['Like New', 'bg-emerald-100 text-emerald-700'],
                      'good'     => ['Good',     'bg-blue-100 text-blue-700'],
                      'fair'     => ['Fair',     'bg-orange-100 text-orange-700'],
                    ];
                    [$cl, $cc] = $condMap[$item->product_condition] ?? [$item->product_condition, 'bg-gray-100 text-gray-600'];
                  @endphp
                  <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $cc }}">{{ $cl }}</span>
                  <span class="text-xs text-gray-400">× {{ $item->quantity }}</span>
                </div>
              </div>

              <div class="text-right shrink-0">
                <p class="font-bold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400 mt-0.5">@ Rp {{ number_format($item->product_price, 0, ',', '.') }}</p>
              </div>
            </div>
          @endforeach
        </div>

        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 space-y-2">
          <div class="flex justify-between text-sm text-gray-600">
            <span>Subtotal</span>
            <span>Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}</span>
          </div>
          <div class="flex justify-between text-sm text-gray-600">
            <span>Ongkos Kirim ({{ $pesanan->courier }} – {{ $pesanan->courier_service }})</span>
            <span>Rp {{ number_format($pesanan->shipping_cost, 0, ',', '.') }}</span>
          </div>
          @if($pesanan->notes)
            <div class="text-xs text-gray-400 pt-1 border-t border-gray-200">
              Catatan: {{ $pesanan->notes }}
            </div>
          @endif
          <div class="flex justify-between font-black text-gray-900 text-base border-t border-gray-200 pt-2 mt-2">
            <span>Total Pembayaran</span>
            <span>Rp {{ number_format($pesanan->total_amount, 0, ',', '.') }}</span>
          </div>
        </div>
      </div>

      {{-- Info Pembayaran --}}
      <div class="bg-white border border-gray-100 rounded-2xl p-6">
        <h2 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-4">Informasi Pembayaran</h2>

        @if($pesanan->payment)
          @php
            // Status di tabel payments: pending, paid, failed, expired
            $payStatus = [
              'pending' => ['Menunggu',   'bg-yellow-100 text-yellow-700'],
              'paid'    => ['Lunas',      'bg-emerald-100 text-emerald-700'],
              'failed'  => ['Gagal',      'bg-red-100 text-red-600'],
              'expired' => ['Kadaluarsa', 'bg-gray-100 text-gray-500'],
            ];
            [$pl, $pc] = $payStatus[$pesanan->payment->status] ?? [$pesanan->payment->status, 'bg-gray-100 text-gray-600'];
          @endphp
          <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
              <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1">Status</p>
              <span class="px-2.5 py-1 rounded-full text-[10px] font-black {{ $pc }}">{{ $pl }}</span>
            </div>
            <div>
              <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1">Metode</p>
              <p class="font-bold text-gray-900">{{ $pesanan->payment->payment_method ?? '—' }}</p>
            </div>
            <div>
              <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1">Transaction ID</p>
              <p class="font-mono text-xs text-gray-500">{{ $pesanan->payment->transaction_id ?? '—' }}</p>
            </div>
            <div>
              <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1">Dibayar</p>
              <p class="text-gray-700">
                {{ $pesanan->payment->paid_at ? $pesanan->payment->paid_at->format('d M Y, H:i') : '—' }}
              </p>
            </div>
          </div>
        @else
          <p class="text-sm text-gray-400 italic">Belum ada data pembayaran.</p>
        @endif
      </div>

      {{-- Testimoni --}}
      @if($pesanan->testimonial)
        <div class="bg-white border border-gray-100 rounded-2xl p-6">
          <h2 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-4">Testimoni Pembeli</h2>

          <div class="flex items-center gap-1 mb-3">
            @for($i = 1; $i <= 5; $i++)
              <svg class="w-4 h-4 {{ $i <= $pesanan->testimonial->rating ? 'text-yellow-400' : 'text-gray-200' }}"
                   fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
              </svg>
            @endfor
            <span class="text-sm font-bold text-gray-700 ml-1">{{ $pesanan->testimonial->rating }}/5</span>
            <span class="ml-2 px-2 py-0.5 rounded-full text-[10px] font-bold
              {{ $pesanan->testimonial->status === 'approved' ? 'bg-emerald-100 text-emerald-700' :
                 ($pesanan->testimonial->status === 'pending'  ? 'bg-yellow-100 text-yellow-700' :
                                                                  'bg-red-100 text-red-600') }}">
              {{ ucfirst($pesanan->testimonial->status) }}
            </span>
          </div>

          <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ $pesanan->testimonial->comment }}</p>

          @if($pesanan->testimonial->images->count() > 0)
            <div class="flex flex-wrap gap-2">
              @foreach($pesanan->testimonial->images->sortBy('sort_order') as $img)
                <div class="w-16 h-16 rounded-xl overflow-hidden border border-gray-100">
                  <img src="{{ Storage::url($img->image_path) }}" class="w-full h-full object-cover" />
                </div>
              @endforeach
            </div>
          @endif
        </div>
      @endif

    </div>

    {{-- ── Kolom Kanan (1/3) ── --}}
    <div class="space-y-5">

      {{-- Update Status --}}
      <div class="bg-white border border-gray-100 rounded-2xl p-6">
        <h2 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-4">Update Status</h2>

        @if($isFinal)
          <div class="p-3 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-500 text-center">
            Status <span class="font-bold">{{ $st['label'] }}</span> sudah final dan tidak dapat diubah.
          </div>
        @else
          <form method="POST" action="{{ route('admin.pesanan.updateStatus', $pesanan->id) }}">
            @csrf
            @method('PATCH')

            <div class="space-y-2 mb-4">
              {{-- FIX: nextStatuses disesuaikan dengan enum DB — tidak ada 'paid' di orders.status.
                   Alur: pending → processing → shipped → completed (cancelled bisa di semua tahap) --}}
              @php
                $nextStatuses = [
                  'pending'    => ['processing', 'cancelled'],
                  'processing' => ['shipped',    'cancelled'],
                  'shipped'    => ['completed',  'cancelled'],
                ];
                $available = $nextStatuses[$pesanan->status] ?? [];
              @endphp

              @if(empty($available))
                <p class="text-xs text-gray-400 italic text-center">Tidak ada status berikutnya yang tersedia.</p>
              @endif

              @foreach($available as $s)
                @php
                  $opt = $statusMap[$s] ?? ['label' => $s, 'class' => 'bg-gray-100 text-gray-600'];
                @endphp
                <label class="flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition-all duration-200
                              border-gray-100 hover:border-gray-300">
                  <input type="radio" name="status" value="{{ $s }}" class="accent-emerald-600" />
                  <div>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black {{ $opt['class'] }}">
                      {{ $opt['label'] }}
                    </span>
                  </div>
                </label>
              @endforeach
            </div>

            @if(!empty($available))
              <button type="submit"
                      class="w-full py-2.5 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-emerald-600 transition-colors duration-200">
                Simpan Status
              </button>
            @endif
          </form>
        @endif
      </div>

      {{-- Info Pembeli --}}
      <div class="bg-white border border-gray-100 rounded-2xl p-6">
        <h2 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-4">Pembeli</h2>
        <div class="flex items-center gap-3 mb-4">
          <div class="w-10 h-10 rounded-full bg-emerald-600 flex items-center justify-center text-white text-sm font-black shrink-0">
            {{ strtoupper(substr($pesanan->user?->name ?? '?', 0, 1)) }}
          </div>
          <div>
            <p class="font-bold text-gray-900">{{ $pesanan->user?->name ?? '—' }}</p>
            <p class="text-xs text-gray-400">{{ $pesanan->user?->email }}</p>
          </div>
        </div>
      </div>

      {{-- Alamat Pengiriman --}}
      <div class="bg-white border border-gray-100 rounded-2xl p-6">
        <h2 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-4">Alamat Kirim</h2>

        @if($pesanan->address)
          <div class="text-sm space-y-1.5">
            <p class="font-bold text-gray-900">{{ $pesanan->address->recipient_name }}</p>
            <p class="text-gray-500">{{ $pesanan->address->phone }}</p>
            <p class="text-gray-600 leading-relaxed">
              {{ $pesanan->address->address_detail }},<br/>
              {{ $pesanan->address->city_name }},
              {{ $pesanan->address->province_name }}
              {{ $pesanan->address->postal_code }}
            </p>
          </div>
        @else
          <p class="text-sm text-gray-400 italic">Belum ada alamat.</p>
        @endif
      </div>

      {{-- Pengiriman --}}
      <div class="bg-white border border-gray-100 rounded-2xl p-6">
        <h2 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-4">Pengiriman</h2>
        <div class="space-y-2 text-sm">
          <div class="flex justify-between">
            <span class="text-gray-500">Kurir</span>
            <span class="font-bold text-gray-900 uppercase">{{ $pesanan->courier ?? '—' }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-500">Layanan</span>
            <span class="font-bold text-gray-900">{{ $pesanan->courier_service ?? '—' }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-500">Estimasi</span>
            <span class="font-bold text-gray-900">{{ $pesanan->shipping_estimate ?? '—' }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-500">Ongkir</span>
            <span class="font-bold text-gray-900">Rp {{ number_format($pesanan->shipping_cost, 0, ',', '.') }}</span>
          </div>
        </div>
      </div>

      {{-- Timestamps --}}
      <div class="bg-white border border-gray-100 rounded-2xl p-6">
        <h2 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-3">Timeline</h2>
        <div class="space-y-2 text-xs text-gray-500">
          <div class="flex justify-between">
            <span>Dibuat</span>
            <span class="font-semibold text-gray-700">{{ $pesanan->created_at->format('d M Y, H:i') }}</span>
          </div>
          <div class="flex justify-between">
            <span>Diperbarui</span>
            <span class="font-semibold text-gray-700">{{ $pesanan->updated_at->format('d M Y, H:i') }}</span>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

@endsection