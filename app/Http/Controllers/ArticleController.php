<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index(Request $request) 
    {
        $keyword = $request->keyword;
        $maker = $request->maker;

        $query = Article::query();

        if(!empty($keyword)){
            $query->where('name','like','%'.$keyword.'%');
        }

        if(!empty($maker)){
            $query->where('maker',$maker);
        }

        $articles = $query->paginate(5);

        return view('step7index',compact('articles','keyword','maker'));
    }
    //商品一覧画面

    public function creat() 
    {
        return view('step7creat');
    }
    //商品新規登録画面

    public function show($id) 
    {
        $article = Article::find($id);

        return view('step7show',compact('article'));
    }
    //商品情報詳細画面

    public function edit($id) 
    {
        $article = Article::find($id);

        return view('step7edit',compact('article'));
    }
    //商品情報編集画面

    public function update(Request $request,$id)
    {

        $article = Article::find($id);

        $article->name = $request->name;
        $article->maker = $request->maker;
        $article->price = $request->price;
        $article->stock = $request->stock;
        $article->comment = $request->comment;
        
        $article->save();
        return redirect()->route('show',$id);
    }
    //editの内容を更新する処理

}
