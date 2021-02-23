function convert_article(contenu){
    var notebaspage = 0,
    baspage = "";
    if(contenu.search("'>")==0){
        contenu = contenu.replace("'>","<p class=\"quote\">");
    }
    else if(contenu.search("t>")==0){
        contenu = contenu.replace("t>","<h5>");
    }
    else if(contenu.search(".>")!=0){
        contenu = "<p>" + contenu;
    }
    contenu = contenu.replace(/\*\/>/gi,"<strong><em>");
    contenu = contenu.replace(/\/>/gi,"<em>");
    contenu = contenu.replace(/<\//gi,"</em>");
    contenu = contenu.replace(/<\*\//gi,"</em></strong>");
    contenu = contenu.replace(/\*>/gi,"<strong>");
    contenu = contenu.replace(/<\*/gi,"</strong>");

    contenu = contenu.replace(/b>/gi,"<span style=\"text-decoration:line-through;\">");
    contenu = contenu.replace(/<b/gi,"</span>");

    contenu = contenu.replace(/{/gi,"</p><hr/><section class=\"p-0 pl-4\"><p>");
    contenu = contenu.replace(/}/gi,"</p></section><p>");

    contenu = contenu.replace(/!>small<size/gi,"<img class=\"img small\" src=\"");
    contenu = contenu.replace(/!> small <size/gi,"<img class=\"img small\" src=\"");
    contenu = contenu.replace(/!>small <size/gi,"<img class=\"img small\" src=\"");
    contenu = contenu.replace(/!> small<size/gi,"<img class=\"img small\" src=\"");
    
    contenu = contenu.replace(/!>big<size/gi,"<img class=\"img big\" src=\"");
    contenu = contenu.replace(/!> big <size/gi,"<img class=\"img big\" src=\"");
    contenu = contenu.replace(/!>big <size/gi,"<img class=\"img big\" src=\"");
    contenu = contenu.replace(/!> big<size/gi,"<img class=\"img big\" src=\"");
    
    contenu = contenu.replace(/!>medium<size/gi,"<img class=\"img medium\" src=\"");
    contenu = contenu.replace(/!> medium <size/gi,"<img class=\"img medium\" src=\"");
    contenu = contenu.replace(/!>medium <size/gi,"<img class=\"img medium\" src=\"");
    contenu = contenu.replace(/!> medium<size/gi,"<img class=\"img medium\" src=\"");
    
    contenu = contenu.replace(/!>/gi,"<img class=\"img\" src=\"");
    
    contenu = contenu.replace(/<!/gi,"\" alt=\"image non disponible\"/>");

    contenu = contenu.replace(/\%>/gi,"<div class=\"row justify-content-center\"><audio controls><source src=\"");
    contenu = contenu.replace(/by>/gi,"\">Votre navigateur ne supporte pas la lecture audio.</audio></div><div class=\"text-center\"> Source : ");
    contenu = contenu.replace(/<\%/gi,"</div>");

    var p = contenu.search(/\^>/);
    while(p>=0){
        var note = contenu.substr(p+2,contenu.search(/<\^/)-p-2);
        notebaspage++;
        contenu = contenu.replace("^>"+note+"<^"," <a style=\"font-size:60%;vertical-align:super;\" href=\"#note_"+notebaspage+"\"> ["+notebaspage+"] </a>");
        baspage += "\nsmp;note_"+notebaspage+"\">["+notebaspage+"] "+note;
        p = contenu.search(/\^>/);
    }

    contenu += baspage;

    p = contenu.search(/#definir /);
    while(p>=0){
        var prepro = contenu.substr(p+9,contenu.search(/###/)-p-9);
        contenu = contenu.replace("#definir "+prepro+"###","");
        var p2;
        if((p2 = prepro.search(/police /))>=0){
            var police = prepro.substr(p2+7);
            view.style.fontFamily = "'"+police+"'";
        }
        else if((p2 = prepro.search(/couleur /))>=0){
            var couleur = prepro.substr(p2+8);
            view.className += " c-"+couleur;
        }
        p = contenu.search(/#definir /);
    }
    contenu = contenu.replace(/<'\nsmp;/g,"</p><p style=\"font-size:60%\" class=\"my-0\" id=\"");
    contenu = contenu.replace(/<t\nsmp;/g,"</h5><p style=\"font-size:60%\" class=\"my-0\" id=\"");
    contenu = contenu.replace(/\nsmp;/g,"</p><p style=\"font-size:60%\" class=\"my-0\" id=\"");
    contenu = contenu.replace(/c>  /gi,"<span class=\"c-");
    contenu = contenu.replace(/c> /gi,"<span class=\"c-");
    contenu = contenu.replace(/c>/gi,"<span class=\"c-");
    contenu = contenu.replace(/<#/gi,"\">");
    contenu = contenu.replace(/<c/gi,"</span>");

    contenu = contenu.replace(/l>/gi,"<a href=\"");
    contenu = contenu.replace(/<:>/gi,"\">");
    contenu = contenu.replace(/<l/gi,"</a>");
    contenu = contenu.replace(/\n\'>/gi,"</p><p class=\"quote\">");
    contenu = contenu.replace(/<\'\n/gi,"</p><p>");
    contenu = contenu.replace(/t>/gi,"</p><h5>");
    contenu = contenu.replace(/<t/gi,"</h5><p>");
    contenu = contenu.replace(/\'>/gi,"<span class=\"quote\">");
    contenu = contenu.replace(/<\'/gi,"</span>");
    contenu = contenu.replace(/\.>\n/gi,"</p><ul><li>");
    contenu = contenu.replace(/\.>/gi,"</p><ul><li>");

    contenu = contenu.replace(/\.1>\n/gi,"</p><ol><li>");
    contenu = contenu.replace(/\.1>/gi,"</p><ol><li>");

    contenu = contenu.replace(/\n<;\n/gi,"</li><li>");
    contenu = contenu.replace(/<;\n/gi,"</li><li>");
    contenu = contenu.replace(/\n<;/gi,"</li><li>");
    contenu = contenu.replace(/<;/gi,"</li><li>");

    contenu = contenu.replace(/\n<\.1/gi,"</li></ol><p>");
    contenu = contenu.replace(/<\.1/gi,"</li></ol><p>");

    contenu = contenu.replace(/\n<\./gi,"</li></ul><p>");
    contenu = contenu.replace(/<\./gi,"</li></ul><p>");
    contenu = contenu.replace(/\n/gi,"</p><p>");
    contenu = contenu.replace(/&/gi,"ₔ");
    contenu += "</p>";
    contenu = contenu.replace(/<p><\/p>/gi,"");

    return contenu;
}