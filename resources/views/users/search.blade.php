@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <!-- <div class="col-md-8"> -->
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">検索結果</div>

                <div class="card-body">
                <div style="margin-top:50px;">
                  <h1>検索結果</h1>
                  @if(isset($users))
                  <!-- $all_usersに値がセットされていて，かつNULLでないとき -->
                  <table class="table">
                    <tr>
                      <th>ユーザー名</th><th>ID</th>
                    </tr>
                    @foreach($users as $user)
                      <tr>
                        <td>{{$user->name}}</td>
                        <td><a href="{{ url('users/' .$user->id) }}" class="text-secondary">{{ $user->screen_name }}</a>
                        </td>
                      </tr>
                    @endforeach
                  </table>
                  @endif
                  @if(!empty($message))
                  <div class="alert alert-primary" role="alert">{{ $message}}</div>
                  @endif
                  @if(!empty($keyword_name))
                  <div class="alert alert-primary" role="alert">{{ $keyword_name}}</div>
                  @else
                  <!-- <div class="alert alert-primary" role="alert">keyword_nameの中身は空です。</div> -->
                  @endif
                  </div>

                  <!-- <a href="{{ url('users/' .$user->id) }}" class="text-secondary">{{ $user->screen_name }}</a> -->



                  <!-- フラッシュメッセージ？？？ -->
                  <!-- @if(session('flash_message'))
                  <div class="alert alert-primary" role="alert" style="margin-top:50px;">{{ session('flash_message')}}</div>
                  @endif
                  <div style="margin-top:50px;">
                    <h1>ユーザー一覧</h1>
                    <table class="table">
                      <tr>
                        <th>アカウント名</th><th>ユーザー名</th>
                      </tr>
                    @foreach($all_users as $user)
                      <tr>
                        <td>{{$user->name}}</td><td>{{$user->screen_name}}</td>
                      </tr>
                    @endforeach
                    </table>-->
                  </div>
            </div>
        </div>
    </div>
</div>



@endsection