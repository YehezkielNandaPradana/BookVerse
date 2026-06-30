{{-- Sidebar menu, sesuaikan item berdasarkan role user login --}}
<aside class="w-64 bg-gray-900 text-white p-4">
    <div class="text-xl font-bold mb-6">BookVerse</div>

    <nav class="space-y-1">
        <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-800">Dashboard</a>

        {{-- Master Data --}}
        <a href="{{ route('master.books.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">Buku</a>
        <a href="{{ route('master.authors.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">Penulis</a>
        <a href="{{ route('master.publishers.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">Penerbit</a>
        <a href="{{ route('master.categories.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">Kategori</a>
        <a href="{{ route('master.shelves.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">Rak</a>
        <a href="{{ route('master.members.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">Anggota</a>
        <a href="{{ route('master.librarians.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">Petugas</a>

        {{-- Transaksi --}}
        <a href="{{ route('transaction.borrowings.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">Peminjaman</a>
        <a href="{{ route('transaction.returns.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">Pengembalian</a>
        <a href="{{ route('transaction.fines.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">Denda</a>
        <a href="{{ route('transaction.reservations.index') }}" class="block px-3 py-2 rounded hover:bg-gray-800">Reservasi</a>

        {{-- Lainnya --}}
        <a href="{{ route('reports.books') }}" class="block px-3 py-2 rounded hover:bg-gray-800">Laporan</a>
        <a href="{{ route('settings.edit') }}" class="block px-3 py-2 rounded hover:bg-gray-800">Pengaturan</a>
        <a href="{{ route('audit.activity-logs') }}" class="block px-3 py-2 rounded hover:bg-gray-800">Audit Log</a>
    </nav>
</aside>
