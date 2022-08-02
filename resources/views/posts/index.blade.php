@extends('layouts.app')

@section('content')

<!-- 投稿一覧表示 -->
<div class="post-table-container container">

    <div class="flash_message_area mb-3">
        <!-- フラッシュメッセージ 登録の場合 -->
        @if (session('flash_register_message'))
        <div class="flash_message bg-success text-center py-3 mb-3">
            <p class="text-white m-0">{{ session('flash_register_message') }}</p>
        </div>
        @endif

        <!-- フラッシュメッセージ 投稿編集の場合 -->
        @if (session('flash_edit_post_message'))
        <div class="flash_message bg-info text-center py-3 mb-3">
            <p class="text-white m-0">{{ session('flash_edit_post_message') }}</p>
        </div>
        @endif

        <!-- フラッシュメッセージ アカウント編集の場合 -->
        @if (session('flash_edit_account_message'))
        <div class="flash_message bg-info text-center py-3 mb-3">
            <p class="text-white m-0">{{ session('flash_edit_account_message') }}</p>
        </div>
        @endif

        <!-- フラッシュメッセージ 削除の場合 -->
        @if (session('flash_delete_message'))
        <div class="flash_message bg-danger text-center py-3 mb-3">
            <p class="text-white m-0">{{ session('flash_delete_message') }}</p>
        </div>
        @endif
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach ($posts as $post)
            <div class="card mb-5">

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
                    @if($post->created_at != $post->updated_at)
                    <div class="post-body">
                        {{ $post->body }} <span>（編集済み）</span>
                    </div>
                    @else
                    <div class="post-body">
                        {{ $post->body }}
                    </div>
                    @endif

                    <!-- ifで画像があるときとない時で分岐させる -->
                    @if(!empty($post->image))
                    <div class="post-image w-50">
                        <img src="{{ $post->image }}" alt="ユーザーアイコン">
                    </div>
                    @endif
                </div>

                <div class="card-footer d-flex justify-content-end align-items-center p-2">
                    @if($post->user_id === Auth::user()->id)
                    <!-- 自分が投稿したものであるとき編集と削除を出すように分岐させる -->
                    <button class="btn btn-primary"><a href="{{ url('post_edit/'.$post->id) }}">編集</a></button>
                    <button class="btn btn-danger ml-3"><a href="{{ url('post_delete/'.$post->id) }}">削除</a></button>
                    @endif
                </div>

            </div>
            @endforeach

        </div>
    </div>

    <div class="d-flex justify-content-center">{{ $posts->links() }}</div>

</div>
@endsection