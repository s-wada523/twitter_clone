<!-- ホーム画面 -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- フラッシュメッセージ -->
            <!-- @if (session('flash_message'))
                <div class="flash_message">
                    {{ session('flash_message') }}
                </div>
            @endif -->

            <main class="mt-4">
                @yield('content')
            </main>
            
            <!-- 以下は必要性を感じないため削除対象 -->
            <div class="card">
                <div class="card-header">ダッシュボード</div>

                <div class="card-body">
                    @if (Session::has('flash_message'))
                        <p class="bg-success">{!! Session::get('flash_message') !!}</p>
                    @endif

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    ログインに成功!
                </div>
            </div>
            <!-- ここまで -->
        </div>
    </div>
</div>
@endsection
