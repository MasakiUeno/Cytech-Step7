<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/step7edit.css') }}">
    <title>商品情報編集画面</title>
</head>

<body>
    <h1>商品情報編集画面</h1>
    
    <div class="form-container">
        <form action="{{ route('update',$article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="form-group">
                <label class="form-label">
                    ID.<span class="required">*</span>
                </label>
                <input type="text" class="form-input" value="{{ $article->id }}" readonly>
            </div>

            <div class="form-group">
                <label class="form-label">
                    商品名<span class="required">*</span>
                </label>
                <input type="text" class="form-input" name="maker" value="{{ $article->maker }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">
                    メーカー名<span class="required">*</span>
                </label>
                <div class="form-input-wrapper">
                <input type="text" class="form-input" name="maker" value="{{ $article->maker }}" required>
                    <span class="dropdown-icon"></span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">
                    価格<span class="required">*</span>
                </label>
                <input type="number" class="form-input" name="price" value="{{ $article->price }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">
                    在庫数<span class="required">*</span>
                </label>
                <input type="number" class="form-input" name="stock" value="{{ $article->stock }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">
                    コメント
                </label>
                <input type="text" class="form-input" name="comment" value="{{ $article->comment }}">
            </div>

            <div class="form-group">
                <label class="form-label">
                    商品画像
                </label>
                <div class="form-input-wrapper">
                    <input type="file" id="fileInput" name="Image" accept="image/*">
                    <label for="fileInput" class="file-select-button">ファイルを選択</label>
                </div>
            </div>

            <div class="button-group">
                <button type="submit" class="btn-register">更新</button>
                <a href="{{ route('show',$article->id) }}">
                <button type="button" class="btn-back">戻る</button>
                </a>
            </div>
        </form>
    </div>
</body>
</html>
