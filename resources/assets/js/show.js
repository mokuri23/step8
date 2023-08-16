document.addEventListener('DOMContentLoaded', function() {
  // 詳細ボタンがクリックされた時の処理
  document.querySelectorAll('.detail-button').forEach(function (button) {
    button.addEventListener('click', function () {
      var productId = this.getAttribute('data-product-id');
      // 詳細ページへのリンク
      window.location.href = '/product/detail/' + productId;
    });
  });
});