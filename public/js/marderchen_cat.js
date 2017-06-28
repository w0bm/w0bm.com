 /*MEOW  HTML5 /jquery browser CAT ANEKO by mardechen (png pictures from https://play.google.com/store/apps/details?id=skin.flower10&hl=de apk)  
          script by me (not the soundcript) MEOW! other skins possible if batching pngs filnames with irfanview like "_#" after deleting icon.png i like flower CAT! png and sound
          linked to marderchen.de so only need the script */
 //sound start
 var html5_audiotypes = {
     "mp3": "audio/mpeg",
     "mp4": "audio/mp4",
     "ogg": "audio/ogg",
     "wav": "audio/wav"
 }
 function createsoundbite(sound) {
     var html5audio = document.createElement('audio')
     if (html5audio.canPlayType) { //check support for HTML5 audio
         for (var i = 0; i < arguments.length; i++) {
             var sourceel = document.createElement('source')
             sourceel.setAttribute('src', arguments[i])
             if (arguments[i].match(/\.(\w+)$/i))
                 sourceel.setAttribute('type', html5_audiotypes[RegExp.$1])
             html5audio.appendChild(sourceel)
         }
         html5audio.load()
         html5audio.playclip = function() {
             html5audio.pause()
             html5audio.currentTime = 0
             html5audio.play()
         }
         return html5audio
     } else {
         return {
             playclip: function() {
                 throw new Error("Your browser doesn't support HTML5 audio unfortunately")
             }
         }
     }
 }
 var mouseoversounds = createsoundbite("http://marderchen.de/wusel/Aneko_data/flower_pngs/meow_click.mp3")
 var clicksounds = createsoundbite("http://marderchen.de/wusel/Aneko_data/flower_pngs/meow_click.mp3")
     //soundend
 function leszeugs() {
     t = 1;
     daa = 1;
     xm = Math.random() * 640;
     ym = Math.random() * 480;
     x = 200;
     y = 200;
     xalt = 300;
     yalt = 300;
     xcatz = 200;
     ycatz = 200;
     zeit1 = 0;
     zeit3 = 0;
     istani = 5;
     zeit4 = 0;
     zeit2 = 0;
     zeit1random = Math.random() * 10;
     zeit5 = 0;
     wohinrandomx = 0;
     wohinrandomy = 0;
     wohinzufallzeit = 300 + Math.random() * 300 + 100;
     getnextt = 0;
     xchaos = 20;
     ychaos = 20;
     often = 0;
     oftenist = Math.random() * 7;
     tutrandom = 0;
     tutcounter = 0;
     countz = 0;
     katze = 1;
     speedz = 5; //pixeldistanz fÃ¼r bewegung
     meows = 36; //pngs
     actionenrand = new Array([1, 2], [12, 21], [17, 18], [19, 20], [20, 21], [19, 1], [20, 1], [24, 25], [26, 27], [34, 35]); //png zuordnung \/
     mup = new Array(28, 29);
     mupr = new Array(32, 33);
     mright = new Array(22, 23);
     mdownr = new Array(10, 11);
     mdown = new Array(4, 5);
     mdownl = new Array(8, 9);
     mleft = new Array(15, 16);
     mupl = new Array(30, 31);
     wohin = new Array(mup, mupr, mright, mdownr, mdown, mdownl, mleft, mupl);
     for (var i = 1; i < meows; i++) {
         document.write("<SPAN id='a" + i + "' class='kutze a" + i + "' onclick='clicksounds.playclip()' onmouseover='mouseoversounds.playclip()'><img id='" + i + "' src='http://marderchen.de/wusel/Aneko_data/flower_pngs/_" + i + ".png' /></SPAN>");
     }
 }
 function getmouse() {
     document.onmousemove = handleMouseMove;
     function handleMouseMove(event) {
         xm = event.clientX + 15;
         ym = event.clientY + 15;
     }
 }
 function bewegz(katze) {
     countz++;
     if (countz >= 2) {
         countz = 0;
     }
     for (t = 1; t < meows; t++) {
         if (t == katze) {
             document.all["a" + t].style.position = "absolute";
             document.all["a" + t].style.left = xcatz + 'px';
             document.all["a" + t].style.top = ycatz + 'px';
         }
         if (t != katze) {
             document.all["a" + t].style.position = "absolute";
             document.all["a" + t].style.left = -80 + 'px';
             document.all["a" + t].style.top = -80 + 'px';
         }
     }
 }
 function wuseldahin(x, y) {
     if (x >= (xalt + speedz * 1.5) || x <= (xalt - speedz * 1.5) || y <= (yalt - speedz * 1.5) || y >= (yalt + speedz * 1.5)) {
         daa = 0;
         zeit3++;
         katze = 3;
     } else {
         daa = 1;
         zeit3 = 0;
     }
     if (zeit3 > 50) {
         if (x < xalt && y < yalt) {
             katze = wohin[7][countz];
             xalt -= speedz;
             yalt -= speedz;
         } //mupl
         if (x > xalt && y > yalt) {
             katze = wohin[3][countz];
             xalt += speedz;
             yalt += speedz;
         } //mdownr
         if (x < xalt && y > yalt) {
             katze = wohin[5][countz];
             yalt += speedz;
             xalt -= speedz;
         } //mdownl
         if (x > xalt && y < yalt) {
             katze = wohin[1][countz];
             yalt -= speedz;
             xalt += speedz;
         } //mupr
         if (x <= (xalt + speedz) && x >= (xalt - speedz) && y < yalt) {
             katze = wohin[0][countz];
             yalt -= speedz;
         } //mup
         if (x <= (xalt + speedz) && x >= (xalt - speedz) && y > yalt) {
             katze = wohin[4][countz];
             yalt += speedz;
         } //mdown
         if (x < xalt && y >= (yalt - speedz) && y <= (yalt + speedz)) {
             katze = wohin[6][countz];
             xalt -= speedz * 1.5;
         } //mleft
         if (x > xalt && y >= (yalt - speedz) && y <= (yalt + speedz)) {
             katze = wohin[2][countz];
             xalt += speedz;
         } //mright
     }
     xcatz = xalt;
     ycatz = yalt;
     bewegz(katze);
 }
 function animierzufallig() {
     if (daa == 1) {
         if (istani > 4) {
             katze = actionenrand[Math.round(tutrandom)][tutcounter];
         }
         if (istani <= 4) {
             katze = 1;
         }
     }
 }
 function zeitreise() {
     zeit1++;
     zeit2++;
     if (zeit3 < 60) {
         zeit3++;
     }
     zeit4++;
     if (zeit1 >= zeit1random) {
         tutrandom = Math.random() * 9;
         zeit1 = 0;
         zeit1random = Math.random() * 140 + 90;
         istani = Math.random() * 10;
     }
     if (zeit2 >= 20) {
         tutcounter++;
         if (tutcounter >= 2) {
             tutcounter = 0;
         }
         zeit2 = 0;
     }
     setTimeout('zeitreise()', 10);
 }
 function wuselirgentwohin() {
     wohinrandomx = xcatz + Math.random() * 400 - 200;
     wohinrandomy = ycatz + Math.random() * 400 - 200;
     if (zeit4 > wohinzufallzeit) {
         zeit4 = 0;
         getnextt = 1;
         wohinzufallzeit = Math.random() * 200 + 100;
         often = Math.random() * 8 + 2;
     }
     if (getnextt == 1) {
         zeit5++;
         if (daa == 1) {
             zeit5 = 100;
         }
     }
     if (oftenist > often) {
         getnextt = 0;
     }
     if (getnextt == 1 && (zeit5 > 40 || daa == 1)) {
         if ((wohinrandomx) < (document.body.clientHeight - 100) && (wohinrandomx) > 100) {
             xchaos = wohinrandomx;
             oftenist++;
         }
         if ((wohinrandomy) < (document.body.clientWidth - 100) && (wohinrandomy) > 100) {
             ychaos = wohinrandomy;
             oftenist++;
         }
         zeit5 = 0;
     }
 }
 function wusel() {
     getmouse();
     if (getnextt == 0) {
         wuseldahin(xm, ym);
     }
     if (getnextt == 1) {
         wuseldahin(xchaos, ychaos);
     }
     animierzufallig();
     wuselirgentwohin();
     setTimeout('wusel()', 100);
 }
 leszeugs();
 getmouse();
 wusel();
 zeitreise();
