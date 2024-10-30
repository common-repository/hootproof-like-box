=== Plugin Name ===
Contributors: hootproof
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=P9EGHVC5L32V4
Tags: facebook, like box, page plugin, feed, datenschutz, privacy, germany
Requires at least: 3.0.1
Tested up to: 4.4.5
Stable tag: 1.1.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Datenschutzfreundliche Facebook Like Box für deine Facebook-Page mit optionaler Anzeige der letzten Posts.

== Description ==

Dieses Plugin liefert ein Widget, das folgende Informationen zu einer Facebook-Seite anzeigt: 

* Name der Seite
* Titelbild der Seite
* Profilbild der Seite
* Anzahl Likes der Seite
* Link zur Seite
* Die letzten Beiträge auf der Facebook-Seite mit Bild und Link (optional)


Um das Plugin zu nutzen, muss eine so genannte Facebook App angelegt werden, um eine App-ID und ein App-Secret zu erhalten. Dazu ist ein Facebook-Konto erforderlich. Wie das geht, erfährst du im Installations-Tab.


Einstellungen des Widgets:

* Titel: Überschrift des Widgets auf der Website
* Page-ID: die ID (numerisch) oder Slug deiner Seite (der Teil der URL nach facebook.com/)
* App-ID: von Facebook generierte ID deiner App
* App-Secret: von Facebook generierter Schlüssel für deine App
* Anzahl der Beiträge, die angezeigt werden: Hiermit kannst du festlegen, wie viele Facebook-Posts im Feed-Bereich Widget angezeigt werden (maximal 100). Wenn du keine Posts anzeigen möchtest, gib -1 ein.
* Maximale Höhe des Feeds in Pixeln: Hier kannst du steuern, wie hoch der Feed-Bereich des Widgets ist. Empfohlen: 369 (Pixel).
* Zeilenumbruch nach jedem Beitragsbild: Wenn nicht aktiviert, erscheint das Bild eines Posts in der gleichen Zeile wie das Datum und der Text.

== Installation ==

Lade das Plugin wie gewohnt herunter und aktiviere es.


Erstelle deine Facebook App (unbedingt erforderlich):

1. Melde dich ggf. bei Facebook an. Gehe zu https://developers.facebook.com/
1. Oben rechts unter "My Apps" klick auf "Add New App"
1. Wähle "Website" 
1. Folge den Schritten, um deine App anzulegen. Gib dabei einen einzigartigen Namen an, der nicht das Wort "Facebook" oder ähnliches enthält.
1. Klicke zum Schluss auf "Skip Quick Start"
1. Finde deine App-ID und dein App-Secret.

[youtube https://www.youtube.com/watch?v=5Fm-LkyVbVQ]

Gib die App-ID und das App-Secret im Widget in WordPress ein.

Gib die Page-ID (z.B. "hootproof" ohne Anführungszeichen oder eine numerische ID) deiner Facebook-Seite im Widget ein. 

Gib die sonstigen Einstellungen ein und speichere das Widget.



== Frequently Asked Questions ==

= Was unterscheidet das Plugin von anderen Facebook Like Box Plugins? =

Dieses Plugin erzeugt keine Datenübertragung zwischen Facebook und dem Aufrufer der Website. Daher werden keine personenbezogenen Daten wie z.B. Facebook-Cookies übertragen. Alle Anfragen des Plugins an Facebook erfolgen ausschließlich auf dem Webserver.

= Warum ist kein direktes Like möglich? =

Um die Datenübertragung zwischen Facebook um dem Benutzer der Website zu verhindern, können nur Links im Plugin platziert werden. Der Like-Button ist nicht als Link umsetzbar, sondern würde wiederum die Einbindung von Facebook-Skripten und damit auch die Übertragung personenbezogener Daten erfordern.


== Screenshots ==

1. Beispiel für Anzeige des Widgets auf der Website.
2. Widgeteinstellungen im WordPress Backend.

== Changelog ==

= 1.0 =
* Initial version.
* 1.1.2 Bug fixes, performance optimization
* 1.1.3 Use -1 instead of 0 in order to not display any posts from your timeline
