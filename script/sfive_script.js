function showInfo(id)
{
	
	var pos=$("#pos_"+id).val();
	for(var a=1;a<=max;a++)
	{
		if(a==id){
			$("#info_div_"+id).show('200');
			$("#info_"+id).show('200');
			$("#info_"+id).html('<img src="images/loader.gif" width="110" height="80">');
			$.ajax({
				url: "starting_content.php?pos="+pos,
				cache: false,
				success: function(html){		
					$("#info_"+id).html(html);
					$("#button_"+id).html('<input type="button" style="border: 0px; width: 20px; height: 20px; background: url(\'images/up_btn.png\') no-repeat;" onclick="hideInfo('+id+');">');
				},
			});
		}
		else{
			hideInfo(a);
		}
	}
}
function hideInfo(id)
{
	$("#info_"+id).hide('200');
	$("#info_div_"+id).hide('200');
	$("#button_"+id).html('<input type="button" style="border: 0px; width: 20px; height: 20px; background: url(\'images/down_btn.png\') no-repeat;" onclick="showInfo('+id+');">');
}