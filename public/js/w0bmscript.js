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
    var player = videojs(video, {
        controls: true,
        playbackRates: [0.25, 0.5, 1, 1.5, 2],
        inactivityTimeout: 0,
        controlBar: {
            children: {
                'playToggle': {},
                'progressControl': {},
                'currentTimeDisplay': {},
                'timeDivider': {},
                'durationDisplay': {},
                'volumeControl': {},
                'playbackRateMenuButton': {},
                'fullscreenToggle': {}
            }
        }
    }, function() {
        this.addClass('video-js');
        this.volume(0.3);
        if (typeof localStorage != "undefined") {
            this.volume(localStorage.getItem("volume") || 0.3);
            this.on("volumechange", function () {
                localStorage.setItem("volume", this.volume());
            });
        }
    });

    if(localStorage.getItem('background') == undefined) {
        if($.browser.mobile)
            localStorage.setItem('background', 'false');
        else
            localStorage.setItem('background', 'true');
    }
    var background = localStorage.getItem('background') === 'true';

    var canvas = document.getElementById('bg');
    var context = canvas.getContext('2d');
    var cw = canvas.width = canvas.clientWidth | 0;
    var ch = canvas.height = canvas.clientHeight | 0;

    if(!background)
        $(canvas).css('display', 'none');

    function animationLoop() {
        if(video.paused || video.ended || !background)
            return;
        context.drawImage(video, 0, 0, cw, ch);
        window.requestAnimFrame(animationLoop);
    }

    video.addEventListener('play', animationLoop);

    $('#togglebg').on('click', function (e) {
        e.preventDefault();
        background = !background;
        localStorage.setItem('background', background.toString());
        if(background)
            $(canvas).css('display', 'block');
        else
            $(canvas).css('display', 'none');
        animationLoop();
    });


    function getNext() {
        var next = $('#next');
        if(next.css('visibility') != 'hidden') {
            next.get(0).click();
        }
    }

    function getPrev() {
        var prev = $('#prev');
        if(prev.css('visibility') != 'hidden') {
            prev.get(0).click();
        }
    }

    //Key Bindings
    $('html').on('keydown', function(e) {
        if(e.defaultPrevented || e.target.nodeName.match(/\b(input|textarea)\b/i) || $(e.target).attr('contenteditable') == 'true')
            return;

        //arrow keys
        else if(e.keyCode == 39)
            getNext();
        else if(e.keyCode == 37)
            getPrev();

        //gamer-style
        else if(e.keyCode == 65)
            getPrev();
        else if(e.keyCode == 68)
            getNext();

        //vi style
        else if(e.keyCode == 72)
            getPrev();
        else if(e.keyCode == 76)
            getNext();

        else if(e.keyCode == 82) //click random
            $('#prev').next().get(0).click();

        else if(e.keyCode == 70) //add fav
            $('#fav').get(0).click();

        else if(e.keyCode == 67 && !e.ctrlKey) //toggle comments
            $(".comments").fadeToggle(localStorage.comments = !(localStorage.comments == "true"));

        else if(e.keyCode == 87 || e.keyCode == 38)
            player.volume(player.volume() + 0.1);

        else if(e.keyCode == 83 || e.keyCode == 40)
            player.volume(player.volume() - 0.1);
    });

    $('.wrapper > div').on('DOMMouseScroll mousewheel', function(e) {
        e.deltaY < 0 ? getNext() : getPrev();
        return false;
    });

} else {
    var canvas = document.getElementById('bg');
    canvas.parentNode.removeChild(canvas);
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
            var comment = $(data).appendTo('.commentwrapper').find('time.timeago');
            comment.timeago();
            comment.tooltip();
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
        if($('video').length) {
            var info = [];
            if(video.interpret) {
                info.push(' <strong>Interpret:</strong> ' + video.interpret);
            }
            if(video.songtitle) {
                info.push(' <strong>Songtitle:</strong> ' + video.songtitle);
            }
            if(video.imgsource) {
                info.push(' <strong>Video Source:</strong> ' + video.imgsource);
            }
            if(video.category.name) {
                info.push(' <strong>Category:</strong> ' + video.category.name);
            }
            $('span.fa-info-circle').attr('data-content', info.join('<br>'));
        }
        else {
            var row = ctx.parents('tr');
            row.find('span').show();
            row.find('input, select').hide();
            row.find('.vinterpret').html(video.interpret || '');
            row.find('.vsongtitle').html(video.songtitle || '');
            row.find('.vimgsource').html(video.imgsource || '');
            row.find('.vcategory').html('<a href="/' + video.category.shortname + '">' + video.category.name + '</a>');
        }
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
        row.on('dblclick touchdown', function(e) {
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
        html: true,
        trigger: 'manual',
        container: $(this).attr('id'),
        placement: 'top',
    }).on('mouseenter', function () {
        var _this = this;
        $(this).popover('show');
        $(this).siblings('.popover').on('mouseleave', function () {
            $(_this).popover('hide');
        });
    }).on('mouseleave', function () {
        var _this = this;
        setTimeout(function () {
            if (!$('.popover:hover').length) {
                $(_this).popover('hide')
            }
        }, 100);
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
    p.style.marginBottom = "3px";

    var bar = document.createElement("div");
    var outerBar = document.createElement("div");
    outerBar.appendChild(bar);
    p.appendChild(outerBar);

    $(outerBar).css({
        height: "3px", width: "100%",
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
            var id = $(this).data('thumb');
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

//Pagination
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


//enable bootstrap tooltips and timeago
$(function () {
    var s = $.timeago.settings;
    var str = s.strings;
    s.refreshMillis = 1000;
    //same format as laravel diffForHumans()
    str.seconds = "%d seconds";
    str.minute = "1 minute";
    str.hour = "1 hour";
    str.hours = "%d hours";
    str.day = "1 day";
    str.month = "1 month";
    str.year = "1 year";
    $('time.timeago').timeago();
    $('[data-toggle="tooltip"]').tooltip();
});

// Notifications
var messagesBadge = $('ul.navbar-right > li > a > span.badge');
var activeMessage;
if(messagesBadge.text() > 0) {
    messagesBadge.css('visibility', 'visible');
}

if(/\/user\/.+\/comments/i.test(location.href)) {
    //Comment View
    (function($) {
        if(typeof Handlebars == "undefined") return; // only on profilelayout

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        Handlebars.registerHelper('paginate', paginate);

        var comlist = Handlebars.compile($('#comlist').html());
        var pagination = Handlebars.compile($('#paginationtmpl').html());
        var jsondata = {};
        var username = location.href.match(/\/user\/(.+)\/comments/i)[1];

        var getMessages = function(url) {
            var baseUrl = '/api/comments';
            if(!url) url = baseUrl;

            $.getJSON(url, { 'username': username })
                .done(function(data) {
                    $('.spinner').hide();
                    jsondata = data;
                    $('#list').html(comlist(data));
                    $('time.timeago').timeago();
                    $('time[data-toggle="tooltip"]').tooltip();
                    var page = {
                        pagination: {
                            page: data.current_page,
                            pageCount: data.last_page
                        }
                    };

                    $('#pagination').html(pagination(page));

                    $('#pagination a').on('click touchdown', function(e) {
                        e.preventDefault();
                        getMessages(baseUrl + '?page=' + $(this).data('page'));
                    });
            });
        };
        getMessages();
    })(jQuery);
}
else {
    (function($) {
        if(typeof Handlebars == "undefined") return; // only on profilelayout

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        Handlebars.registerHelper('paginate', paginate);


        var msglist = Handlebars.compile($('#msglist').html());
        var msgtmpl = Handlebars.compile($('#msgtmpl').html());
        var pagination = Handlebars.compile($('#paginationtmpl').html());
        var jsondata = {};

        var getMessages = function(url) {
            var baseUrl = '/api/messages';
            if(!url) url = baseUrl;

            $.getJSON(url)
                .done(function(data) {
                    $('.spinner').hide();
                    jsondata = data;
                    $('#list').html(msglist(data));
                    if(typeof activeMessage != "undefined") $('#listitems a[data-id="' + activeMessage + '"]').addClass('active');

                    var page = {
                        pagination: {
                            page: data.current_page,
                            pageCount: data.last_page
                        }
                    };

                    $('#pagination').html(pagination(page));

                    $('#pagination a').on('click touchdown', function(e) {
                        e.preventDefault();
                        getMessages(baseUrl + '?page=' + $(this).data('page'));
                    });

                    $('#listitems a').on('click touchdown', function(e) {
                        e.preventDefault();
                        var self = $(this);
                        var i = self.data('index');
                        activeMessage = $(this).data('id');

                        $('#message').html(msgtmpl(jsondata.data[i]));
                        if(!jsondata.data[i].read) {

                            $.post('/api/messages/read','m_ids[]=' + self.data('id'))
                                .done(function(data) {
                                    self.removeClass('list-group-item-info');
                                    messagesBadge.text(messagesBadge.text() - 1);
                                    if(messagesBadge.text() <= 0) {
                                        messagesBadge.css('visibility', 'hidden');
                                    }
                                });

                        }
                        $('a').removeClass('active');
                        self.addClass('active');
                        $('time.timeago').timeago();
                        $('time[data-toggle="tooltip"]').tooltip();
                    });
                });
        };
        getMessages();
    })(jQuery);
}

function readAll() {
    $.ajax({
        url: '/api/messages/readall',
        success: function(data) {
            if(data == 1) {
                flash('success', 'Marked all messages as read');
                $('.list-group-item-info').removeClass('list-group-item-info');
                messagesBadge.text('0');
                messagesBadge.css('visibility', 'hidden');
            }
            else {
                flash('error', 'Failed to mark all messages as read');
                flash('error', data);
            }
        },
        error: function(jqxhr, status, error) {
            flash('error', 'Failed to mark all messages as read');
            flash('error', status);
            flash('error', error);
        }
    });
}

$('ul.dropdown-menu').on('click touchdown', function(e) {
    e.stopPropagation();
});

function deleteComment(self) {
    var comment = self.closest('div[data-id]');
    var id = comment.data('id');
    var username = $(comment.children('.panel-footer').children('a')[0]).text();
    do {
        var reason = prompt('Reason for deleting comment ' + id + ' by ' + username);
        if(reason == null)
            return;
    } while(reason == '');
    $.ajax({
        url: '/api/comments/' + comment.data('id') + '/delete',
        method: 'POST',
        data: { reason: reason },
        success: function(retval) {
            if(retval == 'success') {
                flash('success', 'Comment deleted');
                comment.removeClass('panel-default').addClass('panel-danger');
                comment.find('.panel-footer').children('a[onclick="deleteComment($(this))"]').replaceWith('<a href="#" onclick="restoreComment($(this))"><i style="color:green"; class="fa fa-refresh" aria-hidden="true"></i></a>');
                comment.find('.panel-footer > a[onclick="editComment($(this))"]').remove();
            }
            else if(retval == 'invalid_request') flash('error', 'Invalid request');
            else if(retval == 'not_logged_in') flash('error', 'Not logged in');
            else if(retval == 'insufficient_permissions') flash('error', 'Insufficient permissions');
            else flash('error', 'Unknown exception');
        },
        error: function(jqxhr, status, error) {
            flash('error', 'Unknwon exception');
            flash('error', status);
            flash('error', error);
        }
    });
}

function restoreComment(self) {
    var comment = self.closest('div[data-id]');
    var id = comment.data('id');
    var username = $(comment.children('.panel-footer').children('a')[0]).text();
    do {
        var reason = prompt('Reason for restoring comment ' + id + ' by ' + username);
        if(reason == null)
            return;
    } while(reason == '');
    console.log(reason);
    $.ajax({
        url: '/api/comments/' + comment.data('id') + '/restore',
        method: 'POST',
        data: { reason: reason },
        success: function(retval) {
            if(retval == 'success') {
                flash('success', 'Comment restored');
                comment.removeClass('panel-danger').addClass('panel-default');
                comment.find('.panel-footer').children('a[onclick]').replaceWith('<a href="#" onclick="deleteComment($(this))"><i style="color:red"; class="fa fa-times" aria-hidden="true"></i></a> <a href="#" onclick="editComment($(this))"><i style="color:cyan;" class="fa fa-pencil-square" aria-hidden="true"></i></a>');
            }
            else if(retval == 'invalid_request') flash('error', 'Invalid request');
            else if(retval == 'not_logged_in') flash('error', 'Not logged in');
            else if(retval == 'insufficient_permissions') flash('error', 'Insufficient permissions');
            else if(retval == 'comment_not_deleted') flash('error', 'Comment is not deleted');
            else flash('error', 'Unknown exception');
        },
        error: function(jqxhr, status, error) {
            flash('error', 'Failed restoring comment');
            flash('error', status);
            flash('error', error);
        }
    });
}

function editComment(self) {
    var comment = self.closest('div[data-id]');
    var body = comment.find('.panel-body');
    var id = comment.data('id');
    $.ajax({
        url: '/api/comments/' + id,
        success: function(retval) {
            if(retval.error == 'null') {
                var textarea = $('<textarea class="form-control">');
                body.replaceWith(textarea);
                textarea.val($('<div>').html(retval.comment).text());
                self.prev().remove();
                self.replaceWith('<a href="#" class="saveCommentEdit"><i class="fa fa-floppy-o" aria-hidden="true"></i></a> <a href="#" class="abortCommentEdit"><i style="color:red;" class="fa fa-ban" aria-hidden="true"></i></a>');
                comment.find('.abortCommentEdit').on('click', function(e) {
                    e.preventDefault();
                    $(this).prev().remove();
                    $(this).replaceWith('<a href="#" onclick="deleteComment($(this))"><i style="color:red"; class="fa fa-times" aria-hidden="true"></i></a> <a href="#" onclick="editComment($(this))"><i style="color:cyan;" class="fa fa-pencil-square" aria-hidden="true"></i></a>');
                    textarea.replaceWith(body);
                });
                comment.find('.saveCommentEdit').on('click', function(e) {
                    e.preventDefault();
                    var _this = $(this);
                    $.ajax({
                        url: '/api/comments/' + id + '/edit',
                        method: 'POST',
                        data: { comment: textarea.val() },
                        success: function(retval) {
                            if(retval.error == 'null') {
                                body.html(retval.rendered_comment);
                                flash('success', 'Comment edited successfully');
                            }
                            else if(retval.error == 'invalid_request')
                                flash('error', 'Invalid request was sent by your browser');
                            else if(retval.error == 'not_logged_in')
                                flash('error', 'Not logged in');
                            else if(retval.error == 'insufficient_permissions')
                                flash('error', 'Insufficient permissions');
                            else if(retval.error == 'comment_not_found')
                                flash('error', 'Comment does not exist');
                            else
                                flash('error', 'Unknown exception');
                        },
                        error: function(jqxhr, status, error) {
                            flash('error', 'Unknown exception');
                            flash('error', status);
                            flash('error', error);
                        },
                        complete: function() {
                            textarea.replaceWith(body);
                            _this.next().remove();
                            _this.replaceWith('<a href="#" onclick="deleteComment($(this))"><i style="color:red"; class="fa fa-times" aria-hidden="true"></i></a> <a href="#" onclick="editComment($(this))"><i style="color:cyan;" class="fa fa-pencil-square" aria-hidden="true"></i></a>');
                        }
                    });
                });
            }
            else if(retval.error == 'comment_not_found')
                flash('error', 'Comment does not exist');
            else
                flash('error', 'Unknown exception');
        },
        error: function(jqxhr, status, error) {
            flash('error', 'Failed receiving non-rendered comment from API');
            flash('error', status);
            flash('error', error);
        }
    });
}

$(function () {
    var cBar = $('.vjs-control-bar');
    var cBarStatus = false;
    $('video').on('mousemove', function () {
        if(cBarStatus) return;
        cBar.css('display', 'flex');
        cBarStatus = true;
    }).on('mouseleave', function (e) {
        if($(e.relatedTarget).is('[class^="vjs"]') || !cBarStatus) return;
        cBar.hide();
        cBarStatus = false;
    });
    $('[class^="vjs"').on('mouseleave', function (e) {
        if(e.relatedTarget == $('video').get(0) || $(e.relatedTarget).is('[class^="vjs"]') || !cBarStatus) return;
        cBar.hide();
        cBarStatus = false;
    });
});
