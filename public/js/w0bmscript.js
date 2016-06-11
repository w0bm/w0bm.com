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
if($('video').length) {
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
        else if(e.keyCode == 67 && !e.ctrlKey) {
            $(".comments").fadeToggle(localStorage.comments = !(localStorage.comments == "true"));
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
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        if($('#bg').css('display') != 'none') $('#togglebg').click();
    }
}

function get_next() {
    var next = $('#next');
    if(next.css('visibility') != 'hidden') {
        next.get(0).click();
    }
}

function get_prev() {
    var prev = $('#prev');
    if(prev.css('visibility') != 'hidden') {
        prev.get(0).click();
    }
}

function get_random() {
    $('#prev').next().get(0).click();
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

    function updaterow(ctx, video) {
        console.log(video);
        var row = ctx.parents('tr');
        row.find('span').show();
        row.find('input, select').hide();
        row.find('.vinterpret').html(video.interpret || '');
        row.find('.vsongtitle').html(video.songtitle || '');
        row.find('.vimgsource').html(video.imgsource || '');
        row.find('.vcategory').html('<a href="/' + video.category.shortname + '">' + video.category.name + '</a>');
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    var indexform = $('.indexform, #webmedit');
    $('.indexedit').find('input, select').hide();
    if(indexform.length) {
        var row = $('tr');
        row.on('click touchdown', function(e) {
            var self = $(this);
            self.find('input, select').show();
            self.find('span').hide();
        });
    }
    indexform.on('submit', function (e) {
        var self = $(this);
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: self.attr('action'),
            data: self.serialize()
        }).done(function (data) {
            flash('success', 'Video successfully updated');
            updaterow(self, data);
            self.find('#webmeditmodal').modal('hide');
        }).fail(function(data){
            flash('error', 'Error updating video');
            flash('error', data);
            console.log(data);
            self.find('#webmeditmodal').modal('hide');
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
    if (v == null) return;
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


(function($) {
    var comments = localStorage.comments;
    if (comments === undefined) localStorage.comments = true;
    comments = comments === undefined || comments === "true";
    $(".comments").toggle(comments);
    $("#toggle").click(function(){$(".comments").fadeToggle(localStorage.comments = !(localStorage.comments == "true"))});
})(jQuery);


if(/\..+\/(?:songindex|user)/i.test(window.location.href)) {
    function get_loc(e) {
        return [
            (e.clientX + $('div#thumb').width() >= $(window).width()) ? e.pageX - 5 - $('div#thumb').width() : e.pageX + 5,
            (e.clientY + $('div#thumb').height() >= $(window).height()) ? e.pageY - 5 - $('div#thumb').height() : e.pageY + 5
        ];
    }

    $(document).ready(function() {
        $('table tbody tr').on('mouseenter', function(e) {
            var id = $(this).attr('data-thumb');
            var lnk = 'https://w0bm.com/thumbs/' + id + '.gif';
            var loc = get_loc(e);
            $(document.body).prepend('<div id="thumb"></div>');
            $('div#thumb').prepend('<img id="thumb"/>');
            $('img#thumb').text('Loading...');
            $('div#thumb').css({
                'position': 'absolute',
                'left': loc[0],
                'top': loc[1],
                'z-index': '5',
                'border': '1px white solid',
                'box-shadow': '5px 5px 7px 0px rgba(0,0,0,0.75)',
                'color': 'white',
                'background-color': '#181818'
            });
            var img = $('img#thumb');
            var thumb = $('<img/>');
            thumb.load(function() {
                img.attr("src", $(this).attr("src"));
                loc = get_loc(e);
                $('div#thumb').css({
                    'left': loc[0],
                    'top': loc[1]
                });
            });
            thumb.attr("src", lnk);
        }).on('mousemove', function(e) {
            $('div#thumb').css({
                'left': get_loc(e)[0],
                'top': get_loc(e)[1]
            });
        }).on('mouseleave', function() {
            $('#thumb').remove();
        });
    });
}

//enable bootstrap tooltips
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});


// Notifications
(function($) {
    if(typeof Handlebars == "undefined") return; // only on profilelayout

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    var paginate = function(pagination, options) {
        var type = options.hash.type || 'middle';
        var ret = '';
        var pageCount = Number(pagination.pageCount);
        var page = Number(pagination.page);
        var limit;
        if (options.hash.limit) limit = +options.hash.limit;

        //page pageCount
        var newContext = {};
        switch (type) {
            case 'middle':
                if (typeof limit === 'number') {
                    var i = 0;
                    var leftCount = Math.ceil(limit / 2) - 1;
                    var rightCount = limit - leftCount - 1;
                    if (page + rightCount > pageCount)
                        leftCount = limit - (pageCount - page) - 1;
                    if (page - leftCount < 1)
                        leftCount = page - 1;
                    var start = page - leftCount;

                    while (i < limit && i < pageCount) {
                        newContext = { n: start };
                        if (start === page) newContext.active = true;
                        ret = ret + options.fn(newContext);
                        start++;
                        i++;
                    }
                }
                else {
                    for (var i = 1; i <= pageCount; i++) {
                        newContext = { n: i };
                        if (i === page) newContext.active = true;
                        ret = ret + options.fn(newContext);
                    }
                }
                break;
            case 'previous':
                if (page === 1) {
                    newContext = { disabled: true, n: 1 }
                }
                else {
                    newContext = { n: page - 1 }
                }
                ret = ret + options.fn(newContext);
                break;
            case 'next':
                newContext = {};
                if (page === pageCount) {
                    newContext = { disabled: true, n: pageCount }
                }
                else {
                    newContext = { n: page + 1 }
                }
                ret = ret + options.fn(newContext);
                break;
            case 'first':
                if (page === 1) {
                    newContext = { disabled: true, n: 1 }
                }
                else {
                    newContext = { n: 1 }
                }
                ret = ret + options.fn(newContext);
                break;
            case 'last':
                if (page === pageCount) {
                    newContext = { disabled: true, n: pageCount }
                }
                else {
                    newContext = { n: pageCount }
                }
                ret = ret + options.fn(newContext);
                break;
        }

        return ret;
    };

    Handlebars.registerHelper('paginate', paginate);


    var msglist = Handlebars.compile($('#msglist').html());
    var msgtmpl = Handlebars.compile($('#msgtmpl').html());
    var pagination = Handlebars.compile($('#paginationtmpl').html());
    var jsondata = {};

    var getMessages = function(url) {
        if(!url) url = '/api/messages';

        $.getJSON(url)
            .done(function(data) {
                $('.spinner').hide();
                jsondata = data;
                $('#list').html(msglist(data));

                var page = {
                    pagination: {
                        page: data.current_page,
                        pageCount: data.last_page
                    }
                };

                $('#pagination').html(pagination(page));

                $('#pagination a').on('click touchdown', function(e) {
                    e.preventDefault();
                    getMessages($(this).attr('href'));
                });

                $('#listitems a').on('click touchdown', function(e) {
                    e.preventDefault();
                    var self = $(this);
                    var i = self.data('index');

                    $('#message').html(msgtmpl(jsondata.data[i]));
                    if(!jsondata.data[i].read) {

                        $.post('/api/messages/read','m_ids[]=' + self.data('id'))
                            .done(function(data) {
                                self.removeClass('list-group-item-info');
                            });

                    }
                    $('a').removeClass('active');
                    self.addClass('active');
                    $('time.timeago').timeago();

                });
            });
    };
    getMessages();
})(jQuery);
