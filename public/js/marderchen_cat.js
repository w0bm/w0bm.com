       /*MEOW  HTML5 /jquery browser CAT ANEKO by mardechen (png pictures from https://play.google.com/store/apps/details?id=skin.flower10&hl=de apk)  
         script by me (not the soundcript) MEOW! other skins possible if batching pngs filnames with irfanview like "_#" after deleting icon.png don't forget the _bubble.png  i like flower CAT! png and sound
         linked to marderchen.de so only need the script still writing on it hihi*/

         //sound start
        var html5_audiotypes={
        "mp3": "audio/mpeg","mp4": "audio/mp4","ogg": "audio/ogg","wav": "audio/wav"}
        function createsoundbite(sound){
        var html5audio=document.createElement('audio')
        if (html5audio.canPlayType){ //check support for HTML5 audio
                for (var i=0; i<arguments.length; i++){
                        var sourceel=document.createElement('source')
                        sourceel.setAttribute('src', arguments[i])
                        if (arguments[i].match(/\.(\w+)$/i))
                        sourceel.setAttribute('type', html5_audiotypes[RegExp.$1])
                        html5audio.appendChild(sourceel)
                }
                html5audio.load()
                html5audio.playclip=function(){
                        html5audio.pause()
                        html5audio.currentTime=0
                        html5audio.play()
                }
                return html5audio
        }
        else{
                return {playclip:function(){throw new Error("Your browser doesn't support HTML5 audio unfortunately")}}
        }}       

        //var mouseoversounds=createsoundbite("http://marderchen.de/wusel/Aneko_data/flower_pngs/meow_click.mp3")
        //soundend

        function leszeugs() {
        t=1; daa=1; 
        xm=Math.random()*640; ym=Math.random()*480; ymcach=0; xmcach=0;
        zeit1=0; zeit3=0; istani=5; zeit4=0; zeit2=0; zeit1random=Math.random()*10; zeit5=0;
        wohinrandomx=0; wohinrandomy=0; wohinzufallzeit=300+Math.random()*300+100; getnextt=0; xchaos=20;ychaos=20;
        often=0; oftenist=Math.random()*7; durchlaufcounter=0; active =0;
        tutrandom=0; tutcounter=0; suchminimumzeit=0; suchmaus=0; spooldone=1;
        countz=0;katze=1;
        speedz=5; //pixeldistanz für bewegung
        meows = 36; //pngs
        actionenrand=new Array([1,2],[12,21],[17,18],[19,20],[20,21],[19,1],[20,1],[24,25],[26,27],[34,35]); //png zuordnung \/
        mup= new Array(28,29);
        mupr= new Array(32,33);
        mright= new Array(22,23);
        mdownr= new Array(10,11);
        mdown= new Array(4,5);
        mdownl= new Array(8,9);
        mleft= new Array(15,16);
        mupl= new Array(30,31);
        wohin= new Array(mup,mupr,mright,mdownr,mdown,mdownl,mleft,mupl);
        // ram = document.getElementById('mCSB_2');
        zeitstart=0; bleibneweile=0;
        for(var i=1 ; i<meows; i++){    document.write("<SPAN id='a"+i+"' class='a"+i+"' onmouseover='fillmeowzbuffer(Math.round(Math.random()*13))' onmouseover='holdiemaus()'><img id='"+i+"' src='https://w0bm.com/wusel/meow_png/_"+i+".png' /></SPAN>");     } // onmouseover='mouseoversounds.playclip()'
        kommeaufy=document.getElementById('commentForm').offsetHeight;// + document.getElementById('commentForm').innerHeight  ;
        mittex=document.getElementById('mCSB_2').offsetLeft- document.getElementById('mCSB_2').scrollLeft+350;
        x=0; y=kommeaufy;  xalt=0; yalt=kommeaufy;  xcatz=200; ycatz=kommeaufy; malkrier=0;
        katzensagenmenge= 16;
        katzensagen1 = "Think have seen movement there ";
        katzensagen2 = "awesome scratching me with spiky mouscursor ***PURRRRRRRRRR*** ";
        katzensagen3 = "~ ~  ~ MEOW ~  ~ ~ :3  ";
        katzensagen4 = "mew MEW MEEEEW (>^.^<) ";
        katzensagen5 = "Have you CATNIP?? *extremly cute look* ";
        katzensagen6 = "I like you so much *hug* *";
        katzensagen7 = "Iam dieing if you close page, not much lifes left *caterwaul* ";
        katzensagen8 = "mew MIAUS MEOOOOW ... >Purrrrrr< ";
        katzensagen9 = "Didyou know? Iam noxy =^.^= ";
        katzensagen10 = "Oh look! webms with sound ~JOY~ ";
        katzensagen11 = "I want to get invissible hihi *";
        katzensagen12 = "here I go.. ,,,^.^.,,       ";
        katzensagen13 = "lets take a look behind the w0bm banner";
        katzensagen14 = "Iam wearily .. so wearily slepping a while..";
        katzensagen15 = "You  terrify me hihihihihi    ";
        katzensagen16 = "Wh00Oops! this is  s c a r r y  ";
        katzensagen17 = "Need to catch mouse again its gone :> ";
        document.write("<SPAN id='blubb' class='blubb'> <img id='blubber' src='https://w0bm.com/wusel/meow_png/_bubble.png' /></SPAN>");
        document.write("<SPAN id='meowz' class='meowz' ><FONT><P><FONT SIZE=6 STYLE='font-size: 20pt;' >!MEOW!<p>thinking...</p></FONT>  </SPAN>");
        meme=0; countyy=0; meowcach= new Array(); meme=0; zeit5=0; zeit6=0; showeran=Math.random()*500+100; showeraus=0; textposx=100;textposy=100;
        cuteszeugs=8;fillmeowzbuffer(cuteszeugs);
        }

       function getmouse() { 
                document.onmousemove = handleMouseMove;
                function handleMouseMove(event) {
                    xmcach = event.clientX+15 + document.body.scrollLeft;
                    ymcach = event.clientY+15 + document.body.scrollTop ;
                    if (ymcach <document.body.clientHeight){ym=ymcach;}
                    if (xmcach <document.body.clientWidth){xm=ymcach;}
                }
        }
        function bewegz(katze){
            countz++;
            if (countz >=2) {countz =0;}
            for (t=1; t <meows; t++) {
                if (t == katze){   
                    document.all["a"+t].style.position = "absolute";               
                    document.all["a"+t].style.left =  xcatz+'px';
                    document.all["a"+t].style.top = ycatz+'px';
                    //  document.all["a"+t].opacity = 0.6;
                    // document.all["a"+t].style.opacity = 0.6+'opacity';
                }
                if (t != katze){       
                    document.all["a"+t].style.position = "absolute";           
                    document.all["a"+t].style.left =  -80+'px';
                    document.all["a"+t].style.top = -80+'px';
                }
            }
        }
       function initdieCATZ(x2,y2){
          if(zeitstart ==0){xalt=x2; yalt=y2;           xcatz=xalt-2;  ycatz=yalt+1;zeitstart =1;}
          if(getnextt==0 && zeitstart==1) {wuseldahin(x2+mittex,y2,1);}
          if(getnextt==0 && daa ==1){bleibneweile++; }
          if (bleibneweile== 29) {active=1;spooldone=0;}
          if (getnextt==0 && spooldone==1 &&bleibneweile >31 &&active==1) {getnextt=1;}
       }
       function wuseldahin(x,y,normal){ 

          if(x >= (xalt+speedz*1.5) || x <= (xalt-speedz*1.5)  || y <= (yalt-speedz*1.5) ||y>= (yalt+speedz*1.5)){
          daa=0; zeit3++; katze=3; }  else {daa=1; zeit3=0; }
          if(zeit3 >50){
               if(x < xalt && y < yalt){katze=wohin[7][countz]; xalt-=speedz; yalt-=speedz;  }//mupl
               if(x > xalt && y > yalt){katze=wohin[3][countz]; xalt+=speedz; yalt+=speedz; }//mdownr
               if(x < xalt && y > yalt){katze=wohin[5][countz];  yalt+=speedz; xalt-=speedz;}//mdownl
               if(x > xalt && y < yalt){katze=wohin[1][countz];  yalt-=speedz; xalt+=speedz; }//mupr
               if(x <= (xalt+speedz) && x >= (xalt-speedz)  && y < yalt){katze=wohin[0][countz]; yalt-=speedz;  }//mup
               if(x <= (xalt+speedz) && x >= (xalt-speedz) && y > yalt){katze=wohin[4][countz];  yalt+=speedz; }//mdown
               if(x < xalt&& y >= (yalt-speedz) &&y<= (yalt+speedz)) {katze=wohin[6][countz]; xalt-=speedz*1.5; } //mleft
               if(x > xalt && y >= (yalt-speedz) &&y<= (yalt+speedz)){katze=wohin[2][countz]; xalt+=speedz;  }//mright
          }
          //   if (Math.round(tutrandom) ==8 && zeit3 ==48) {meme=0;}
          //if (zeit3>120){meme=0;}
          xcatz=xalt; ycatz=yalt;
          bewegz(katze);
        }

        function animierzufallig() {
                if(daa==1){
                if( istani> 4) {katze=actionenrand[Math.round(tutrandom)][tutcounter];}
                if( istani<=4) {katze=1;}
        }}
        function zeitreise() {
                if (zeit6 <suchminimumzeit&& spooldone ==1) {zeit6++;getnextt=3;}
                zeit1++;zeit2++;if (zeit3 <60) {zeit3++;} zeit4++; zeit5++;
                if (zeit1 >=zeit1random ){tutrandom= Math.random()*9; zeit1=0; if (spooldone==1) {malkreier=0; fillmeowzbuffer(Math.round(Math.random()*(katzensagenmenge-3))); }
                if (Math.round(tutrandom) !=8) {zeit1random=Math.random()*140+90; istani=Math.random()*10;}
                if(zeit5 > showeran && spooldone ==1){ spooldone=0;  }
             //   if (zeit6 > (suchminimumzeit-3)){zeit6++;}
                if (zeit6 >showeraus &&spooldone==1){zeit5=0; zeit6=0; spooldone=0; showeran =Math.random()*400+300; showeraus=Math.random()*1+3;}}
                if (Math.round(tutrandom) ==8) {if (malkreier ==0) {fillmeowzbuffer(13); malkreier=1;} zeit1random=Math.random()*300+650; istani=6; wohinzufallzeit=Math.random()*300+700;}
                
                if (zeit2 >=20){tutcounter++;if (tutcounter >=2) {tutcounter=0;}zeit2=0;}
                setTimeout('zeitreise()',10);
        }
        function wuselirgentwohin() {
                wohinrandomx=xcatz+Math.random()*400-200; wohinrandomy=ycatz+Math.random()*400-200;
                if (zeit4 > wohinzufallzeit && getnextt==1){zeit4=0; getnextt=2; wohinzufallzeit=Math.random()*150+80; often=Math.random()*8+2;}
                if (getnextt ==2) {zeit5++; if(daa==1){zeit5=100;}}
             //  if (oftenist > often && getnextt==2 &&spooldone ==1) {getnextt=1;}
                if (getnextt ==2 && (zeit5 > 40 || daa ==1)) {
                if ((wohinrandomx)< (document.body.clientHeight-document.body.scrollTop-600) && (wohinrandomx)> 100 ) {xchaos=wohinrandomx;oftenist++;}
                if ((wohinrandomy)< (document.body.clientWidth-document.body.scrollLeft-600) && (wohinrandomy)> 100 ) {ychaos=wohinrandomy;oftenist++;} zeit5=0;
                }
        }
        function fillmeowzbuffer(cuteszeugs){
           durchlaufcounter=0; color =0; countyy=1; zeit6=0;
           //    if ((Math.random()*20) <6) { meme=1; } else{meme=0;}
           if (getnextt ==0){cuteszeugs =8;}
           meowcach ="";
           if (cuteszeugs ==0) {meowcach = katzensagen1.split('');}
           if (cuteszeugs ==1) {meowcach = katzensagen2.split('');}
           if (cuteszeugs ==2) {meowcach = katzensagen3.split('');}
           if (cuteszeugs ==3) {meowcach = katzensagen4.split('');}
           if (cuteszeugs ==4) {meowcach = katzensagen5.split('');}
           if (cuteszeugs ==5) {meowcach = katzensagen6.split('');}
           if (cuteszeugs ==6) {meowcach = katzensagen7.split('');}
           if (cuteszeugs ==7) {meowcach = katzensagen8.split('');}
           if (cuteszeugs ==8) {meowcach = katzensagen9.split('');}
           if (cuteszeugs ==9) {meowcach = katzensagen10.split('');}
           if (cuteszeugs ==10) {meowcach = katzensagen11.split('');}
           if (cuteszeugs ==11) {meowcach = katzensagen12.split('');}
           if (cuteszeugs ==12) {meowcach = katzensagen13.split('');}
           if (cuteszeugs ==13) {meowcach = katzensagen14.split('');}
           if (cuteszeugs ==14) {meowcach = katzensagen15.split('');}
           if (cuteszeugs ==15) {meowcach = katzensagen16.split('');}
           if (cuteszeugs ==16) {meowcach = katzensagen17.split('');}
        } 
        function mewmewmew() {
            if (spooldone==0) { document.all["blubb"].style.position = "absolute"; 
               textposx= 20+Math.random()*2+xcatz;
               textposy= -30+Math.random()*2+ycatz;
               document.all["blubb"].style.left = textposx+'px';  document.all["blubb"].style.top = textposy+'px'; 
               document.all["meowz"].style.left = 5+textposx+'px';  document.all["meowz"].style.top = textposy+'px';
               haarkneul="";
               for(var iy=0 ; iy< 18; iy++){ haarkneul +=meowcach[iy];} 
               meowcach[meowcach.length]= meowcach[0];
               meowcach.splice( 0,1);
               document.all["meowz"].style.color="#00ff00"; //or use rainbowarray rainbow[chosencolor]
               document.getElementById("meowz").textContent=haarkneul;
               durchlaufcounter++; 
               if (durchlaufcounter> (meowcach.length*3)){ spooldone=1;meme=0;}
               if (cuteszeugs ==12){wuseldahin(0,0,0);}}//document.getElementById('commentForm').innerHeight;
            if (meme ==0) { document.all["blubb"].style.position = "absolute"; document.all["meowz"].style.position = "absolute"; 
                document.all["blubb"].style.left =  -120+'px';  document.all["blubb"].style.top = -120+'px'; 
                document.all["meowz"].style.left =  -120+'px';  document.all["meowz"].style.top = -120+'px'; meme=1; }
            setTimeout('mewmewmew()',100);
        }
        function holdiemaus() {
            if (spooldone==1){fillmeowzbuffer(Math.round(Math.random()*2+(katzensagenmenge-2)));   getmouse();  getnextt=3; spooldone=0;  zeit6=0; suchminimumzeit= Math.random()*50+400; }
        }
        function wusel() {   
            getmouse(); 
            if (getnextt==0) {initdieCATZ(-40,kommeaufy);}
            if (getnextt==1) {xchaos=ym; ychaos=xm; wuseldahin(xchaos,ychaos,0);}
            if (getnextt==2) { wuselirgentwohin(); wuseldahin(xchaos,ychaos,0);}
            if (getnextt==3)  {wuseldahin(xm,ym,0);}
            animierzufallig();
            setTimeout('wusel()',100);
         }
 
        getmouse(); 
        leszeugs();
        wusel();
        mewmewmew();
        zeitreise();