<form action="?s=news_dodaj" method="POST" enctype="multipart/form-data">

<div class="rbox"><strong>NAG��WEK*</strong><BR>
<input name="title" type="text" maxlength="255" value="{$title}" class="maxlen"><BR>
krotki, (kilka wyrazow) naglowek newsa, zachecajacy do czytania
</div>


<div class="rbox"><strong>TRE��</strong><BR>
<textarea name="news" rows="10" class="maxlen">{$description}</textarea><BR>
cala tresc newsa, nie uzywamy znacznikow BR, kazdy enter (lub nawet kilka po kolei) bedzie tworzyl znaczniki P, ktore podziela tresc na akapity
</div>


<div class="rbox"><strong>DATA DODANIA*</strong><BR>
<input type="text" name="date" value="{$data_dodania}" class="maxlen"><BR>
data dodania newsa w formacie rrrr-mm-dd hh:mm:ss
</div>


<div class="rbox"><strong>GRAFIKA</strong><BR>
<input type="file" name="graph" class="maxlen"><BR>
zdjecie, lub obrazek, ktory wyswietli sie obok newsa,<br>
podczas przegladania, zostanie wyswietlona miniaturka, a po kliknieciu w nia, pojawi sie w nowym oknie normalny obrazek max wymiary 600px x 800px, skompresowane ACDSee. JPG@50
</div>


<div class="rbox"><strong>POWI�ZANI WYKONAWCY</strong> -> <a href="#" onClick="window.open('artists-alphabetical-list.php?id=arti','_blank','scrollbars=yes,width=200,height=500');">DODAJ</a><BR>
<input id="arti" name="artists" type="text" maxlength="255" value="{$artists}" class="maxlen"><BR>
id powiazanych z newsem wykonawcow, oddzielone przecinkami (bez zadnych spacji i innych znakow)<br>
np: 24,12,477,432<BR>
</div>


<div class="rbox"><strong>POWI�ZANE KONCERTY</strong> -> <a href="#" onClick="window.open('alphabetical-list-concerts.php?id=conc','_blank','scrollbars=yes,width=320,height=500');">DODAJ</a><BR>
<input id="conc" name="concerts" type="text" maxlength="255" value="{$concerts}" class="maxlen"><BR>
id powiazanych z newsem koncertow, oddzielone przecinkami (bez zadnych spacji i innych znakow)<br>
np: 24,12,477,432<BR>
</div>


<div class="rbox"><strong>POWI�ZANE WYTW�RNIE</strong> -> <a href="#" onClick="window.open('alphabetical-list-labels.php?id=labe','_blank','scrollbars=yes,width=210,height=500');">DODAJ</a><BR>
<input id="labe" name="labels" type="text" maxlength="255" value="{$labels}" class="maxlen"><BR>
id powiazanych z newsem wytworni, oddzielone przecinkami (bez zadnych spacji i innych znakow)<br>
np: 24,12,477,432<BR>
</div>


<div class="rbox"><strong>POWI�ZANE ALBUMY</strong> -> <a href="#" onClick="window.open('alphabetical-list-albums.php?id=albu','_blank','scrollbars=yes,width=280,height=500');">DODAJ</a><BR>
<input id="albu" name="albums" type="text" maxlength="255" value="{$labels}" class="maxlen"><BR>
id powiazanych z newsem albumow, oddzielone przecinkami (bez zadnych spacji i innych znakow)<br>
np: 24,12,477,432<BR>
</div>



<div class="rbox"><strong>POWI�ZANE MIASTA</strong> -> <a href="#" onClick="window.open('alphabetical-list-cities.php?id=citi','_blank','scrollbars=yes,width=210,height=500');">DODAJ</a><BR>
<input id="citi" name="concerts" type="text" maxlength="255" value="{$labels}" class="maxlen"><BR>
id powiazanych z newsem miast, oddzielone przecinkami (bez zadnych spacji i innych znakow)<br>
np: 2,1,4,8<BR>
</div>


<input type="submit" name="action" value="DODAJ" class="btn" style="float: right; display: inline; width: 200px; color: green;">
<input type="reset" name="action" value="RESET" class="btn" style="float: left; display: inline; width: 100px;">


</form>