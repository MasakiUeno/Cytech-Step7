<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/step7show.css') }}">
    <title>商品情報詳細画面</title>
</head>

<body>
    <h1>商品情報詳細画面</h1>
    
    <div class="form-container">
        <form>
            <div class="form-group">
                <label class="form-label">
                    ID
                </label>
                <input type="text" class="form-input" value="{{ $product->id }}" readonly>
            </div>

            <div class="form-group image-preview-group">
                <label class="form-label">
                    商品画像
                </label>
                <div class="image-preview">
                <img src="{{ asset('storage/'.$product->image) }}" class="product-image">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">
                    商品名
                </label>
                <input type="text" class="form-input" value="{{ $product->product_name }}" readonly>
            </div>

            <div class="form-group">
                <label class="form-label">
                    メーカー名
                </label>
                <div class="form-input-wrapper">
                    <select class="form-input" disabled>
                        @foreach($companies as $company)
                        <option value="{{ $company->id }}"
                        {{ $product->company_id == $company->id ? 'selected' : '' }}>
                        {{ $company->company_name }}
                        </option>
                        @endforeach
                    </select>
                    <span class="dropdown-icon"></span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">
                    価格
                </label>
                <input type="text" class="form-input" value="￥{{ $product->price }}" readonly>
            </div>

            <div class="form-group">
                <label class="form-label">
                    在庫数
                </label>
                <input type="number" class="form-input" value="{{ $product->stock }}" readonly>
            </div>

            <div class="form-group">
                <label class="form-label">
                    コメント
                </label>
                <input type="text" class="form-input" value="{{ $product->comment }}"readonly>
            </div>

            <div class="button-group">
            <a href="{{ route('edit',$product->id) }}">
                <button type="button" class="btn-register">編集</button>
            </a>
                <a href="{{ route('index') }}">
                <button type="button" class="btn-back">戻る</button>
                </a>
            </div>
        </form>
    </div>
</body>
</html>
