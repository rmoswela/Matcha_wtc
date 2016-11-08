document.querySelector('#res').addEventListener('click', function ()
{
  var xhr = new XMLHttpRequest();
  var param = "name=zamani&page=index.php";

  xhr.open("POST", "handler/match.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function()
  {
    var list = "";
    if (xhr.readyState == XMLHttpRequest.DONE)
    {
      if (xhr.status == 200)
      {
        list = JSON.parse(xhr.responseText);
        console.log("status 200: "+ list);
      }
      else {
        console.log(xhr.responseText);
      }
    }
  };
  xhr.send(param);
});
