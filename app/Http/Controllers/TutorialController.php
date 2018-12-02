<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutorial;

class TutorialController extends Controller
{

    public function index()
    {
      $tutorial=Tutorial::all();
      return $tutorial;
    }
    public function show($id)
    {
      $tutorial= Tutorial::find($id);

      if(!$tutorial)
        return response()->json([
          'error' =>'id tutorial tidak ditemukan'
        ],404);
        return $tutorial;
    }
    public function create(Request $request)
    {
      $this->validate($request, [
        'title' => 'required',
        'body'  => 'required',
      ]);
      $relasi= $request->user()->tutorials()->create([
      'title' => $request->json('title'),
      'slug'  =>str_slug($request->json('email')) ,
      'body'  => $request->json('body'),

    ]);
    return $relasi;
    }
    public function update(Request $request, $id)
    {
      $this->validate($request, [
        'title' => 'required',
        'body'  => 'required',
      ]);

      $data= Tutorial::find($id);
      if($request->user()->id != $data->user_id){
        return response()->json([
          'error' =>'tidak boleh mengedit'
        ],407);
      }
      $data->title = $request->title;
      $data->body = $request->body;
      $data->save();
    return $data;
    }
    public function destroy($id)
    {
      $data = Tutorial::where('id',$id)->first();
      $data->delete();
      return response()->json([
        'status' =>'data berhasil dihapus'
      ]);

    }
}
