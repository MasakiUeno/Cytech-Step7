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
        <form>
            <div class="form-group">
                <label class="form-label">
                    商品名<span class="required">*</span>
                </label>
                <input type="text" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label">
                    メーカー名<span class="required">*</span>
                </label>
                <div class="form-input-wrapper">
                    <input type="text" class="form-input" required>
                    <span class="dropdown-icon"></span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">
                    価格<span class="required">*</span>
                </label>
                <input type="number" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label">
                    在庫数<span class="required">*</span>
                </label>
                <input type="number" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label">
                    コメント
                </label>
                <input type="text" class="form-input">
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
                <button type="submit" class="btn-register">新規登録</button>
                <a href="{{ route('index') }}">
                <button type="button" class="btn-back">戻る</button>
                </a>
            </div>
        </form>
    </div>
</body>
</html>
