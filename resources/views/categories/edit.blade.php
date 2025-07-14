<h1>Edit Kategori: {{ $category->name }}</h1>
<form action="{{ route('categories.update', $category) }}" method="POST">
    @csrf
    @method('PUT')
    <div>
        <label for="name">Nama Kategori:</label>
        <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}">
        @error('name') <div>{{ $message }}</div> @enderror
    </div>
    <br>
    <button type="submit">Update</button>
</form>
