<h1>Edit Supplier: {{ $supplier->name }}</h1>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('suppliers.update', $supplier) }}" method="POST">
    @csrf
    @method('PUT')
    <div><label>Nama Supplier: <input type="text" name="name" value="{{ old('name', $supplier->name) }}"></label></div>
    <div><label>No. Telepon: <input type="text" name="phone_number" value="{{ old('phone_number', $supplier->phone_number) }}"></label></div>
    <div><label>Alamat: <textarea name="address">{{ old('address', $supplier->address) }}</textarea></label></div>
    <br>
    <button type="submit">Update</button>
</form>
