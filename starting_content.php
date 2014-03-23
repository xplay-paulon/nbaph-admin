<?php
include('../sql.php');
require('clean.php');

if(isset($_GET['pos']))
$pos=clean(trim($_GET['pos']));

//echo $pos;

$getlist_sql="SELECT * FROM startingfive WHERE Position='$pos' ORDER BY Votes DESC;";
$getlist=mysql_query($getlist_sql) or die ("GETLIST :". mysql_error());
?>
<table>
	<tr>
		<td width="100">Image</td>
		<td width="880">
		<div style=" width: 200px; height: 20px;display: inline-block;">Player Name</div>
		<div style=" width: 60px; height: 20px;display: inline-block; text-align: center;">Votes</div>
		<div style="width: 50px; display: inline-block;"> Number</div>
		<span>Stats Link</span>
		</td>

	</tr>
<?php
while($players=mysql_fetch_array($getlist)){
?>

	<tr>
		<td width="100">
		<?php
			/*if($grow['Filename'])
			 {
				 $path = "../".$grow['Filename'];
			 }
			else
			 {
				 $path = "../images/startingfive/".$players['StartingfiveID']."_sfive.jpg";
			 }*/
			
			//if(file_exists($path))
			echo '<img src="' . $players['Filename'] . '" width="100" height="100">';
			//else
			//echo "no image";
		?>
		<br />
			<form action="starting.php" id="sfive_form" name="sfive_form" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id_edit" id="id_edit" value="<?php echo $players['StartingfiveID'];?>">
				<!--input type="file" name="edit_image" id="edit_image"><br /-->
				<input type="text" name="edit_image" id="edit_image" value="<?php echo $players['Filename']; ?>"> (270x250)<br />
				<input type="submit" name="update" id="update" value="Update">
			</form>

		</td>
		<td width="200">
			<form action="starting.php" id="sfive_form" name="sfive_form" method="post" enctype="multipart/form-data">
				<div style=" width: 200px; height: 20px;display: inline-block;">
					<input type="text" name="pname_edit" id="pname_edit" value="<?php echo $players['PlayerName'];?>" style="width:195px;">
				</div>
				<div style=" width: 60px; height: 20px;display: inline-block; text-align: center;font-weight: bold;"><?php echo $players['Votes'];?></div>
		
				<div style="width: 50px; display: inline-block;text-align: center;">
					<input type="text" name="num_edit" id="num_edit" value="<?php echo $players['PlayerNumber'];?>" style="width: 25px;">
				</div>
            <input type="text" name="link_edit" id="link_edit" value="<?php echo $players['Stats'];?>" style="width: 270px;">
            <input type="hidden" name="id_edit" id="id_edit" value="<?php echo $players['StartingfiveID'];?>">
            <input type="submit" name="save" id="save" value="save">
            <input type="submit" name="delete" id="delete" value="delete">
         </form>
			
		</td>
	</tr>

<?php
}
?>

</table>