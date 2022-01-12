<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JawabanModel extends Model
{
    protected $table = 'jawaban';

    protected $primaryKey = 'id_jawaban';

    protected $fillable = ["isi_jawaban", "file_jawaban", "jml_like", "jml_dislike", "id_user", "id_pertanyaan"];

    public function MenjawabPertanyaan()
    {
        return $this->hasOne('App\ModelPertanyaan','id_pertanyaan');
    }

    public function PemberiJawaban()
    {
        return $this->belongsTo('App\user','id_user');
    }
}
