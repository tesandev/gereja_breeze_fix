<?php

namespace App\Http\Controllers;

use App\Models\Renungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class RenunganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():Response
    {
        return response()->view('renungan.index',[
            'renungan' => Renungan::orderBy('updated_at','desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():Response
    {
        return response()->view('renungan.form');
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

        $usr = DB::table('renungan')->insert([
            'title'=> $request->title,
            'body'=> $request->body,
        ]);

        if ($usr) {
            session()->flash('notif.success','Renungan berhasil dibuat!');
            return redirect()->route('renungan.index');
        }

        return abort(500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id):Response
    {
        return response()->view('renungan.show',[
            'renungan' => Renungan::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return response()->view('renungan.form',[
            'renungan' => Renungan::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id):RedirectResponse
    {
        $tb = Renungan::findOrFail($id);
        $this->validate($request, [
            'title' => 'required|string|min:3|max:250',
            'body' => 'required|string|min:3|max:10000',
        ]);

        $update = DB::table('renungan')->where('id',$id)->update([
            'title'=> $request->title,
            'body'=> $request->body,
            'updated_at' => Carbon::now()
        ]);
        if ($update) {
            session()->flash('notif.success','Renungan berhasil diupdate');
            return redirect()->route('renungan.index');
        }

        return abort(500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tb = Renungan::findOrFail($id);
        
        $delete = $tb->delete($id);
        if ($delete) {
            session()->flash('notif.success','Renungan berhasil dihapus');
            return redirect()->route('renungan.index');
        }
        return abort(500);
    }

    //Api Mobile
    public function listrenungan()
    {
        $list = Renungan::all();
        return $list;
    }

    public function renungandetail($id)
    {
        $dta = Renungan::findOrFail($id);
        return $dta;
    }
}
