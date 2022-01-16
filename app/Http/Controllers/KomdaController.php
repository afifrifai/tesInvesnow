<?php

namespace App\Http\Controllers;

use App\Models\Komda;
use Illuminate\Http\Request;

class KomdaController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      return view('komda.komda',[
          'komda' => Komda::all()
      ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
     return view ('komda.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      $validate = $request->validate([
          "name" => "required"
      ]);

      $komda = new Komda;
      $komda->name = $request->name;
      $simpan = $komda->save();

      return redirect()->route('komda')->with('success', 'Berhasil menambahkan komda');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit(Komda $komda)
  {
      return view('komda.edit',[
          'komda' => $komda
      ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Komda $komda)
  {
      $rules = [
          "name" => "required"
      ];

      if($request->email != $komda->email){
          $rules['email'] = 'required|email:dns|unique:komdas';
      }

      $validate = $request->validate($rules);
      Komda::where('id', $komda->id)->update($validate);
      return redirect()->route('komda')->with('success', 'Berhasil mengubah data');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Komda $komda)
  {
      Komda::destroy($komda->id);
      return redirect()->route('komda')->with('success', 'Berhasil menghapus data');
  }
}

