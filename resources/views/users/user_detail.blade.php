@extends('layouts.app')

@section('content')


<!-- 投稿一覧表示 -->
<div class="post-table-container container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- ユーザーのプロフィール -->
            <div class="user-profile card mb-4 ">
                <div class="card-header">{{ __('ユーザープロフィール') }}</div>

                <div class="user-info card-body d-flex justify-content-center align-items-center">
                    <div class="user-image">
                        @if(empty($user->image_icon))
                        <img src="{{ asset('icon/icon-default-user.svg') }}" alt="ユーザーアイコン">
                        @else
                        <img src="{{ $user->image_icon }}" alt="ユーザーアイコン">
                        @endif
                    </div>
                    <div class="user-detail d-flex flex-column ml-4 w-50">
                        <span class="mb-2">{{ $user->name }}</span>
                        <a href="{{ url('user_detail/'.$user->id) }}" class="mb-2">@ {{ $user->account_name }}</a>
                        @if(empty($user->self_introduction))
                        <div>まだ自己紹介がありません</div>
                        @else
                        <div>{{ $user->self_introduction }}</div>
                        @endif
                    </div>
                </div>

            </div>

            @foreach ($posts as $post)
            <div class="card mb-4">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="user-info d-flex align-items-center">
                        <div class="user-image">
                            @if(empty($post->image_icon))
                            <img src="{{ asset('icon/icon-default-user.svg') }}" alt="ユーザーアイコン">
                            @else
                            <img src="{{ $post->image_icon }}" alt="ユーザーアイコン">
                            @endif
                        </div>
                        <div class="user-detail ml-2 d-flex flex-column">
                            <span class="mb-0">{{ $post->name }}</span>
                            <a href="{{ url('user_detail/'.$post->user_id) }}">@ {{ $post->account_name }}</a>
                        </div>
                    </div>
                    <div class="create-time">{{ $post->created_at->format('Y年m月d日') }}</div>
                </div>

                <div class="card-body">
                    <div class="post-body">
                        {{ $post->body }}
                    </div>
                    <!-- ifで画像があるときとない時で分岐させる -->
                    @if(!empty($post->image))
                    <div class="post-image w-50">
                        <img src="{{ $post->image }}" alt="ユーザーアイコン">
                    </div>
                    @endif
                </div>

                <div class="card-footer d-flex justify-content-end align-items-center">
                    @if($post->user_id === Auth::user()->id)
                    <!-- 自分が投稿したものであるとき編集と削除を出すように分岐させる -->
                    <div class="post-edit"><a class="text-primary font-weight-bold" href="{{ url('post_edit/'.$post->id) }}">編集</a></div>
                    <div class="post-delete ml-4 text-danger font-weight-bold"><a class="text-danger" href="{{ url('post_delete/'.$post->id) }}">削除</a></div>
                    @endif
                </div>

            </div>
            @endforeach

        </div>
    </div>
</div>
@endsection