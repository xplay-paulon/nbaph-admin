<style>
	.author-wrapper{padding-top:20px;}
	.author-wrapper .input-row{min-height:40px; clear:both;}
	.author-wrapper .input-row .input-left{display: block; float:left; text-align: right;min-width: 180px;}

	.author-wrapper .input-row .input-right{display: block; float:left; text-align: left;}
</style>
<div class='author-wrapper'>
	<form id='writer-form' name='writer-form' method="POST" action="/admin/around-the-nba/ajax.php?request=submitAddAuthor" enctype='multipart/form-data'>
		<div class='input-row'>
			<span class='input-left'>
				<span><label for='writer-fullname'>Fullname :</label></span>				
			</span>
			<span class='input-right'>
				<span><input type='text' name='writer-fullname' id='writer-fullname' value="<?php echo @$data['fullname']; ?>" required /></span>
				<input type='hidden' name='writer-id' value='<?php echo @$data['id']; ?>' />
			</span>
		</div>
		<div class='input-row'>
			<span class='input-left'>
				<span><label for='writer-bio'>Bio :</label></span>
			</span>
			<span class='input-right'>
				<span><textarea name='writer-bio' id='writer-bio'><?php echo @$data['bio']; ?></textarea></span>
			</span>
		</div>
		<div class='input-row'>
			<span class='input-left'>
				<span><label for='writer-photo'>Photo :</label></span>
			</span>
			<span class='input-right'>
				<span><input type='file' name='writer-photo' id='writer-photo' /></span>
			</span>
		</div>
		<div class='input-row'>
			<span class='input-left'>
				<span>&nbsp;</span>
			</span>
			<span class='input-right'>
				<span><input type='checkbox' name='writer-status' id='writer-status' <?php echo (isset($data['status']) && $data['status']==1)?'checked=checked':''; ?> /> Status(Enable/Disable)</span>
			</span>
		</div>
	</form>
</div>