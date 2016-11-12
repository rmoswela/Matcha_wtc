function age_options()
{
  var i = 19;
  var filter = document.getElementsByClassName('age-filter');
  while (i < 100)
  {
    var opt1_filter = document.createElement('option');
    var opt2_filter = document.createElement('option');
    opt1_filter.innerHTML = i;
    opt2_filter.innerHTML = i;
    filter[0].appendChild(opt1_filter);
    filter[1].appendChild(opt2_filter);
    i++;
  }
};
age_options();
