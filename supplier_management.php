<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <button class="btn btn-success float-right btn-sm" id="new_supplier"><i class="fa fa-plus"></i> New Supplier</button>
        </div>
    </div>
    <br>
    <div class="col-lg-12">
        <div class="card ">
            <div class="card-header"><b>Supplier List</b></div>
            <div class="card-body">
                <table class="table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Address</th>
                            <th class="text-center">Contact No</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include 'db_connect.php';
                            $suppliers = $conn->query("SELECT * FROM suppliers order by name asc");
                            $i = 1;
                            while($row= $suppliers->fetch_assoc()):
                         ?>
                        <tr>
                            <td class="text-center">
                                <?php echo $i++ ?>
                            </td>
                            <td>
                                <?php echo ucwords($row['name']) ?>
                            </td>
                            <td>
                                <?php echo $row['address'] ?>
                            </td>
                            <td>
                                <?php echo $row['contact_no'] ?>
                            </td>
                            <td>
                                <?php echo $row['price'] ?> <!-- Display the price here -->
                            </td>
                            <td>
                                <center>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-success btn-sm">Action</button>
                                        <button type="button" class="btn btn-success btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item edit_supplier" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Edit</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item delete_supplier" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Delete</a>
                                        </div>
                                    </div>
                                </center>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
  $('table').dataTable();
$('#new_supplier').click(function(){
  uni_modal('New Supplier','manage_supplier.php')
})
$('.edit_supplier').click(function(){
  uni_modal('Edit Supplier','manage_supplier.php?id='+$(this).attr('data-id'))
})
$('.delete_supplier').click(function(){
    _conf("Are you sure to delete this supplier?","delete_supplier",[$(this).attr('data-id')])
  })
  function delete_supplier($id){
    start_load()
    $.ajax({
      url:'ajax.php?action=delete_supplier',
      method:'POST',
      data:{id:$id},
      success:function(resp){
        if(resp==1){
          alert_toast("Data successfully deleted",'success')
          setTimeout(function(){
            location.reload()
          },1500)

        }
      }
    })
  }
</script>
