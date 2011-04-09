<?php $this->load->view('includes/header.php'); ?>	

<?php
// Check if the user is the owner of this bibiliography (Hide delete options if they are not)
if (!empty($_COOKIE['key'])) {
	if ($key != $_COOKIE['key']) {
		$user_is_owner = FALSE;
	} else {
		$user_is_owner = TRUE;
	}	
} else {
	$user_is_owner = FALSE;
}
?>

		<div class="box">
			<h1 class="icon list">My Bibliography
				<?php if($user_is_owner == TRUE): ?>
					<a href="<?php echo site_url('mybib/remove_bibliography'); ?>" class="delete body-text" style="font-size:18px;">Delete Bibliography</a>
				<?php endif; ?>
				
			<a href="#msg-share" class="share body-text" style="font-size:18px; margin-right:10px;">Share This Bibliography</a>
			<div class="msg-share" style="display:none;padding:20px;">
				<strong>Share Your Bibliography</strong>
				<p class="body-text left" style="font-size:16px;">Anyone who visits the link below will be able to view your bibliography. However, they will not be able to add or delete references.</p>
				<p><input type="text" name="bib-link" value="<?php echo site_url("mybib/view/$key"); ?>" style="width:540px; height:100%; padding:20px;" onClick="javascript:this.select();"></p>
				<a href="#msg-close" class="msg-close">Close</a>
			</div>
			</h1>		
				<form name="order-by-form" action="<?php echo site_url("mybib/view/$key"); ?>" method="POST">	
					<ul class="unstyled left">
						<li>
							<label for="order-by">Order By:</label>
							<select name="order-by">
								<option value="date" <?php if ($order == 'date') { echo 'selected'; } ?>>Date Created</option>
								<option value="alphabetical" <?php if ($order == 'alphabetical') { echo 'selected'; } ?>>Alphabetical</option>
							</select>
						</li>
						<li>
							<label for="style">Reference Style:</label>
							<select name="style">
								<option value="apa" <?php if ($style == 'apa') { echo 'selected'; } ?>>QUT APA</option>
								<option value="harvard" <?php if ($style == 'harvard') { echo 'selected'; } ?>>QUT Harvard</option>
							</select>
						</li>
						<li>
							<label for="type">Type of References:</label>
							<select name="type">
								<option value="all" <?php if ($type == 'all') { echo 'selected'; } ?>>All</option>
								<option value="book" <?php if ($type == 'book') { echo 'selected'; } ?>>Books</option>
								<option value="webpage" <?php if ($type == 'webpage') { echo 'selected'; } ?>>Webpages</option>
								<option value="journal" <?php if ($type == 'journal') { echo 'selected'; } ?>>Journals</option>
								<option value="newspaper" <?php if ($type == 'newspaper') { echo 'selected'; } ?>>Newspapers</option>
							</select>
						</li>
						<li>
							<input type="submit" value="Filter" class="btn primary spacer" style="margin-top:25px;">
						</li>
					</ul>
				</form>
				
				<div class="clear"></div>
				<hr />
				
				<?php if (count($data->result()) == 0) {
					echo "<h2>Oops, Nothing was found...</h2>";
					echo "<p>No matching references were found. Either you have not created any yet, or nothing matches the filters set above.</p>";
					echo '<p>To create a new reference please use the <a href="' . base_url() . '">Reference Generator</a></p>';
				};?>
				
				<?php 
					
					foreach ($data->result() as $ref) {
   						$base = site_url();
   					?>
						<div class="reference"><?php if($style=='apa') { echo $ref->apa; } else { echo $ref->harvard; } ?>
									<div class="msg-intext">
										<p><?php if($style=='apa') { echo $ref->apa_intext; } else { echo $ref->harvard_intext; } ?></p>
										<a href="#msg-close" class="msg-close">Close</a>
									</div>
									<div class="overlay no-select">
										<a href="#intext" class="in-text">In-text Reference</a>
										<?php if($user_is_owner == TRUE): ?>
										<a href="<?php echo $base . '/mybib/remove/' . $ref->id; ?>" class="delete-ref">Remove</a>
										<?php endif; ?>
									</div>
							</div>
   						
					<?php } ?>

<?php $this->load->view('includes/footer.php'); ?>