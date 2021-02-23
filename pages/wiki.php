<?php include_once("../lib/start_session.php");?>
<?php include_once("../lib/document_base.php");?>
<!DOCTYPE html>
<html>
	<link href="../ressources/design/body.css" rel="stylesheet" media="all" type="text/css">
	<link rel="icon" href="../ressources/images/favicon.ico" type="image/x-icon"/>
    <head>
        <?php
            // TODO : TO DISCUSS ABOUT ANALYTICS include_once("../lib/google_analytics.php");
            $nom_page='Numéros';
            // TODO : ADD DESCRIPTION HERE
            $description_page="TODO";
            include_once("../lib/meta.php");
        ?>
        <meta charset="UTF-8">
        <meta property='og:image'  content='https://assos.utc.fr/lefil/ressources/images/logo.png'/>
	</head>
    <?php include_once("../components/components_include.php");?>
	<body>
		<?php $_SESSION['last_uri'] = $_SERVER['REQUEST_URI'];?>
		<nav class="sticked container pt-1 pb-2 mb-4"> <!-- Bandeau de navigation -->
			<div class="row ">
				<div class="col-sm-6 justify-content-center px-0">
					<div class="navbar justify-content-around text-center px-0">
						<a class="text-center link-head-nav" href="../calendrier/">Calendrier & Débats</a>
						<a class="text-center link-head-nav" href="../articles/">Articles</a>
						<a class="text-center link-head-nav" href="../bop_s/">BOP's</a>
					</div>
				</div>
				<div class="col-sm-6 justify-content-center px-0">
					<div class="navbar justify-content-around text-center px-0">
						<a class="text-center link-head-nav" href="../spotted/">Spotted</a>
						<a class="text-center link-head-nav" href="../concours/">Concours Fil-Cid</a>
						<a class="text-center link-head-nav" href="../association/">Page des Assos</a>
					</div>
				</div>
			</div>
		</nav>

		<main class="container"> <!-- Contenu de la page-->
			<section class="row">
				<section class="col-sm-4 border rounded-left-top p-4" style="height:max-content">
					<ol type="I">
						<li><a href="#edition_texte">L'Édition de texte</a>
							<ol type="1">
								<li><a href="#police">La Police</a>
									<ol type="a">
										<li><a href="#gras">Le Gras</a></li>
										<li><a href="#italique">L'Italique</a></li>
										<li><a href="#grasitalique">Le Gras et l'Italique</a></li>
										<li><a href="#barre">Le Barré</a></li>
									</ol>
								</li>
								<li><a href="#paragraphe">Le Paragraphe</a>
									<ol type="a">
										<li><a href="#paragrapheclassique">Le Paragraphe classique</a></li>
										<li><a href="#citationcourte">La Citation courte</a></li>
										<li><a href="#citation">La Citation longue</a></li>
									</ol>
								</li>
								<li><a href="#miseenforme">La Mise en forme</a>
									<ol type="a">
										<li><a href="#titre">Le Titre</a></li>
										<li><a href="#liste">La Liste</a></li>
										<li><a href="#note">La Note</a></li>
										<li><a href="#image">L'Image</a></li>
										<li><a href="#podacast">Le Podcast</a></li>
										<li><a href="#hyperlien">L'Hyperlien</a></li>
									</ol>
								</li>
							</ol>
						</li>
					</ol>
				</section>
				<section class="col-sm-8">
					<h3 id="edition_texte">L'Édition de texte<a class="float-right" style="font-size:smaller;" onclick="close_sec('edition_texte')">▲</a></h3>
					<hr/>
					<article class="wiki" id="s_edition_texte">
						<p>Cette partie du wiki a pour but d'aider les auteurs à prendre en main l'éditeur de texte de la page <em><a href="../nouveau/">assos.utc.fr/lefil/nouveau/</a></em>. Il ne s'agit ni d'un tutoriel, ni d'un cours, mais plutôt d'exemples permettant de comprendre la syntaxe des outils disponibles.</p>
					</article>

					<h4 id="police">La Police</h4>
					<hr/>

					<h5 id="gras">Le Gras<a class="float-right" style="font-size:smaller;" onclick="close_sec('gras')">▲</a></h5>
					<hr/>
					<article class="wiki" id="s_gras">
						<p>Il est possible de mettre la police en gras en utilisant la balise <span class="balise">*&gt;</span>texte<span class="balise">&lt;*</span> :</p>
						<div class="row">
							<div class="col-sm-6 example">
								<p>Tous les êtres humains naissent <strong>libres</strong> et <strong>égaux</strong> en dignité et en droits. Ils sont <strong>doués de raison et de conscience</strong> et doivent agir les uns envers les autres dans un <strong>esprit de fraternité</strong>.</p>
							</div>
							<div class="col-sm-6">
								Tous les êtres humains naissent <span class="balise">*&gt;</span>libres<span class="balise">&lt;*</span> et <span class="balise">*&gt;</span>égaux<span class="balise">&lt;*</span> en dignité et en droits. Ils sont <span class="balise">*&gt;</span>doués de raison et de conscience<span class="balise">&lt;*</span> et doivent agir les uns envers les autres dans un <span class="balise">*&gt;</span>esprit de fraternité<span class="balise">&lt;*</span>.
							</div>
						</div>
					</article>

					<h5 id="italique">L'Italique<a class="float-right" style="font-size:smaller;" onclick="close_sec('italique')">▲</a></h5>
					<hr/>
					<article class="wiki" id="s_italique">
						<p>Il est aussi possible de mettre la police en italique en utilisant la balise <span class="balise">/&gt;</span>texte<span class="balise">&lt;/</span> :</p>
						<div class="row">
							<div class="col-sm-6 example">
								<p>Tous les êtres humains naissent <em>libres</em> et <em>égaux</em> en dignité et en droits. Ils sont <em>doués de raison et de conscience</em> et doivent agir les uns envers les autres dans un <em>esprit de fraternité</em>.</p>
							</div>
							<div class="col-sm-6">
								Tous les êtres humains naissent <span class="balise">/&gt;</span>libres<span class="balise">&lt;/</span> et <span class="balise">/&gt;</span>égaux<span class="balise">&lt;/</span> en dignité et en droits. Ils sont <span class="balise">/&gt;</span>doués de raison et de conscience<span class="balise">&lt;/</span> et doivent agir les uns envers les autres dans un <span class="balise">/&gt;</span>esprit de fraternité<span class="balise">&lt;/</span>.
							</div>
						</div>
					</article>

					<h5 id="grasitalique">Le Gras et L'Italique<a class="float-right" style="font-size:smaller;" onclick="close_sec('grasitalique')">▲</a></h5>
					<hr/>
					<article class="wiki" id="s_grasitalique">
						<p>Il est possible de combiner directement les deux formats en utilisant la balise <span class="balise">*/&gt;</span>texte<span class="balise">&lt;*/</span> :</p>
						<div class="row">
							<div class="col-sm-6 example">
								<p>Tous les êtres humains naissent <strong><em>libres</em></strong> et <strong><em>égaux</em></strong> en dignité et en droits. Ils sont <strong><em>doués de raison et de conscience</em></strong> et doivent agir les uns envers les autres dans un <strong><em>esprit de fraternité</em></strong>.</p>
							</div>
							<div class="col-sm-6">
								Tous les êtres humains naissent <span class="balise">*/&gt;</span>libres<span class="balise">&lt;*/</span> et <span class="balise">*/&gt;</span>égaux<span class="balise">&lt;*/</span> en dignité et en droits. Ils sont <span class="balise">*/&gt;</span>doués de raison et de conscience<span class="balise">&lt;*/</span> et doivent agir les uns envers les autres dans un <span class="balise">*/&gt;</span>esprit de fraternité<span class="balise">&lt;*/</span>.
							</div>
						</div>
					</article>

					<h5 id="barre">Le Barré<a class="float-right" style="font-size:smaller;" onclick="close_sec('barre')">▲</a></h5>
					<hr/>
					<article class="wiki" id="s_barre">
						<p>Autre feature : le barré avec la balise <span class="balise">b&gt;</span>texte<span class="balise">&lt;b</span> :</p>
						<div class="row">
							<div class="col-sm-6 example">
								<p>Tous les êtres humains naissent <span style="text-decoration: line-through">libres</span> et <span style="text-decoration: line-through">égaux</span> en dignité et en droits. Ils sont <span style="text-decoration: line-through">doués de raison et de conscience</span> et doivent agir les uns envers les autres dans un <span style="text-decoration: line-through">esprit de fraternité</span>.</p>
							</div>
							<div class="col-sm-6">
								Tous les êtres humains naissent <span class="balise">b&gt;</span>libres<span class="balise">&lt;b</span> et <span class="balise">b&gt;</span>égaux<span class="balise">&lt;b</span> en dignité et en droits. Ils sont <span class="balise">b&gt;</span>doués de raison et de conscience<span class="balise">&lt;b</span> et doivent agir les uns envers les autres dans un <span class="balise">b&gt;</span>esprit de fraternité<span class="balise">&lt;b</span>.
							</div>
						</div>
					</article>

					<h4 id="paragraphe">Le Paragraphe</h4>
					<hr/>

					<h5 id="paragrapheclassique">Le Paragraphe classique<a class="float-right" style="font-size:smaller;" onclick="close_sec('paragrapheclassique')">▲</a></h5>
					<hr/>
					<article class="wiki" id="s_paragrapheclassique">
						<p>Un simple saut de ligne suivi d'aucune balise de paragraphe entraine le début d'un nouveau paragraphe classique :</p>
						<div class="row">
							<div class="col-sm-6 example">
								<p>Tous les êtres humains naissent libres et égaux en dignité et en droits. Ils sont doués de raison et de conscience et doivent agir les uns envers les autres dans un esprit de fraternité.</p>
								<p>Tout individu a droit à la vie, à la liberté et à la sûreté de sa personne.</p>
							</div>
							<div class="col-sm-6">
								Tous les êtres humains naissent libres et égaux en dignité et en droits. Ils sont doués de raison et de conscience et doivent agir les uns envers les autres dans un esprit de fraternité.<br/>Tout individu a droit à la vie, à la liberté et à la sûreté de sa personne.
							</div>
						</div>
					</article>

					<h5 id="citationcourte">La Citation courte<a class="float-right" style="font-size:smaller;" onclick="close_sec('citationcourte')">▲</a></h5>
					<hr/>
					<article class="wiki" id="s_citationcourte">
						<p>Au sein de n'importe quel paragraphe, la balise <span class="balise">'&gt;</span>citation<span class="balise">&lt;'</span> permet d'insérer une courte citation :</p>
						<div class="row">
							<div class="col-sm-6 example">
								<p>D'après la Déclaration Universelle des Droits de l'Homme, <span class="quote">Tous les êtres humains naissent libres et égaux en dignité et en droits</span>. Pourtant, soixante-dix ans après sa rédaction, les crimes racistes et les inégalités sociales persistent malheureusement.</p>
							</div>
							<div class="col-sm-6">
								D'après la Déclaration Universelle des Droits de l'Homme, <span class="balise">'&gt;</span>Tous les êtres humains naissent libres et égaux en dignité et en droits<span class="balise">&lt;'</span>. Pourtant, soixante-dix ans après sa rédaction, les crimes racistes et les inégalités sociales persistent malheureusement.
							</div>
						</div>
					</article>

					<h5 id="citation">La Citation longue<a class="float-right" style="font-size:smaller;" onclick="close_sec('citation')">▲</a></h5>
					<hr/>
					<article class="wiki" id="s_citation">
						<p>En commençant un paragraphe directement par la balise de citation <span class="balise">'&gt;</span>paragraphe<span class="balise">&lt;'</span>, le paragraphe devient lui-même une citation :</p>
						<div class="row">
							<div class="col-sm-6 example">
								<p>D'après l'article premier de la Déclaration Universelle des Droits de l'Homme que voici :</p>
								<p class="quote">Tous les êtres humains naissent libres et égaux en dignité et en droits</p>
							</div>
							<div class="col-sm-6">
								D'après l'article premier de la Déclaration Universelle des Droits de l'Homme que voici :<br/>
								<span class="balise">'&gt;</span>Tous les êtres humains naissent libres et égaux en dignité et en droits<span class="balise">&lt;'</span>
							</div>
						</div>
						<p>Bien entendu, on peut mettre une citation courte dans une citation longue :</p>
						<div class="row">
							<div class="col-sm-6 example">
								<p>D'après l'article premier de la Déclaration Universelle des Droits de l'Homme que voici :</p>
								<p class="quote">Tous les êtres humains naissent <span class="quote">libres</span> et <span class="quote">égaux</span> en dignité et en droits</p>
							</div>
							<div class="col-sm-6">
								D'après l'article premier de la Déclaration Universelle des Droits de l'Homme que voici :<br/>
								<span class="balise">'&gt;</span>Tous les êtres humains naissent <span class="balise">'&gt;</span>libres<span class="balise">&lt;'</span> et <span class="balise">'&gt;</span>égaux<span class="balise">&lt;'</span> en dignité et en droits<span class="balise">&lt;'</span>
							</div>
						</div>
					</article>

					<h4 id="miseenforme">La Mise en forme</h4>
					<hr/>

					<h5 id="titre">Le Titre<a class="float-right" style="font-size:smaller;" onclick="close_sec('titre')">▲</a></h5>
					<hr/>
					<article class="wiki" id="s_titre">
						<p>En dehors d'un paragraphe, la balise <span class="balise">t&gt;</span>titre<span class="balise">&lt;t</span> permet d'insérer un titre :</p>
						<div class="row">
							<div class="col-sm-6 example">
								<h5>Article 1</h5>
								<p>Tous les êtres humains naissent libres et égaux en dignité et en droits. </p>
							</div>
							<div class="col-sm-6">
								<span class="balise">t&gt;</span>Article 1<span class="balise">&lt;t</span><br/>
								Tous les êtres humains naissent libres et égaux en dignité et en droits.
							</div>
						</div>
					</article>

					<h5 id="liste">La Liste<a class="float-right" style="font-size:smaller;" onclick="close_sec('liste')">▲</a></h5>
					<hr/>
					<article class="wiki" id="s_liste">
						<p>En dehors d'un paragraphe, l'ensemble de balises <span class="balise">.&gt;</span>Point 1<span class="balise">&lt;;</span><span class="c-red">Point 2</span><span class="balise">&lt;;</span><span class="c-red">Point 3</span><span class="balise">&lt;.</span> permettent d'insérer une liste :</p>
						<div class="row">
							<div class="col-sm-6 example">
								<ul><li>2 œufs</li><li>250g de farine</li><li>75g de sucre</li><li>50g de beurre</li><li>25cl de crème</li><li>25cl de crème</li><li>15cl de lait</li></ul>
							</div>
							<div class="col-sm-6">
								<span class="balise">.&gt;</span>2 œufs<span class="balise">&lt;;</span>250g de farine<span class="balise">&lt;;</span>75g de sucre<span class="balise">&lt;;</span>50g de beurre<span class="balise">&lt;;</span>25cl de crème<span class="balise">&lt;;</span>25cl de crème<span class="balise">&lt;;</span>15cl de lait<span class="balise">&lt;.</span>
							</div>
						</div>
						<span class="c-red"><strong>Remarques</strong></span>
						<p style="border-left:0.5rem double red;padding-left:1rem;">Lorsque vous utilisez le bouton <span class="quote">• Liste</span> sans sélection, la balise apparaîtra sous cette forme. Si vous l'utilisez avec un texte sélectionner, le texte sera considéré comme étant le Point 1. Les Point 2 et 3 seront à remplacer ensuite.</p>
						<p style="border-left:0.5rem double red;padding-left:1rem;">Pour obtenir une liste numérotée utilisée les suprabalises <span class="balise">.1&gt;</span>liste<span class="balise">&lt;.1</span> à la place de <span class="balise">.&gt;</span>liste<span class="balise">&lt;.</span></p>
					</article>

					<h5 id="note">La Note<a class="float-right" style="font-size:smaller;" onclick="close_sec('note')">▲</a></h5>
					<hr/>
					<article class="wiki" id="s_note">
						<p>La balise <span class="balise">^&gt;</span>note<span class="balise">&lt;^</span> permet d'insérer une note de bas de page :</p>
						<div class="row">
							<div class="col-sm-6 example">
								<p>Tous les êtres humains naissent libres et égaux en dignité et en droits. <a style="font-size:60%;vertical-align:super;" href="#note_1"> [1] </a></p>
								<p>Nul ne peut être arbitrairement arrêté, détenu ou exilé. <a style="font-size:60%;vertical-align:super;" href="#note_2"> [2] </a></p>
								<p style="font-size:60%" class="my-0" id="note_1">[1] Article 1 de la DUDH</p>
								<p style="font-size:60%" class="my-0" id="note_2">[2] Article 9 de la DUDH</p>
							</div>
							<div class="col-sm-6">
								Tous les êtres humains naissent libres et égaux en dignité et en droits.<span class="balise">^&gt;</span>Article 1 de la DUDH<span class="balise">&lt;^</span><br/>
								Nul ne peut être arbitrairement arrêté, détenu ou exilé.<span class="balise">^&gt;</span>Article 9 de la DUDH<span class="balise">&lt;^</span>
							</div>
						</div>
					</article>

					<h5 id="image">L'Image<a class="float-right" style="font-size:smaller;" onclick="close_sec('image')">▲</a></h5>
					<hr/>
					<article class="wiki" id="s_image">
						<p>La balise <span class="balise">!&gt;</span>url_img<span class="balise">&lt;!</span> doit être utilisé hors paragraphe et permet d'insérer une image depuis une url :</p>
						<div class="row">
							<div class="col-sm-8 example">
								<p> <img class="img" src="https://assos.utc.fr/lefil/img/lefil.png" alt="image non disponible"> <a style="font-size:60%;vertical-align:super;" href="#note_1"> [1] </a> </p>
								<p style="font-size:60%" class="my-0" id="note_1">[1] Logo du Fil P19 et A19</p>
							</div>
							<div class="col-sm-4">
								<span class="balise">!&gt;</span>https://assos.utc.fr/lefil/img/lefil.png<span class="balise">&lt;!</span><span class="balise">^&gt;</span>Logo du Fil P19 et A19<span class="balise">&lt;^</span>
							</div>
						</div>
					</article>

					<h5 id="podcast">Le Podcast<a class="float-right" style="font-size:smaller;" onclick="close_sec('podcast')">▲</a></h5>
					<hr/>
					<article class="wiki" id="s_podcast">
						<p>L'insertion de podcast est rendue possible avec la balise <span class="balise">%&gt;</span>url_sng <span class="balise">by&gt;</span> source <span class="balise">&lt;%</span> hors paragraphe :</p>
						<div class="row">
							<div class="col-sm-8 example">
								<div class="row justify-content-center"><audio controls=""><source src="https://assos.utc.fr/lefil/img/song.wav">Votre navigateur ne supporte pas la lecture audio.</audio></div>
								<div class="text-center"> Source :  Au Clair de la lune, libre de droit </div>
							</div>
							<div class="col-sm-4">
								<span class="balise">%&gt;</span>https://assos.utc.fr/lefil/img/song.wav <span class="balise">by&gt;</span> Au Clair de la lune, libre de droit <span class="balise">&lt;%</span>
							</div>
						</div>
					</article>

					<h5 id="hyperlien">L'Hyperlien<a class="float-right" style="font-size:smaller;" onclick="close_sec('hyperlien')">▲</a></h5>
					<hr/>
					<article class="wiki" id="s_hyperlien">
						<p>L'ensemble de balises <span class="balise">l&gt;</span><span class="c-red">url</span><span class="balise">&lt;:&gt;</span>texte<span class="balise">&lt;l</span> permet d'insérer une hyperlien :</p>
						<div class="row">
							<div class="col-sm-6 example">
								<p>Rejoins la joyeuse troupe du Fil sur le <a href="https://assos.utc.fr/assos/lefil">Portail des Assos : Le Fil</a></p>
							</div>
							<div class="col-sm-6">
								Rejoins la joyeuse troupe du Fil sur le <span class="balise">l&gt;</span>https://assos.utc.fr/assos/lefil<span class="balise">&lt;:&gt;</span>Portail des Assos : Le Fil<span class="balise">&lt;l</span>
							</div>
						</div>
						<span class="c-red"><strong>Remarque 1</strong></span>
						<p style="border-left:0.5rem double red;padding-left:1rem;">Lorsque vous utilisez le bouton <button class="btn-edit"><img src="../img/link.png" style="max-width:24px; height:auto;" width="24"/></button> sans sélection, la balise apparaîtra sous cette forme. Si vous l'utilisez avec un texte sélectionner, le texte sera considéré comme étant le texte. L'url sera à remplacer ensuite.</p>
						<span class="c-red"><strong>Remarque 2</strong></span>
						<p style="border-left:0.5rem double red;padding-left:1rem;">En utilisant la balise d'image à la place du texte, vous pouvez faire une image-lien.</p>

					</article>

				</section>
				<script>
					function close_sec(section){
						var sec = document.getElementById("s_"+section),
							lnk = document.getElementById(section).getElementsByTagName("a")[0];

							sec.style.height = "1rem";
							sec.style.borderBottom = "1px dashed silver";
							lnk.setAttribute("onclick","open_sec('"+section+"')");
							lnk.innerHTML = "▼";
					}
					function open_sec(section){
						var sec = document.getElementById("s_"+section),
							lnk = document.getElementById(section).getElementsByTagName("a")[0];

							sec.style.height = "max-content";
							sec.style.borderBottom = "";
							lnk.setAttribute("onclick","close_sec('"+section+"')");
							lnk.innerHTML = "▲";
					}
				</script>
			</section>
		</main>

		<footer class="mt-4 mb-0 py-2 bg-dark text-white text-center"> <!-- Pied de la page-->
				<h5 class="font-logo">© Le Fil, club du Pôle Vie du Campus de l'université de technologie de Compiègne - 2019</h5>
				<a class="link-head" href="https://assos.utc.fr/assos/lefil">le club</a><br/>
				<a class="link-head" href="mailto:lefil@assos.utc.fr">nous contacter</a>
		</footer>
	</body>
</html>