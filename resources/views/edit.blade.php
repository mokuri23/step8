<x-app-layout>

  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品編集画面</h2>
  </x-slot>

  <!-- 編集フォーム -->
  <div class="create-container">
    <div class="wrapper">
      <form action="{{ route('update', ['id' => $product->id ]) }}" enctype="multipart/form-data">
        @csrf
        <div class="form">
          <div>ID : {{ $product->id }}</div>
        </div>
        <div class="form">
          <label>商品名</label>
          <input type="text" name="product" id="product" value="{{ $product->product_name }}" class="input">
        </div>

        <div class="form">
          <label>メーカー</label>
          <select name="company_id" id="company">
            <option value="">選択してください</option>
            @foreach($companies as $company)
            <option value="{{ $company->id }}" {{ $company->id == $product->company_id ? 'selected' : '' }}>
              {{ $company->company_name }}
            </option>
            @endforeach
          </select>
        </div>

        <div class="form">
          <label>価格</label>
          <input type="number" name="price" id="price" value="{{ $product->price }}" class="input">
        </div>

        <div class="form">
          <label>在庫数</label>
          <input type="number" name="stock" id="stock" value="{{ $product->stock }}" class="input">
        </div>


        <div class="form">
          <label>コメント</label>
          <textarea name="comment" cols="20" rows="5">{{ $product->comment }}</textarea>
        </div>

        <div class="form">
          <input type="file" name="img_path" id="img_path">
        </div>

        <div class="form">
          <label>商品画像</label>
          <img src="{{ asset('storage/image' .$product->img_path) }}" class="img">
        </div>

        <div>
          <button type="submit" class="btn">更新</button>
        </div>

        <div>
          @if ($errors->any())
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
          @endif
        </div>
      </form>
    </div>
  </div>

  <div class="back-page">
    <form action="{{ route('index') }}" method="get">
      <button type="submit" class="back-btn">戻る</button>
    </form>
  </div>

</x-app-layout>