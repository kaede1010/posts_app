@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('ユーザーの履歴') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="mb-2">---- 投稿情報 ----</div>

                    <dl class="list-unstyled">
                        @if($posts->isEmpty())
                        <p class="font-weight-bold text-center">現在投稿はありません</p>
                        @endif

                        @foreach($posts as $post)

                        @if($post->created_at != $post->updated_at )
                        <dt>{{ $post->updated_at->format('Y年m月d日') }}</dt>
                        <dd class="mb-4">投稿が編集されました！</dd>
                        @else
                        <dt>{{ $post->created_at->format('Y年m月d日') }}</dt>
                        <dd class="mb-4">投稿が作成されました！</dd>
                        @endif

                        @endforeach

                        <div class="mb-2">---- アカウント情報 ----</div>

                        @if($user->created_at != $user->updated_at )
                        <dt>{{ $user->updated_at->format('Y年m月d日') }}</dt>
                        <dd class="mb-4">アカウントが編集されました！</dd>
                        @else
                        <dt>{{ $user->created_at->format('Y年m月d日') }}</dt>
                        <dd>{{ $user->name }}でアカウント登録しました。</dd>
                        @endif

                    </dl>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection