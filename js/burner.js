function getHTTPObject(){
   if (window.ActiveXObject) 
       return new ActiveXObject("Microsoft.XMLHTTP");
   else if (window.XMLHttpRequest) 
       return new XMLHttpRequest();
   else {
      alert("Your browser does not support AJAX.");
      return null;
   }
}

function updateDiv( new_text ){
  if ( new_text ){
    document.getElementById('form').style.display = 'none';
    document.getElementById('display').innerHTML = new_text;
    document.getElementById('display').style.display = 'block';
  } else {
    document.getElementById('form').style.display = 'block';
    document.getElementById('display').style.display = 'none';
  }
}
function showForm() {

  document.getElementById('form').style.display = 'block';
  document.getElementById('display').style.display = 'none';

}

function showUrlBox( link_id ) {
  document.getElementById('url-box').style.display = 'block';
  document.getElementById('form').style.display = 'none';
  document.getElementById('url-form').value = "http://jessekeane.me/imf/?x=" + link_id;
  return;
}
function showMessage( message_id ){
	var send_id = encodeURIComponent(message_id);
    httpObject = getHTTPObject();
    if (httpObject != null) {
        httpObject.open("GET", "read.php?id="+send_id, true);
        httpObject.send(null);
        httpObject.onreadystatechange = function() {
        	if ( httpObject.readyState == 4 ) {
        		updateDiv(httpObject.responseText);
        	}
        }
    }
}
function submitForm(){
  var message = document.forms["main_form"]["message"].value;
  var exp_time = document.forms["main_form"]["exp_time"].value;
  var select_box = document.forms["main_form"]["exp_value"];
  var exp_value = select_box.options[select_box.selectedIndex].value;
  var sendmessage = encodeURIComponent(message);
  var params = "message=" + message + "&exp_time=" + exp_time + "&exp_value=" + exp_value;
    httpObject = getHTTPObject();
    if (httpObject != null) {
        httpObject.open("GET", "write.php?"+params, true);
        httpObject.send(null);
        httpObject.onreadystatechange = function() {
          if ( httpObject.readyState == 4 ) {
            showUrlBox(httpObject.responseText);
            showMessage(httpObject.responseText);
          }
        }
    }
}