<x-app-layout>
    <x-slot name="header">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;500;600&family=Jost:wght@300;400;500;600&display=swap">
        <h2 class="font-['Cormorant_Garamond',serif] text-2xl text-[#152349] tracking-wide">
            {{ $koleksi->nama_koleksi }}
        </h2>
    </x-slot>

    <div class="py-8 bg-[#F5F0E8] font-['Jost',sans-serif]">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-[#27AE60]/10 border border-[#27AE60]/30 text-[#27AE60] px-4 py-2.5 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <a href="{{ route('koleksi.index') }}" class="inline-block text-[0.7rem] uppercase tracking-[0.08em] text-[#8A8078] hover:text-[#152349]">
                &larr; Kembali ke Kelola Koleksi
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
                            {{ $koleksi->tersedia ? 'Tersedia' : 'Tidak Tersedia' }}
                        </span>
                        <button type="submit" class="w-10 h-5 rounded-full relative transition {{ $koleksi->tersedia ? 'bg-[#27AE60]' : 'bg-[#E0D8CC]' }}">
                            <span class="absolute top-0.5 {{ $koleksi->tersedia ? 'right-0.5' : 'left-0.5' }} w-4 h-4 rounded-full bg-white transition"></span>
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-[#FDFAF5] border border-[#E0D8CC] p-6">
                <h3 class="font-['Cormorant_Garamond',serif] text-xl text-[#152349] mb-2">Tanggal Tidak Tersedia</h3>
                <p class="text-xs text-[#8A8078] mb-4">Item ini otomatis dianggap tersedia di semua tanggal, kecuali tanggal yang ditandai di bawah ini.</p>

                <form action="{{ route('koleksi.blocked-dates.store', $koleksi) }}" method="POST" class="flex items-end gap-3 mb-6 flex-wrap">
                    @csrf
                    <div>
                        <label class="block text-[0.65rem] uppercase tracking-[0.08em] text-[#8A8078] mb-1">Dari Tanggal</label>
                        <input type="date" name="tanggal_mulai" required class="border-[#E0D8CC] text-sm">
                    </div>
                    <div>
                        <label class="block text-[0.65rem] uppercase tracking-[0.08em] text-[#8A8078] mb-1">Sampai Tanggal (opsional)</label>
                        <input type="date" name="tanggal_selesai" class="border-[#E0D8CC] text-sm">
                    </div>
                    <button type="submit" class="bg-[#152349] text-[#FDFAF5] text-sm px-4 py-2 hover:bg-[#C56E4E] transition">
                        Tandai Tidak Tersedia
                    </button>
                </form>

                @if ($koleksi->unavailableDates->isEmpty())
                    <p class="text-sm text-[#8A8078]">Belum ada tanggal yang diblokir.</p>
                @else
                    <div class="flex flex-wrap gap-2">
                        @foreach ($koleksi->unavailableDates->sortBy('tanggal') as $date)
                            <form action="{{ route('koleksi.blocked-dates.destroy', [$koleksi, $date]) }}" method="POST" class="flex items-center gap-1 bg-[#F5F0E8] border border-[#E0D8CC] px-3 py-1.5">
                                @csrf
                                @method('DELETE')
                                <span class="text-sm text-[#152349]">{{ $date->tanggal->format('d M Y') }}</span>
                                <button type="submit" class="text-[#C0392B] text-xs hover:underline ml-1">&times;</button>
                            </form>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>