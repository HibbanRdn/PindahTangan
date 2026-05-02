@extends('admin.layouts.app')
@section('title', 'Testimoni')
@section('breadcrumb')
  <span>Testimoni</span>
@endsection

@section('content')

<style>
  /* ── Tab Bar ───────────────────────────────────── */
  .tab-bar {
    display: flex;
    gap: 3px;
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 4px;
    width: fit-content;
  }
  .tab-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 7px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    color: var(--text-3);
    transition: all .15s;
    white-space: nowrap;
  }
  .tab-btn:hover { color: var(--text-1); background: var(--page-bg); }
  .tab-btn.active { background: var(--text-1); color: #fff; }
  .tab-pill {
    font-size: 10.5px;
    font-weight: 700;
    padding: 1px 6px;
    border-radius: 20px;
    background: rgba(255,255,255,.2);
    color: inherit;
    line-height: 1.5;
  }
  .tab-btn:not(.active) .tab-pill {
    background: var(--border-light);
    color: var(--text-3);
  }

  /* ── Star Rating ───────────────────────────────── */
  .stars-row { display: inline-flex; gap: 2px; }
  .stars-row svg { width: 13px; height: 13px; }

  /* ── Thumbnail strip ───────────────────────────── */
  .thumb-strip { display: flex; gap: 4px; flex-wrap: wrap; }
  .thumb-item {
    width: 38px; height: 38px;
    border-radius: 6px;
    overflow: hidden;
    border: 1px solid var(--border);
    background: var(--page-bg);
    flex-shrink: 0;
  }
  .thumb-item img { width: 100%; height: 100%; object-fit: cover; display: block; }

  /* ── Comment clamp ─────────────────────────────── */
  .comment-clamp {
    font-size: 12.5px;
    color: var(--text-2);
    line-height: 1.55;
    max-width: 260px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  /* ── Action pair ───────────────────────────────── */
  .action-pair { display: flex; gap: 6px; justify-content: flex-end; flex-wrap: wrap; }

  /* ── Page entrance ─────────────────────────────── */
  @keyframes fadeUp {
    from { opacity:0; transform:translateY(8px); }
    to   { opacity:1; transform:translateY(0); }
  }
  .fade-up { animation: fadeUp .35s cubic-bezier(.22,1,.36,1) both; }
  .fade-up-1 { animation-delay:.04s; }
  .fade-up-2 { animation-delay:.08s; }
</style>

{{-- ── Page Header ── --}}
<div style="margin-bottom:24px;" class="fade-up">
  <div style="font-size:22px;font-weight:800;color:var(--text-1);letter-spacing:-.02em;">
    Moderasi Testimoni
  </div>
  <div style="font-size:13.5px;color:var(--text-3);margin-top:3px;">
    Review dan publish ulasan dari pembeli
    @if(($counts['pending'] ?? 0) > 0)
      —
      <span style="color:#d97706;font-weight:700;">{{ $counts['pending'] }} menunggu review</span>
    @endif
  </div>
</div>

{{-- ── Tab Filter ── --}}
<div class="tab-bar fade-up fade-up-1" style="margin-bottom:20px;">
  <a href="{{ route('admin.testimoni.index') }}"
     class="tab-btn {{ !request('status') ? 'active' : '' }}">
    Semua
    <span class="tab-pill">{{ $counts['all'] ?? 0 }}</span>
  </a>
  <a href="{{ route('admin.testimoni.index', ['status' => 'pending']) }}"
     class="tab-btn {{ request('status') === 'pending' ? 'active' : '' }}">
    Pending
    <span class="tab-pill">{{ $counts['pending'] ?? 0 }}</span>
  </a>
  <a href="{{ route('admin.testimoni.index', ['status' => 'approved']) }}"
     class="tab-btn {{ request('status') === 'approved' ? 'active' : '' }}">
    Approved
    <span class="tab-pill">{{ $counts['approved'] ?? 0 }}</span>
  </a>
  <a href="{{ route('admin.testimoni.index', ['status' => 'rejected']) }}"
     class="tab-btn {{ request('status') === 'rejected' ? 'active' : '' }}">
    Rejected
    <span class="tab-pill">{{ $counts['rejected'] ?? 0 }}</span>
  </a>
</div>

{{-- ── Table ── --}}
<div class="card fade-up fade-up-2" style="overflow:hidden;">
  <div style="overflow-x:auto;">
    <table class="data-table">
      <thead>
        <tr>
          <th>Pembeli</th>
          <th>Rating</th>
          <th>Komentar</th>
          <th>Foto</th>
          <th>Produk</th>
          <th>Tanggal</th>
          <th>Status</th>
          <th style="text-align:right;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($testimonials as $t)
          <tr>

            {{-- Pembeli --}}
            <td>
              <div style="display:flex;align-items:center;gap:9px;">
                @php
                  $initials = collect(explode(' ', $t->user->name))
                    ->take(2)->map(fn($w) => strtoupper($w[0]))->join('');
                @endphp
                <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#d1fae5,#a7f3d0);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:800;color:#065f46;flex-shrink:0;">
                  {{ $initials }}
                </div>
                <div style="min-width:0;">
                  <div style="font-size:13px;font-weight:700;color:var(--text-1);white-space:nowrap;">
                    {{ $t->user->name }}
                  </div>
                  <div style="font-size:11.5px;color:var(--text-3);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:130px;">
                    {{ $t->user->email }}
                  </div>
                  <div style="font-size:11px;color:var(--text-3);margin-top:1px;">
                    <span class="font-mono" style="background:var(--page-bg);padding:1px 5px;border-radius:4px;border:1px solid var(--border);">
                      {{ $t->order->order_code }}
                    </span>
                  </div>
                </div>
              </div>
            </td>

            {{-- Rating --}}
            <td>
              <div class="stars-row">
                @for($s = 1; $s <= 5; $s++)
                  <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                       style="fill:{{ $s <= $t->rating ? '#f59e0b' : '#e5e7eb' }}">
                    <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                  </svg>
                @endfor
              </div>
              <div style="font-size:11.5px;color:var(--text-3);margin-top:3px;">
                {{ $t->rating }}/5
              </div>
            </td>

            {{-- Komentar --}}
            <td>
              <p class="comment-clamp">"{{ $t->comment }}"</p>
            </td>

            {{-- Foto --}}
            <td>
              @if($t->images->isNotEmpty())
                <div class="thumb-strip">
                  @foreach($t->images->take(3) as $img)
                    <div class="thumb-item">
                      <img src="{{ Storage::url($img->image_path) }}" alt="foto" />
                    </div>
                  @endforeach
                  @if($t->images->count() > 3)
                    <div class="thumb-item" style="display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:var(--text-3);">
                      +{{ $t->images->count() - 3 }}
                    </div>
                  @endif
                </div>
              @else
                <span style="font-size:12px;color:var(--text-3);">—</span>
              @endif
            </td>

            {{-- Produk --}}
            <td>
              @php $firstItem = $t->order->items->first(); @endphp
              @if($firstItem)
                <div style="font-size:12.5px;font-weight:600;color:var(--text-1);max-width:140px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;line-height:1.4;">
                  {{ $firstItem->product_name }}
                </div>
                @if($t->order->items->count() > 1)
                  <div style="font-size:11px;color:var(--text-3);margin-top:2px;">
                    +{{ $t->order->items->count() - 1 }} item lainnya
                  </div>
                @endif
              @else
                <span style="font-size:12px;color:var(--text-3);">—</span>
              @endif
            </td>

            {{-- Tanggal --}}
            <td>
              <div style="font-size:12.5px;color:var(--text-2);white-space:nowrap;">
                {{ $t->created_at->format('d M Y') }}
              </div>
              <div style="font-size:11.5px;color:var(--text-3);margin-top:2px;">
                {{ $t->created_at->diffForHumans() }}
              </div>
            </td>

            {{-- Status --}}
            <td>
              @php
                $badgeMap = [
                  'pending'  => ['Pending',  'badge-yellow'],
                  'approved' => ['Approved', 'badge-green'],
                  'rejected' => ['Rejected', 'badge-red'],
                ];
                [$label, $class] = $badgeMap[$t->status] ?? [$t->status, 'badge-gray'];
              @endphp
              <span class="badge {{ $class }}">{{ $label }}</span>
            </td>

            {{-- Aksi --}}
            <td>
              <div class="action-pair">
                @if($t->status !== 'approved')
                  <form method="POST" action="{{ route('admin.testimoni.approve', $t->id) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-sm"
                      style="background:#DCFCE7;color:#15803D;border:1px solid #BBF7D0;"
                      onmouseover="this.style.background='#16a34a';this.style.color='#fff';this.style.borderColor='#16a34a'"
                      onmouseout="this.style.background='#DCFCE7';this.style.color='#15803D';this.style.borderColor='#BBF7D0'">
                      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                      Approve
                    </button>
                  </form>
                @endif
                @if($t->status !== 'rejected')
                  <form method="POST" action="{{ route('admin.testimoni.reject', $t->id) }}"
                        onsubmit="return confirm('Reject testimoni dari {{ addslashes($t->user->name) }}?')">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-sm btn-danger">
                      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                      Reject
                    </button>
                  </form>
                @endif
              </div>
            </td>

          </tr>
        @empty
          <tr>
            <td colspan="8" style="text-align:center;padding:56px 24px;color:var(--text-3);">
              <svg width="36" height="36" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                   style="margin:0 auto 12px;display:block;opacity:.4;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
              </svg>
              <div style="font-weight:600;font-size:13px;margin-bottom:4px;color:var(--text-2);">
                Belum ada testimoni
              </div>
              <div style="font-size:12px;">
                Tidak ada testimoni untuk filter ini
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  @if($testimonials->hasPages())
    <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border-light);">
      <div style="font-size:12.5px;color:var(--text-3);">
        Menampilkan {{ $testimonials->firstItem() }}–{{ $testimonials->lastItem() }}
        dari {{ $testimonials->total() }} testimoni
      </div>
      <div style="display:flex;gap:4px;align-items:center;">

        {{-- Prev --}}
        @if($testimonials->onFirstPage())
          <span class="btn btn-sm btn-ghost" style="opacity:.4;cursor:not-allowed;">
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
          </span>
        @else
          <a href="{{ $testimonials->previousPageUrl() }}" class="btn btn-sm btn-ghost">
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
          </a>
        @endif

        {{-- Pages --}}
        @foreach($testimonials->getUrlRange(1, $testimonials->lastPage()) as $page => $url)
          @if($page == $testimonials->currentPage())
            <span class="btn btn-sm" style="background:var(--text-1);color:#fff;border:none;min-width:34px;justify-content:center;">
              {{ $page }}
            </span>
          @else
            <a href="{{ $url }}" class="btn btn-sm btn-ghost" style="min-width:34px;justify-content:center;">
              {{ $page }}
            </a>
          @endif
        @endforeach

        {{-- Next --}}
        @if($testimonials->hasMorePages())
          <a href="{{ $testimonials->nextPageUrl() }}" class="btn btn-sm btn-ghost">
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
          </a>
        @else
          <span class="btn btn-sm btn-ghost" style="opacity:.4;cursor:not-allowed;">
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
          </span>
        @endif

      </div>
    </div>
  @endif

</div>

@endsection