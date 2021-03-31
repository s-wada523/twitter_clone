<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Tweet;
use App\Models\Follower;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(User $user)
    public function index(User $user)
    {
        $all_users = $user->getAllUsers(auth()->user()->id);
        // auth()->user()->idは，ログインユーザーのID
        // $all_usersには，ログインユーザー以外のユーザーIDを代入

        return view('users.index', [
            'all_users'  => $all_users
        ]);
    }

    public function following($id)
    {
        $user = new User;
        $all_users = $user->getAllUsers(auth()->user()->id);

        return view('users.followingIndex', [
            'all_users'  => $all_users
        ]);
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
        //フラッシュメッセージの導入
        // \Session::flash('flash_message', 'ログインが成功しました');
        // return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // 詳細画面
    // public function show(User $user, Tweet $tweet, Follower $follower, $id)
    public function show(User $user, Tweet $tweet, Follower $follower)
    {
        $login_user = auth()->user();
        // 以下の2行では上手くいかない
        // 理由はまだ不明
        //$is_following = $user->isFollowing($id);
        //$is_followed = $user->isFollowed($id);

        // 以下の6行を実行すると，user->nameとuser->screen_nameとプロフィールを編集するボタンが表示されない
        // また，フォロー・フォロー解除ボタンをクリックするとnot found
        // $is_following = $login_user->isFollowing($id);
        // $is_followed = $login_user->isFollowed($id);
        // $timelines = $tweet->getUserTimeLine($id);
        // $tweet_count = $tweet->getTweetCount($id);
        // $follow_count = $follower->getFollowCount($id);
        // $follower_count = $follower->getFollowerCount($id);


        $is_following = $login_user->isFollowing($user->id);
        $is_followed = $login_user->isFollowed($user->id);
        $timelines = $tweet->getUserTimeLine($user->id);
        $tweet_count = $tweet->getTweetCount($user->id);
        $follow_count = $follower->getFollowCount($user->id);
        $follower_count = $follower->getFollowerCount($user->id);

        // 以下の6行を実行すると
        // isFollowing() must be of the type integer, null given, called in /var/www/twitter_pj/app/Http/Controllers/UsersController.php on line 95
        // isFollowingの引数は整数型が与えられるべきなのに，nullが与えられている，というエラーが発生
        // $is_following = $login_user->isFollowing($user->id);
        // $is_followed = $login_user->isFollowed($user->id);
        // $timelines = $tweet->getUserTimeLine($user->id);
        // $tweet_count = $tweet->getTweetCount($user->id);
        // $follow_count = $follower->getFollowCount($user->id);
        // $follower_count = $follower->getFollowerCount($user->id);

        return view('users.show', [
            'user'           => $user,
            'is_following'   => $is_following,
            'is_followed'    => $is_followed,
            'timelines'      => $timelines,
            'tweet_count'    => $tweet_count,
            'follow_count'   => $follow_count,
            'follower_count' => $follower_count
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */



    // 編集画面の取得
    // public function edit(User $user, $id)
    public function edit(User $user)

    {
        //空のレコードを取得
        // $user = User::where('id', $id)->first();



        return view('users.edit', ['user' => $user]);
        // ユーザの取得
        // プロパティの変更
        // 保存
    }



    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'screen_name'   => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            // ユニークに設定しているscreen_nameを自身のIDのときだけ無効にする
            'name'          => ['required', 'string', 'max:255'],
            'profile_image' => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'email'         => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)]
        ]);
        $validator->validate();
        $user->updateProfile($data);

        return redirect('users/'.$user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // フォロー
    public function follow(User $user)
    {
        $follower = auth()->user();
        // フォローしているか
        // $is_following = $user->isFollowing($user->id);
        $is_following = $follower->isFollowing($user->id);
        if(!$is_following) {
            // フォローしていなければフォローする
            $follower->follow($user->id);
            return back();
        }
    }

    // フォロー解除
    public function unfollow(User $user)
    {
        $follower = auth()->user();
        // フォローしているか
        // $is_following = $user->isFollowing($user->id);
        $is_following = $follower->isFollowing($user->id);
        if($is_following) {
            // フォローしていればフォローを解除する
            $follower->unfollow($user->id);
            return back();
        }
    }

    public function serch(User $user)
    {
        $all_users = $user->getAllUsers(auth()->user()->id);
        // auth()->user()->idは，ログインユーザーのID
        // $all_usersには，ログインユーザー以外のユーザーIDを代入


        return view('users.serch', [
            'all_users'  => $all_users
        ]);
    }

    public function search(Request $request, User $user)
    {
        $keyword_name = $request->name;
        // $keyword_id = $request->id;


        // if(!empty($keyword_name) && empty($keyword_id)) {
        if(!empty($keyword_name)) {

            // $query = User::query();

            // $user = User::where('id', $id)->first();

            // $users = User::where('name', 'like', '%' .$keyword_name. '%')->get();
            // $users = $query->where('name','like', '%' .$keyword_name. '%')->get();
            $users = $user->getSearchedUsers($keyword_name);
            $all_users = $user->getAllUsers(auth()->user()->id);
            $message = "「". $keyword_name."」を含む名前の検索が完了しました。";

            return view('users.search', [
                'users'  => $users,
                'all_users'  => $all_users,
                'message'  => $message
            ]);

            // 上と同義
            // return view('users.search')->with([
            //     'all_users' => $all_users,
            //     'message' => $message,
            //   ]);

        } else {
            $message = "検索結果はありません。";
            $keyword_name;
            return view('users.search', [
                'message'  => $message,
                'keyword_name'  => $keyword_name
            ]);
        }

    }

}
