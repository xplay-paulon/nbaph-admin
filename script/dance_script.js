function showInfo(id)
{
	
	var gallId=$("#gall_id_"+id).val();
	for(var a=1;a<=max;a++)
	{
		if(a==id){
			$("#info_div_"+id).show('200');
			$("#info_"+id).show('200');
			$("#info_"+id).html('<img src="images/loader.gif" width="110" height="80">');
			$.ajax({
				url: "dance_photos_content.php?id="+gallId,
				cache: false,
				success: function(html){		
					$("#info_"+id).html(html);
					$("#button_"+id).html('<input type="button" style="border: 0px; width: 20px; height: 20px; background: url(\'images/up_btn.png\') no-repeat;" onclick="hideInfo('+id+');">');
				}
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
function saveInfo(sID){
	//alert(sID);
	var gname=$('#gname_'+sID).val();
	var gdesc=$('#gdesc_'+sID).val();
	var gsort=$('#gsort_'+sID).val();
	
	gname=$.trim(gname);
	gdesc=$.trim(gdesc);
	$.ajax({
		url: "dance_update_info.php?action=info&sID="+sID+"&gname="+gname+"&gdesc="+gdesc+"&gsort="+gsort,
		cache: false,
		success: function(upInfo){		
		$('#test_'+sID).html(upInfo);
		//$('#error').html(upCap);
			//window.location.href='gallery.php';
		}
	});
}
function updateCap(cid){

		var caption=$('#caption_'+cid).val();
		//alert(caption);
		//alert(gid);

			$.ajax({
				url: "dance_update.php?cid="+cid+"&caption="+caption,
				cache: false,
				success: function(upCap){		
				$('#cap_span_'+cid).html(upCap);
				//$('#error').html(upCap);
					//window.location.href='gallery.php';
				}
			});
}

function updateThumb(cid){

		var cred=$('#thumbs_'+cid).val();
		var sec=$('#second_'+cid).val();
		//alert(caption);
		//alert(gid);

			$.ajax({
				url: "dance_update_thumbs.php?cid="+cid+"&cred="+cred+"&sec="+sec,
				cache: false,
				success: function(upCred){		
				$('#thumbs_span_'+cid).html(upCred);
				//$('#error').html(upCap);
					//window.location.href='gallery.php';
				}
			});

}

function updateCredits(cid){

		var cred=$('#credits_'+cid).val();
		//alert(caption);
		//alert(gid);

			$.ajax({
				url: "dance_update_credits.php?cid="+cid+"&cred="+cred,
				cache: false,
				success: function(upCred){		
				$('#credits_span_'+cid).html(upCred);
				//$('#error').html(upCap);
					//window.location.href='gallery.php';
				}
			});
}

function updateSort(cid){

		var cred=$('#sort_'+cid).val();
		//alert(caption);
		//alert(gid);

			$.ajax({
				url: "dance_update_sort.php?cid="+cid+"&cred="+cred,
				cache: false,
				success: function(upCred){		
				$('#sort_span_'+cid).html(upCred);
				//$('#error').html(upCap);
					//window.location.href='gallery.php';
				}
			});
}

function deleteGalleryPhoto(gid){

		//alert(gid);
			$.ajax({
				url: "dance_delete.php?gid="+gid,
				cache: false,
				success: function(gallDel){		
				$('#error').html(gallDel);
					window.location.href='dance_photos.php';
				}
			});

} 



function changeDanceStat(statID){
	var stat_ctr=$("#ctr_id_"+statID).val();
	$.ajax({
		url: "dance_update_status.php?statID="+statID+"&action=photos&rand="+Math.random(),
		cache: false,
		success: function(upStat){		
		 
		$('#gallery_status_'+stat_ctr).html(upStat);
		//$('#error').html(upCap);
			//window.location.href='gallery.php';
		}
	});
}




