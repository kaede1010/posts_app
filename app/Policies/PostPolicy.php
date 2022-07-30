<?php

namespace App\Policies;

use App\Models\User;

use App\Models\Post;

use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 指定されたユーザーの投稿のとき削除可能
     *
     * @param User $user
     * @param Post $post
     * @return bool     
     */
    public function destroy(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }
}
