<!doctype html>
<html lang="de">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width,initial-scale=1">
    <meta charset="UTF-8">
    <meta name="_token" content="{{csrf_token()}}">
    <link rel="icon" href="/favicon.png">
    <title>w0bm.com - WebMs with sound!</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/jquery.mcustomscrollbar/3.0.6/jquery.mCustomScrollbar.min.css">
    <link rel="favicon" 
      type="image/ico" 
      href="favicon.ico" />
    <link href="//fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/w0bmcustom.css') }}">
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
<script src="/js/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/js/isotope.pkgd.min.js"></script>
<script src="/js/imagesloaded.pkgd.min.js"></script>
<script>
    function flash(type, message) {
        var html = '<div class="alert alert-:TYPE: alert-dismissable" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>:REPLACE:</div>';
        var alerts = $('.flashcontainer > .container');
        if(type === 'error') type = 'danger';
        alerts.append(html.replace(/:TYPE:/, type).replace(/:REPLACE:/, message));
        alertrm(jQuery);
    }

    window.requestAnimFrame = (function(){
        return window.requestAnimationFrame
                || window.webkitRequestAnimationFrame
                || window.mozRequestAnimationFrame
                || function(callback) { window.setTimeout(callback, 1000 / 60);};
    })();

    var video = document.getElementById('video');
    if(video !== null) {
        video.volume = 0.3;
        if (typeof localStorage != "undefined") {
            video.volume = localStorage.getItem("volume") || 0.3;
            video.addEventListener("volumechange", function () {
                localStorage.setItem("volume", video.volume);
            });
        }

        var canvas = document.getElementById('bg');
        var context = canvas.getContext('2d');
        var cw = canvas.width = canvas.clientWidth|0;
        var ch = canvas.height = canvas.clientHeight|0;

        function animationLoop() {
            if(video.paused || video.ended)
                return false;
             context.drawImage(video, 0, 0, cw, ch);
             window.requestAnimFrame(animationLoop);
        }
        video.addEventListener('play', function() {
            animationLoop();
        });
        if(video.autoplay)
            animationLoop();

    } else {
        var canvas = document.getElementById('bg');
        canvas.parentNode.removeChild(canvas);
    }
    
    //temporary fix for scrolling not working on other pages
    var regex = /w0bm.com\/(?:.+\/)?(\d+)/i;
    if(regex.test(window.location.href) && $('video').length) {
        $('html').on('keydown', function(e) {
            if(e.defaultPrevented || e.target.nodeName.match(/\b(input|textarea)\b/i)) {
                return;
            }
            else if(e.keyCode == 39) {
                get_next();
            }
            else if(e.keyCode == 37) {
                get_prev();
            }
            else if(e.keyCode == 82) {
                get_random();
            }
            else if(e.keyCode == 70) {
            	to_favs();
            }
        });
        $('.wrapper > div').on('DOMMouseScroll mousewheel', function(e) {
            e.deltaY < 0 ? get_next() : get_prev();
        	return false;
        });
        if(navigator.userAgent.toLowerCase().indexOf('chrome') > -1) {
            $('video').on('click', function() {
	            $(this).get(0).paused ? $(this).get(0).play() : $(this).get(0).pause();
            });
        }
    }
    
    function get_next() {
        if($('#next').css('visibility') != 'hidden') {
            $('#next').get(0).click();
        }
    }
    
    function get_prev() {
        if($('#prev').css('visibility') != 'hidden') {
            $('#prev').get(0).click();
        }
    }
    
    function get_random() {
        $('a:contains(random)').get(0).click();
    }
    
    function to_favs() {
    	$('#fav').get(0).click();
    }

    (function ($) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        var commentform = $('#commentForm');
        commentform.on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: commentform.attr('action'),
                data: commentform.serialize()
            }).done(function (data) {
                flash('success', 'Comment saved successfully');
                $('.nocomments').remove();
                $('.commentwrapper').append(data);
                var textarea = commentform.find('textarea').val('');
                textarea.blur();
            }).fail(function(data){
                flash('error', 'Error saving comment');
                flash('error', data);
            });
        });
    })(jQuery);


    (function ($) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        var favBtn = $('#fav');
        favBtn.on('click touchdown', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'GET',
                url: favBtn.attr('href')
            }).done(function (data) {
                flash('success', data);
                var icon = favBtn.find('i');
                if(icon.hasClass('fa-heart-o')) {
                    icon.removeClass('fa-heart-o');
                    icon.addClass('fa-heart');
                } else {
                    icon.removeClass('fa-heart');
                    icon.addClass('fa-heart-o');
                }
            });
        })
    })(jQuery);

    (function ($) {
        $('#togglebg').on('click touchdown', function (e) {
            e.preventDefault();
            $.ajax({
                dataType: 'json',
                url: $(this).attr('href'),
                data: {}
            }).done(function () {
                $('#bg').toggle();
            });
        });
    })(jQuery);

    (function ($) {
        $(':not(form)[data-confirm]').on('click touchdown', function () {
            return confirm($(this).data('confirm'));
        });
    })(jQuery);

    (function ($) {
        $(".comments").mCustomScrollbar({
            axis: 'y',
            theme: 'minimal',
            scrollInertia: 0
        });
    })(jQuery);

    var alertrm = function ($) {
        $('.alert').each(function (index) {
            $(this).delay(3000 + index * 1000).slideUp(300);
        });
    };
    alertrm(jQuery);

    $('#categories').imagesLoaded(function () {
        $('#categories').isotope({
            itemSelector: '.category',
            percentPosition: true,
            layoutMode: 'masonry'
        });
    });

    $(function() {
        $('[data-toggle="popover"]').popover({
            html: true
        });
    });

    /* bye bye kadse D: greetz gz
    (function() {
        new Image().src = "/images/catfart/cutf.png";
        var n = document.createElement("div");
        var a = new Audio();

        a.addEventListener("pause", function () {
            n.setAttribute("class", "catfart");
        });

        a.addEventListener("play", function () {
            n.setAttribute("class", "catfart farting");
        });

        n.addEventListener("mouseover", function () {
            if (!a.paused) return;
            a.src = "/images/catfart/pupsi" + (Math.random()*28|0) + ".mp3";
            a.play();
        });

        n.setAttribute("class", "catfart");
        document.body.appendChild(n);
    })();*/

    (function() {
        var v = document.getElementById("video");
        if (typeof v == "undefined") return;
        var p = v.parentNode;
        p.style.marginBottom = "1px";

        var bar = document.createElement("div");
        var outerBar = document.createElement("div");
        outerBar.appendChild(bar);
        p.appendChild(outerBar);

        $(outerBar).css({
            height: "1px", width: "100%",
            overflow: "hidden", willChange: "transform",
            position: "absolute", bottom: "0"
        });

        $(bar).css({
            height: "inherit", width: "inherit",
            position: "absolute", transform: "translateX(-100%)",
            backgroundColor: "rgba(31, 178, 176, 0.4)"
        });

        var update = function () {
            requestAnimationFrame(update);
            if (v.paused) return;
            var perc = 100 / v.duration * v.currentTime;
            bar.style.transform = "translateX("+(-100 + perc)+"%)";
        };
        update();
    })();
</script>
</body>
</html>
