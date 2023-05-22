<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():Response
    {
        return response()->view('petugas.index',[
            'petugas' => DB::table('petugas')->select('petugas.*','jadwalkegiatan.tanggalkegiatan','jadwalkegiatan.jamkegiatan')
                            ->leftJoin('jadwalkegiatan', 'jadwalkegiatan.id', '=', 'petugas.jadwal_id')
                            ->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():Response
    {
        return response()->view('petugas.form',[
            'selectedID' => 0,
            'listjadwal' => DB::table('jadwalkegiatan')->select('id','tanggalkegiatan','jamkegiatan')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):RedirectResponse
    {
        $this->validate($request, [
            'body' => 'required|string|min:3|max:10000',
        ]);

        $cek = DB::table('petugas')->select('petugas.jadwal_id')
                ->where('jadwal_id',$request->jadwal_id)
                ->first();

        if ($cek->jadwal_id == $request->jadwal_id) {
            session()->flash('notif.error','Petugas di jadwal tersebut sudah ada');
            return redirect()->route('petugas.create');
        }

        $usr = DB::table('petugas')->insert([
            'jadwal_id'=> $request->jadwal_id,
            'body'=> $request->body,
        ]);

        if ($usr) {
            session()->flash('notif.success','Petugas berhasil dibuat!');
            return redirect()->route('petugas.index');
        }

        return abort(500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id):Response
    {
        return response()->view('petugas.show',[
            'petugas' => DB::table('petugas')->select('petugas.*','jadwalkegiatan.tanggalkegiatan','jadwalkegiatan.jamkegiatan')
                        ->leftJoin('jadwalkegiatan', 'jadwalkegiatan.id', '=', 'petugas.jadwal_id')
                        ->where('petugas.id',$id)
                        ->first(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pt = Petugas::findOrFail($id);
        return response()->view('petugas.form',[
            'petugas' => $pt,
            'selectedID' => $pt->jadwal_id,
            'listjadwal' => DB::table('jadwalkegiatan')->select('id','tanggalkegiatan','jamkegiatan')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id):RedirectResponse
    {
        $tb = Petugas::findOrFail($id);
        $this->validate($request, [
            'body' => 'required|string|min:3|max:10000',
        ]);

        $update = DB::table('petugas')->where('petugas.id','=',$id)->update([
            'jadwal_id'=> $request->jadwal_id,
            'body'=> $request->body,
            'updated_at' => Carbon::now()
        ]);
        if ($update) {
            session()->flash('notif.success','Petugas berhasil diupdate');
            return redirect()->route('petugas.index');
        }

        return abort(500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tb = Petugas::findOrFail($id);
        
        $delete = $tb->delete($id);
        if ($delete) {
            session()->flash('notif.success','Petugas berhasil dihapus');
            return redirect()->route('petugas.index');
        }
        return abort(500);
    }

    //Api Mobile
    public function listpetugas()
    {
        $list = DB::table('petugas')->select('petugas.*','jadwalkegiatan.tanggalkegiatan','jadwalkegiatan.jamkegiatan')
        ->leftJoin('jadwalkegiatan', 'jadwalkegiatan.id', '=', 'petugas.jadwal_id')
        ->get();
        return $list;
    }

    public function petugasdetail($id)
    {
        $dta = DB::table('petugas')->select('petugas.*','jadwalkegiatan.tanggalkegiatan','jadwalkegiatan.jamkegiatan')
        ->leftJoin('jadwalkegiatan', 'jadwalkegiatan.id', '=', 'petugas.jadwal_id')
        ->where('petugas.id',$id)
        ->first();
        return $dta;
    }
}
