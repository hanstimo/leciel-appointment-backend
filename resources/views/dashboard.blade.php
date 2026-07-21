<x-app-layout>
    <x-slot name="header">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;500;600&family=Jost:wght@300;400;500;600&display=swap">
        <h2 class="font-['Cormorant_Garamond',serif] text-2xl text-[#152349] tracking-wide">
            Dashboard Admin &mdash; Manajemen Appointment
        </h2>
    </x-slot>

    <div class="py-8 bg-[#F5F0E8] font-['Jost',sans-serif]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-[#27AE60]/10 border border-[#27AE60]/30 text-[#27AE60] px-4 py-2.5 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filter status --}}
            <div class="flex items-center gap-2 flex-wrap">
                @php
                    $tabs = [
                        '' => 'Semua',
                        'menunggu' => 'Menunggu',
                        'dikonfirmasi' => 'Dikonfirmasi',
                        'selesai' => 'Selesai',
                        'dibatalkan' => 'Dibatalkan',
                    ];
                @endphp
                @foreach ($tabs as $value => $label)
                    <a href="{{ $value ? route('dashboard', ['status' => $value]) : route('dashboard') }}"
                       class="px-4 py-1.5 text-[0.7rem] uppercase tracking-[0.08em] border transition
                              {{ $statusFilter == $value || (!$statusFilter && !$value)
                                    ? 'bg-[#152349] text-[#FDFAF5] border-[#152349]'
                                    : 'bg-transparent text-[#152349] border-[#E0D8CC] hover:border-[#C56E4E]' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            

            {{-- Tabel appointment --}}
            <div class="bg-[#FDFAF5] border border-[#E0D8CC] overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-[#F5F0E8] text-[#8A8078] text-[0.65rem] uppercase tracking-[0.08em]">
                            <th class="py-3 px-5 text-left font-medium">Tanggal & Jam</th>
                            <th class="py-3 px-5 text-left font-medium">Pelanggan</th>
                            <th class="py-3 px-5 text-left font-medium">Koleksi</th>
                            <th class="py-3 px-5 text-left font-medium">Sumber</th>
                            <th class="py-3 px-5 text-left font-medium">Status</th>
                            <th class="py-3 px-5 text-left font-medium">Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E0D8CC]">
                        @forelse ($appointments as $appointment)
                            <tr class="hover:bg-[#F5F0E8]/50 transition">
                                <td class="py-4 px-5 align-top whitespace-nowrap">
                                    <p class="font-medium text-[#152349]">{{ \Carbon\Carbon::parse($appointment->tanggal)->format('d M Y') }}</p>
                                    <p class="text-[#8A8078] text-xs mt-0.5">{{ \Carbon\Carbon::parse($appointment->jam)->format('H:i') }} WIB</p>
                                </td>
                                <td class="py-4 px-5 align-top">
                                    <p class="font-medium text-[#152349]">{{ $appointment->pelanggan->nama }}</p>
                                    <p class="text-[#8A8078] text-xs mt-0.5">{{ $appointment->pelanggan->no_telepon }}</p>
                                </td>
                                <td class="py-4 px-5 align-top">
                                    <div class="flex flex-wrap gap-2 max-w-xs">
                                        @forelse ($appointment->koleksis as $koleksi)
                                            <div class="flex items-center gap-2 bg-[#F5F0E8] border border-[#E0D8CC] pl-1 pr-2.5 py-1">
                                                <img src="{{ $koleksi->foto }}" alt="{{ $koleksi->nama_koleksi }}" class="w-10 h-10 object-cover">
                                                <span class="text-xs text-[#152349] whitespace-nowrap">{{ $koleksi->nama_koleksi }}</span>
                                            </div>
                                        @empty
                                            <span class="text-[#8A8078]/50 text-xs">&mdash;</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="py-4 px-5 align-top">
                                    <span class="px-2.5 py-1 text-xs font-medium
                                        {{ $appointment->pelanggan->sumber === 'whatsapp' ? 'bg-[#27AE60]/10 text-[#27AE60]' : 'bg-[#152349]/10 text-[#152349]' }}">
                                        {{ $appointment->pelanggan->sumber === 'whatsapp' ? 'WhatsApp (VIP)' : 'Web' }}
                                    </span>
                                </td>
                                <td class="py-4 px-5 align-top">
                                    <form action="{{ route('appointments.updateStatus', $appointment) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        @php
                                            $statusColor = [
                                                'menunggu' => 'bg-[#E67E22]/10 text-[#E67E22] border-[#E67E22]/30',
                                                'dikonfirmasi' => 'bg-[#C56E4E]/10 text-[#C56E4E] border-[#C56E4E]/30',
                                                'selesai' => 'bg-[#27AE60]/10 text-[#27AE60] border-[#27AE60]/30',
                                                'dibatalkan' => 'bg-[#C0392B]/10 text-[#C0392B] border-[#C0392B]/30',
                                            ][$appointment->status] ?? 'bg-gray-50 text-gray-600 border-gray-200';
                                        @endphp
                                        <select name="status" onchange="this.form.submit()"
                                            class="text-xs font-medium border pl-3 pr-7 py-1.5 cursor-pointer {{ $statusColor }}">
                                            <option value="menunggu" @selected($appointment->status === 'menunggu')>Menunggu</option>
                                            <option value="dikonfirmasi" @selected($appointment->status === 'dikonfirmasi')>Dikonfirmasi</option>
                                            <option value="selesai" @selected($appointment->status === 'selesai')>Selesai</option>
                                            <option value="dibatalkan" @selected($appointment->status === 'dibatalkan')>Dibatalkan</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="py-4 px-5 align-top text-[#8A8078] text-xs max-w-[160px] truncate">{{ $appointment->catatan }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-[#8A8078]">Belum ada appointment.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Form tambah appointment VIP --}}
            <div class="bg-[#FDFAF5] border border-[#E0D8CC] p-6" x-data="{ activeKategori: null }">
                <h3 class="font-['Cormorant_Garamond',serif] text-xl text-[#152349] mb-4">Catat Appointment VIP (WhatsApp)</h3>

                <form action="{{ route('appointments.storeManual') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-[0.68rem] uppercase tracking-[0.12em] text-[#8A8078] mb-1">Nama Pelanggan</label>
                            <input type="text" name="nama" required class="w-full border-[#E0D8CC] text-sm focus:border-[#C56E4E] focus:ring-0">
                        </div>
                        <div>
                            <label class="block text-[0.68rem] uppercase tracking-[0.12em] text-[#8A8078] mb-1">No. WhatsApp</label>
                            <input type="text" name="no_telepon" required class="w-full border-[#E0D8CC] text-sm focus:border-[#C56E4E] focus:ring-0">
                        </div>
                        <div>
                            <label class="block text-[0.68rem] uppercase tracking-[0.12em] text-[#8A8078] mb-1">Tanggal</label>
                            <input type="date" name="tanggal" required class="w-full border-[#E0D8CC] text-sm focus:border-[#C56E4E] focus:ring-0">
                        </div>
                        <div>
                            <label class="block text-[0.68rem] uppercase tracking-[0.12em] text-[#8A8078] mb-1">Jam</label>
                            <input type="time" name="jam" required class="w-full border-[#E0D8CC] text-sm focus:border-[#C56E4E] focus:ring-0">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[0.68rem] uppercase tracking-[0.12em] text-[#8A8078] mb-2">Koleksi yang ingin dilihat</label>

                        <div class="flex gap-2 flex-wrap mb-4">
                            @foreach ($koleksiList->pluck('kategori')->unique() as $kategori)
                                <button type="button"
                                    @click="activeKategori = activeKategori === '{{ $kategori }}' ? null : '{{ $kategori }}'"
                                    :class="activeKategori === '{{ $kategori }}' ? 'bg-[#152349] text-[#FDFAF5] border-[#152349]' : 'bg-transparent text-[#152349] border-[#E0D8CC] hover:border-[#C56E4E]'"
                                    class="px-4 py-1.5 text-[0.7rem] uppercase tracking-[0.08em] border transition">
                                    {{ $kategori }}
                                </button>
                            @endforeach
                        </div>

                        <div class="border border-[#E0D8CC] p-4">
                            <template x-if="!activeKategori">
                                <p class="text-xs text-[#8A8078] text-center py-10">Pilih kategori di atas untuk menampilkan koleksinya</p>
                            </template>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-h-[34rem] overflow-y-auto">
                                @foreach ($koleksiList as $koleksi)
                                    <label x-show="activeKategori === '{{ $koleksi->kategori }}'"
                                        x-data="{ checked: false }"
                                        class="relative border cursor-pointer transition block"
                                        :class="checked ? 'border-[#C56E4E] bg-[#FBF7F0]' : 'border-[#E0D8CC] hover:border-[#DC8C69]'">
                                        <img src="{{ $koleksi->foto }}" alt="{{ $koleksi->nama_koleksi }}" class="w-full aspect-square object-cover">
                                        <div class="p-2.5">
                                            <p class="text-[0.8rem] font-medium text-[#152349] leading-tight">{{ $koleksi->nama_koleksi }}</p>
                                            <p class="text-[0.62rem] uppercase tracking-[0.08em] text-[#8A8078] mt-0.5">{{ $koleksi->kategori }}</p>
                                        </div>
                                        <span x-show="checked" class="absolute top-2 right-2 w-5 h-5 rounded-full bg-[#C56E4E] text-white flex items-center justify-center text-[10px]">&check;</span>
                                        <input type="checkbox" name="koleksi_ids[]" value="{{ $koleksi->id }}" x-model="checked" class="hidden">
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[0.68rem] uppercase tracking-[0.12em] text-[#8A8078] mb-1">Catatan</label>
                        <textarea name="catatan" rows="2" class="w-full border-[#E0D8CC] text-sm focus:border-[#C56E4E] focus:ring-0"></textarea>
                    </div>

                    <button type="submit" class="bg-[#152349] text-[#FDFAF5] text-sm font-medium px-6 py-2.5 hover:bg-[#C56E4E] transition">
                        Simpan Appointment
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>