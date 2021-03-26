<?php

//namespace App;
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    //  
    protected $fillable = [
        'screen_name',
        'name',
        'profile_image',
        'email',
        'password'
    ];

    // リレーションの親子関係
    public function followers()
    {
        return $this->belongsToMany(self::class, 'followers', 'followed_id', 'following_id');
        // followers()はフォローされているユーザIDから，フォローしているユーザIDにアクセスする
    }

    public function follows()
    {
        return $this->belongsToMany(self::class, 'followers', 'following_id', 'followed_id');
        // follows()はフォローしているユーザIDから，フォローされているユーザIDにアクセスする

    }

    public function getAllUsers(Int $user_id)
    {
        // paginate(5)：ページごとに表示したいアイテム数が5
        // 引数で受け取ったログインしているユーザを除くユーザを1ページにつき5名取得
        return $this->Where('id', '<>', $user_id)->paginate(5);
    }

    // 追加したメソッド
    public function getSearchedUsers(String $keyword_name)
    {
        return $this->Where('name', 'like', '%' .$keyword_name. '%')->get();
    }

    // フォローする
    public function follow(Int $user_id) 
    {
        return $this->follows()->attach($user_id);
    }
    
    // フォロー解除する
    public function unfollow(Int $user_id)
    {
        return $this->follows()->detach($user_id);
    }
    
    // フォローしているか
    public function isFollowing(Int $user_id) 
    {
        // followed_idとは，自身をフォローしてるユーザーのID
        // followed_idが$user_idと等しいとき，
        return (boolean) $this->follows()->where('followed_id', $user_id)->first(['id']);
    }
    
    // フォローされているか
    public function isFollowed(Int $user_id) 
    {
        return (boolean) $this->followers()->where('following_id', $user_id)->first(['id']);
    }

    public function updateProfile(Array $params)
    {
        if (isset($params['profile_image'])) {
            $file_name = $params['profile_image']->store('public/profile_image/');

            $this::where('id', $this->id)
                ->update([
                    'screen_name'   => $params['screen_name'],
                    'name'          => $params['name'],
                    'profile_image' => basename($file_name),
                    'email'         => $params['email'],
                ]);
        } else {
            $this::where('id', $this->id)
                ->update([
                    'screen_name'   => $params['screen_name'],
                    'name'          => $params['name'],
                    'email'         => $params['email'],
                ]); 
        }

        return;
    }
}
