<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Presensi;
use App\Models\TanggalPresensi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PenggunaController extends Controller
{
    public function showPengguna(Request $request)
    {
        $filterDate = $request->input('filterDate', date('Y-m-d'));
        $tanggal = TanggalPresensi::where('tanggal', $filterDate)->first();

        if (!$tanggal) {
            return redirect()->back()->with('error', 'Belum ada data absensi untuk tanggal tersebut');
        }

        $tanggalId = $tanggal->id;

        $data = Pengguna::with(['presensis' => function ($query) use ($tanggalId) {
            $query->where('tanggal_id', $tanggalId);
        }])->get();

        $sdhAbsen = $data->filter(function ($pengguna) {
            return $pengguna->presensis->isNotEmpty() && $pengguna->presensis->first()->foto != null;
        })->count();

        $blmAbsen = $data->filter(function ($pengguna) {
            return $pengguna->presensis->isEmpty() || $pengguna->presensis->first()->foto == null;
        })->count();

        return view('index', compact('data', 'filterDate', 'sdhAbsen', 'blmAbsen'));
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
            $pengguna = Pengguna::create([
                'no_induk' => $request->input('no_induk'),
                'nama_yatimin' => $request->input('nama_yatimin'),
                'kelahiran' => $request->input('kelahiran'),
                'alamat' => $request->input('alamat'),
            ]);

            $tanggalHariIni = Carbon::now();

            $tanggalTerakhir = TanggalPresensi::orderBy('tanggal', 'desc')->first()->tanggal;

            $currentDate = $tanggalHariIni;
            while ($currentDate <= $tanggalTerakhir) {
                $tanggal = TanggalPresensi::firstOrCreate(['tanggal' => $currentDate->format('Y-m-d')]);

                Presensi::create([
                    'pengguna_id' => $pengguna->id,
                    'tanggal_id' => $tanggal->id,
                    'foto' => null,
                ]);

                $currentDate->addDay();
            }

            return response()->json(['success' => 'Berhasil menambahkan data pengguna dan presensi'], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()->all()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan, coba lagi'], 500);
        }
    }


    public function savePhoto(Request $request)
    {
        $userId = $request->input('user_id');
        $photoData = $request->input('photo');
        $filterDate = $request->input('filter_date');

        $userName = Pengguna::findOrFail($userId);

        $currentDate = Carbon::parse($filterDate)->format('Y-m-d');
        $fileName = 'photo_' . $userId . '_' . str_replace(' ', '_', $userName->nama_yatimin) . '_' . $currentDate . '.jpg';

        $image = str_replace('data:image/jpeg;base64,', '', $photoData);
        $image = base64_decode($image);

        $userFolder = storage_path('app/public/photos/' . $userId);
        if (!file_exists($userFolder)) {
            mkdir($userFolder, 0777, true);
        }

        $path = $userFolder . '/' . $fileName;
        file_put_contents($path, $image);

        $tanggalId = TanggalPresensi::where('tanggal', $filterDate)->first()->id;

        $presensi = Presensi::updateOrCreate(
            ['pengguna_id' => $userId, 'tanggal_id' => $tanggalId],
            ['foto' => 'photos/' . $userId . '/' . $fileName]
        );

        Log::info(Storage::url($presensi->foto));
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
