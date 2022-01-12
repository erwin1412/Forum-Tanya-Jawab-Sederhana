<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LikeDislikeJawabanModel extends Model
{
    protected $table = 'like-dislike_jawaban';

    protected $primaryKey = 'id_like-dislike_jawaban';

    protected $fillable = ["status", "id_user", "id_jawaban"];

}
