/////////function to filter the list according to the users needs///////////////
function filter_list()
{
  alert("clicked");
  var age_opt_to = document.getElementById('upto');
  var age_opt_from = document.getElementById('from');
  var to_selected_age = age_opt_to.options[age_opt_to.selectedIndex].text;
  var from_selected_age = age_opt_from.options[age_opt_from.selectedIndex].text;
  var post_data = "min_age="+from_selected_age+"&max_age="+to_selected_age;
  return (post_data);
  console.log(from_selected_age+"\n"+to_selected_age);
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
var data_post = filter_list();
function loadSuggestions(data_post)
{

  var xhr = new XMLHttpRequest();
  var param = data_post;

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