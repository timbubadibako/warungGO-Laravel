<h1>Tambah Kategori Baru</h1>
<form action="{{ route('categories.store') }}" method="POST">
    @csrf
    <div>
        <label for="name">Nama Kategori:</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}">
        @error('name') <div>{{ $message }}</div> @enderror
    </div>
    <br>
    <button type="submit">Simpan</button>
</form>
