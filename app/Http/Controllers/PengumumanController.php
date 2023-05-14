<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():Response
    {
        return response()->view('pengumuman.index',[
            'pengumuman' => Pengumuman::orderBy('updated_at','desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():Response
    {
        return response()->view('pengumuman.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):RedirectResponse
    {
        $this->validate($request, [
            'title' => 'required|string|min:3|max:250',
            'body' => 'required|string|min:3|max:10000',
        ]);

        $usr = DB::table('pengumuman')->insert([
            'title'=> $request->title,
            'body'=> $request->body,
        ]);

        if ($usr) {
            session()->flash('notif.success','Pengumuman berhasil dibuat!');
            return redirect()->route('pengumuman.index');
        }

        return abort(500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id):Response
    {
        return response()->view('pengumuman.show',[
            'pengumuman' => Pengumuman::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return response()->view('pengumuman.form',[
            'pengumuman' => Pengumuman::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id):RedirectResponse
    {
        $tb = Pengumuman::findOrFail($id);
        $this->validate($request, [
            'title' => 'required|string|min:3|max:250',
            'body' => 'required|string|min:3|max:10000',
        ]);

        $update = DB::table('pengumuman')->where('id',$id)->update([
            'title'=> $request->title,
            'body'=> $request->body,
            'updated_at' => Carbon::now()
        ]);
        if ($update) {
            session()->flash('notif.success','Pengumuman berhasil diupdate');
            return redirect()->route('pengumuman.index');
        }

        return abort(500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id):RedirectResponse
    {
        $tb = Pengumuman::findOrFail($id);
        
        $delete = $tb->delete($id);
        if ($delete) {
            session()->flash('notif.success','Pengumuman berhasil dihapus');
            return redirect()->route('pengumuman.index');
        }
        return abort(500);
    }

    //Api Mobile
    public function listpengumuman()
    {
        $list = Pengumuman::all();
        return $list;
    }

    public function pengumumandetail($id)
    {
        $dta = Pengumuman::findOrFail($id);
        return $dta;
    }
}
