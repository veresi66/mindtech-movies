TMDB listázó
----

A teszt feladat megoldása Laravel 9 keretrendszerben készült.

A feldat megoldása modules könyvtárban található. A megoldás megpróbálja a magyar nyelvűadatokat kinyerni az TMDB API-n keresztül, ahol nincs magyar nyelv, ott angol nyelvű szöveg kerül lementésre, haegyik sincs akkor a mező üresen marad.

A rendszer telepítése a 

      composer install

paranccsal történk, mely létrehozza az alapvető laravel és a tesztfeladat függőségeit. A függőségek telepítése után az adatbázis létrehozásához le kell futtatni a 

     php artisan migrate

parancsot. Ezzel létrejött az adatbázis szerkezete. Az adatbázis adatfeltültése kétféle módon történhet. 

Parancssorból meghívjuk a

     php artisan tmdb:initialize

parancsot, vagy böngészőben - miután létrehoztuk a virtuális teszt szerver - beírjuk a **tesztszerverneve/tmdb** sort. Kis idő elteltével megjelenik a 210 film címét, pontátlagát és a szavazatok számát tartalmazó lista. A listábam a film címe egy link, melyre kattintva az adott film adatbázisban található adataiból összeállított adatlap jelenik meg.

A feladatban meghatározott cron script-ként futtatására tervezett parancs a 

     php artisan tmdb:update


A feladathoz nem készítettem teszt eseteket.
