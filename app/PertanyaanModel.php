<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PertanyaanModel extends Model
{
    protected $table = 'pertanyaan';

    protected $primaryKey = 'id_pertanyaan';

    protected $fillable = ["judul_pertanyaan", "isi_pertanyaan", "file_pertanyaan", "jml_like", "jml_dislike", "id_user"];

    public function DaftarJawaban()
    {
        return $this->hasMany('App\JawabanModel','id_pertanyaan');
    }
    
    public function PertanyaanMilik()
    {
        return $this->belongsTo('App\user', 'id_user');
    }

    public function MateriTerkait()
    {
        return $this->belongsToMany('App\MateriModel', 'pertanyaan_dibuat', 'id_pertanyaan', 'id_materi');
    }
}
