<h1>Daftar Menu</h1>

@if (session('success'))
    <div style="color: green;">{{ session('success') }}</div>
@endif

<a href="{{ route('admin.menu.create') }}">Tambah Menu</a>

<table border="1" cellpadding="10" cellspacing="0" style="margin-top: 20px;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Gambar</th>
            <th>Nama Menu</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($menu as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>
                    @if ($item->gambar)
                        <img src="{{ asset('menu/' . $item->gambar) }}" alt="Gambar Menu" width="60">
                    @else
                        <span>-</span>
                    @endif
                </td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->kategori }}</td>
                <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                <td>
                    <a href="{{ route('admin.menu.edit', $item->id) }}">Edit</a> |
                    <form action="{{ route('admin.menu.destroy', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin menghapus menu ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">Belum ada menu</td>
            </tr>
        @endforelse
    </tbody>
</table>
