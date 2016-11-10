function loadSuggestions()
{
  var xhr = new XMLHttpRequest();
  var param = "name=zamani&page=index.php";

  xhr.open("POST", "handler/match.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function()
  {
    var i = 0;
    var list = "";
    var right_content = document.getElementById('right-content');
    if (xhr.readyState == XMLHttpRequest.DONE)
    {
      if (xhr.status == 200)
      {
        list = JSON.parse(xhr.responseText);
        while (list[i]) {
          var child_div = document.createElement('div');
          child_div.setAttribute('class', "profile-match");
          child_div.innerHTML = list[i][3];
          right_content.appendChild(child_div);
          console.log("females 200: "+ list[i][3]);
          i++;
        }
        console.log(xhr.responseText);
      }
      else {
        console.log(xhr.responseText);
      }
    }
  };
  xhr.send(param);
}
