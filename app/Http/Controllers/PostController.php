<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use App\Models\Post;

class PostController extends Controller
{
    // 投稿一覧画面
    public function index()
    {
        $posts = Post::select('posts.*', 'users.name', 'users.account_name', 'users.image_icon')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->orderBy('created_at', 'desc')
            ->simplePaginate(15);

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    // 投稿作成画面
    public function post_register()
    {
        // 認証済みのユーザーを取得
        $user = auth()->user();

        // post_registerのviewを返す
        return view('posts.post_register', [
            'user' => $user,
        ]);
    }

    // 投稿作成機能
    public function postRegister(Request $request)
    {
        // バリデーション
        $this->validate($request, [
            'body' => 'required | max:140',
            'image' => 'nullable | image',
        ]);
        // hasFileメソッドで$requestの中にファイルが存在しているのか判定
        if ($request->hasFile('image')) {

            // isValidメソッドでファイルが存在しているかに付け加え、問題なくアップロードできたのか確認
            if ($request->file('image')->isValid()) {

                // ファイルそのものはWebサーバーに保存
                $file_name = $request->file('image')->getClientOriginalName();

                // s3にアップロード(/uploadsフォルダ内に)
                $path = Storage::disk('s3')->putFile('/upload', $request->file('image'));

                // アップロード先のURLを取得する
                $file_path = Storage::disk('s3')->url($path);
            }
        } else {
            // ファイルが存在しない場合は，$file_pathにnullを代入する
            $file_path = null;
        }

        $request->user()->posts()->create([
            'body' => $request->body,
            'image' => $request->image = $file_path,
        ]);

        return redirect('/posts')->with('flash_register_message', '投稿が作成されました !');
    }

    // 投稿編集画面
    public function post_edit(Request $request, Post $post)
    {
        // 認証済みのユーザーを取得
        $user = auth()->user();

        // ユーザーIDと投稿のuser_idが違う場合は投稿一覧画面にリダイレクト
        if ($user->id !== $post->user_id) {
            return redirect('/posts');
        }

        return view('posts.post_edit', [
            'user' => $user,
            'post' => $post,
        ]);
    }

    // 投稿編集機能
    public function edit(Request $request)
    {
        // バリデーション
        $this->validate($request, [
            'body' => 'required | max:140',
            'image' => 'nullable | image',
        ]);

        // itemsテーブルから$requestで受け取ったidとitemsテーブルのidが同じデータを1件取得する
        $post = Post::where('id', '=', $request->id)->first();

        // hasFileメソッドで$requestの中にファイルが存在しているのか判定
        if ($request->hasFile('image')) {

            // isValidメソッドでファイルが存在しているかに付け加え、問題なくアップロードできたのか確認
            if ($request->file('image')->isValid()) {

                // ファイルそのものはWebサーバーに保存
                $file_name = $request->file('image')->getClientOriginalName();

                // s3にアップロード(/uploadsフォルダ内に)
                $path = Storage::disk('s3')->putFile('/upload', $request->file('image'));

                // アップロード先のURLを取得する
                $file_path = Storage::disk('s3')->url($path);
            }
        } else {
            // ファイルが存在しない場合は，$file_path1にnullを代入する
            $file_path = $post->image;
        }

        // データを置き換える
        $post->body = $request->body;
        $post->image = $file_path;

        // データを保存する
        $post->save();

        return redirect('/posts')->with('flash_edit_post_message', '投稿が編集されました !');
    }

    // 投稿削除機能
    public function destroy(Request $request, Post $post)
    {
        // 認証済みのユーザーを取得
        $user = auth()->user();

        // ユーザーIDと$postのuser_idが同じ場合，投稿を削除
        if ($user->id === $post->user_id) {
            // ユーザー自身の投稿しか削除できない
            $this->authorize('destroy', $post);

            $post->delete();

            return redirect('/posts')->with('flash_delete_message', '投稿が削除されました !');
        } else {
            // 違う場合は投稿一覧画面にリダイレクトする
            return redirect('/posts');
        }
    }
}
