<x-app-layout>
    <x-slot name="header">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;500;600&family=Jost:wght@300;400;500;600&display=swap">
        <h2 class="font-['Cormorant_Garamond',serif] text-2xl text-[#152349] tracking-wide">
            Kelola Koleksi
        </h2>
    </x-slot>

    <div class="py-8 bg-[#F5F0E8] font-['Jost',sans-serif]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-[#27AE60]/10 border border-[#27AE60]/30 text-[#27AE60] px-4 py-2.5 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex items-center justify-between">
                <p class="text-sm text-[#8A8078]">Matikan toggle untuk menandai koleksi sedang tidak bisa dilihat customer (misal lagi direparasi / dipinjam).</p>
                <a href="{{ route('dashboard') }}" class="px-4 py-1.5 text-[0.7rem] uppercase tracking-[0.08em] border border-[#E0D8CC] text-[#152349] hover:border-[#C56E4E] transition">
                    &larr; Kembali ke Dashboard
                </a>
            </div>

            @foreach ($koleksis->groupBy('kategori') as $kategori => $items)
                <div>
                    <p class="text-xs font-semibold text-[#8A8078] uppercase tracking-[0.08em] mb-3 border-b border-[#E0D8CC] pb-1">{{ $kategori }}</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        @foreach ($items as $koleksi)
                            <a href="{{ route('koleksi.edit', $koleksi) }}" class="block bg-[#FDFAF5] border border-[#E0D8CC] hover:border-[#C56E4E] transition relative {{ !$koleksi->tersedia ? 'opacity-50' : '' }}">
    <img src="{{ $koleksi->foto }}" alt="{{ $koleksi->nama_koleksi }}" class="w-full aspect-square object-cover">
    <div class="p-2.5">
        <p class="text-[0.8rem] font-medium text-[#152349] leading-tight">{{ $koleksi->nama_koleksi }}</p>
        <p class="text-[0.65rem] uppercase tracking-[0.08em] mt-1 {{ $koleksi->tersedia ? 'text-[#27AE60]' : 'text-[#C0392B]' }}">
            {{ $koleksi->tersedia ? 'Tersedia' : 'Tidak Tersedia' }}
        </p>
    </div>
</a>
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</x-app-layout>