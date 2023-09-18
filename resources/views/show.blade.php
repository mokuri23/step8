<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      商品詳細画面
    </h2>
  </x-slot>


  <!-- 詳細ページ -->
  <div class="show-container">
    <div class="wrapper">
      <table class="table">
        <tr>
          <th>商品ID</th>
          <td>No.{{ $product->id }}</td>
        </tr>
        <th>商品画像</th>
        <td>
          <img src="{{ asset('storage/image/' .$product->img_path) }}" class="img">
        </td>
        <tr>
          <th>商品名</th>
          <td>{{ $product->product_name }}</td>
        </tr>
        <tr>
          <th>メーカー</th>
          <td>{{ $product->company_name }}</td>
        </tr>
        <tr>
          <th>価格</th>
          <td>{{ $product->price }}</td>
        </tr>
        <tr>
          <th>在庫数</th>
          <td>{{ $product->stock }}</td>
        </tr>
        <tr>
          <th>コメント</th>
          <td>{{ $product->comment }}</td>
        </tr>
      </table>

      <div class="show-back-page">
        <form action="{{ route('edit', ['id' => $product->id]) }}" method="get">
          <button type="submit" class="create-btn">編集</button>
        </form>

        <form action="{{ route('index') }}" method="get">
          <button type="submit" class="blue-btn">戻る</button>
        </form>
      </div>
    </div>
  </div>


</x-app-layout>