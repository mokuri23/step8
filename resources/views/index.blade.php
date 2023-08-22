<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      商品一覧画面
    </h2>
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
    <button onclick="location.href='./create'" class="btn">新規登録</button>

    <div class="alert">
      @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
      @endif
    </div>
  </div>

  <!-- 商品一覧 -->
  <div class="table-container">
    <table class="table">
      <thead>
        <tr>
          <th>商品ID</th>
          <th>商品画像</th>
          <th>商品名</th>
          <th>価格</th>
          <th>在庫数</th>
          <th>コメント</th>
          <th>メーカー名</th>
          <th></th>
          <th></th>
        </tr>
      </thead>

      <tbody>
        @foreach($products as $product)
        <tr>
          <td>{{ $product->id }}</td>
          <td>
            @if($product->img_path !=='')
            <img src="{{ asset('storage/' . $product->img_path) }}">
            @else
            <p>no image</p>
            @endif
          </td>
          <td>{{ $product->product_name }}</td>
          <td>{{ $product->price }}</td>
          <td>{{ $product->stock }}</td>
          <td>{{ $product->company_name }}</td>
          <td>
            <button type="button" class="btn btn-primary" onclick="location.href='/product/edit/{{ $product->id }}' ">編集</button>
          </td>
          <td>
            <form method="post" action="{{ route('delete',['id' => $product->id]) }}">
              @csrf
              @method('DELETE')
              <button type="submit" onclick="return confirm('削除しますか？');">削除</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <!-- {{ $products->links() }} -->
  </div>




</x-app-layout>