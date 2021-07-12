<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    use HasFactory;



    public function imagePath() {
//        $path = '/storage/images/';
        $path = env('IMAGE_PATH' , '/storage/images/');
        $imageFile = $this -> image ?? 'default.jpeg';

        return $path.$imageFile;
    }

    public function user() {
        return $this -> belongsTo(User::class);
    }

    public function viewers() {
        return $this -> belongsToMany(User::class, 'post_user',
            'post_id','user_id','id','id','users');

//        return $this -> belongsToMany(User::class);   // 위와 같이 알아서 써줌(생략 가능) 피버테이블이 두 개인 경우에는 최소한 테이블 이름은 적어야 함
    }
}
