<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileModel extends Model
{
    protected $table = 'profiles';
    protected $primaryKey = 'id_profile';

    protected $fillable = ["nama_lengkap", "jenis_kelamin", "nomor_telepon","email", "id_user"];
    
    public function profile()
    {
        return $this->belongsTo('App\user','id_user');
    }
}
