<h1>Tambah Supplier Baru</h1>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('suppliers.store') }}" method="POST">
    @csrf
    <div><label>Nama Supplier: <input type="text" name="name" value="{{ old('name') }}"></label></div>
    <div><label>No. Telepon: <input type="text" name="phone_number" value="{{ old('phone_number') }}"></label></div>
    <div><label>Alamat: <textarea name="address">{{ old('address') }}</textarea></label></div>
    <br>
    <button type="submit">Simpan</button>
</form>
