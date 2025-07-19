<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Import Str
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    // Menampilkan semua kategori
    public function index()
    {
        // Ambil semua kategori dengan count produk
        $categories = Category::withCount('products')->latest()->get();

        //kategori kurang diminati
        $sepiPeminat = $categories->filter(fn($category) => $category->products_count === 0);

        // Terpopuler kategori
        $terpopuler = $categories->sortByDesc('products_count')->take(5);
        // Debug info
        Log::info('Categories count: ' . $categories->count());
        Log::info('Categories with products_count:', $categories->pluck('name', 'products_count')->toArray());

        return view('categories.index', compact('categories', 'sepiPeminat', 'terpopuler'));
    }

    // Menampilkan form tambah kategori
    public function create()
    {
        return view('categories.create');
    }

    // Menyimpan kategori baru
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:categories']);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->route('categories.index');
    }

    // Menampilkan form edit kategori
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // Mengupdate kategori
    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required|string|max:255|unique:categories,name,'.$category->id]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->route('categories.index');
    }

    // Menghapus kategori
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index');
    }
}
