<?php include('db_connect.php');
?>


<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
				<form action="" id="manage-item">
					<div class="card">
						<div class="card-header">
							Item Form
						</div>
						<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Item Name</label>
								<input type="text" class="form-control" name="item_name">
							</div>
							<div class="form-group">
								<label class="control-label">Quantity</label>
								<input type="number" class="form-control" name="quantity">
							</div>
							<div class="form-group">
								<label class="control-label">Date of Arrival</label>
								<input type="date" class="form-control" name="date_arrival">
							</div>
							<div class="form-group">
								<label class="control-label">Expiration Date</label>
								<input type="date" class="form-control" name="expiration_date">
							</div>
							<div class="form-group">
								<label class="control-label">Supplier Name</label>
								<select class="form-control" name="supplier_name">
									<option value="">Select Supplier</option>
									<?php 
									$suppliers = $conn->query("SELECT * FROM suppliers");
									while($row=$suppliers->fetch_assoc()):
										?>
										<option value="<?php echo $row['name'] ?>"><?php echo $row['name'] ?></option>
									<?php endwhile; ?>
								</select>
							</div>
						</div>

						<div class="card-footer">
							<div class="row">
								<div class="col-md-12">
									<button class="btn btn-sm btn-success col-sm-3 offset-md-3"> Save</button>
									<button class="btn btn-sm btn-default col-sm-3" type="button" onclick="$('#manage-item').get(0).reset()"> Cancel</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<b>Item List</b>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Item Info.</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$batch_lot = $conn->query("SELECT * FROM batch_lot order by id asc");
								while($row=$batch_lot->fetch_assoc()):
									?>
									<tr>
										<td class="text-center"><?php echo $i++ ?></td>
										<td class="">
											<p>Item Name: <b><?php echo $row['item_name'] ?></b></p>
											<p><small>Quantity: <b><?php echo $row['quantity'] ?></b></small></p>
											<p><small>Date of Arrival: <b><?php echo $row['date_arrival'] ?></b></small></p>
											<p><small>Expiration Date: <b><?php echo $row['expiration_date'] ?></b></small></p>
											<p><small>Supplier Name: <b><?php echo $row['supplier_name'] ?></b></small></p>
										</td>
										<td class="text-center">
											<button class="btn btn-sm btn-success edit_item" type="button" data-id="<?php echo $row['id'] ?>" data-item_name="<?php echo $row['item_name'] ?>" data-quantity="<?php echo $row['quantity'] ?>" data-date_arrival="<?php echo $row['date_arrival'] ?>" data-expiration_date="<?php echo $row['expiration_date'] ?>" data-supplier_name="<?php echo $row['supplier_name'] ?>" >Edit</button>
											<button class="btn btn-sm btn-danger delete_item" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
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
	
	td{
		vertical-align: middle !important;
	}
	td p {
		margin:unset;
	}
</style>
<script>
	$('#manage-item').on('reset',function(){
		$('input:hidden').val('')
	})
	
	$('#manage-item').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_batch_lot',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success:function(resp){
    if(resp==1){
        alert_toast("Data successfully added",'success')
        setTimeout(function(){
            location.reload()
        },1500)

        // Check if there's an order quantity and item ID to deduct from batch and lot
        if($('#order_quantity').val() != '' && $('#item_id').val() != ''){
            var order_quantity = $('#order_quantity').val();
            var item_id = $('#item_id').val();
            $.ajax({
                url:'ajax.php?action=save_batch_lot',
                method:'POST',
                data:{order_quantity: order_quantity, item_id: item_id},
                success:function(response){
                    console.log(response); // Debugging purposes
                }
            });
        }
    }
    else if(resp==2){
        alert_toast("Data successfully updated",'success')
        setTimeout(function(){
            location.reload()
        },1500)
    }
}
		})
	})
	$('.edit_item').click(function(){
		start_load()
		var item = $('#manage-item')
		item.get(0).reset()
		item.find("[name='id']").val($(this).attr('data-id'))
		item.find("[name='item_name']").val($(this).attr('data-item_name'))
		item.find("[name='quantity']").val($(this).attr('data-quantity'))
		item.find("[name='date_arrival']").val($(this).attr('data-date_arrival'))
		item.find("[name='expiration_date']").val($(this).attr('data-expiration_date'))
		item.find("[name='supplier_name']").val($(this).attr('data-supplier_name'))
		end_load()
	})
	$('.delete_item').click(function(){
		_conf("Are you sure to delete this item?","delete_batch_lot",[$(this).attr('data-id')])
	})
	function delete_batch_lot($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_batch_lot',
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
	$('table').dataTable()
</script>
