/////////////////////////////////function to refresh the suggested list /////////////////////////////////////////
function refreshList(suggest)
{
  var i = 0;
  var j = 0;
  while (j < 3)
  {
    document.getElementById('sugg_id_'+j).innerHTML = suggest[i].firstname;
    i++;
    j++;
    if (!suggest[i])
    {
      i = 0;
      console.log("reset i to zero");
    }
  }
  j = 0;
  setInterval(function ()
  {
    while (j < 3)
    {
      document.getElementById('sugg_id_'+j).innerHTML = suggest[i].firstname;
      i++;
      j++;
      if (!suggest[i])
      {
        i = 0;
        console.log("reset i to zero");
      }
    }
    j = 0;
  }, 60000);
}

///////////////////////////// function to get the suggested users for a logged in usr////////////////////////////////
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
    var best_content = document.getElementById('best-match');
    if (xhr.readyState == XMLHttpRequest.DONE)
    {
      if (xhr.status == 200)
      {
        list = JSON.parse(xhr.responseText);

        while (i < 3) {
          var s_list = document.createElement('div');
          s_list.setAttribute('class', "suggested-profile");
          s_list.setAttribute('id', "sugg_id_"+i);
          right_content.appendChild(s_list);
          i++;
        }
        console.log(list.suggest);
        if (list.suggest != undefined)
        {
          refreshList(list.suggest);
        }
        if (list.match != undefined)
        {
          console.log(list.match[0][1]);
          var i = 0;
          while (list.match[i]) {
            var b_list = document.createElement('div');
            b_list.setAttribute('class', "best-match-profile");
            b_list.setAttribute('id', "best_id_"+i);
            b_list.innerHTML = list.match[i].firstname;
            best_content.appendChild(b_list);
            i++;
          }
          console.log(i);
        }
      }
      else {
        console.log(xhr.responseText);
      }
    }
  };
  xhr.send(param);
}
