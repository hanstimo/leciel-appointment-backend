<x-app-layout>
    <x-slot name="header">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;500;600&family=Jost:wght@300;400;500;600&display=swap">
        <h2 class="font-['Cormorant_Garamond',serif] text-2xl text-[#152349] tracking-wide">
            Block History &middot; {{ $koleksi->nama_koleksi }}
        </h2>
    </x-slot>

    <div class="py-8 bg-[#F5F0E8] font-['Jost',sans-serif]">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-[#27AE60]/10 border border-[#27AE60]/30 text-[#27AE60] px-4 py-2.5 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <a href="{{ route('koleksi.edit', $koleksi) }}" class="inline-block text-[0.7rem] uppercase tracking-[0.08em] text-[#8A8078] hover:text-[#152349]">
                &larr; Back to {{ $koleksi->nama_koleksi }}
            </a>

            <div class="bg-[#FDFAF5] border border-[#E0D8CC] p-6">
                <h3 class="font-['Cormorant_Garamond',serif] text-xl text-[#152349] mb-2">Past Blocks</h3>
                <p class="text-xs text-[#8A8078] mb-5">
                    Blocks whose dates have already passed. They no longer affect availability
                    and are kept here as a record.
                </p>

                @if ($riwayat->isEmpty())
                    <p class="text-sm text-[#8A8078]">No past blocks for this item.</p>
                @else
                    <div class="border border-[#E0D8CC] divide-y divide-[#E0D8CC]">
                        @foreach ($riwayat as $r)
                            <div class="flex items-center justify-between gap-4 px-4 py-3">
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
                                            &middot; {{ $r['atas_nama'] }}
                                        @endif
                                    </p>
                                </div>
                                <span class="text-[0.65rem] uppercase tracking-[0.08em] text-[#8A8078] shrink-0">
                                    {{ $r['label'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <form action="{{ route('koleksi.blocked-dates.history.clear', $koleksi) }}" method="POST" class="mt-5"
                          onsubmit="return confirm('Permanently delete all past blocked dates for this item?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-[#C0392B] text-xs hover:underline">
                            Clear history
                        </button>
                    </form>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
