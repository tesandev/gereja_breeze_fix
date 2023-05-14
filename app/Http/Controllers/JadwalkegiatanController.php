<?php

namespace App\Http\Controllers;

use App\Models\Jadwalkegiatan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class JadwalkegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():Response
    {
        return response()->view('jadwalkegiatan.index',[
            'jadwalkegiatan' => Jadwalkegiatan::orderBy('updated_at','desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():Response
    {
        return response()->view('jadwalkegiatan.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):RedirectResponse
    {
        $this->validate($request, [
            'namakegiatan' => 'required|string|min:3|max:250',
            'lokasi' => 'required|string|min:3|max:250',
            'tanggalkegiatan' => 'required',
            'jamkegiatan' => 'required',
        ]);

        $usr = DB::table('jadwalkegiatan')->insert([
            'namakegiatan' => $request->namakegiatan,
            'lokasi' => $request->lokasi,
            'tanggalkegiatan' => $request->tanggalkegiatan,
            'jamkegiatan' => $request->jamkegiatan,
        ]);

        if ($usr) {
            session()->flash('notif.success','Jadwal Kegiatan berhasil dibuat!');
            return redirect()->route('jadwalkegiatan.index');
        }

        return abort(500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->view('jadwalkegiatan.show',[
            'jadwalkegiatan' => Jadwalkegiatan::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return response()->view('jadwalkegiatan.form',[
            'jadwalkegiatan' => Jadwalkegiatan::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id):RedirectResponse
    {
        $tb = Jadwalkegiatan::findOrFail($id);
        $this->validate($request, [
            'namakegiatan' => 'required|string|min:3|max:250',
            'lokasi' => 'required|string|min:3|max:250',
            'tanggalkegiatan' => 'required',
            'jamkegiatan' => 'required',
        ]);

        $update = DB::table('jadwalkegiatan')->where('id',$id)->update([
            'namakegiatan' => $request->namakegiatan,
            'lokasi' => $request->lokasi,
            'tanggalkegiatan' => $request->tanggalkegiatan,
            'jamkegiatan' => $request->jamkegiatan,
            'updated_at' => Carbon::now()
        ]);
        if ($update) {
            session()->flash('notif.success','Jadwal Kegiatan berhasil diupdate');
            return redirect()->route('jadwalkegiatan.index');
        }

        return abort(500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id):RedirectResponse
    {
        $tb = Jadwalkegiatan::findOrFail($id);
        
        $delete = $tb->delete($id);
        if ($delete) {
            session()->flash('notif.success','Jadwal Kegiatan berhasil dihapus');
            return redirect()->route('jadwalkegiatan.index');
        }
        return abort(500);
    }

    //Api Mobile
    public function listjadwalkegiatan()
    {
        $list = Jadwalkegiatan::all();
        return $list;
    }
}
