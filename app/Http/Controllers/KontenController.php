<?php

namespace App\Http\Controllers;

use App\Models\Konten;
use Illuminate\Http\Request;

class KontenController extends Controller
{
    public function index()
    {
        $kontens = Konten::all();
        return response()->json($kontens);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori_konten' => 'required|in:food,news,travel',
            'gambar_konten' => 'nullable|image',
        ]);

        if ($request->hasFile('gambar_konten')) {
            $image = $request->file('gambar_konten');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $request->merge(['gambar_konten' => $imageName]);
        }

        $konten = Konten::create($request->all());
        return response()->json($konten, 201);
    }

    public function show($id)
    {
        $konten = Konten::findOrFail($id);
        return response()->json($konten);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'deskripsi' => 'sometimes|required|string',
            'kategori_konten' => 'sometimes|required|in:food,news,travel',
            'gambar_konten' => 'nullable|image',
        ]);

        $konten = Konten::findOrFail($id);

        if ($request->hasFile('gambar_konten')) {
            // Hapus gambar lama jika ada
            if ($konten->gambar_konten && file_exists(public_path('images') . '/' . $konten->gambar_konten)) {
                unlink(public_path('images') . '/' . $konten->gambar_konten);
            }
    
            // Unggah gambar baru
            $image = $request->file('gambar_konten');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $request->merge(['gambar_konten' => $imageName]);
        }

        $konten->update($request->all());

        return response()->json($konten);
    }

    public function destroy($id)
    {
        $konten = Konten::findOrFail($id);
        $konten->delete();

        return response()->json(['status' => 'Delete successfully'], 200);
        return response()->json(null, 204);
    }

    public function getKontenByKategori($kategori)
    {
        $kontens = Konten::where('kategori_konten', $kategori)->get();

        if ($kontens->isEmpty()) {
            return response()->json([
                'message' => 'No content found in this category.'
            ], 404);
        }

        return response()->json($kontens, 200);
    }
}
