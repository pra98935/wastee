<?php
include('include/header.php');
?>

<div class="container pagebg not-found-page">
	<div class="row">
		<div class="col-md-12 whitebg-page">
			<div class="">
				
				<div class="col-md-6">
					<img src="<?php echo base_url('assets/images/404-cat.png') ?>">
				</div>
				
				<div class="col-md-6 error-not-found">
					<div class="text">
						<h1>Ooops</h1>
						<p> We can't find the page you are looking for.</p>
						<p><a href="<?php echo base_url(); ?>" class="btn"> View Homepage </a></p>
					</div>
				</div>	
				
			</div>	
		</div>	
	</div>
</div>	

<?php
include('include/footer.php');
?>

