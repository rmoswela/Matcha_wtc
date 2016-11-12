$(document).ready(function()
{
	var pages = ["photos","update","likes","fame"];
	var initProfile = [];

	$.get("php/profile.php?action=userProfile", function(data)
	{
		//initProfile = JSON.parse(data);
		console.log(data);
	})


	for (var i = 0; i < pages.length; i++) {

		var btn = "#"+pages[i]+"Button";
		var page = pages[i];
		$(btn).click(function()
		{

			var button_id = $(this).attr("id");
			var len = button_id.length;
			var sub = len - 6;
			page = (button_id.substring(0, sub));

			$(".page").removeClass("visible");
			$("#"+page).addClass("visible");

		});
	}


	/*************************** GET DATA FOR THE PAGE **************************/
	$.get("php/profile.php?action=getUserImages", function(data)
	{
		/*$("#userImagesDisplay");
		data = JSON.parse(data);
		console.log(data);
		for (var i = 0; i < data.length; i++) {
			$("#userImagesDisplay").append("<img src='"+data[i].url+"'/>");
		}*/
		//var ar = JSON.parse(data);
		//console.log(ar);
	})
	//Create a list of age groups
	var ageOptions = $("#age");
	for (var i = 19; i < 100; i++) {
		var o = new Option(i, i);
		var o1 = new Option(i, i);
		var o2 = new Option(i, i);
		$(o).html(i);
		$("#age").append(o);
		$("#beginAge").append(o1);
		$("#toAge").append(o2);
	}


	$("#photosForm").submit(function(event)
	{
		var $fileUpload = $("input[type='file']");
		event.preventDefault();
		if (parseInt($fileUpload.get(0).files.length)>2){
		    alert("You can only upload a maximum of 2 files");
        }
        else
        {
        		var url=$(this).attr("action");
						alert(url);
		    		$.post({
				        url: url,
				        type: $(this).attr("method"),
				        //dataType: "JSON",
				        data: new FormData(this),
				        processData: false,
				        contentType: false,
				        success: function (data, status)
				        {
				        	alert(data);
				        },
				        error: function (xhr, desc, err)
				        {
				        	alert(err.message)
				        }
				    });
        }
	})


	$("#photo-upload-div").hide(100);
	$("#showUpload").click(function()
	{
		$("#photo-upload-div").toggle("slow");
	})


	//////////////////////// SUBMIT PHOTOS FORM /////////////////////////////////
	$("#profileForm").submit(function(event)
	{
		var formData = $(this).serialize();

		var $fileUpload = $("input[type='file']");
		event.preventDefault();
		// if (parseInt($fileUpload.get(0).files.length)>2){
		//     alert("You can only upload a maximum of 2 files");
    //     }
    //     else
    //     {
         		var url=$(this).attr("action");
		    		$.post({
				        url: url,
				        type: $(this).attr("method"),
				        //dataType: "JSON",
				        data: new FormData(this),
				        processData: false,
				        contentType: false,
				        success: function (data, status)
				        {
				        	alert(data);
				        },
				        error: function (xhr, desc, err)
				        {
				        	alert(err.message)
				        }
				    });
      //  }
	})

	//////////////////////////////////////////////////////////////////////////////



});
