<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LikeDislikePertanyaanModel extends Model
{
    protected $table = 'like-dislike_pertanyaan';

    protected $primaryKey = 'id_like-dislike_pertanyaan';

    protected $fillable = ["status", "id_user", "id_pertanyaan"];

}
