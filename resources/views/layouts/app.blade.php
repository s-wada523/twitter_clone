<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'TwitterClone') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto align-items-center">
                            <!-- Authentication Links -->
                            @guest
                            <!-- ユーザーは認証されていない -->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('ログイン') }}</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('アカウント作成') }}</a>
                                    </li>
                                @endif
                            @else
                            <!-- 認証されている -->
                                <!-- 追加 -->
                                
                                <!-- ユーザー検索フォーム -->
                                <li class="nav-item mr-5">
                                    <a href="{{ url('/serch') }}" class="btn btn-md btn-primary">検索する</a>
                                    <!-- ツイートするをクリックすると，tweets/createへ遷移 -->

                                    <!-- <form action="{{ url('/search')}}" method="post">
                                        {{ csrf_field()}}
                                        {{method_field('get')}}
                                        <div class="form-group">
                                            <input type="text" class="form-control col-md-5" placeholder="検索したい名前を入力してください" name="name">
                                        </div>
                                    </form> -->
                                </li>
                                <!-- テスト -->
                                <!-- <li class="nav-item mr-5">
                                    <form action="/bbs" method="POST">
                                        検索:<br>
                                        <input name="name">
                                        <br>
                                    </form>
                                </li> -->

                                <!-- ツイートボタン -->
                                <li class="nav-item mr-5">
                                    <a href="{{ url('tweets/create') }}" class="btn btn-md btn-primary">ツイートする</a>
                                    <!-- ツイートするをクリックすると，tweets/createへ遷移 -->
                                </li>

                                <!-- プロフィール -->
                                <li class="nav-item">
                                    <a href="{{ url('users/' .auth()->user()->id) }}" class="dropdown-item">プロフィール</a>
                                </li>

                                 <!-- プロフ画像 -->
                                 <li class="nav-item">
                                    <img src="{{ auth()->user()->profile_image }}" class="rounded-circle" width="50" height="50">
                                    <!-- <img src="{{ asset('storage/profile_image/' .auth()->user()->profile_image) }}" class="rounded-circle" width="50" height="50"> -->
                                </li>

                                <!-- ユーザー名 -->
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ auth()->user()->name }} <span class="caret"></span>
                                    </a>
                                    <!-- ログインしているユーザーネームをクリックすると，新たな以下の項目が表示 -->

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <!-- <a href="{{ url('users/' .auth()->user()->id) }}" class="dropdown-item">プロフィール</a> -->
                                        <!-- プロフィールをクリックすると，users/{id}へ遷移 -->
                                        <a href="{{ route('logout') }}" class="dropdown-item"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('ログアウト') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </body>
</html>