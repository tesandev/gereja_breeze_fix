<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

use App\Models\Bacaan;
// We will use Form Request to validate incoming requests from our store and update method
use App\Http\Requests\Bacaan\StoreRequest;
use App\Http\Requests\Bacaan\UpdateRequest;

class BacaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():Response
    {
        return response()->view('bacaan.index',[
            'bacaan' => Bacaan::orderBy('updated_at','desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():Response
    {
        return response()->view('bacaan.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request):RedirectResponse
    {
        $validate = $request->validated();

        if ($request->hasFile('featured_image')) {
            //taruh image di public storage
            $filePath = Storage::disk('public')->put('images/bacaan/featured-images',request()->file('featured_image'));
            $validate['featured_image'] = $filePath;
        }

        $create = Bacaan::create($validate);

        if ($create) {
            session()->flash('notif.success','Bacaan created successfully!');
            return redirect()->route('bacaan.index');
        }

        return abort(500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id):Response
    {
        return response()->view('bacaan.show',[
            'bacaan' => Bacaan::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return response()->view('bacaan.form',[
            'bacaan' => Bacaan::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id):RedirectResponse
    {
        $bacaan = Bacaan::findOrFail($id);
        $validated = $request->validated();

        if($request->hasFile('featured_image')){
            //delete image
            Storage::disk('Public')->delete($bacaan->featured_image);
            $filePath = Storage::disk('Public')->put('images/bacaan/featured-images',request()->file('featured_image'),'public');
            $validated['featured_image'] = $filePath;
        }

        $update = $bacaan->update($validated);
        if ($update) {
            session()->flash('notif.success','Baacaan berhasil diupdate');
            return redirect()->route('bacaan.index');
        }

        return abort(500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id):RedirectResponse
    {
        $bacaan = Bacaan::findOrFail($id);
        Storage::disk('public')->delete($bacaan->featured_image);
        $delete = $bacaan->delete($id);
        if ($delete) {
            session()->flash('notif.success','Baccan berhasil dihapus');
            return redirect()->route('bacaan.index');
        }
        return abort(500);
    }
}
