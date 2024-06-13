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
                                <th>User name</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php foreach ($all as $dataItem) { ?>
                                    <tr>
                                        <td><?php echo $dataItem['id']; ?></td>
                                        <td><?php echo $dataItem['name']; ?></td>
                                        <td><?php echo number_format($dataItem['total_price'], 2, ',', '.') ?></td>
                                        <td><?php echo $dataItem['status']; ?></td>
                                        <td><?php echo $dataItem['created_at']; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-outline-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
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