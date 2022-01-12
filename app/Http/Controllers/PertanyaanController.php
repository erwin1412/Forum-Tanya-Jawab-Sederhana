<?php

namespace App\Http\Controllers;

use App\LikeDislikePertanyaanModel;
use App\MateriModel;
use App\PertanyaanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;


class PertanyaanController extends Controller
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
        $pertanyaanDibuat = Auth::user();
        $listPertanyaan = $pertanyaanDibuat->pertanyaanDibuat;
        return view('tampilan.index', compact('listPertanyaan'));
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
        // $request->validate([
        //     "judul_pertanyaan" => 'bail|required',
        //     "isi_pertanyaan" => 'required',
        // ]);

        // sementara like dislike diset 0
        // $store = new PertanyaanModel();
        // $store->judul_pertanyaan = $request["judul_pertanyaan"];
        // $store->isi_pertanyaan = $request["keterangan_pertanyaan"];
        // $store->file_pertanyaan = $request["input_file"];
        // $store->jml_like = 0;
        // $store->jml_dislike = 0;
        // $store->id_user = Auth::user()->id_user;
        // $store->save();
        
        $idMateri= [];
        $materiArr = explode(',',$request['materi']);
        foreach ($materiArr as $nama_materi) {
            $materiKapital = strtoupper($nama_materi);
            $materi = MateriModel::where("nama_materi",$materiKapital)->first();
            if($materi){
                $idMateri[] = $materi->id_materi;
            }else{
                $materi_baru = MateriModel::create(["nama_materi" => $materiKapital]);
                $idMateri[] = $materi_baru->id_materi;
            }
        }

        //upload file
        $nama_file='';
        if($request->file('input_file')){
            $file = $request->file('input_file');
            $nama_file = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'file_pertanyaan';
            $file->move($tujuan_upload,$nama_file);
        }
        
        $pertanyaan_baru = PertanyaanModel::create([
                            'judul_pertanyaan'  => $request["judul_pertanyaan"],
                            'isi_pertanyaan'    => $request["isi_pertanyaan"],
                            'file_pertanyaan'   => $nama_file,
                            'jml_like'          => 0,
                            'jml_dislike'       => 0,
                            'id_user'           => Auth::user()->id_user
                        ]);

        $pertanyaan_baru->MateriTerkait()->sync($idMateri);                
        Alert::success('Berhasil', 'Pertanyaan Kamu Berhasil di Buat');

        return redirect("/pertanyaan");
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
        return view("tampilan.show", compact("show"));
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
            $tujuan_upload = 'file_pertanyaan';
            $file->move($tujuan_upload,$nama_file);

            $post = PertanyaanModel::where('id_pertanyaan', $id)
                ->update([
                    'judul_pertanyaan'  => $request["judul_pertanyaan"],
                    "isi_pertanyaan"    => $request['isi_pertanyaan'],
                    'file_pertanyaan'   => $nama_file,
                ]);
        }else{
            $post = PertanyaanModel::where('id_pertanyaan', $id)
                ->update([
                    'judul_pertanyaan'  => $request["judul_pertanyaan"],
                    "isi_pertanyaan" => $request['isi_pertanyaan'],
                ]);
        }
        Alert::success('Update Berhasil', 'Pertanyaan Kamu Berhasil di Update');

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
        $query = PertanyaanModel::where('id_pertanyaan',$id)->delete();

        Alert::success('Hapus Berhasil', 'Pertanyaan Kamu Berhasil di Hapus');
        return redirect('/pertanyaan');
    }

    public function showAll() {
        $listPertanyaan = PertanyaanModel::all();
        return view('tampilan.index_semua', compact('listPertanyaan'));
    }

    public function download($file_name) {
        $file_path = public_path('file_pertanyaan/'.$file_name);
        return response()->download($file_path);
    }
}
