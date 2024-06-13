<div class="container-fluid py-5 mt-5">
    <div class="container py-5">
        <?php if (isset($_SESSION['user_id'])) { ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Products</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['all'] as $item) { ?>
                            <tr>
                                <th scope="row">
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo _WEB_ROOT_ .  $item['img'] ?>" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="">
                                    </div>
                                </th>
                                <td>
                                    <p class="mb-0 mt-4"><?php echo $item['name'] ?></p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4"><?php echo $item['price'] ?></p>
                                </td>
                                <td>
                                    <div class="input-group quantity mt-4" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm text-center border-0" value="<?php echo $item['quantity'] ?>">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4"><?php echo number_format($item['quantity'] * $item['price'], 2) ?></p>
                                </td>
                                <td>
                                    <a href="<?php echo (_WEB_ROOT_ . '/homecarts/delete?user_id=' . $_SESSION['user_id'] . '&product_id=' . $item['product_id']) ?>" class="btn btn-md rounded-circle bg-light border mt-4 delete-product-btn">
                                        <i class="fa fa-times text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    <h5 class="mt-4">Total: <?php echo number_format($data['total'], 2) ?></h5>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="<?php echo _WEB_ROOT_ . '/homecarts/checkout' ?>" class="btn btn-success btn-lg mt-4">Checkout</a>
                </div>
            </div>
        <?php } else { ?>
            <div class="d-flex justify-content-center align-items-center" style="height: 50vh;">
                <h2>Please <a href="<?php echo _WEB_ROOT_ . '/auth/login' ?>">login</a> to view your cart.</h2>
            </div>
        <?php } ?>
    </div>
</div>
