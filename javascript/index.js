function age_options()
{
  var i = 19;
  var sort = document.getElementsByClassName('age-sort');
  var filter = document.getElementsByClassName('age-filter');
  console.log(select);
  while (i < 100)
  {
    var opt1_filter = document.createElement('option');
    var opt2_filter = document.createElement('option');
    option1.innerHTML = i;
    option2.innerHTML = i;
    filter[0].appendChild(option1);
    filter[1].appendChild(option2);
    i++;
  }
};

age_options();
