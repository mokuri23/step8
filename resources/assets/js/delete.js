document.addEventListener('DOMContentLoaded', function() {
  let deleteButtons = document.querySelectorAll('.delete-button');

  deleteButtons.forEach(button => {
    button.addEventListener('click', function () {
      if(loadConfigFromFile("削除しますか？")) {
        // 削除処理実行
        let from = button.closest('form');
        form.submit();
      }
    });
  });
});