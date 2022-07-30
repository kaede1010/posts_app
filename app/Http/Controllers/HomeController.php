<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Models\Post;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // 認証済みのユーザーを取得
        $user = auth()->user();

        // tasksテーブルからログインしているユーザーのIDと紐づくデータを取ってくる
        $posts = Post::where('user_id', '=', $user->id)->orderBy('created_at', 'desc')->get();

        return view('home')->with([
            'posts' => $posts,
            'user' => $user,
        ]);
    }
}
