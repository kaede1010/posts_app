<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'image'];

    /**
     * 投稿を保持するユーザーの取得
     * 
     * TaskモデルからUserのデータを取得できる（紐付け）
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
}
