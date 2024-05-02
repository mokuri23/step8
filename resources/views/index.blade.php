<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      <a href="{{ route('index') }}">商品一覧画面</a>
    </h2>
  </x-slot>

  <div class="container">
    <form action="{{ route('search') }}" method="GET" enctype="multipart/form-data" id="search" class="search-form">
      @csrf
      <div class="box">
        <label class="label">メーカー選択</label>
        <select name="company" class="select-box">
          <option value="">All categories</option>
          @foreach($companies as $company)
          <option value="{{ $company->id }}">{{ $company->company_name }}</option>
          @endforeach
        </select>

        <label class="keyword-label">キーワード</label>
        <input type="text" class="keyword-box" name="keyword" id="keyword" placeholder="Type to Search">
      </div>

      <!-- 価格フォーム -->
      <div class="box">
        <label class="label">価格</label>
        <input type="text" class="min_price" name="min_price" placeholder="下限価格"> 円〜
        <input type="text" class="max_price" name="max_price" placeholder="上限価格"> 円
        <!-- 在庫フォーム -->
        <label class="label">在庫数</label>
        <input type="text" class="min_stock" name="min_stock" placeholder="下限在庫数"> 個〜
        <input type="text" class="max_stock" name="max_stock" placeholder="上限在庫数"> 個

        <!-- 検索ボタン -->
        <button class="search-button" type="submit" id="search-button" data-url="{{ route('search') }}">検索</button>
      </div>
    </form>
  </div>
  <!-- 新規登録ボタン -->
  <div class="container" id="message-box">
    <button onclick="location.href='./create'" class="btn new-create-btn">新規登録</button>
    @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
    @endif
  </div>




  <!-- 商品一覧 -->
  <div class="table-container" id="table">
    <table class="table tablesorter">
      <thead>
        <tr>
          <th scope="col" class="table-header">商品ID</th>
          <th scope="col" class="table-header">商品画像</th>
          <th scope="col" class="table-header">商品名</th>
          <th scope="col" class="table-header">価格</th>
          <th scope="col" class="table-header">在庫数</th>
          <th scope="col" class="table-header">コメント</th>
          <th scope="col" class="table-header">メーカー名</th>
          <th scope="col" class="table-header"></th>
          <th scope="col" class="table-header"></th>
        </tr>
      </thead>

      <tbody>
        @foreach($products as $product)
        <tr class="table-form" data-id="{{ $product->id }}">
          <td class="table-data">{{ $product->id }}</td>
          <td class="table-data">
            <img width="50px" src="{{ asset('storage/image/' . $product->img_path) }}" />
          </td>
          <td class="table-data">{{ $product->product_name }}</td>
          <td class="table-data">￥{{ $product->price }}</td>
          <td class="table-data">{{ $product->stock }}</td>
          <td class="table-data">{{ $product->comment }}</td>
          <td class="table-data">{{ $product->company_name }}</td>
          <td class="table-data">
            <a href="{{ route('show', ['id' => $product->id]) }}" class="btn blue-btn">詳細</a>
            <form class="del-form" method="post" action="{{ route('delete',['id' => $product->id]) }}">
              @csrf
              @method('DELETE')
              <button data-id="{{ $product->id }}" type="submit" class="link-btn del-btn">削除</button>
            </form>
          </td>
          <td>
            <a href="{{ route('cart', ['id' => $product->id]) }}" class="btn">購入</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $products->appends(request()->query())->links() }}
  </div>
</x-app-layout>