<?php
function truncate($mytext) {  

	if(strlen($mytext) < 100)
		return $mytext;
	else
	{  
		$chars = 100;  
		$mytext = substr($mytext,0,$chars);  
		$mytext = substr($mytext,0,strrpos($mytext,' '));  
		$mytext = str_replace('<div>','',$mytext);
		$mytext = str_replace('<p>','',$mytext);
		$mytext = str_replace('<ul>','',$mytext);
		$mytext = str_replace('<li>','',$mytext);
		return $mytext . '...';  
	}
} 
?>
<div id = 'ved_content' style = "clear: left; width: 1000px; margin: 0px auto;">
<h1>
<?php

		if($this->session->userdata($table_name . '_add_function') != '')
			$add_function =  $this->session->userdata($table_name . '_add_function');
		else
			$add_function = 'action/add/'.$table_name;
			
		echo str_replace('_',' ',ucwords($table_name)); 
	
		if($this->session->userdata($table_name . '_hide_add') != '')
			echo ' - ' . anchor ( $add_function, 'Add'); 
		else
			echo ' - ' . anchor ( $add_function, 'Add');
?>

</h1>
<br>
<script type="text/javascript" language="javascript" src="media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#rounded-corner').dataTable();
			} );
		</script>
<table id="rounded-corner">
<thead>

<tr><!--table headers-->
<?php

	$fields = $data->list_fields();
	$ref_fields = array ();
	if(isset($rel))
		foreach ($rel as $col => $fields_list)
			$ref_fields[$col] = $fields_list->list_fields();
		
	$field_arr  = array();
	$j = 0;
	
	foreach ($fields as $field)
	{
		if($field == $pk or $field == 'spec_sheet')
		{
			$field_arr[] = $field;
			$j++;
			continue;
		}
		if ($j==0)
			echo '<th class="rounded-company">'.str_replace('_',' ',ucfirst($field)).'</th>';
		
		else
		{
			if ($field == 'order_column')
				echo '<th>Reorder</th>';
			else
				echo '<th>'.str_replace('_',' ',ucfirst($field)).'</th>';
		}	
		$field_arr[] = $field;
		$j++;
	}
	echo '<th>Edit</td>';
	if($this->ion_auth->is_admin())
		echo '<th class = "rounded-q4">Delete</td>';
	
?>	
</tr>
</thead>
<tbody>
<?php	
	if(strlen($this->uri->segment(4)) != 0)
	{
		$page = $row = $this->uri->segment(4);
	}
	else
	{
		$row = 0;
		$page = '';
	}
		
	foreach ($data->result() as $item)
	{
		echo '<tr onMouseOver = "this.bgColor = \'#d3d3d3\'" onMouseOut = "this.bgColor = \'#ffffff\'">';
		$i = 0;

		
		$num_fields = $j;
		
		while ( $i < $num_fields )
		{
			//if ($type_info[$field_arr[$i]] == 'date')
				//$value = date('d-m-Y',strtotime($item->$field_arr[$i]));
			//else 
			//{
				if($field_arr[$i] == $pk or $field_arr[$i] == 'spec_sheet')
				{
					$i++;
					continue;
				}
				
				switch ($field_arr[$i])
				{					
					case 'order_column':
					if ($row == 0 and $total_rows == 1)
					{
						$value = '';
					}
					else
					{
						if ($row == 0)
							$value = anchor ('action/move_down/' . $table_name . '/' . $item->$field_arr[0] . '/' . $page, '<img src = "img/arrow-blue-rounded-down.png" />');
						else if ($row == $total_rows-1)
							$value = ' ' . anchor ('action/move_up/' . $table_name . '/' . $item->$field_arr[0] . '/' . $page, '<img src = "img/arrow-blue-rounded-up.png" />') ;
						else
						{
							$value = anchor ('action/move_down/' . $table_name . '/' . $item->$field_arr[0] . '/' . $page, '<img src = "img/arrow-blue-rounded-down.png" />');
							$value .= ' ' . anchor ('action/move_up/' . $table_name . '/' . $item->$field_arr[0] . '/' . $page, '<img src = "img/arrow-blue-rounded-up.png" />');
						}
					}
					break;
					
					default:
					if(isset($referring[$field_arr[$i]]))
					{
						$options = array();
						foreach ($rel[$field_arr[$i]]->result() as $referenced)
						{
							
							$options[$referenced->id] = $referenced->$ref_fields[$field_arr[$i]][1];
						}
						$value = $options[$item->$field_arr[$i]];
					}	
					else
						//$value = $item->$field_arr[$i];
						$value = truncate(strip_tags($item->$field_arr[$i]));
						//print_r($referring);
					break;
				}
				$location = substr(anchor ('action/view/' . $table_name . '/' . $item->$field_arr[0], 'Edit'),9,-10);
				
				if (isset($width))
					echo "<td $width >$value</td>";
				else
				{
					echo "<td >$value</td>";
				}
				
				$i++;
		}
		
		$attributes = array ('rel'=>'facebox');
	
		$userdata = array ('uri'=> $this->uri->uri_string());
		
		if($this->session->userdata($table_name . '_edit_function') != '')
			$edit_function =  $this->session->userdata($table_name . '_edit_function');
		else
			$edit_function = 'action/edit/' . $table_name ;
		
		
		echo '<td>'. anchor ( $edit_function . '/' . $item->$field_arr[0], 'Edit') .'</td>';
		if($this->ion_auth->is_admin())
			echo '<td>'. anchor ('action/confirm/' . $table_name . '/' . $item->$field_arr[0], 'Delete',$attributes) .'</td>';

		echo '</tr>';
		
		$row++;

	}
?>
</tbody>
</table>
<?php //echo $this->pagination->create_links(); ?>

</div>