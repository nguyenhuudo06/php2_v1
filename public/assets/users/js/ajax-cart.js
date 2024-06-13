$(document).ready(function () {
  $(".add-to-cart").on("click", function (e) {
    e.preventDefault();

    var productId = $(this).data("id");
    var quantity = $(this).data("quantity");
    var url = $(this).data("url");

    $.ajax({
      url: url,
      type: "POST",
      data: { id: productId, quantity: quantity },
      success: function (response) {
        var response = JSON.parse(response);
        if (response.status === "success") {
          // Xử lý khi thành công
          alert("Sản phẩm đã được thêm vào giỏ hàng!");
        } else {
          // Xử lý khi có lỗi
          alert("Đã có lỗi xảy ra. Vui lòng thử lại sau!");
        }
      },
      error: function (xhr, status, error) {
        if (xhr.status == 401) {
          // Nếu mã lỗi là 401 (Unauthorized)
          alert("Bạn cần đăng nhập để thực hiện thao tác này!");
          var jsonResponse = JSON.parse(xhr.responseText);
          // Chuyển hướng đến trang đăng nhập
          window.location.href = jsonResponse.redirect_url;
        } else if (xhr.status == 500) {
          // Nếu mã lỗi là 500 (Internal Server Error)
          alert("Đã có lỗi xảy ra trên máy chủ. Vui lòng thử lại sau!");
        } else {
          // Xử lý lỗi khác
          console.log("Error:", error);
        }
      },
    });
  });
});
