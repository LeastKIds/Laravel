<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    여기에 쓰여 있어야만 create로 넣을 수 있다.
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts() {
        return $this -> hasMany(Post::class);
    }

    public function viewed_posts() {
//        return $this -> belongsToMany(Post::class);   // 피버 테이블이 두 개 인경우 아래로 코딩을 해야함(적어도 테이블 이름은 적어줌)
        return $this -> belongsToMany(Post::class,'post_user','user_id'
            , 'post_id','id','id','posts');
    }
}
