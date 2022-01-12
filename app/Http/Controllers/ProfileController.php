<?php

namespace App\Http\Controllers;

use App\LikeDislikePertanyaanModel;
use App\LikeDislikeJawabanModel;
use App\ProfileModel;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
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
        //
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
        //
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
    public function edit($id)
    {
       
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
        $id_user = Auth::user()->id_user;

        if (ProfileModel::where('id_user',$id_user)->exists()) {
            $post = ProfileModel::where('id_user', $id_user)
                ->update([
                    "nama_lengkap"  => $request['nama_lengkap'],
                    "jenis_kelamin" => $request['jenis_kelamin'],
                    "nomor_telepon" => $request['nomor_telepon'],
                ]);
        }else{
            $post = ProfileModel::create([
                "jenis_kelamin" => $request['jenis_kelamin'],
                "nama_lengkap"  => $request['nama_lengkap'],
                "nomor_telepon" => $request['nomor_telepon'],
                "id_user"       => $id_user
            ]);
        }

        Alert::success('Update Berhasil', 'Kamu berhasil update profil');

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

    public function likePertanyaan(Request $request, $id_pertanyaan)
    {
        $id_user = Auth::user()->id_user;
        if(LikeDislikePertanyaanModel::where('id_user',$id_user)
                                        ->where('id_pertanyaan', $id_pertanyaan)
                                        ->where('status', 'dislike')
                                        ->exists()) // Pertama: Cek kondisi apakah id yg login sudah pernah memberikan dislike atau belum
                                        {
            LikeDislikePertanyaanModel::where('id_user',$id_user)
                                        ->where('id_pertanyaan', $id_pertanyaan)
                                        ->update([
                                            'status'=> 'like', //klu pernah, status nya diubah jadi like
            ]);
            Alert::success('Proses Berhasil', 'Pertanyaan ini sudah kamu like');

        }else if(LikeDislikePertanyaanModel::where('id_user',$id_user)
                                        ->where('id_pertanyaan', $id_pertanyaan)
                                        ->where('status', 'like')
                                        ->exists()) // Kedua: Cek kondisi apakah id yg login sudah pernah memberikan like atau belum
                                        {
            Alert::warning('Proses Gagal', 'Anda sudah menyukai pertanyaan ini'); // klu ada, lgsgs kasih peringatan aja klu dia sudah pernah like pertanyaan ini
        }else{
            LikeDislikePertanyaanModel::create([ // Kondisi terakhir klu dia blm pernah ngasih like/dislike ke pertanyaan itu. tinggal create aja
                'status'        => 'like',
                'id_user'       => Auth::user()->id_user,
                'id_pertanyaan' => $id_pertanyaan
            ]);
        Alert::success('Proses Berhasil', 'Pertanyaan ini sudah kamu like');

        }

        return redirect()->back();
    }

    public function dislikePertanyaan(Request $request, $id_pertanyaan)
    {
        $id_user = Auth::user()->id_user;
        if(LikeDislikePertanyaanModel::where('id_user',$id_user)
                                        ->where('id_pertanyaan', $id_pertanyaan)
                                        ->where('status', 'like')
                                        ->exists()) 
                                        {
            LikeDislikePertanyaanModel::where('id_user',$id_user)
                                        ->where('id_pertanyaan', $id_pertanyaan)
                                        ->update([
                                        'status'=> 'dislike', 
            ]);
            Alert::success('Proses Berhasil', 'Pertanyaan ini sudah kamu dislike');

        }else if(LikeDislikePertanyaanModel::where('id_user',$id_user)
                                        ->where('id_pertanyaan', $id_pertanyaan)
                                        ->where('status', 'dislike')
                                        ->exists()){
            Alert::warning('Proses Gagal', 'Anda sudah mendislike pertanyaan ini');
        }else{
            LikeDislikePertanyaanModel::create([
                'status'        => 'dislike',
                'id_user'       => Auth::user()->id_user,
                'id_pertanyaan' => $id_pertanyaan
            ]);
        Alert::success('Proses Berhasil', 'Pertanyaan ini sudah kamu dislike');

        }

        return redirect()->back();
    }

    public function likeJawaban(Request $request, $id_jawaban) {
        $id_user = Auth::user()->id_user;
        if(LikeDislikeJawabanModel::where('id_user', $id_user)
                                    ->where('id_jawaban', $id_jawaban)
                                    ->where('status', 'dislike')
                                    ->exists()) 
                                    {
            LikeDislikeJawabanModel::where('id_user', $id_user)
                                    ->where('id_jawaban', $id_jawaban)
                                    ->update([
                                        'status'=> 'like',
            ]);
            DB::table('jawaban')->where('id_jawaban', $id_jawaban)->increment('jml_like');
            DB::table('jawaban')->where('id_jawaban', $id_jawaban)->decrement('jml_dislike');
            Alert::success('Proses Berhasil', 'Jawaban ini sudah kamu like');

        }elseif(LikeDislikeJawabanModel::where('id_user', $id_user)
                                        ->where('id_jawaban', $id_jawaban)
                                        ->where('status', 'like')
                                        ->exists())
                                        {
            Alert::warning('Proses Gagal', 'Anda sudah menyukai jawaban ini');

        }else{
            LikeDislikeJawabanModel::create([
                'status' => 'like',
                'id_user' => Auth::user()->id_user,
                'id_jawaban' => $id_jawaban
            ]);
            DB::table('jawaban')->where('id_jawaban', $id_jawaban)->increment('jml_like');
            Alert::success('Proses Berhasil', 'Jawaban ini sudah kamu like');
        }

        return redirect()->back();
        
    }

    public function dislikeJawaban(Request $request, $id_jawaban) {
        $id_user = Auth::user()->id_user;
        if(LikeDislikeJawabanModel::where('id_user', $id_user)
                                    ->where('id_jawaban', $id_jawaban)
                                    ->where('status', 'like')
                                    ->exists()) 
                                    {
            LikeDislikeJawabanModel::where('id_user', $id_user)
                                    ->where('id_jawaban', $id_jawaban)
                                    ->update([
                                        'status'=> 'dislike',
            ]);
            DB::table('jawaban')->where('id_jawaban', $id_jawaban)->increment('jml_dislike');
            DB::table('jawaban')->where('id_jawaban', $id_jawaban)->decrement('jml_like');
            Alert::success('Proses Berhasil', 'Jawaban ini sudah kamu dislike');

        }elseif(LikeDislikeJawabanModel::where('id_user', $id_user)
                                        ->where('id_jawaban', $id_jawaban)
                                        ->where('status', 'dislike')
                                        ->exists())
                                        {
            Alert::warning('Proses Gagal', 'Anda sudah menyukai jawaban ini');

        }else {
            LikeDislikeJawabanModel::create([
                'status' => 'dislike',
                'id_user' => Auth::user()->id_user,
                'id_jawaban' => $id_jawaban
            ]);
            DB::table('jawaban')->where('id_jawaban', $id_jawaban)->increment('jml_dislike');
            Alert::success('Proses Berhasil', 'Jawaban ini sudah kamu like');
        }

        return redirect()->back();

    }
}
