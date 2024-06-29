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

    public function store(Request $request)
    {
        $request->validate([
            'komen' => 'required|string',
            'id_konten' => 'required|exists:kontens,id_konten'
        ]);

        $komen = new Komen([
            'komen' => $request->komen,
            'id' => Auth::id(),
            'id_konten' => $request->id_konten,
            'timestamp' => now()
        ]);

        $komen->save();

        return response()->json($komen, 201);
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
        $this->authorize('update', $komen);
        
        $komen->komen = $request->komen;
        $komen->save();

        return response()->json($komen);
    }

    public function destroy($id)
    {
        $komen = Komen::findOrFail($id);
        $this->authorize('delete', $komen);
        
        $komen->delete();

        return response()->json(null, 204);
    }

    public function getByKonten($id_konten)
    {
        $komens = Komen::where('id_konten', $id_konten)->get();
        return response()->json($komens);
    }
}
