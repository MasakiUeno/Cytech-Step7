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
    <form method="GET" action="{{ route('index') }}">
        <div class="search-bar input">
            <input type="text" name="keyword" placeholder="検索キーワード" value="{{ $keyword ?? '' }}">
            <select name="maker" class="search-bar select">
                <option value="">メーカー名</option>

                @foreach ($companies as $company)
                <option value="{{ $company->id }}"
                {{ ($maker == $company->id) ? 'selected' : '' }}>
                {{ $company->name }}
                </option>
                @endforeach

                @if ($products->count() === 0)
                <p>該当する商品がありません</p>
                @endif

            </select>
            <button type="submit" class="search-bar button">検索</button>
        </div>
    </form>

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
                @foreach ($products as $index => $product)
                    <tr style="background-color: {{ $index % 2 == 0 ? '#ccc' : '#fff' }};">
                        <td>{{ $product->id }}</td>
                        <td>商品画像</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->company->maker }}</td>
                        <td>
                        <a href="{{ route('show',$product->id) }}">
                            <button class="button-detail">詳細</button>
                        </a>
                        <form action="{{ route('destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="button-delete"onclick="return confirm('本当に削除しますか？')">削除</button>
                        </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-top: 20px;">
    {{ $products->appends(request()->query())->links() }}
    </div>
</body>