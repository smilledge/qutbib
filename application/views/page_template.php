<?php $this->load->view('includes/header.php'); ?>	

		<div class="box">
			
			<?php if ($submitted == TRUE) : ?>
				<h1>Thank You</h1>
				<p>You bug has been submitted successfully.</p>
				<a href=" <?php echo site_url(); ?> ">Home</a> | <a href=" <?php echo site_url('page/bug'); ?> ">Report another bug</a>
			<?php endif; ?>
			<?php if ($submitted == FALSE) : ?>
			<h1>Report a Bug</h1>
			<form action="<?php echo site_url('page/bug'); ?>" method="POST">
				<p>If you come across a bug please report it below.</p>
				<p>Make sure you specify the page where you noticed the bug and any other relevant information.</p>
				<textarea rows="5" cols="40" name="description" placeholder="Bug Description..." style="width:400px;"></textarea>
				<p><input type="submit" value="Submit Bug Report" style="float:left;"></p>
			</form>
			<?php endif; ?>

<?php $this->load->view('includes/footer.php'); ?>