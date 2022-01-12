<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MateriModel extends Model
{
    protected $table = 'materi';

    protected $primaryKey = 'id_materi';

    protected $fillable = ["nama_materi"];

    public function PertanyaanTerkait()
    {
        return $this->belongsToMany('App\PertanyaanModel', 'pertanyaan_dibuat', 'id_materi' , 'id_pertanyaan');
    }
    
}
