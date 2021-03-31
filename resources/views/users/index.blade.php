@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach ($all_users as $user)
                    <div class="card">
                        <div class="card-haeder p-3 w-100 d-flex">
                            <!-- プロフ画像 -->
                            <img src="{{ $user->profile_image }}" class="rounded-circle" width="50" height="50">
                            <!-- <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" class="rounded-circle" width="50" height="50"> -->
                            <div class="ml-2 d-flex flex-column">
                                <!-- ユーザー名 -->
                                <p class="mb-0">{{ $user->name }}</p>
                                <!-- ユーザーID -->
                                <a href="{{ url('users/' .$user->id) }}" class="text-secondary">{{ $user->screen_name }}</a>
                                <!-- クリックすると，users/{id}へ遷移 -->
                            </div>
                            <!-- ログインユーザーがフォローされているかの判定 -->
                            @if (auth()->user()->isFollowed($user->id))
                                <div class="px-2">
                                    <span class="px-1 bg-secondary text-light">フォローされています</span>
                                </div>
                            @endif
                            <div class="d-flex justify-content-end flex-grow-1">
                                <!-- フォローしているかの判定 -->
                                @if (auth()->user()->isFollowing($user->id))
                                    <form action="{{ route('unfollow', ['id' => $user->id]) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <!-- <button type="submit" class="btn btn-danger">フォロー解除</button> -->
                                        <button type="submit" class="btn btn-primary">フォロー中</button>
                                    </form>
                                @else
                                    <form action="{{ route('follow', ['id' => $user->id]) }}" method="POST">
                                        {{ csrf_field() }}
                                        <!-- <button type="submit" class="btn btn-primary">フォローする</button> -->
                                        <!-- <button type="submit" class="btn btn-link">フォローする</button> -->
                                        <button type="submit" class="btn btn-outline-primary">フォローする</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="my-4 d-flex justify-content-center">
            {{ $all_users->links() }}
        </div>
    </div>
@endsection