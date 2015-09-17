<!doctype html>
<html lang="de">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"">
    <meta name="viewport"
          content="width=device-width,initial-scale=1">
    <meta charset="UTF-8">
    <meta name="_token" content="{{csrf_token()}}">
    <title>w0b me</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/jquery.mcustomscrollbar/3.0.6/jquery.mCustomScrollbar.min.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css">
    <link rel="favicon" 
      type="image/png" 
      href="favicon.png" />
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <style>
        .flashcontainer {
            position:absolute;
            top:20px;
            opacity: 0.8;
            z-index: 5;
            width: 100%
        }
        .flashcontainer:empty {
            display:none;
        }
        .navbar {
            margin-bottom: 0;
        }
        .navbar-form > .form-group > input.form-control {
            background: rgba(32, 32, 32, 0.3);
            color: #c8c8c8;
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
            border: 0;
            z-index: 3;
        }
        .vertical-align {
            min-height: calc(100% - 50px);
            min-height: calc(100vh - 50px);
            display: flex;
            align-items: center;
        }
        .wrapper {
            width: 100%;
        }
        .row {
            width: 100%;
        }
        .comments {
            float: left;
            height: calc(100% - 50px);
            height: calc(100vh - 50px);
            width: 350px;
            background: rgba(32, 32, 32, 0.6);
            padding: 5px;
            overflow-y: scroll;
            border-right: 1px solid #3F3F3F;
        }
        .comments textarea {
            color: #c8c8c8;
            background: rgba(90, 88, 88, 0.4) none repeat scroll 0% 0%;
            height: 2.7em;
            resize: vertical;
            -webkit-transition: height 0.8s;
            -moz-transition: height 0.8s;
            transition: height 0.8s;
        }
        .comments textarea:active, .comments textarea:focus, .comments textarea:valid {
            height: 8em;
        }
        a[rel=extern]:after {
            content: "\f08e";
        }
    </style>
</head>
<body>
<canvas id="bg" @if(!Session::get('background', true)) style="display: none;"@endif></canvas>

@include('partials.navigation')

<div class="wrapper">
    @yield('aside')
    <div style="width: auto; overflow: hidden; position: relative;">
        <div class="container">
            @yield('content')
        </div>
        @include('partials.flash')
    </div>

</div>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="//cdn.jsdelivr.net/jquery.mcustomscrollbar/3.0.6/jquery.mCustomScrollbar.concat.min.js"></script>
<script>
    var video = document.getElementById('video');
    if(video !== null) {
        video.volume = 0.3;
        video.play();


        var canvas = document.getElementById('bg'),
                context = canvas.getContext('2d'),
                cw = canvas.clientWidth ,
                ch = canvas.clientHeight;


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

    (function($){
        document.onkeydown = checkKey;

        var prev = document.getElementById('prev');
        var next = document.getElementById('next');
        function checkKey(event) {
            if (event.defaultPrevented || event.target.nodeName.match(/\b(input|textarea)\b/i) ) {
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
    })(jQuery);

    (function($){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $('#togglebg').on('click touchdown', function(e) {
            e.preventDefault();
            $.ajax({
                dataType: 'json',
                url: $(this).attr('href'),
                data: {}
            }).done(function() {
                $('#bg').toggle();
            });
        });
    })(jQuery);

    (function($) {
        $(':not(form)[data-confirm]').on('click touchdown', function(){
            return confirm($(this).data('confirm'));
        });
    })(jQuery);

    (function($){
        $(".comments").mCustomScrollbar({
            axis: 'y',
            theme: 'minimal',
            scrollInertia: 0
        });
    })(jQuery);

    (function ($) {
        $('.alert').each(function(index) {
            $(this).delay(3000 + index * 1000).slideUp(300);
        });
    })(jQuery);


</script>
</body>
</html>
