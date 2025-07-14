<h1>Manajemen Supplier</h1>
<a href="{{ route('suppliers.create') }}">Tambah Supplier Baru</a>
<br><br>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Nama Supplier</th>
            <th>No. Telepon</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($suppliers as $supplier)
        <tr>
            <td>{{ $supplier->name }}</td>
            <td>{{ $supplier->phone_number }}</td>
            <td>{{ $supplier->address }}</td>
            <td>
                <a href="{{ route('suppliers.edit', $supplier) }}">Edit</a>
                <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
