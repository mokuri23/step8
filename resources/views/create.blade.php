<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      新規登録画面
    </h2>
  </x-slot>

  <!-- 新規作成フォーム -->
  <div class="create-container">
    <div class="wrapper">
      <form action="{{ route('store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form">
          <label>商品名</label>
          <input type="text" class="input" id="name" name="product_name" value="{{ old('product_name') }}">
        </div>

        <div class="form">
          <label>価格</label>
          <input type="number" class="input" id="price" name="price" value="{{ old('price') }}">
        </div>

        <div class="form">
          <label>在庫数</label>
          <input type="number" class="input" id="stock" name="stock" value="{{ old('stock') }}">
        </div>

        <div class="form">
          <label>メーカー</label>
          <select name="company_id" id="company">
            <option value="">選択してください</option>
            <option value="コカコーラ">コカコーラ</option>
            <option value="キリン">キリン</option>
            @foreach($companies as $company)
            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
            @endforeach
          </select>
        </div>

        <div class="form">
          <label>コメント</label>
          <textarea name="comment" cols="20" rows="5" value="{{ old('comment') }}"></textarea>
        </div>

        <div class="form">
          <label>商品画像</label>
          <input type="file" name="img_path" id="img_path">
        </div>
        <div>
          <button type="submit" class="btn">新規登録</button>
        </div>

        <div>
          @if($errors->any())
          <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
          @endif
        </div>
      </form>
    </div>
  </div>

  <div class="back-page">
    <!-- <button class="back-btn" onclick="location.href='{{ route('index') }}'">戻る</button> -->
    <a href="{{ route('index') }}" class="btn btn-secondary">戻る</a>
  </div>

</x-app-layout>