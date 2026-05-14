<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Http\Requests\ProductRequest;
use Exception;

class ProductController extends Controller
{
    public function index(Request $request) 
    {
        $keyword = $request->keyword;
        $maker = $request->maker;

        $min_price = $request->min_price;
        $max_price = $request->max_price;
        $min_stock = $request->min_stock;
        $max_stock = $request->max_stock;

        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'desc');

        $query = Product::query();

        if(!empty($keyword)){
            $query->where('product_name','like','%'.$keyword.'%');
        }

        if(!empty($maker)){
            $query->where('company_id',$maker);
        }

        if(!empty($min_price)){
            $query->where('price', '>=', $min_price);
        }

        if(!empty($max_price)){
            $query->where('price', '<=', $max_price);
        }

        if(!empty($min_stock)){
            $query->where('stock', '>=', $min_stock);
        }

        if(!empty($max_stock)){
            $query->where('stock', '<=', $max_stock);
        }

        $query->orderBy($sort, $direction);

        if ($request->ajax()) {
            $products = $query->with('company')->get();
            return response()->json([
                'products' => $products
            ]);
        }

        $products = $query->with('company')->paginate(5);

        $companies = Company::all();

        return view('step7index',compact('products','keyword','maker','companies','min_price', 'max_price', 'min_stock', 'max_stock'));
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

    public function update(ProductRequest $request,$id)
    {
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

    public function store(ProductRequest $request)
    {
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

    public function destroy(Request $request,$id)
    {
        DB::beginTransaction();

        try{
            $product = Product::findOrFail($id);
            $product->delete();

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'message' => '商品を削除しました'
                ]);
            }

            return redirect()->route('index')->with('success', '削除しました');
        }catch (Exception $e){
            DB::rollback();

            if ($request->ajax()) {
                return response()->json([
                    'error' => '削除に失敗しました'
                ],500);
            }

            return redirect()->route('index')->with('error', '削除に失敗しました');
        }
    }
    //一覧から削除する処理

}
