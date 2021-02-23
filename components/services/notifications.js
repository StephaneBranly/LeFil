function write_notification(icon, content, tmp) {
  var section_notifs = document.getElementById("notifications");
  var actual_content = section_notifs.innerHTML;
  unique_id = Date.now();
  section_notifs.innerHTML =
    '<div onclick="remove_notification(' +
    unique_id +
    ");\" class='notification entrance' id='notification_" +
    unique_id +
    "'><i class='" +
    icon +
    "'></i><p>" +
    content +
    "</p></div>" +
    actual_content;
  setTimeout("remove_tag(" + unique_id + ");", 800);
  if (tmp) {
    setTimeout("remove_notification(" + unique_id + ");", tmp);
  }
}

function remove_notification(id) {
  real_id = "notification_" + id;
  var notification = document.getElementById(real_id);
  notification.classList.add("delete");
  notification.parentNode.removeChild(notification)
}

function remove_tag(id){
  real_id = "notification_" + id;
  var notification = document.getElementById(real_id);
  notification.classList.remove("entrance");
}
