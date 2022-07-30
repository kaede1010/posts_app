@extends('layouts.app')

@section('content')
<div class="post-table-container container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach ($all_users as $user)
            <div class="user-profile card mb-4 ">
                <div class="card-header p-0">
                    <div class="user-info card-body d-flex align-items-center">
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
            </div>
            @endforeach
        </div>
    </div>
    <div class="d-flex justify-content-center">
        {{ $all_users->links() }}
    </div>
</div>
@endsection