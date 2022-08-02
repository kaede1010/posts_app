@extends('layouts.app')

@section('content')

<div class="post-container container">
    <!-- バリデーションエラーの表示 -->
    @include('common.errors')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('アカウントを編集') }}</div>

                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="{{ route('userEdit') }}">
                        @csrf

                        <div class="user-info mb-3">
                            <div class="d-flex align-items-center">
                                <div class="user-image">
                                    @if(empty($user->image_icon))
                                    <img src="{{ asset('icon/icon-default-user.svg') }}" alt="ユーザーアイコン">
                                    @else
                                    <img src="{{ $user->image_icon }}" alt="ユーザーアイコン">
                                    @endif
                                </div>
                                <div class="user-detail ml-2 d-flex flex-column">
                                    <span class="mb-0">{{ $user->name }}</span>
                                    <a href="{{ url('user_detail/'.$user->id) }}">@ {{ $user->account_name }}</a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="account_name" class="col-md-4 col-form-label text-md-right">{{ __('アカウント名（10文字以内）') }}</label>

                            <div class="col-md-6">
                                <input id="account_name" type="text" class="form-control @error('account_name') is-invalid @enderror" name="account_name" value="{{ $user->account_name }}" placeholder="アカウント名を入力してください" maxlength="10" required autocomplete="account_name" autofocus>

                                @error('account_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('名前（10文字以内）') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" placeholder="名前を入力してください" maxlength="10" required autocomplete="name">

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="formFile" class="col-md-4 col-form-label text-md-right">{{ __('アイコン画像（※必須ではありません）') }}</label>
                            <div class="col-md-6">
                                <input class="form-control p-0 h-auto @error('image') is-invalid @enderror" type="file" name="image_icon" id="formFile">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="self_introduction" class="col-md-4 col-form-label text-md-right">{{ __('自己紹介（100文字以内）') }}</label>

                            <div class="col-md-6">
                                <textarea class="form-control @error('self_introduction') is-invalid @enderror" id="exampleFormControlTextarea1" name="self_introduction" rows="5" placeholder="自己紹介を書きましょう！" maxlength="100">{{ $user->self_introduction }}</textarea>

                                @error('self_introduction')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('メールアドレス') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" placeholder="メールアドレスを入力してください" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('パスワード（8文字以上）') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="変更する場合は入力してください" autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0 justify-content-center">
                            <div class="col-md-6 text-center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('編集') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection