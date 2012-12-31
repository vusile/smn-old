<div>
Are you sure you want to delete <span style = 'font-weight: bold'><?php echo $title; ?> </span> from the <span style = 'font-weight: bold'><? echo $table; ?></span> database?

<?php 
	echo anchor ('action/delete/' . $table . '/' . $pk . '/' . $id , 'Yes');
?> - 
<?php 
	echo anchor ('main/view/' . $table , 'No');
?>
</div>