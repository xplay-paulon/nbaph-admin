<style>
	.author-wrapper{
		color:red;
	}
	.author-row{
		background: #f8f8f8;		
		padding:10px;
	}
	.author-image, .author-name{padding:5px; display:block; float:left;}
	.author-control{padding:5px; display:block; float:right;}
	.clear{clear:both;}
	.lightbackground{background:#f2f2f2;}

</style>
<div class='author-wrapper'>
	<?php foreach($data as $d): ?>
	<div class='author-row<?php echo (($d['id'] % 2)==0)?" lightbackground":""; ?>'>
		<span class='author-image'><img src="/ftp-web/images/bloggers/<?php echo $d['photo']; ?>" /></span>
		<span class='author-name'><?php echo $d['fullname']; ?></span>
		<span class='author-control'>
			<input type='button' value='Select' class='select_author' id='<?php echo $d['id']; ?>' />
			<input type='button' value='Edit' class='edit_author' id='<?php echo $d['id']; ?>' />
		</span>
		<div class='clear'></div>
	</div>
	<?php endforeach; ?>	
</div>
<script>
	$(document).ready(function(){
		$("input.select_author").bind('click',function(){			
			$("#writer").val($(this).parent().parent().find(".author-name").html());
			$("#writer_id").val($(this).attr("id"));
			$("div[id=dialog]").dialog("close");
		});
		$("input.edit_author").bind('click',function(){
			//alert($(this).attr("id"));
			$.ajax({
				url:"/admin/around-the-nba/ajax.php?request=formEditAuthors&id=" + $(this).attr("id"),
				cache:false
			}).done(function(retHtml){
				$("div[id=dialog]").html(retHtml).dialog("open");
			});
			$(".form-dialog .ui-button-text:contains('Add Author')").text('Save');

		});
	});
</script>