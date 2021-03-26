@extends('layouts.app')

@section('content')

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
      <td>{{$user->name}}</td><td>{{$user->screen_name}}</td>
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

@endsection