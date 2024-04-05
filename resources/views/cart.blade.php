<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      購入画面
    </h2>
  </x-slot>

  <div class="show-container">
    <div class="wrapper">
      <form method="post" action="{{ route('purchase', ['id' => $product->id]) }}" enctype="multipart/form-data">
        @csrf
        <div>
          <img src="{{ asset('storage/image/' . $product->img_path) }}" class="purchase-img">
        </div>

        <div class="purchase-name">
          {{ $product->id }}. {{ $product->product_name }} (￥{{ $product->price }})
        </div>

        <div class="purchase">
          @if ($product->stock > 0)
          <input type="number" name="quantity" min="1">
          <button class="purchase-btn" type="submit">購入する</button>
          <!-- <button class="purchase-btn" type="submit" data-product-id="{{ $product->id }}">購入へ</button> -->
          @else
          <p>※在庫がありません</p>
          @endif
        </div>
      </form>
    </div>
  </div>

  <div class="back-page">
    <button class="link-btn" onclick="location.href='{{ route('index') }}'">戻る</button>
  </div>
</x-app-layout>