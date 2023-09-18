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
    <button onclick="location.href='./create'" class="btn create-btn">登録</button>

    <div class="alert">
      @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
      @endif
    </div>
  </div>

  <!-- 商品一覧 -->
  <div class="table index-table">
    <table class="table-container">
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
        <tr class="table-form">
          <td class="table-data">{{ $product->id }}</td>
          <td class="table-data">
            <img width="50px" src="{{ asset('storage/image/' . $product->img_path) }}" />
          </td>
          <td class="table-data">{{ $product->product_name }}</td>
          <td class="table-data">￥{{ $product->price }}</td>
          <td class="table-data">{{ $product->stock }}</td>
          <td class="table-data">{{ $product->comment }}</td>
          <td class="table-data">{{ $product->company_name }}</td>
          <td>
            <a href="{{ route('show', ['id' => $product->id]) }}" class="btn blue-btn">詳細</a>
            <!-- <button type="button" class="blue-btn" onclick="location.href='{{ route('show', ['id' => $product->id]) }}'">詳細</button> -->
          </td>
          <td>
            <form method="post" action="{{ route('delete',['id' => $product->id]) }}">
              @csrf
              @method('DELETE')
              <a href="{{ route('delete',['id' => $product->id]) }}" class="delete-btn" onclick="return confirm('削除しますか？');">削除</a>
              <!-- <button type="submit" class="delete-btn" onclick="return confirm('削除しますか？');">削除</button> -->
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $products->links() }}
  </div>




</x-app-layout>