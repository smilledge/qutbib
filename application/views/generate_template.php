<?php $this->load->view('includes/header.php'); ?>	
<?php $base = site_url(); ?>			
<?php if (isset($harvard) || isset($apa)) : ?>
		<div class="box">		
			<h1 class="icon list">Your reference</h1>
			<h2>QUT APA Format</h2>
			<div class="reference"><?php echo $apa; ?>
				<div class="msg-intext">
					<p><?php echo $apa_intext; ?></p>
					<a href="#msg-close" class="msg-close">Close</a>
				</div>
				<div class="overlay no-select">
					<a href="#intext" class="in-text">In-text Reference</a>
				</div>
			</div>

			<h2>QUT Harvard Fromat</h2>
			<div class="reference"><?php echo $harvard; ?>
				<div class="msg-intext">
					<p><?php echo $harvard_intext; ?></p>
					<a href="#msg-close" class="msg-close">Close</a>
				</div>
				<div class="overlay no-select">
					<a href="#intext" class="in-text">In-text Reference</a>
				</div>
			</div>
		</div>
<?php endif; ?>
		<div class="box">
			<h1 class="icon add">Create a new reference</h1>
				
<?php $this->load->view('forms/generate_form.php') ?>


<?php $this->load->view('includes/footer.php'); ?>