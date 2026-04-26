<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/step7creat.css') }}">
    <title>商品新規登録画面</title>
</head>

<body>
    <h1>商品新規登録画面</h1>
    
    <div class="form-container">
        <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
            <div class="form-group">
                <label class="form-label">
                    商品名<span class="required">*</span>
                </label>
                <input type="text" name="product_name" class="form-input" required>
                @error('product_name')
                <div style="color:red">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    メーカー名<span class="required">*</span>
                </label>
                <select name="company_id" class="form-input" required>
                @foreach ($companies as $company)
                <option value="{{ $company->id }}">
                {{ $company->company_name }}
                </option>
                @endforeach
                </select>
                @error('company_id')
                <div style="color:red">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    価格<span class="required">*</span>
                </label>
                <input type="number" name="price" class="form-input" required>
                @error('price')
                <div style="color:red">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    在庫数<span class="required">*</span>
                </label>
                <input type="number" name="stock" class="form-input" required>
                @error('stock')
                <div style="color:red">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    コメント
                </label>
                <input type="text" name="comment" class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">
                    商品画像
                </label>
                <div class="form-input-wrapper">
                    <input type="file" id="fileInput" name="image" accept="image/*">
                    <label for="fileInput" class="file-select-button">ファイルを選択</label>
                </div>
            </div>

            <div class="button-group">
                <button type="submit" class="btn-register">新規登録</button>
                <a href="{{ route('index') }}">
                <button type="button" class="btn-back">戻る</button>
                </a>
            </div>
        </form>
    </div>
</body>
</html>
