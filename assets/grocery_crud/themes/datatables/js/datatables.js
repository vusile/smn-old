var default_per_page = typeof default_per_page !== 'undefined' ? default_per_page : 25;

$(document).ready(function() {
	var mColumns = [];
	
	$('table#groceryCrudTable thead tr th').each(function(index){
		if(!$(this).hasClass('actions'))
		{
			mColumns[index] = index;
		}
	});
	
	var aButtons = [];
	
	if(!unset_export)
	{
		aButtons.push(    {
	         "sExtends":    "xls",
	         "sButtonText": export_text,
	         "mColumns": mColumns
	     });
	}
	
	if(!unset_print)
	{
		aButtons.push({
	         "sExtends":    "print",
	         "sButtonText": print_text,
	         "mColumns": mColumns
	     });		
	}
	
	/*var use_storage = localstorage_supported();
	var pathname = window.location.pathname;
	if(if(pathname.indexOf("/success/") != -1) use_storage = false;*/
	
	oTable = $('#groceryCrudTable').dataTable({
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"bStateSave": true,
		"iDisplayLength": default_per_page,
		"aaSorting": datatables_aaSorting,
		"oLanguage":{
		    "sProcessing":   list_loading,
		    "sLengthMenu":   show_entries_string,
		    "sZeroRecords":  list_no_items,
		    "sInfo":         displaying_paging_string,
		    "sInfoEmpty":   list_zero_entries,
		    "sInfoFiltered": filtered_from_string,
		    "sSearch":       search_string+":",
		    "oPaginate": {
		        "sFirst":    paging_first,
		        "sPrevious": paging_previous,
		        "sNext":     paging_next,
		        "sLast":     paging_last
		    }		
		},
		"sDom": 'T<"clear"><"H"lfr>t<"F"ip>',
	    "oTableTools": {
	    	"aButtons": aButtons,
	        "sSwfPath": base_url+"assets/grocery_crud/themes/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
	    }
	});

	$('a[role=button]').live("mouseover mouseout", function(event) {
		  if ( event.type == "mouseover" ) {
			  $(this).addClass('ui-state-hover');
		  } else {
			  $(this).removeClass('ui-state-hover');
		  }
	});	
	
	$('th.actions').unbind('click');
	$('th.actions>div').html($('th.actions>div').text());
	
} ); 


function localstorage_supported()
{
   var storage,
                 fail,
                 uid,
                 supported;
   try {
         uid = new Date;
         (storage = window.localStorage).setItem(uid, uid);
         fail = storage.getItem(uid) != uid;
         storage.removeItem(uid);
         fail && (storage = false);
   } catch(e) {}
   supported = false;
   if(storage) supported = true;
   return supported;
}

function delete_row(delete_url , row_id)
{	
	if(confirm(message_alert_delete))
	{
		$.ajax({
			url: delete_url,
			dataType: 'json',
			success: function(data)
			{					
				if(data.success)
				{
					$('#ajax_refresh_and_loading').trigger('click');
					$('#report-success').html( data.success_message ).slideUp('fast').slideDown('slow');						
					$('#report-error').html('').slideUp('fast');
					$('tr#row-'+row_id).addClass('row_selected');
					var anSelected = fnGetSelected( oTable );
					oTable.fnDeleteRow( anSelected[0] );					
				}
				else
				{
					$('#report-error').html( data.error_message ).slideUp('fast').slideDown('slow');						
					$('#report-success').html('').slideUp('fast');						
					
				}
			}
		});
	}
	
	return false;
}

function fnGetSelected( oTableLocal )
{
	var aReturn = new Array();
	var aTrs = oTableLocal.fnGetNodes();
	
	for ( var i=0 ; i<aTrs.length ; i++ )
	{
		if ( $(aTrs[i]).hasClass('row_selected') )
		{
			aReturn.push( aTrs[i] );
		}
	}
	return aReturn;
}