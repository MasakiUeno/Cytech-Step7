<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/step7index.css') }}">
    <script src="https://code.jquery.com/jquery-4.0.0.min.js"></script>
    <title>商品一覧画面</title>
</head>

<body>
    <h1>商品一覧画面</h1>

    <div>
    <form method="GET" action="{{ route('index') }}" id="search-form">
        <div class="search-bar input">
            <input type="text" name="keyword" placeholder="検索キーワード" value="{{ $keyword ?? '' }}">
            <select name="maker" class="search-bar select">
                <option value="">メーカー名</option>

                @foreach ($companies as $company)
                <option value="{{ $company->id }}"
                {{ ($maker == $company->id) ? 'selected' : '' }}>
                {{ $company->company_name }}
                </option>
                @endforeach

                @if ($products->count() === 0)
                <p>該当する商品がありません</p>
                @endif

            </select>

            <div class="range-search">
                <input type="number" name="min_price" placeholder="価格下限" value="{{ $min_price ?? '' }}">
                〜
                <input type="number" name="max_price" placeholder="価格上限" value="{{ $max_price ?? '' }}">
            </div>
            
            <div class="range-search">
                <input type="number" name="min_stock" placeholder="在庫下限" value="{{ $min_stock ?? '' }}">
                〜
                <input type="number" name="max_stock" placeholder="在庫上限" value="{{ $max_stock ?? '' }}">
            </div>
            <button type="submit" id="search-button" class="search-bar button">検索</button>
        </div>
    </form>

        <div class="form-container">
            <table>
                <thead>
                    <tr>
                        <th class="sort" data-sort="id">ID <span>▲▼</span></th>
                        <th>商品画像</th>
                        <th class="sort" data-sort="product_name">商品名 <span>▲▼</span></th>
                        <th class="sort" data-sort="price">価格 <span>▲▼</span></th>
                        <th class="sort" data-sort="stock">在庫数 <span>▲▼</span></th>
                        <th class="sort" data-sort="company_id">メーカー名 <span>▲▼</span></th>
                        <th>
                        <a href="{{ route('creat') }}">
                            <button type="button" class="button-new">新規登録</button>
                        </a>
                        </th>
                    </tr>
                </thead>
                <tbody id="product-table">
                @foreach ($products as $index => $product)
                    <tr style="background-color: {{ $index % 2 == 0 ? '#ccc' : '#fff' }};">
                        <td>{{ $product->id }}</td>
                        <td><img src="{{ asset('storage/' . $product->img_path) }}" class="product-image"></td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->company->company_name }}</td>
                        <td>
                        <a href="{{ route('show',$product->id) }}">
                            <button class="button-detail">詳細</button>
                        </a>
                        <form action="{{ route('destroy', $product->id) }}" method="POST" enctype="multipart/form-data" novalidate>
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

    <script>
        $(function() {

            let currentSort = 'id';
            let currentDirection = 'desc';
            
            function fetchProducts(){
                
                let params = {
                    'keyword': $('input[name="keyword"]').val(),
                    'maker': $('select[name="maker"]').val(),
                    'min_price': $('input[name="min_price"]').val(),
                    'max_price': $('input[name="max_price"]').val(),
                    'min_stock': $('input[name="min_stock"]').val(),
                    'max_stock': $('input[name="max_stock"]').val(),
                    'sort': currentSort,
                    'direction': currentDirection
                };

                $.ajax({
                    url: "{{ route('index') }}",
                    type: 'GET',
                    data: params,
                    dataType: 'json',
                })
                .done(function(data) {
                    $('#product-table').empty();
                    $.each(data.products, function(index, product) {
                        let imageSrc = product.img_path ? '/storage/' + product.img_path : '';
                        let rowColor = (index % 2 == 0) ? '#ccc' : '#fff';
                        let html = `
                        <tr style="background-color: ${rowColor};">
                        <td>${product.id}</td>
                        <td>
                        ${imageSrc ? `<img src="${imageSrc}" class="product-image" style="width: 50px;">` : '画像なし'}
                        </td>
                        <td>${product.product_name}</td>
                        <td>${product.price}</td>
                        <td>${product.stock}</td>
                        <td>${product.company.company_name}</td>
                        <td>
                        <a href="/product/show/${product.id}"><button class="button-detail">詳細</button></a>
                        <form action="/product/${product.id}" method="POST" style="display:inline;">
                        <button type="submit" class="button-delete">削除</button>
                        </form>
                        </td>
                        </tr>
                        `;
                        $('#product-table').append(html);
                    });
                })
                .fail(function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        $.each(errors, function(key, value) {
                            errorMessage += value[0] + '\n';
                        });
                        alert(errorMessage);
                    }else{
                        alert('検索に失敗しました');
                    }
                });
            };

            $('.sort').on('click', function() {
                let sort = $(this).data('sort');
                if (currentSort === sort) {
                    currentDirection = (currentDirection === 'asc') ? 'desc' : 'asc';
                }else{
                    currentSort = sort;
                    currentDirection = 'asc';
                }
                fetchProducts();
            });

            $('#search-button').on('click', function(e) {
                e.preventDefault();
                fetchProducts();
            });

            $(document).on('click', '.button-delete', function(e) {
                e.preventDefault();

                if (!confirm('本当に削除しますか？')) {
                    return false;
                }

                let deleteButton = $(this);
                let form = deleteButton.closest('form');
                let deleteUrl = form.attr('action');//"/product/destroy/" + productId;

                $.ajax({
                    url: deleteUrl,
                    type: 'POST',
                    data: {
                        '_method': 'DELETE',
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    },
                })
                .done(function(data) {
                    deleteButton.closest('tr').fadeOut(600, function() {
                        $(this).remove();
                    });
                    alert('削除しました');
                })
                .fail(function() {
                    alert('削除に失敗しました');
                });
            });
        });
    </script>
</body>