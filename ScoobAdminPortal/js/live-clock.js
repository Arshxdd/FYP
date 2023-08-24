function updateTime() {
  var today = new Date();
  var date = today.toLocaleDateString();
  var time = today.toLocaleTimeString();
  document.getElementById('current-time').innerHTML = date + ' ' + time;
}

setInterval(updateTime, 1000);
