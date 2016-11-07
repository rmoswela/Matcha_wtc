document.querySelector('#inter').addEventListener('click', function ()
{
  document.getElementById('sexual').style.display = "none";
  document.getElementById('biography').style.display = "none";
  document.getElementById('interests').style.display = "inline";
});
document.querySelector('#sex').addEventListener('click', function ()
{
  document.getElementById('interests').style.display = "none";
  document.getElementById('biography').style.display = "none";
  document.getElementById('sexual').style.display = "inline";
});
document.querySelector('#bio').addEventListener('click', function ()
{
  document.getElementById('sexual').style.display = "none";
  document.getElementById('interests').style.display = "none";
  document.getElementById('biography').style.display = "inline";
});
