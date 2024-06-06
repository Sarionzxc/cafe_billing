<?php 
include('db_connect.php');
session_start();
if(isset($_GET['id'])){
$supplier = $conn->query("SELECT * FROM suppliers where id =".$_GET['id']);
foreach($supplier->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}
?>
<div class="container-fluid">
	<div id="msg"></div>
	
	<form action="" id="manage-supplier">	
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="address">Address</label>
			<input type="text" name="address" id="address" class="form-control" value="<?php echo isset($meta['address']) ? $meta['address']: '' ?>" required>
		</div>
		<div class="form-group">
    <label for="price">Price</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">&#8369;</span> <!-- Peso sign -->
        </div>
        <input type="text" name="price" id="price" class="form-control" value="<?php echo isset($meta['price']) ? $meta['price']: '' ?>" required>
    </div>
</div>

		<div class="form-group">
			<label for="contact_no">Contact No</label>
			<input type="text" name="contact_no" id="contact_no" class="form-control" value="<?php echo isset($meta['contact_no']) ? $meta['contact_no']: '' ?>" required>
		</div>
	</form>
</div>
<script>
	
	$('#manage-supplier').submit(function(e){
		e.preventDefault();
		start_load()

		var tempData = new URLSearchParams($(this).serialize())
		const name = tempData.get("name")
		const address = tempData.get("address")
		const contact_no = tempData.get("contact_no")

		if(name == "" || address == "" || contact_no == ""){
			$('#msg').html('<div class="alert alert-danger">All fields are required!</div>') 
			end_load()
		}
		else{
			start_load()
			$.ajax({
				url:'ajax.php?action=save_supplier',
				method:'POST',
				data:$(this).serialize(),
				success:function(resp){
					if(resp ==1){
						alert_toast("Data successfully saved",'success')
						setTimeout(function(){
							location.reload()
						},1500)
					}else{
						$('#msg').html('<div class="alert alert-danger">Error saving data</div>')
					}
				}
			})
		}
	})

</script>
