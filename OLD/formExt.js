$('document').ready(function(){
	alert("hi");	
	if ($('input[name=sendAPI]:checked').val() == "lob")
	{
		$('#lob_extra_data').show('fast');
	}
	else
	{
		$('#lob_extra_data').hide('fast');
	}

});