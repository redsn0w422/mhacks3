function sendPicUrl()
{
	var arr = $(".checkbox");
	var url_arr = new Array();
	for (i = 0; i < arr.length; i++)
	{
		console.log(arr[i]);
		console.log(arr[i].value);
		url_arr.push(arr[i].value);
	}
	console.log(url_arr.toString());
	var data = "{\"transaction\":\"photoCheckoutv2\",";
	data += "\"apikey\":\"a61e8e47ca83e86a2b8c705899ae9f6d\",";
	data += "\"devinf\":\"Chrome,32.0.1700.76\",";
	data += "\"act\":\"mweb5UrlV2\",";
	data += "\"view\":\"mweb5UrlV2JSON\",";
	data += "\"affId\":\"hackathon\",";
	data += "\"appver\":\"1.0\",";
	data += "\"images\":[";
	for (i = 0; i < url_arr.length; i++)
	{
		data += "\"" + url_arr + "\","
	}
	data += "],";
	data += "}";

	$.post("quickprint_landing.php", data);
}
