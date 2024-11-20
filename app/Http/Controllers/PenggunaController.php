<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PenggunaController extends Controller
{
    public function showPengguna()
    {
        $data = Pengguna::all();
        $sdhAbsen = Pengguna::whereNotNull('foto')->count();
        $blmAbsen = Pengguna::whereNull('foto')->count();
        return view('index', compact('data', 'sdhAbsen', 'blmAbsen'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'no_induk' => 'required|integer|unique:penggunas,no_induk',
            'nama_yatimin' => 'required|string|max:255',
            'kelahiran' => 'required|integer|min:1900|max:' . date('Y'),
            'alamat' => 'required|string|max:255',
        ], [
            'no_induk.required' => 'No Induk harus diisi.',
            'no_induk.integer' => 'No Induk harus berupa angka.',
            'no_induk.unique' => 'No Induk sudah ada di database.',
            'nama_yatimin.required' => 'Nama Yatimin harus diisi.',
            'nama_yatimin.max' => 'Nama Yatimin tidak boleh lebih dari 255 karakter.',
            'kelahiran.required' => 'Tahun kelahiran harus diisi.',
            'kelahiran.integer' => 'Tahun kelahiran harus berupa angka.',
            'kelahiran.min' => 'Tahun kelahiran tidak boleh kurang dari 1900.',
            'kelahiran.max' => 'Tahun kelahiran tidak boleh lebih dari tahun saat ini.',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.max' => 'Alamat tidak boleh lebih dari 255 karakter.',
        ]);

        try {
            Pengguna::create([
                'no_induk' => $request->input('no_induk'),
                'nama_yatimin' => $request->input('nama_yatimin'),
                'kelahiran' => $request->input('kelahiran'),
                'alamat' => $request->input('alamat'),
            ]);

            return response()->json(['success' => 'Berhasil menambahkan data'], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        }
    }

    public function savePhoto(Request $request)
    {
        $userId = $request->user_id;
        $photoData = $request->photo;
        $userName = Pengguna::findOrFail($userId);

        $fileName = 'photo_' . $userId . '_' . str_replace(' ', '_', $userName->nama_yatimin) . '.jpg';

        $image = str_replace('data:image/jpeg;base64,', '', $photoData);
        $image = base64_decode($image);
        $path = storage_path('app/public/photos/' . $fileName);

        file_put_contents($path, $image);

        $user = Pengguna::find($userId);
        $user->foto = $fileName;
        $user->save();

        Log::info(Storage::url($user->foto));

        return response()->json(['message' => 'Foto berhasil disimpan']);
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:penggunas,id',
            'status' => 'required|boolean',
        ]);

        $pengguna = Pengguna::find($request->user_id);
        $pengguna->status = $request->status;
        $pengguna->save();

        return response()->json(['success' => true]);
    }
}
