<?php

namespace App\Http\Controllers;

use App\Models\Konten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'gambar_konten' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar_konten')) {
            $file = $request->file('gambar_konten');
            $tanggalSekarang = now()->format('Ymd_His'); 
            $extension = $file->getClientOriginalExtension();
            $fileName = $tanggalSekarang . '.' . $extension;
            $path = $file->storeAs('public/images', $fileName);
            $data['gambar_konten'] = $path;
        }
        
        $konten = Konten::create($data);
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
            'gambar_konten' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $konten = Konten::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('gambar_konten')) {
            $file = $request->file('gambar_konten');
            $tanggalSekarang = now()->format('Ymd_His');
            $extension = $file->getClientOriginalExtension();
            $fileName = $tanggalSekarang . '.' . $extension;
            $path = $file->storeAs('public/images', $fileName);

            if (Storage::exists($konten->gambar_konten)) {
                Storage::delete($konten->gambar_konten);
            }

            $data['gambar_konten'] = $path;
        }

        $konten->update($data);
        return response()->json($konten);
    }

    public function destroy($id)
    {
        $konten = Konten::findOrFail($id);
        $konten->delete();

        return response()->json(['status' => 'Delete successfully'], 200);
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
