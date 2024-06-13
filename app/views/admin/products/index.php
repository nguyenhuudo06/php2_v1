<div class="content-wrapper mt-2">

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <th>Id</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Special</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php foreach ($all as $dataItem) { ?>
                                    <tr>
                                        <td><?php echo ($dataItem['id']) ?></td>
                                        <td>
                                            <img style="width: 80px; height: 80px; object-fit: cover; display: block;" src="<?php echo (_WEB_ROOT_ . $dataItem['img']) ?>" alt="">
                                        </td>
                                        <td><?php echo ($dataItem['name']) ?></td>
                                        <td><?php echo ($dataItem['price']) ?></td>
                                        <td><?php echo ($dataItem['quantity']) ?></td>
                                        <td><?php echo ($dataItem['description']) ?></td>
                                        <td><?php echo ($dataItem['category_name']) ?></td>
                                        <td><?php echo ($dataItem['status']) ?></td>
                                        <td><?php echo ($dataItem['views']) ?></td>
                                        <td><?php echo ($dataItem['special']) ?></td>
                                        <td>
                                            <button type="button" class="btn btn-outline-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                            <button type="button" class="btn btn-outline-danger delete-btn" data-id="<?php echo ($dataItem['id']) ?>" data-url="<?php echo(_WEB_ROOT_ . '/admin/products/delete') ?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>