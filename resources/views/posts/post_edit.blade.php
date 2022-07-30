@extends('layouts.app')

@section('content')

<div class="post-container container">
    <!-- バリデーションエラーの表示 -->
    @include('common.errors')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('投稿を編集') }}</div>

                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="{{ route('post_edit') }}">
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

                        <input type="text" class="form-control" name="id" value="{{$post->id}}" hidden>
                        
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">投稿の内容（140文字以内））</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="body" rows="5" placeholder="早速投稿してみよう！" maxlength="140" required autofocus>{{ $post->body }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="formFile" class="form-label">画像を変更または追加（※必須ではありません）</label>
                            <input class="form-control p-0 h-auto" type="file" id="formFile" name="image">
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('編集する') }}
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