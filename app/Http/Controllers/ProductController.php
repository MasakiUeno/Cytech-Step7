<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use Exception;

class ProductController extends Controller
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
        $request->validate([
            'product_name' => 'required|max:255',
            'company_id'   => 'required|exists:companies,id',
            'price'        => 'required|integer|min:0',
            'stock'        => 'required|integer|min:0',
            'comment'      => 'nullable|max:1000',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ],[
            'product_name.required' => '商品名は必須です',
            'company_id.required'   => 'メーカーを選択してください',
            'price.required'        => '価格は必須です',
            'stock.required'        => '在庫数は必須です',
            'price.integer'         => '価格は数値で入力してください',
            'stock.integer'         => '在庫数は数値で入力してください',
        ]);

        DB::beginTransaction();

        try{
        
            $product = Product::find($id);

            $product->product_name = $request->product_name;
            $product->company_id = $request->company_id;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->comment = $request->comment;

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('images', 'public');
                $product->img_path = $path;
            }
        
            $product->save();
            DB::commit();

            return redirect()->route('show',$id)->with('success', '情報を更新しました');
        }catch (Exception $e){
            DB::rollback();
            return back()->withInput()->with('error', '更新に失敗しました');
        }
    }
    //editの内容を更新する処理

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|max:255',
            'company_id'   => 'required|exists:companies,id',
            'price'        => 'required|integer|min:0',
            'stock'        => 'required|integer|min:0',
            'comment'      => 'nullable|max:1000',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ],[
            'product_name.required' => '商品名は必須です',
            'company_id.required'   => 'メーカーを選択してください',
            'price.required'        => '価格は必須です',
            'stock.required'        => '在庫数は必須です',
            'price.integer'         => '価格は数値で入力してください',
            'stock.integer'         => '在庫数は数値で入力してください',
        ]);

        DB::beginTransaction();

        try{
            $product = new Product();

            $product->product_name = $request->product_name;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->company_id = $request->company_id;
            $product->comment = $request->comment;
        
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('images', 'public');
                $product->img_path = $path;
            }
            
            $product->save();

            DB::commit();
            
            return redirect()->route('index')->with('success', '登録しました');
        }catch (Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', '登録に失敗しました: ' . $e->getMessage());
        }


    }
    //新規登録更新

    public function destroy($id)
    {
        DB::beginTransaction();

        try{
            $product = Product::findOrFail($id);
            $product->delete();

            DB::commit();
            return redirect()->route('index')->with('success', '削除しました');
        }catch (Exception $e){
            DB::rollback();
            return redirect()->route('index')->with('error', '削除に失敗しました');
        }
    }
    //一覧から削除する処理

}
