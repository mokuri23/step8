<x-app-layout>
  <x-slot name="header">
    <h2>商品一覧</h2>
  </x-slot>

  <div class="container">
    <form action="{{ route('search') }}" method="GET" enctype="multipart/form-data">
      @csrf
      <div class="select">
        <select name="company" id="company" class="select-company" type="button">
          <option value="">All categories</option>
          @foreach($companies as $company)
          <option value="{{ $company->id }}">{{ $company->company_name }}</option>
          @endforeach
        </select>
        <div class="keyword">
          <input type="text" class="keyword-box" name="keyword" id="keyword" placeholder="Type to Search">
          <button type="submit" alt="検索"></button>
        </div>
      </div>
    </form>
  </div>

  <!-- 新規登録ボタン -->
  <div class="container">
    <a href="{{ route('create') }}" class="btn">新規登録</a>
    <div class="alert">
      @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
      @endif
    </div>
  </div>

  <table class="table-container">
    <thead>
      <tr>
        <th>@sortablelink ('id', '商品ID')</th>
        <th>@sortablelink ('img_path', '商品画像')</th>
        <th>@sortablelink ('product_name', '商品名')</th>
        <th>@sortablelink ('price', '価格')</th>
        <th>@sortablelink ('stock', '在庫数')</th>
        <th>@sortablelink ('comment', 'コメント')</th>
        <th>@sortablelink ('company_name', 'メーカー名')</th>
        <th>詳細</th>
        <th>削除</th>
      </tr>
      <tr>
        <td>{{ $product->id }}</td>
        <td>
          @if($product->img_path !=='')
          <img src="{{ asset('storage/'.$product->img_path) }}">
          @else
          <p>no image</p>
          @endif
        </td>
        <td>{{ $product-> }}</td>
        <td>{{ $product-> }}</td>
        <td>{{ $product-> }}</td>
        <td>{{ $product-> }}</td>
        <td>{{ $product-> }}</td>
      </tr>

      <tbody>
        @foreach($products as $product)
      </tbody>
    </thead>
  </table>


</x-app-layout>