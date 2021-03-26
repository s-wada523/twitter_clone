@extends('layouts.app')

@section('content')

<form action="{{ url('/search')}}" method="post">
  {{ csrf_field()}}
  {{method_field('get')}}
  <div class="form-group">
    <input type="text" class="form-control col-md-5" placeholder="検索したい名前を入力してください" name="name">
  </div>

  <button type="submit" class="btn btn-primary col-md-5">検索</button>
</form>

<!-- フラッシュメッセージ？？？ -->
@if(session('flash_message'))
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
</table>
</div>

@endsection