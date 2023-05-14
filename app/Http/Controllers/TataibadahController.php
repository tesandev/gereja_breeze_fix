<?php

namespace App\Http\Controllers;

use App\Models\Tataibadah;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\Tataibadah\StoreRequest;
use App\Http\Requests\Tataibadah\UpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TataibadahController extends Controller
{
    public function index():Response
    {
        return response()->view('tataibadah.index',[
            'tataibadah' => Tataibadah::orderBy('updated_at','desc')->get(),
        ]);
    }

    public function create():Response
    {
        return response()->view('tataibadah.form');
    }
    /**
     * Display a listing of the resource.
     */
    public function listtataibadahapi()
    {
        $list = Tataibadah::all();
        return $list;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):RedirectResponse
    {
        $this->validate($request, [
            'namaibadah' => 'required|string|min:3|max:250',
            'contentbody' => 'required|string|min:3|max:10000',
        ]);

        // $create = Tataibadah::create([
        //     'namaibadah'  => $request->title,
        //     'contentbody' => $request->content
        // ]);

        $usr = DB::table('tataibadah')->insert([
            'namaibadah'=> $request->namaibadah,
            'contentbody'=> $request->contentbody,
        ]);

        if ($usr) {
            session()->flash('notif.success','Tata ibadah created successfully!');
            return redirect()->route('tataibadah.index');
        }

        return abort(500);
    }

    public function show(string $id):Response
    {
        return response()->view('tataibadah.show',[
            'tataibadah' => Tataibadah::findOrFail($id),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function apidetail($id)
    {
        $dta = Tataibadah::findOrFail($id);
        return $dta;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return response()->view('tataibadah.form',[
            'tataibadah' => Tataibadah::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id):RedirectResponse
    {
        $tb = Tataibadah::findOrFail($id);
        $this->validate($request, [
            'namaibadah' => 'required|string|min:3|max:250',
            'contentbody' => 'required|string|min:3|max:10000',
        ]);

        $update = DB::table('tataibadah')->where('id',$id)->update([
            'namaibadah'=> $request->namaibadah,
            'contentbody'=> $request->contentbody,
            'updated_at' => Carbon::now()
        ]);
        if ($update) {
            session()->flash('notif.success','Tata ibadah berhasil diupdate');
            return redirect()->route('tataibadah.index');
        }

        return abort(500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id):RedirectResponse
    {
        $tb = Tataibadah::findOrFail($id);
        
        $delete = $tb->delete($id);
        if ($delete) {
            session()->flash('notif.success','Tata ibadah berhasil dihapus');
            return redirect()->route('tataibadah.index');
        }
        return abort(500);
    }
}
