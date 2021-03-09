var active_tab_profile_user = "mes-articles";

function change_article_tab_profile_user(id_tab){
    let old_tab = document.getElementById(active_tab_profile_user);
    let new_tab = document.getElementById(id_tab);
    let old_tab_content = document.getElementById('content_'+active_tab_profile_user);
    let new_tab_content = document.getElementById('content_'+id_tab);

    old_tab.classList.remove('active');
    new_tab.classList.add('active');
    old_tab_content.style.display = "none"; 
    new_tab_content.style.display = "inline-block"; 
    active_tab_profile_user = id_tab;
}
