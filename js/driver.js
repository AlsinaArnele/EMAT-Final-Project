function updateTime() {
  var date = new Date(); 
  var hours = date.getHours();

  if (hours <= 11) {
    hours = 11;
  }
  else if (hours > 11 && hours < 2) {
    hours = 2;
  }
  else{
    hours = 5;
  }


  document.getElementById("UpdateTime").innerHTML = hours;
}
updateTime();