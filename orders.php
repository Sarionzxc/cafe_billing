<?php include('db_connect.php');?>
<style>
    input[type=checkbox] {
        /* Double-sized Checkboxes */
        -ms-transform: scale(1.3); /* IE */
        -moz-transform: scale(1.3); /* FF */
        -webkit-transform: scale(1.3); /* Safari and Chrome */
        -o-transform: scale(1.3); /* Opera */
        transform: scale(1.3);
        padding: 10px;
        cursor:pointer;
    }
</style>
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row mb-4 mt-4">
            <div class="col-md-12">
                
            </div>
        </div>
        <div class="row">
            <!-- Table Panel -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b>List of Orders</b>
                    </div>
                    <div class="card-body">
                        <table class="table table-condensed table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="">Date</th>
                                    <th class="">Invoice</th>
                                    <th class="">Order Number</th>
                                    <th class="">Amount</th>
                                    <th class="">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                $order = $conn->query("SELECT * FROM orders ORDER BY unix_timestamp(date_created) DESC");
                                while($row = $order->fetch_assoc()):
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $i++ ?></td>
                                        <td>
                                            <p> <b><?php echo date("M,d,Y",strtotime($row['date_created'])) ?></b></p>
                                        </td>
                                        <td>
                                            <p> <b><?php echo $row['ref_no'] ? $row['ref_no'] : 'N/A' ?></b></p>
                                        </td>
                                        <td>
                                            <p> <b><?php echo $row['order_number'] ?></b></p>
                                        </td>
                                        <td>
                                            <p class="text-right"> <b><?php echo number_format($row['total_amount'],2) ?></b></p>
                                        </td>
                                        <td class="text-center">
                                            <?php if($row['amount_tendered'] > 1): ?>
                                                <span class="badge badge-success">Paid</span>
                                            <?php else: ?>
                                                <span class="badge badge-primary">Unpaid</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-primary" type="button" onclick="location.href='billing/index.php?id=<?php echo $row['id']?>'" data-id="<?php echo $row['id']?>">Edit</button>
                                            <button class="btn btn-sm btn-outline-primary view_order" type="button" data-id="<?php echo $row['id'] ?>">View</button>
                                            <button class="btn btn-sm btn-outline-danger delete_order" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Table Panel -->
        </div>
    </div>  
</div>
<style>
    td {
        vertical-align: middle !important;
    }
    td p {
        margin: unset;
    }
    img {
        max-width: 100px;
        max-height: 150px;
    }
</style>
<script>
    $(document).ready(function(){
        $('table').dataTable();
    });

    $('#new_order').click(function(){
        uni_modal("New order ","manage_order.php","mid-large");
    });

    $('.view_order').click(function(){
        uni_modal("Order Details","view_order.php?id="+$(this).attr('data-id'),"mid-large");
    });

    $('.delete_order').click(function(){
        var id = $(this).attr('data-id');

        if(confirm("Are you sure you want to delete this order?")) {
            $.ajax({
                url: 'delete_order.php',
                type: 'POST',
                data: {id: id},
                success: function(response) {
                    if (response == 1) {
                        alert("Order deleted successfully.");
                        location.reload();
                    } else {
                        alert("Error deleting order.");
                    }
                },
                error: function() {
                    alert("Error: Could not connect to server.");
                }
            });
        }
    });
</script>
