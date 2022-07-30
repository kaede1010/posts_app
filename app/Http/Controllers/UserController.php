<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Hash;

use Illuminate\Validation\Rule;

use App\Models\User;

use App\Models\Post;

class UserController extends Controller
{
    // アカウント編集画面
    public function user_edit(Request $request)
    {
        // $request->user()で認証済みのユーザーを取得
        $user = auth()->user();

        return view('users.user_edit', [
            'user' => $user,
        ]);
    }

    // アカウント編集機能
    public function userEdit(Request $request)
    {
        // 認証済みのユーザーを取得
        $user = auth()->user();

        // バリデーション
        $this->validate($request, [
            'account_name' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'name' => ['required', 'string', 'max:50'],
            'image_icon' => ['nullable', 'image'],
            'self-introduction' => ['nullable', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        // hasFileメソッドで$requestの中にファイルが存在しているのか判定
        if ($request->hasFile('image_icon')) {

            // isValidメソッドでファイルが存在しているかに付け加え、問題なくアップロードできたのか確認
            if ($request->file('image_icon')->isValid()) {

                // ファイルそのものはWebサーバーに保存
                $file_name = $request->file('image_icon')->getClientOriginalName();

                // s3にアップロード(/uploadsフォルダ内に)
                $path = Storage::disk('s3')->putFile('/upload', $request->file('image_icon'));

                // アップロード先のURLを取得する
                $file_path = Storage::disk('s3')->url($path);
            }
        } else {
            // ファイルが存在しない場合は，$file_path1にnullを代入する
            $file_path = $user->image_icon;
        }

        // データを置き換える
        $user->account_name = $request->account_name;

        $user->name = $request->name;

        $user->image_icon = $file_path;

        $user->self_introduction = $request->self_introduction;

        $user->email = $request->email;

        if (isset($request->password)) {
            $user->password = Hash::make($request->password);
        }

        // データを保存する
        $user->save();

        return redirect('/posts')->with('flash_edit_account_message', 'アカウントが編集されました !');
    }

    // ユーザーの詳細画面
    public function user_detail(Request $request)
    {
        $user = User::where('id', '=', $request->id)->first();

        $posts = Post::select('posts.*', 'users.name', 'users.account_name', 'users.image_icon')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->where('posts.user_id', '=', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('users.user_detail', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }

    // ユーザー一覧画面
    public function user_table()
    {
        $user = auth()->user();

        $all_users = User::where('id', '<>', $user->id)->simplePaginate(5);
        return view('users.user_table', [
            'all_users' => $all_users,
        ]);
    }
}
