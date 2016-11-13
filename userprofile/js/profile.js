var images = [];
$(document).ready(function()
{
	var pages = ["photos","update","likes","fame"];
	var initProfile = [];

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
		//console.log(data);
		//$("#userImagesDisplay");
		data = JSON.parse(data);
		images = data;
		//console.log(data);
		if (data.length > 0)
		{
			for (var i = 0; i < data.length; i++) {
				var param = data[i].id;
				$("#userImagesDisplay").append("<div>"+
				"<img class='pic' src='"+data[i].url+"'/>"
				+"<button onclick='makeprofile("+i+")'>Make profile</button></div>");
			}
		}
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
	$.get("php/profile.php?action=userProfile", function(data)
	{
		initProfile = JSON.parse(data);
		/////////////////SET INTITIAL VALUES FOR THE USER profile
		if (initProfile.length > 0)
		{
			console.log(initProfile);
			$("#age").val(initProfile[0].age);
			$("#gender").val(initProfile[0].gender);
			$("#lookingFor").val(initProfile[0].sexual_preference);
			$("#beginAge").val(initProfile[0].agefrom);
			$("#toAge").val(initProfile[0].toage);
			$("#preferences").val(initProfile[0].interests);
			$("#biography").val(initProfile[0].biography);
			$("#profile_picture").attr("src",initProfile[0].profile_picture);
			//$("#").val(initProfile[0].);
		}
	})


	//////////////////// GET USER LIKES /////////////
	$.get("php/profile.php?action=getUserLikes", function(data)
	{
		var userLikes = JSON.parse(data);
		/////////////////SET INTITIAL VALUES FOR THE USER profile
		if (userLikes.length > 0)
		{
			for (var i = 0; i < userLikes.length; i++) {
				console.log(userLikes[i].username);
				var div = "<div class='card'> <h3 id='likeName'>"+userLikes[i].username+" </h3></div>";
				$("#userLikes").append(div);
			}
		}
	})


		/*$.get("http://ipinfo.io", function (response) {
		    //$("#ip").html("IP: " + response.ip);
		    //$("#address").html("Location: " + response.city + ", " + response.region);
		    //$("#details").html(JSON.stringify(response, null, 4));
				console.log("IP: " + response.ip);
				console.log("Location "+response.city);

				console.log(response);
				//alert("Share your location : "+response.city + response.loc);
				var x;
		    if (confirm("Share your location! \n"+response.loc) == true) {
		        //x = "You pressed OK!";
		    } else {
		      //  x = "You pressed Cancel!";
		    }
		}, "jsonp");
		*/


});

var makeprofile = function(index)
{
	//alert(picId+ " "+images[0].url);
	$.get("php/profile.php?action=chooseProfile&picture="+images[index].url, function(data)
	{
		initProfile = JSON.parse(data);
		/////////////////SET INTITIAL VALUES FOR THE USER profile
		if (initProfile.length > 0)
		{
			console.log(initProfile);
			$("#age").val(initProfile[0].age);
			$("#gender").val(initProfile[0].gender);
			$("#lookingFor").val(initProfile[0].sexual_preference);
			$("#beginAge").val(initProfile[0].agefrom);
			$("#toAge").val(initProfile[0].toage);
			$("#preferences").val(initProfile[0].interests);
			$("#biography").val(initProfile[0].biography);
			//$("#").val(initProfile[0].);
		}
	})

}
