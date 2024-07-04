<?php

namespace App\Http\Controllers;

use App\Models\Komen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class KomenController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $komens = Komen::all();
        return response()->json($komens);
    }

    // public function store(Request $request, $id_konten)
    // {
    //     $request->validate([
    //         'komen' => 'required|string',
            
    //     ]);

    //     $komen = new Komen([
    //         'komen' => $request->komen,
    //         'id' => Auth::id(),
    //         'id_konten' => $id_konten,
    //         'timestamp' => now()
    //     ]);

    //     $komen->save();

    //     return response()->json($komen, 201);
    // }
    
    public function storeById(Request $request, $id_konten)
    {
        // Validasi data yang diterima dari permintaan
        $validatedData = $request->validate([
            'komen' => 'required|string',
        ]);

        $komen = new Komen([
            'komen' => $request->komen,
            'id' => Auth::id(),
            'id_konten' => $id_konten,
            'timestamp' => now()
        ]);

        $komen->save();

        $komens = Komen::where('id_konten', $id_konten)->get();

        // Kembalikan respons dengan komentar yang disimpan dan semua komentar terkait
        return response()->json([
            'message' => 'Komentar berhasil disimpan',
            'data' => $komens
        ]);
    }

    public function show($id)
    {
        $komen = Komen::findOrFail($id);
        return response()->json($komen);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'komen' => 'required|string',
        ]);

        $komen = Komen::findOrFail($id);
        if ($komen->id !== Auth::id()) {
            return response()->json(['error' => 'anda bukan pemilik komen'], 403);
        }
        
        $komen->komen = $request->komen;
        $komen->save();

        return response()->json($komen);
    }

    public function destroy($id)
    {
        $komen = Komen::findOrFail($id);
        if ($komen->id !== Auth::id()) {
            return response()->json(['error' => 'anda bukan pemilik komen'], 403);
        }
        
        $komen->delete();

        return response()->json(['status' => 'Delete successfully'], 200);
    }

    public function getByKonten($id_konten)
    {
        $komens = Komen::where('id_konten', $id_konten)->get();
        return response()->json($komens);
    }
}
