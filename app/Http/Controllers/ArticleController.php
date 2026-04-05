<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;

class ArticleController extends Controller
{
    public function index(Request $request) 
    {
        $keyword = $request->keyword;
        $maker = $request->maker;

        $query = Product::query();

        if(!empty($keyword)){
            $query->where('product_name','like','%'.$keyword.'%');
        }

        if(!empty($maker)){
            $query->where('company_id',$maker);
        }

        $products = $query->paginate(5);

        $companies = Company::all();

        return view('step7index',compact('products','keyword','maker','companies'));
    }
    //商品一覧画面

    public function creat() 
    {
        $companies = Company::all();
        return view('step7creat', compact('companies'));
    }
    //商品新規登録画面

    public function show($id) 
    {
        $product = Product::find($id);
        $companies = Company::all();

        return view('step7show',compact('product','companies'));
    }
    //商品情報詳細画面

    public function edit($id)
    {
        $product = Product::find($id);
        $companies = Company::all();

        return view('step7edit',compact('product','companies'));
    }
    //商品情報編集画面

    public function update(Request $request,$id)
    {

        $product = Product::find($id);

        $product->product_name = $request->product_name;
        $product->company_id = $request->company_id;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->comment = $request->comment;
        
        $product->save();
        return redirect()->route('show',$id);
    }
    //editの内容を更新する処理

    public function store(Request $request)
    {
        $product = new product();

        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->company_id = $request->company_id;
        $product->comment = $request->comment;
    
        $product->save();

        return redirect()->route('index')->with('success', '登録しました');
    }
    //新規登録更新

    public function destroy($id)
    {
        $product = Product::find($id);

        if ($product) 
        {
            $product->delete();
        }
        return redirect()->route('index')->with('success', '削除しました');
    }
    //一覧から削除する処理

}
