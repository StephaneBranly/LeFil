function update_preview(){
    let form = document.getElementById('contenu');
    let preview_section = document.getElementById("article_content");
    preview_section.innerHTML = convert_article(form.value);
}

function toggle_section(id){
    let section = document.getElementById("section"+id);
    let icon_title = document.getElementById("section"+id+"_icon");
    if(section.hidden==true)
    {
        section.hidden=false;
        icon_title.classList.remove('closed');
    }
    else 
    {
        section.hidden=true;
        icon_title.classList.add('closed');
    }
}