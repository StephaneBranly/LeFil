function change_article(id_article,num=null){
    let old_tab = document.getElementById(active_article);
    let new_tab = document.getElementById(id_article);
    let article_content = document.getElementById('right_side');

    old_tab.classList.remove('active');
    new_tab.classList.add('active');
    active_article = id_article;
    if(num)
    {
      changeArticleContent(num,article_content);
    }
    else
      article_content.innerHTML = "<img src='"+image_file+"'/>";
}

function changeArticleContent(id_article,div) {
  var xhr = new XMLHttpRequest();
  url =
    "../components/services/get_article_content.php?id-article=" + id_article;
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4) {
      new_content = readBody(xhr);
      div.innerHTML = convert_article(new_content);
     
    }
  };
  xhr.open("GET", url);
  xhr.send("");
}


