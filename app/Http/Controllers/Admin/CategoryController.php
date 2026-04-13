<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|unique:categories|max:255',
            ]);

            $category = Category::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil ditambahkan',
                'category_id' => $category->id,   // Pastikan nama key ini sama dengan JS
                'category_name' => $category->name // Pastikan nama key ini sama dengan JS
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Nama kategori sudah ada atau terjadi kesalahan.'
            ], 422); // Gunakan code 422 untuk error validasi
        }
    }

    /**
     * Show the form for editing the specified resource
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
        ], [
            'name.required' => 'Nama kategori harus diisi',
            'name.unique' => 'Kategori dengan nama ini sudah ada',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage
     */
    public function destroy(Category $category)
    {
        // Cek apakah kategori punya event
        if ($category->events()->count() > 0) {
            return back()->with('error', 'Kategori ini masih memiliki event, tidak bisa dihapus!');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}
