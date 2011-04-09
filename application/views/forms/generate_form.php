<form action="<?php echo site_url("generate/$type"); ?>" method="post" class="tabbed">
				<ul class="unstyled vtabs">
					<li <?php if ($type == 'book') { echo 'class="selected"'; } ?>><a href="<?php echo site_url("generate/book"); ?>">Book</a></li>
					<li <?php if ($type == 'webpage') { echo 'class="selected"'; } ?>><a href="<?php echo site_url("generate/webpage"); ?>">Webpage</a></li>
					<li <?php if ($type == 'journal') { echo 'class="selected"'; } ?>><a href="<?php echo site_url("generate/journal"); ?>">Journal Article</a></li>
					<li <?php if ($type == 'newspaper') { echo 'class="selected"'; } ?>><a href="<?php echo site_url("generate/newspaper"); ?>">Newspaper Article</a></li>
					<!-- <li <?php if ($type == 'more') { echo 'class="selected"'; } ?>><a href="<?php echo site_url("generate/more"); ?>">More...</a></li> -->
				</ul>
				<fieldset>
					<legend>Contributors</legend>
					<span class="spacer"></span>
					
					<!-- Contributor Form -->
					
					<div class="contrib-wrapper">
						<div class="contrib-form">
							<ul class="unstyled left">
								<li>
									<div class="drop-menu" style="margin-top:34px;">
										<a href="#" class="settings down-arrow">Author</a>
										<div class="drop-menu-content">
											<fieldset>
												<strong>Type of contributor</strong>
												<label><input type="radio" name="contributor-type[0]" value="author" checked="checked"> Author</label>
												<label><input type="radio" name="contributor-type[0]" value="editor"> Editor</label>
												<label><input type="radio" name="contributor-type[0]" value="translator"> Translator</label>
											</fieldset>
											
											<fieldset class="author-type">
												<strong class="spacer">Type of author</strong>
												<label><input type="radio" name="author-type[0]" value="individual" checked="checked"> Individual Author</label>
												<label><input type="radio" name="author-type[0]" value="corporate"> Corporate Author</label>
											</fieldset>
										</div>
									</div>
								</li>
								<li>
									<fieldset class="inline individual">
										<ul class="unstyled left">
											<li>
												<label for="first-name">First Name:</label>
												<input type="text" id="first-name" name="first-name[0]" placeholder="First Name" style="width:160px">
											</li>
											<li>
												<label for="middle-initial">MI:</label>
											<input type="text" id="middle-initial" name="middle-initial[0]" placeholder="" style="width:40px">
											</li>
											<li>
												<label for="last-name">Last Name:</label>
												<input type="text" id="last-name" name="last-name[0]" placeholder="Last Name" style="width:160px">
											</li>
										</ul>
									</fieldset>
								</li>
								<li>
									<fieldset class="invisible left corporate" style="margin-right:10px;">
										<label for="corporate-author">Corporate Author:</label>
										<input type="text" id="corporate-author" name="corporate-author[0]" placeholder="Corporate Author" style="width:400px">
									</fieldset>
								</li>
							</ul>
						</div>
					</div>
					<ul class="unstyled left spacer">
						<li><label for="add-contrib" class="wide-label">Add contributor</label></li>
						<li>
							<input name="add-contrib" id="add-contrib" class="btn left clear" type="button" value="Add a Contributor" />
							<p style="float:left; margin: 5px 0px 0px 10px;">(Individual Author, Corporate Author, Editor or Translator)</p>
						</li>
					</ul>
					<!-- End Contributor Form -->
					
					<fieldset>
						<legend>Publication Details</legend>
						
						<ul class="unstyled left spacer">
							<li>
								<label for="title" class="wide-label"><?php if ($type == 'journal' || $type == 'newspaper') { echo 'Article '; } else if ($type == 'webpage') { echo 'Page '; } ?>Title:</label>
							</li>
							<li>
								<input type="text" id="title" name="title" placeholder="<?php if ($type == 'journal' || $type == 'newspaper') { echo 'Article '; } else if ($type == 'webpage') { echo 'Page '; } ?>Title" style="width:300px;">
								<?php if ($type == 'book'): ?><label for="title" class="min-spacing">Publication Title:</label>	<?php endif; ?>	
							</li>
							<li>
								<?php if ($type == 'book'): ?>
								<input type="text" id="edition" name="edition" placeholder="" style="width:50px;">	
								<label for="edition" class="min-spacing">Ed.</label>
								<?php endif; ?>
							</li>
						</ul>
						
						<?php if ($type == 'newspaper'): ?>
						<ul class="unstyled left spacer">
							<li><label for="publication-title" class="wide-label">Newspaper Title:</label></li>
							<li><input type="text" id="publication-title" name="publication-title" placeholder="Newspaper Title" style="width:300px;"></li>
						</ul>
						<?php endif; ?>
						
						<?php if ($type == 'webpage'): ?>
						<div id="publication-title-wrapper" style="display:none;">
						<ul class="unstyled left spacer">
							<li><label for="publication-title" class="wide-label">Website Name:</label></li>
							<li><input type="text" id="publication-title" name="publication-title" placeholder="Website Name" style="width:300px;"></li>
						</ul>
						</div>
						<?php endif; ?>
						
						<?php if ($type == 'webpage'): ?>
						<ul class="unstyled left spacer">
							<li><label for="url" class="wide-label">URL:</label></li>
							<li><input type="text" id="url" name="url" placeholder="URL" style="width:300px;"></li>
						</ul>
						<?php endif; ?>
						
						<?php if ($type == 'journal'): ?>
						<ul class="unstyled left spacer">
							<li><label for="publication-title" class="wide-label">Journal Title:</label></li>
							<li><input type="text" id="publication-title" name="publication-title" placeholder="Journal Title" style="width:300px;"></li>
						</ul>
						
						<ul class="unstyled left spacer">
							<li><label class="wide-label inline" for="volume">Additional Info:</label></li>
							<li>
								<input type="text" id="volume" name="volume" placeholder="1" style="width:60px;">
								<label for="volume" class="min-spacing">Volume</label>
							</li>
							<li>
								<input type="text" id="issue" name="issue" placeholder="1" style="width:60px;">
								<label for="issue" class="min-spacing">Issue</label>
							</li>
							<li>
								<input type="text" id="year-published" name="year-published" placeholder="YYYY" style="width:120px;">
								<label for="year-published" class="min-spacing">Year Published</label>
							</li>
						</ul>
						<?php endif; ?>

						<?php if ($type == 'book'): ?>
						<ul class="unstyled left spacer">
							<li><label for="publisher" class="wide-label">Publication Info:</label></li>
							<li>
								<input type="text" id="publisher" name="publisher" placeholder="Publisher" style="width:150px;">
								<label for="publisher" class="min-spacing">Publisher</label>
							</li>
							<li>
								<input type="text" id="location" name="location" placeholder="City name, ST" style="width:120px;">
								<label for="location" class="min-spacing">Location</label>
							</li>
							<li>
								<input type="text" id="year-published" name="year-published" placeholder="1999" style="width:60px;">
								<label for="year-published" class="min-spacing">Year</label>
							</li>
						</ul>
						<?php endif; ?>
						
						<?php if ($type == 'webpage' || $type == 'newspaper'): ?>
						<ul class="unstyled left spacer">
							<li><label class="wide-label inline" for="day-published">Date Published:</label></li>
							<li>
								<input type="text" id="day-published" name="day-published" placeholder="12" style="width:60px;">
								<label for="day-published" class="min-spacing">Day</label>
							</li>
							<li>
								<select name="month-published">
									<option value = "1" selected="selected">Janurary</option>
									<option value = "2">February</option>
									<option value = "3">March</option>
									<option value = "4">April</option>
									<option value = "5">May</option>
									<option value = "6">June</option>
									<option value = "7">July</option>
									<option value = "8">August</option>
									<option value = "9">September</option>
									<option value = "10">October</option>
									<option value = "11">November</option>
									<option value = "12">December</option>
								</select> 
								<label for="month-published" class="min-spacing">Month</label>
							</li>
							<li>
								<input type="text" id="year-published" name="year-published" placeholder="1999" style="width:100px;">
								<label for="year-published" class="min-spacing">Year</label>
							</li>
						</ul>		
						<?php endif; ?>

						<?php if ($type == 'webpage'): ?>
						<ul class="unstyled left spacer">
							<li><label class="wide-label inline" for="day-retrieved">Retrieval Date:</label></li>
							<li>
								<input type="text" id="day-retrieved" name="day-retrieved" placeholder="26" style="width:60px;">
								<label for="day-retrieved" class="min-spacing">Day</label>
							</li>
							<li>
								<select name="month-retrieved">
									<option value = "1" selected="selected">Janurary</option>
									<option value = "2">February</option>
									<option value = "3">March</option>
									<option value = "4">April</option>
									<option value = "5">May</option>
									<option value = "6">June</option>
									<option value = "7">July</option>
									<option value = "8">August</option>
									<option value = "9">September</option>
									<option value = "10">October</option>
									<option value = "11">November</option>
									<option value = "12">December</option>
								</select> 
								<label for="month-retrieved" class="min-spacing">Month</label>
							</li>
							<li>
								<input type="text" id="year-retrieved" name="year-retrieved" placeholder="2010" style="width:100px;">
								<label for="year-retrieved" class="min-spacing">Year</label>
							</li>
						</ul>	
						<?php endif; ?>
						
						<?php if ($type != 'webpage'): ?>			
						<ul class="unstyled left spacer">
							<li><label class="wide-label inline" for="from-page">Pages:</label></li>
							<li>
								<input type="text" id="from-page" name="from-page" placeholder="123" style="width:60px;">
								<label for="from-page" class="min-spacing">From</label>	
							</li>
							<li>
								<input type="text" id="to-page" name="to-page" placeholder="456" style="width:60px;">
								<label for="to-page" class="min-spacing">To</label>
							</li>
						</ul>
						<?php endif; ?>
						
						<?php if ($type == 'book' || $type == 'webpage'): ?>
						<ul class="unstyled left spacer">
							<li><label class="wide-label inline" for="unusual-resource-check">Unusual Resource:</label></li>
							<li>
								<label style="margin-top:3px;"><input type="checkbox" id="unusual-resource-check" name="unusual-resource-check" class="inline" style="margin-right:10px;">I am referencing an unusual resource<?php switch ($type){ case 'book': echo '(Poster, brochure, etc.)'; break; case 'webpage': echo '(Blog, Forum, etc.)'; break; } ?></label>
								<div id="unusual-resource-wrapper" style="display:none;" >
									<select id="resource-type" name="resource-type" style="width:300px;">
										<option value="">Please select a resource type</option>
										<?php if ($type == 'book'): ?>
										<option value = "Brochure">Brochure</option>
										<option value = "Pamphlet">Pamphlet</option>
										<option value = "Poster">Poster</option>
										<?php endif; ?>
										<?php if ($type == 'webpage'): ?>
										<option value = "Blog">Blog</option>
										<option value = "Forum">Forum/Message Board</option>
										<?php endif; ?>
									</select>
									<label for="resource-type" class="min-spacing">Resource Type</label>
								</div>
							</li>
						</ul>
						<?php endif; ?>
						
						<?php if ($type == 'journal' || $type == 'newspaper'): ?>
						<ul class="unstyled left spacer">
							<li><label class="wide-label inline" for="doi-check">DOI:</label></li>
							<li>
								<label style="margin-top:3px;"><input type="checkbox" id="doi-check" name="doi-check" style="margin-right:10px;">I am referencing a resource with a Digital Object identifier (DOI)</label>
								<div id="doi-wrapper" style="display:none;" >
									<input type="text" id="doi" name="doi" placeholder="Digital Object identifier Code" style="width:300px;">
									<label for="doi" class="min-spacing">DOI Code</label>
								</div>
							</li>
						</ul>
						<?php endif; ?>
					</fieldset>
					
					<div class="actions spacer"> 
						<input type="submit" value="Generate" class="btn primary" >
						&nbsp;<input type="reset" value="Cancel" class="btn"  >
          			</div> 
					
			</form>