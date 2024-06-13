$(document).ready(function () {
  // Thumbnail
  $("#image").on("change", function (event) {
    var reader = new FileReader();
    reader.onload = function () {
      var output = $("#thumbnail");
      output.attr("src", reader.result);
      output.css("display", "block");
    };
    reader.readAsDataURL(event.target.files[0]);
  });

  // Ajax delete
  $(".delete-btn").on("click", function (e) {
    e.preventDefault();
    const productId = $(this).data("id");
    const productUrl = $(this).data("url");
    const row = $(this).closest('tr');

    if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này không?")) {
      $.ajax({
        url: productUrl,
        type: "POST",
        data: { id: productId },
        success: function (response) {
          console.log(response)
          const data = JSON.parse(response);
          if (data.status == "success") {
            row.remove();
            alert("Sản phẩm đã được xóa thành công.");
          } else {
            alert(`Xóa sản phẩm không thành công. ${data['message']}`);
          }
        },
        error: function (xhr, status, error) {
          console.error("Error:", error);
        },
      });
    }
  });
});
