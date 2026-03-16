<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/step7index.css') }}">
    <title>商品一覧画面</title>
</head>

<body>
    <h1>商品一覧画面</h1>

    <div>
        <div class="search-bar input">
            <input type="text" placeholder="検索キーワード">
            <select class="search-bar select">
                <option value="">メーカー名</option>
                <option value="コカ・コーラ">コカ・コーラ</option>
                <option value="サントリー">サントリー</option>
                <option value="キリン">キリン</option>
            </select>
            <button type="submit" class="search-bar button">検索</button>
        </div>

        <div class="form-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>商品画像</th>
                        <th>商品名</th>
                        <th>価格</th>
                        <th>在庫数</th>
                        <th>メーカー名</th>
                        <th>
                        <a href="{{ route('creat') }}">
                            <button type="button" class="button-new">新規登録</button>
                        </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($articles as $article)
                    <tr style="background-color: #ccc;">
                        <td>{{ $article->id }}</td>
                        <td>商品画像</td>
                        <td>{{ $article->name }}</td>
                        <td>{{ $article->price }}</td>
                        <td>{{ $article->stock }}</td>
                        <td>{{ $article->maker }}</td>
                        <td>
                        <a href="{{ route('show',$article->id) }}">
                            <button class="button-detail">詳細</button>
                        </a>
                            <button class="button-delete">削除</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div style="display: flex; justify-content: center; margin-top: 20px;">
        <a href="#" style="padding: 5px 10px; border: 1px solid #ccc; text-decoration: none; color: black;">&lt;</a>
        <a href="#" style="padding: 5px 10px; border: 1px solid #ccc; text-decoration: none; color: black;">1</a>
        <a href="#" style="padding: 5px 10px; border: 1px solid #ccc; text-decoration: none; color: black;">2</a>
        <a href="#" style="padding: 5px 10px; border: 1px solid #ccc; text-decoration: none; color: black;">&gt;</a>
    </div>
</body>