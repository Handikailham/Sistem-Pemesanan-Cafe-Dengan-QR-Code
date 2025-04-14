
    <h1>Data Meja</h1>
    <a href="{{ route('admin.meja.create') }}" style="display:inline-block; margin-bottom: 10px;">➕ Tambah Meja</a>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; text-align: center;">
        <thead style="background-color: #f0f0f0;">
            <tr>
                <th>ID</th>
                <th>Nomor Meja</th>
                <th>QR Code</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($meja as $m)
            <tr>
                <td>{{ $m->id }}</td>
                <td>Meja {{ $m->nomor }}</td>
                <td>
                    {!! QrCode::size(100)->generate(url('/pesan/' . $m->nomor)) !!}
                    <br>
                    <small>
                        <a href="{{ url('/pesan/' . $m->nomor) }}" target="_blank">
                            Lihat Link
                        </a>
                    </small>
                </td>
                <td>
                    <a href="{{ route('admin.meja.edit', $m->id) }}">Edit</a> |
                    <form action="{{ route('admin.meja.destroy', $m->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin menghapus meja ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
        

            @if ($meja->isEmpty())
                <tr>
                    <td colspan="4">Belum ada data meja.</td>
                </tr>
            @endif
        </tbody>
    </table>

