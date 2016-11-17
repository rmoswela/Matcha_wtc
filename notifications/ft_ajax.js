/*hold instance of the xmlHttpRequest*/
var xmlHttp = createXmlHttpRequestObject();

/*create an instance of the xmlHttpRequest*/
function createXmlHttpRequestObject()
{
	var xmlHttp;

	try{
		/*creation of xmlHttp object by native browsers*/
		xmlHttp = new XMLHttpRequest();
	}
	catch(e)
	{
		try{
			/*creation of xmlHttp object by explorer*/
			xmlHttp = new ActiveXObject("Microsoft.XMLHttp");
		}
		catch(e)
		{
			//ignore
		}
	}
	if (!xmlHttp)
	{
		alert("Error creating an xmlHttpRequest object!");
	}
	else
		return xmlHttp;
}

/*performs server resquests and calls a function to handle server response*/
function process()
{
	/*continue if valid xmlHttp object*/
	if (xmlHttp)
	{
		/*try connect to server*/
		try{
			/*script that handles notifications for views, likes, unlikes and msgs*/
			xmlHttp.open("GET", "//php script to handle server queries", true);
			xmlHttp.onreadystatechange = handleRequestStateChange;
			xmlHttp.send(null);
		}
		catch(e)
		{
			alert("can't connect to server: \n" + e.toString());
		}
	}
}

/*executed when the state of the server request changes from 0-uninitialize to 4-complete*/
function handleRequestStateChange()
{
	/*obtain reference to html div element to perform changes*/
	myDiv = document.getElementById("//element id");

	/*4 represents a complete state, meaning the server has responded*/
	if (xmlHttp.readyState == 4)
	{
		/*continue if the http status is ok==200*/
		if (xmlHttp.status == 200)
		{
			try{
			/*retrieve the response*/
			response = xmlHttp.responseText;
			/*utilize server response*/
			handleServerResponse();
			/*wait for 7sec after executing then query the server script again*/
			setTimeout('process()', 7000);
			}
			catch(e)
			{
				alert("Error reading the response: \n" + e.toString());
			}
		}
		else
			alert("There was a problem retrieving the data: \n" + xmlHttp.statusText);
	}
}

/*manipulate data that you get from the server script*/
function handleServerRequest()
{
	//send data to the div or html element for notifications
}
