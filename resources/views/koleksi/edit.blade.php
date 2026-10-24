<x-app-layout>
    <x-slot name="header">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;500;600&family=Jost:wght@300;400;500;600&display=swap">
        <style>[x-cloak]{display:none!important}</style>
        <h2 class="font-['Cormorant_Garamond',serif] text-2xl text-[#152349] tracking-wide">
            {{ $koleksi->nama_koleksi }}
        </h2>
    </x-slot>

    @php
        $warnaAlasan = [
            'dipinjam'   => 'bg-[#E67E22]/10 text-[#E67E22] border-[#E67E22]/30',
            'diperbaiki' => 'bg-[#8A8078]/10 text-[#8A8078] border-[#8A8078]/30',
            'disewa'     => 'bg-[#C56E4E]/10 text-[#C56E4E] border-[#C56E4E]/30',
            'dijual'     => 'bg-[#C0392B]/10 text-[#C0392B] border-[#C0392B]/30',
        ];
    @endphp

    <div class="py-8 bg-[#F5F0E8] font-['Jost',sans-serif]">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-[#27AE60]/10 border border-[#27AE60]/30 text-[#27AE60] px-4 py-2.5 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-[#C0392B]/10 border border-[#C0392B]/30 text-[#C0392B] px-4 py-2.5 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <a href="{{ route('koleksi.index') }}" class="inline-block text-[0.7rem] uppercase tracking-[0.08em] text-[#8A8078] hover:text-[#152349]">
                &larr; Back to Manage Collection
            </a>

            <div class="bg-[#FDFAF5] border border-[#E0D8CC] p-6 flex gap-6">
                <img src="{{ $koleksi->foto }}" alt="{{ $koleksi->nama_koleksi }}" class="w-40 h-40 object-cover border border-[#E0D8CC]">
                <div class="flex-1">
                    <p class="text-[0.65rem] uppercase tracking-[0.08em] text-[#8A8078] mb-1">{{ $koleksi->kategori }}</p>
                    <p class="text-lg text-[#152349] font-medium mb-4">{{ $koleksi->nama_koleksi }}</p>

                    <form action="{{ route('koleksi.toggle', $koleksi) }}" method="POST" class="flex items-center gap-3">
                        @csrf
                        @method('PATCH')
                        <span class="text-xs uppercase tracking-[0.08em] {{ $koleksi->tersedia ? 'text-[#27AE60]' : 'text-[#C0392B]' }}">
                            {{ $koleksi->tersedia ? 'Available' : 'Unavailable' }}
                        </span>
                        <button type="submit" class="w-10 h-5 rounded-full relative transition {{ $koleksi->tersedia ? 'bg-[#27AE60]' : 'bg-[#E0D8CC]' }}">
                            <span class="absolute top-0.5 {{ $koleksi->tersedia ? 'right-0.5' : 'left-0.5' }} w-4 h-4 rounded-full bg-white transition"></span>
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-[#FDFAF5] border border-[#E0D8CC] p-6">
                <h3 class="font-['Cormorant_Garamond',serif] text-xl text-[#152349] mb-2">Unavailable Dates</h3>
                <p class="text-xs text-[#8A8078] mb-5">
                    This item counts as available on every date except the ones listed below.
                    The reason is for internal use only and is never shown to customers.
                </p>

                <form action="{{ route('koleksi.blocked-dates.store', $koleksi) }}" method="POST"
                      x-data="{ alasan: @js(old('alasan', '')), perluNama() { return @js(\App\Models\KoleksiUnavailableDate::PERLU_NAMA).includes(this.alasan) } }"
                      class="flex items-end gap-3 mb-6 flex-wrap">
                    @csrf
                    <div>
                        <label class="block text-[0.65rem] uppercase tracking-[0.08em] text-[#8A8078] mb-1">From Date</label>
                        <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required
                               class="border-[#E0D8CC] text-sm">
                    </div>
                    <div>
                        <label class="block text-[0.65rem] uppercase tracking-[0.08em] text-[#8A8078] mb-1">To Date (optional)</label>
                        <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                               class="border-[#E0D8CC] text-sm">
                    </div>
                    <div>
                        <label class="block text-[0.65rem] uppercase tracking-[0.08em] text-[#8A8078] mb-1">Reason</label>
                        <select name="alasan" x-model="alasan" required class="border-[#E0D8CC] text-sm">
                            <option value="">Select reason</option>
                            @foreach (\App\Models\KoleksiUnavailableDate::ALASAN as $nilai => $label)
                                <option value="{{ $nilai }}" @selected(old('alasan') === $nilai)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div x-show="perluNama()" x-cloak>
                        <label class="block text-[0.65rem] uppercase tracking-[0.08em] text-[#8A8078] mb-1">Held by</label>
                        <input type="text" name="atas_nama" value="{{ old('atas_nama') }}" maxlength="100"
                               placeholder="Name" x-bind:required="perluNama()"
                               class="border-[#E0D8CC] text-sm">
                    </div>
                    <button type="submit" class="bg-[#152349] text-[#FDFAF5] text-sm px-4 py-2 hover:bg-[#C56E4E] transition">
                        Mark Unavailable
                    </button>
                </form>

                <p class="text-[0.65rem] uppercase tracking-[0.08em] text-[#8A8078] mb-2">Active blocks</p>

                @if ($aktif->isEmpty())
                    <p class="text-sm text-[#8A8078] mb-2">No active blocked dates.</p>
                @else
                    <div class="border border-[#E0D8CC] divide-y divide-[#E0D8CC] mb-2">
                        @foreach ($aktif as $r)
                            <div class="flex items-center justify-between gap-4 px-4 py-3 bg-[#FDFAF5]">
                                <div class="min-w-0">
                                    <p class="text-sm text-[#152349]">
                                        @if ($r['jumlah'] === 1)
                                            {{ $r['mulai']->format('d M Y') }}
                                        @else
                                            {{ $r['mulai']->format('d M Y') }} &ndash; {{ $r['selesai']->format('d M Y') }}
                                        @endif
                                    </p>
                                    <p class="text-xs text-[#8A8078] mt-0.5">
                                        {{ $r['jumlah'] }} {{ \Illuminate\Support\Str::plural('day', $r['jumlah']) }}
                                        @if ($r['atas_nama'])
                                            &middot; <span class="text-[#152349]">{{ $r['atas_nama'] }}</span>
                                        @endif
                                    </p>
                                </div>

                                <div class="flex items-center gap-3 shrink-0">
                                    <span class="text-[0.65rem] uppercase tracking-[0.08em] px-2 py-1 border {{ $warnaAlasan[$r['alasan']] ?? 'bg-[#F5F0E8] text-[#8A8078] border-[#E0D8CC]' }}">
                                        {{ $r['label'] }}
                                    </span>
                                    <form action="{{ route('koleksi.blocked-dates.range', $koleksi) }}" method="POST"
                                          onsubmit="return confirm('Remove this block?')">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="ids" value="{{ implode(',', $r['ids']) }}">
                                        <button type="submit" class="text-[#C0392B] text-xs hover:underline">Remove</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if ($jumlahRiwayat > 0)
                    <a href="{{ route('koleksi.blocked-dates.history', $koleksi) }}"
                       class="inline-block mt-4 text-[0.7rem] uppercase tracking-[0.08em] text-[#8A8078] hover:text-[#152349]">
                        View block history ({{ $jumlahRiwayat }} past {{ \Illuminate\Support\Str::plural('block', $jumlahRiwayat) }}) &rarr;
                    </a>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
