<!doctype html>
<html lang="de">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"">
    <meta name="viewport"
          content="width=device-width,initial-scale=1">
    <meta charset="UTF-8">
    <title>w0b me</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.5/slate/bootstrap.min.css">
    <style>
        body {
            padding-top: 70px;
        }
        .flashcontainer {
            position:fixed;
            margin:0 auto;
            left:0;
            right:0;
            bottom:100px;
            opacity: 0.8;
            z-index: 5;
        }
        .flashcontainer:empty {
            display:none;
        }
        .navbar{
            min-height:20px;
            position: absolute;
            top:0;
            left:0;
            right:0;
        }
        .navbar-form input {
            background: rgba(32, 32, 32, 0.3);
            color: #eee;
        }
        #bg {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 100%;
            -webkit-filter: blur(100px);
            filter:blur(100px);
            transform: translate3d(0, 0, 0);
            z-index: -1;
        }
        .navbar-inverse {
            background-color: rgba(32, 32, 32, 0.6);
            border-color: transparent;
            z-index: 3;
        }
        .vertical-align {
            min-height: calc(100% - 70px);
            min-height: calc(100vh - 70px);
            display: flex;
            align-items: center;

        }
        .wrapper {
            width: 100%;
        }
        .row {
            width: 100%;
        }
    </style>
</head>
<body>
<canvas id="bg"></canvas>

@include('partials.navigation')

<div class="container">
    @yield('content')
</div>


@include('partials.flash')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script>
    var video = document.getElementById('video');
    if(video !== null) {
        video.volume = 0.3;
        video.play();


        var canvas = document.getElementById('bg'),
                context = canvas.getContext('2d'),
                cw = canvas.clientWidth | 0,
                ch = canvas.clientHeight | 0;

        canvas.width = cw;
        canvas.height = ch;

        video.addEventListener('play', function() {
            draw(this,context,cw,ch);
        }, false);


        function draw(v,c,w,h) {
            if(v.paused || v.ended) return false;
            c.drawImage(v,0,0,w,h);

            setTimeout(draw,20,v,c,w,h);
        }

    } else {
        var canvas = document.getElementById('bg');
        canvas.parentNode.removeChild(canvas);
    }

    (function(){
        document.onkeydown = checkKey;
        var prev = document.getElementById('prev');
        var next = document.getElementById('next');
        function checkKey(event) {
            if (event.defaultPrevented) {
                return;
            }
            if(prev == undefined || next == undefined) return;
            if(event.keyIdentifier == 'Left') {
                if(prev.style.visibility == 'hidden') {
                    return;
                }
                prev.click();
            } else if(event.keyIdentifier == 'Right') {
                if(next.style.visibility == 'hidden') {
                    return;
                }
                next.click();
            }
        }
    })();


</script>
</body>
</html>