<?php 
include('db_connect.php');
session_start();
if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM users where id =".$_GET['id']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}
?>
<div class="container-fluid">
	<div id="msg"></div>
	
	<form action="" id="manage-user">	
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="username">Username</label>
			<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required  autocomplete="off">
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
			<?php if(isset($meta['id'])): ?>
			<small><i>Leave this blank if you dont want to change the password.</i></small>
		<?php endif; ?>
		</div>
		<?php if(isset($meta['type']) && $meta['type'] == 3): ?>
			<input type="hidden" name="type" value="3">
		<?php else: ?>
		<?php if(!isset($_GET['mtype'])): ?>
		<div class="form-group">
			<label for="type">User Type</label>
			<select name="type" id="type" class="custom-select">
				<option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected': '' ?>>Cashier</option>
				<option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected': '' ?>>Admin</option>
			</select>
		</div>
		<?php endif; ?>
		<?php endif; ?>
	</form>
</div>
<script>
	
	$('#manage-user').submit(function(e){
		e.preventDefault();
		start_load()

		var tempData = new URLSearchParams($(this).serialize())
		const name = tempData.get("name")
		const username = tempData.get("username")
		const pw = tempData.get("password")
		const type = tempData.get("type")

		console.log(name == null)
		if(!userChecker(username)){
			if(!pwChecker(pw) && pwHasUppercase(pw)){
				$('#msg').html('<div class="alert alert-danger mb-1">Username should contain special character</div> <div class="alert alert-danger">Password should have atleast 8 characterts</div>')
			}
			else if(pwChecker(pw) && !pwHasUppercase(pw)){
				$('#msg').html('<div class="alert alert-danger mb-1">Username should contain special character</div> <div class="alert alert-danger mb-1">Password should contain 1 uppercase</div>')
			}
			else if(!pwChecker(pw) && !pwHasUppercase(pw)){
				$('#msg').html('<div class="alert alert-danger mb-1">Username should contain special character</div> <div class="alert alert-danger mb-1">Password should have atleast 8 characterts</div> <div class="alert alert-danger">Password should contain 1 uppercase</div>')
			}
			else{
				$('#msg').html('<div class="alert alert-danger">Username should contain special character</div>')
			}
			end_load()
		}
		else if(!pwChecker(pw) || !pwHasUppercase(pw)){
			if(!pwHasUppercase(pw)){$('#msg').html('<div class="alert alert-danger">Password should contain 1 uppercase</div>')}
			if(!pwChecker(pw)){$('#msg').html('<div class="alert alert-danger">Password should have atleast 8 characterts</div>')}
			if(!pwHasUppercase(pw) && !pwChecker(pw)){
				$('#msg').html('<div class="alert alert-danger">Password should have atleast 8 characterts</div> <div class="alert alert-danger">Password should contain 1 uppercase</div>')
			}
			end_load()
		}
		else{
			if(name == "" || type == ""){
				$('#msg').html('<div class="alert alert-danger">All fields are required!</div>') 
				end_load()
			}
			else{
				start_load()
				$.ajax({
				url:'ajax.php?action=save_user',
				method:'POST',
				data:$(this).serialize(),
				success:function(resp){
					if(resp ==1){
						alert_toast("Data successfully saved",'success')
						setTimeout(function(){
							location.reload()
						},1500)
					}else{
						$('#msg').html('<div class="alert alert-danger">Username already exist</div>')
					}
				}
			})
			}
		}

		function userChecker(username){
			var regex = /[!@#$%^&*(),.?":{}|<>]/;
			return regex.test(username);
		}
		function pwChecker(pw){
			if (pw.length < 8) {
				return false;
			}
			return true
		}
		function pwHasUppercase(pw) {
			var regex = /[A-Z]/;
			return regex.test(pw);
		}
	})

</script>