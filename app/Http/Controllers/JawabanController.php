<?php

namespace App\Http\Controllers;

use App\JawabanModel;
use App\LikeDislikePertanyaanModel;
use App\LikeDislikeJawabanModel;
use App\PertanyaanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class JawabanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //upload file
        $nama_file='';
        if($request->file('input_file')){
            $file = $request->file('input_file');
            $nama_file = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'file_jawaban';
            $file->move($tujuan_upload,$nama_file);
        }

        // dd($request["id_pertanyaan"]);
        
        $jawaban_baru = JawabanModel::create([
                            'isi_jawaban'       => $request["isi_jawaban"],
                            'file_jawaban'      => $nama_file,
                            'jml_like'          => 0,
                            'jml_dislike'       => 0,
                            'id_user'           => Auth::user()->id_user,
                            'id_pertanyaan'     => $request["id_pertanyaan"],
                        ]);
           
        Alert::success('Berhasil', 'Jawaban Kamu Berhasil di Buat');

        return redirect("/index/all");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $show = PertanyaanModel::where('id_pertanyaan',$id)->first();
        $like = LikeDislikePertanyaanModel::where('id_pertanyaan', $id)->where('status','like')->count();
        $dislike = LikeDislikePertanyaanModel::where('id_pertanyaan', $id)->where('status','dislike')->count();

        // $like_jawaban = LikeDislikeJawabanModel::where('id_jawaban', $id)->where('status','like')->count();
        // $dislike_jawaban = LikeDislikeJawabanModel::where('id_jawaban', $id)->where('status','dislike')->count();

        return view("tampilan.show_jawab", compact("show","like","dislike"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $nama_file='';
        if($request->file('input_file')){
            $file = $request->file('input_file');
            $nama_file = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'file_jawaban';
            $file->move($tujuan_upload,$nama_file);

            $post = JawabanModel::where('id_pertanyaan', $id)
                ->update([
                    "isi_pertanyaan"    => $request['isi_pertanyaan'],
                    'file_pertanyaan'   => $nama_file,
                ]);
        }else{
            $post = JawabanModel::where('id_pertanyaan', $id)
                ->update([
                    "isi_pertanyaan" => $request['isi_pertanyaan'],
                ]);
        }
        Alert::success('Update Berhasil', 'Jawaban Kamu Berhasil di Update');

        return redirect('/pertanyaan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function download($file_name) {
        $file_path = public_path('file_jawaban/'.$file_name);
        return response()->download($file_path);
    }
}
