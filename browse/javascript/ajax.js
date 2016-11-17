/////////function to filter the list according to the users needs///////////////
function remove_error()
{
  document.getElementById('filter_error').style.display = "none";
}

function clear_refresh()
{
  clear_filter();
  location.reload();
}

function clear_filter()
{
  sessionStorage.removeItem('param');
}

function filter_list(data)
{
  var age_opt_to = document.getElementById('upto');
  var age_opt_from = document.getElementById('from');
  var to_selected_age = age_opt_to.options[age_opt_to.selectedIndex].text;
  var from_selected_age = age_opt_from.options[age_opt_from.selectedIndex].text;
  var xhr = new XMLHttpRequest();
  if (to_selected_age < from_selected_age)
  {
    document.getElementById('filter_error').style.display = "inline";
    document.getElementById('filter_error').style.marginTop = "8%";
    document.getElementById('error-label').innerHTML = "ERROR!";
    return;
  }
  if (sessionStorage.getItem('param') != null)
  {
    var param = sessionStorage.getItem('param');
  }
  else
  {
    var param = "submit=post&min_age="+from_selected_age+"&max_age="+to_selected_age;
    sessionStorage.setItem('param', param);
  }
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
        location.reload();
        ///////////////adding the best-match list to best-match-profile div/////
      }
      else {
        console.log(xhr.responseText);
      }
    }
  };
  xhr.send(param);
}

/////////////////////////////////function to refresh the suggested list ////////
function refreshList(suggest)
{
  var i = 0;
  var j = 0;
  while (j < 3)
  {
    document.getElementById('user_link_'+j).innerHTML = suggest[i].firstname;
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
      document.getElementById('user_link_'+j).innerHTML = suggest[i].firstname;
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

//////function to get the suggested users for a logged in usr///////////////////
function loadSuggestions()
{

  var xhr = new XMLHttpRequest();
  var param = "min_age=min&max_age=max";
  if (sessionStorage.getItem('param'))
  {
    param = sessionStorage.getItem('param');
    var res = param.split("&");
    res = res[1].split("=")[1];
    document.getElementById('default_min').innerHTML = res;
    var res = param.split("&");
    res = res[2].split("=")[1];
    document.getElementById('default_max').innerHTML = res;
    document.getElementById('clear_filter').style.opacity = "1";
    document.getElementById('clear_filter').style.pointerEvents = "all";
  }
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
        var k = 0;
        list = JSON.parse(xhr.responseText);
        while (i < 3) {
          var s_list = document.createElement('div');
          var user_link = document.createElement('a');
          s_list.setAttribute('class', "suggested-profile");
          s_list.setAttribute('id', "sugg_id_"+i);
          user_link.setAttribute('href', "#");
          user_link.setAttribute('id', "user_link_"+i);
          s_list.appendChild(user_link);
          right_content.appendChild(s_list);
          i++;
        }
        if (list.suggest != undefined)
        {
          refreshList(list.suggest);
        }
        ///////////////adding the best-match list to best-match-profile div///////////////////////
        if (list.match != undefined)
        {
          var i = 0;
          while (list.match[i]) {
            var b_list = document.createElement('div');
            var user_link = document.createElement('a');
            b_list.setAttribute('class', "best-match-profile");
            user_link.setAttribute('href', "#");
            b_list.setAttribute('id', "best_id_"+i);
            user_link.innerHTML = list.match[i].firstname;
            b_list.appendChild(user_link);
            best_content.appendChild(b_list);
            i++;
          }
          //console.log(xhr.responseText);
        }
      }
      else {
        console.log(xhr.responseText);
      }
    }
  };
  xhr.send(param);
}