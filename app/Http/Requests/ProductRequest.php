<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $action = $this->route()->getActionMethod();
        if ($action === 'index') {
            return [
                'min_price' => 'nullable|integer|min:0',
                'max_price' => 'nullable|integer|min:0|gte:min_price',
                'min_stock' => 'nullable|integer|min:0',
                'max_stock' => 'nullable|integer|min:0|gte:min_stock',
            ];
        }

        return [
            'product_name' => 'required|max:255',
            'company_id'   => 'required|exists:companies,id',
            'price'        => 'required|integer|min:0',
            'stock'        => 'required|integer|min:0',
            'comment'      => 'nullable|max:1000',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => '商品名は必須項目です。',
            'product_name.max'      => '商品名を入力してください。',
            'company_id.required'   => 'メーカーを選択してください。',
            'company_id.exists'     => '指定されたメーカーは存在しません。',
            'price.required'        => '価格は必須項目です。',
            'price.integer'         => '価格は数値で入力してください。',
            'price.min'             => '価格は0円以上にしてください。',
            'stock.required'        => '在庫数は必須項目です。',
            'stock.integer'         => '在庫数は数値で入力してください。',
            'stock.min'             => '在庫数は0個以上にしてください。',
            'comment.max'           => 'コメントは1000文字以内で入力してください。',
            'image.image'           => '指定されたファイルが画像ではありません。',
            'image.mimes'           => '画像の形式は jpeg, png, jpg のいずれかにしてください。',
            'image.max'             => '画像サイズは2MB以内にしてください。',
        ];
    }
}
