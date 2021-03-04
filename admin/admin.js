function preview_email(type) {
  if(type == "news")
  {
    var form = document.getElementById("content_email");
    var value = form.value;
  }
  else var value = ""
  url = "../admin/preview_email?content=" + value + "&t=" + type;
  window.open(url, "_blank");
}
