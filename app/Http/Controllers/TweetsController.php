<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Tweet;
use App\Models\Comment;
use App\Models\Follower;

class TweetsController extends Controller
// TweetsController:子クラス
// Controller：親クラス
{
    //ツイート一覧表示
    public function index(Tweet $tweet, Follower $follower)
    {
        // auth()->user()でUserインスタンスが取得できる
        $user = auth()->user();
        // $follow_ids = (new Follower())->followingIds($user->id);
        $follow_ids = $follower->followingIds($user->id);
        // followed_idだけ抜き出す
        $following_ids = $follow_ids->pluck('followed_id')->toArray();

        // $timelines = (new Tweet())->getTimelines($user->id, $following_ids);
        $timelines = $tweet->getTimelines($user->id, $following_ids);
        // logger(gettype($following_ids));
        // logger($timelines);
        // logger("aiueo");
        return view('tweets.index', [
            'user'      => $user,
            'timelines' => $timelines
        ]);
    }

    //新規ツイート入力画面
    public function create()
    {
        $user = auth()->user();

        return view('tweets.create', [
            'user' => $user
        ]);
    }

    //新規ツイート投稿処理
    public function store(Request $request, Tweet $tweet)
    {
        $user = auth()->user();
        $data = $request->all();

        $validator = Validator::make($data, [
            'text' => ['required', 'string', 'max:140']
        ]);
        $validator->validate();

        $tweet->tweetStore($user->id, $data);

        return redirect('tweets');
    }

    //ツイート詳細画面
    // public function show(Tweet $tweet, Comment $comment, $id)
    public function show(Tweet $tweet, Comment $comment)

    {
        $user = auth()->user();
        // $tweets = $tweet->getTweet($id);
        $tweet = $tweet->getTweet($user->id);
        // $tweet = $tweet->getTweet($tweet->id);
        $comments = $comment->getComments($user->id);
        // $comments = $comment->getComments($tweet->id);

        return view('tweets.show', [
            'user'     => $user,
            // 'tweets'    => $tweets,
            'tweet'    => $tweet,
            'comments' => $comments
        ]);
    }

    //ツイート編集画面
    public function edit(Tweet $tweet)
    {
        $user = auth()->user();
        $tweets = $tweet->getEditTweet($user->id, $tweet->id);

        if (!isset($tweets)) {
            return redirect('tweets');
        }

        return view('tweets.edit', [
            'user'   => $user,
            'tweets' => $tweets
        ]);
    }

    //ツイート編集処理
    public function update(Request $request, Tweet $tweet)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'text' => ['required', 'string', 'max:140']
        ]);

        $validator->validate();
        $tweet->tweetUpdate($tweet->id, $data);

        return redirect('tweets');
    }

    //ツイート削除処理
    public function destroy(Tweet $tweet)
    {
        $user = auth()->user();
        $tweet->tweetDestroy($user->id, $tweet->id);

        return back();
    }
}