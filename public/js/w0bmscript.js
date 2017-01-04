class API {
    static request(post, base, method, params, callback) {
        $.ajax({
            url: '/api/' + base + '/' + method,
            method: post ? 'POST' : 'GET',
            data: params,
            success: cb => {
                if(cb.error === 'null')
                    callback(true, null, cb.warnings, cb);
                else
                    callback(false, this.responsify(cb.error), cb.warnings, cb);
            },
            error: cb => callback(false, null, null, cb)
        });
    }
    static responsify(response) {
        var r = (type, text) => ({type: type, text: text});
        return {
            not_logged_in: r('error', 'Not logged in'),
            invalid_request: r('error', 'Invalid request'),
            video_not_found: r('error', 'Video not found. Perhaps it has already been deleted'),
            insufficient_permissions: r('error', 'Insufficient permissions'),
            no_tags_specified: r('info', 'No tags specified')
        }[response];
    }
}

class Video {
    constructor() {
        let match = location.href.match(/(\d+)(?!.*\/.)/);
        if(!match) return;
        this.id = match[1];
        this.user = $('.fa-info-circle').next().children().text().trim();
        this.tags = $.makeArray($('#tag-display').children().children()).map(el => el.innerText).filter(tag => !!tag);
        this.api = 'video';
        this.apiBase = this.api + '/' + this.id;
    }
    tag(tags, callback) {
        var _this = this;
        function preCallback(success, error, warnings, cb) {
            if(success) {
                _this.tags = [];
                _this.tags = cb.tags.map(tag => tag.name);
            }
            callback(success, error, warnings, cb);
        }
        tags.length ? API.request(true, this.apiBase, 'tag', {tags: tags}, preCallback) : callback(false, API.responsify('no_tags_specified'), null, null);
    }
    untag(tag, callback) {
        var _this = this;
        function preCallback(success, error, warnings, cb) {
            if(success) {
                _this.tags = [];
                _this.tags = cb.tags.map(tag => tag.name);
            }
            callback(success, error, warnings, cb);
        }
        tag = tag.trim();
        !!tag ? API.request(true, this.apiBase, 'untag', {tag: tag}, preCallback) : callback(false, API.responsify('invalid_request'), null, null);
    }
    delete(reason, callback) {
        reason = reason.trim();
        !!reason ? API.request(true, this.apiBase, 'delete', {reason: reason}, callback) : callback(false, API.responsify('invalid_request'), null, null);
    }
}

var video;
$(function() {
    video = new Video();
    if(!video.id) video = null;
});

//CSRF Token AjaxSetup
$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
});

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

Array.prototype.average = function() {
    var sum = 0;
    for(var i = 0; i < this.length; i++)
        sum += this[i];
    return sum / this.length;
};

var videoElem = document.getElementById('video');
if(videoElem !== null) {
    var player = videojs(videoElem, {
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
        if(videoElem.paused || videoElem.ended || !background)
            return;
        context.drawImage(videoElem, 0, 0, cw, ch);
        window.requestAnimFrame(animationLoop);
    }

    videoElem.addEventListener('play', animationLoop);

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
    $(document).on('keydown', function(e) {
        if(e.defaultPrevented || e.target.nodeName.match(/\b(input|textarea)\b/i) || e.ctrlKey || e.altKey || e.shiftKey)
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

        else if(e.keyCode == 67) //toggle comments
            $(".aside").fadeToggle(localStorage.comments = !(localStorage.comments == "true"));

        else if(e.keyCode == 87 || e.keyCode == 38)
            player.volume(player.volume() + 0.1);

        else if(e.keyCode == 83 || e.keyCode == 40)
            player.volume(player.volume() - 0.1);

        else if(e.keyCode == 32)
            player.paused() ? player.play() : player.pause();
    });

    $('.wrapper > div:not(.aside)').on('DOMMouseScroll mousewheel', function(e) {
        if(e.ctrlKey || e.altKey || e.shiftKey)
            return;
        e.preventDefault();
        e.deltaY < 0 ? getNext() : getPrev();
    });
} else {
    var canvas = document.getElementById('bg');
    canvas.parentNode.removeChild(canvas);
}

function commentClickableTimestamp(e) {
    e.preventDefault();
    if(!player) return;
    var match = $(e.target).text().match(/(\d{1,2}):(\d{2})/);
    if(match) {
        var seek = parseInt(match[1]) * 60 + parseInt(match[2]);
        if(seek <= player.duration()) player.currentTime(seek);
    }
}


$(function() {
    $('.comment_clickable_timestamp').on('click', commentClickableTimestamp);
});


(function ($) {
    // Comments
    var commentform = $('#commentForm > form');
    let lastComment = "";
    commentform.on('submit', function (e) {
        e.preventDefault();

        // double comment prevention:
        const data = commentform.serialize();
        if (data == lastComment) {
            alert("nope. just don't. seriously... don't.");
            return false;
        }
        lastComment = data;

        $.ajax({
            type: 'POST',
            url: commentform.attr('action'),
            data: data
        }).done(function (data) {
            flash('success', 'Comment saved successfully');
            $('.nocomments').remove();
            var comment = $(data).appendTo('.commentwrapper').find('time.timeago');
            comment.timeago();
            comment.tooltip();
            comment.closest('.panel-footer').siblings('.panel-body').find('.comment_clickable_timestamp').on('click', commentClickableTimestamp);
            var textarea = commentform.find('textarea').val('');
            textarea.blur();
        }).fail(function(data){
            flash('error', 'Error saving comment');
            flash('error', data);
        });
    });

    //Tags
    let tagsinput = $('#tags'),
        submit = $('#submittags'),
        tagdisplay = $('#tag-display');

    function tagmd() {
        let elReplace = (el, regex, fn) => el.innerHTML = el.innerHTML.replace(regex, fn);
        tagdisplay.children().children(':first-of-type').each((i, el) => {
            elReplace(el, /^nsfw$/i, x => '<span style="color: red;">' + x + '</span>');
            elReplace(el, /^sfw$/i, x => '<span style="color: #23ff00;">' + x + '</span>');
        });
    }
    tagmd();

    function tagDeleteHandler(e) {
        e.preventDefault();
        if(!confirm('Do you really want to delete this tag?')) return;
        video.untag($(this).siblings().text(), (success, error, warnings, cb) => {
            if(success) {
                flash('success', 'Tag successfully deleted');
                let tags = [];
                for(let tag of cb.tags)
                    tags.push('<span class="label label-default"><a href="/index?q=' + tag.normalized + '" class="default-link">' + tag.name + '</a> <a class="delete-tag default-link" href="#"><i class="fa fa-times"></i></a></span>');
                tagdisplay.empty();
                tagdisplay.append(tags.join(" "));
                $('.delete-tag').on('click', tagDeleteHandler);
                tagmd();
            }
            else
                error ? flash(error.type, error.text) : flash('error', 'Unknown exception');
        });
    }

    $('.delete-tag').on('click', tagDeleteHandler);

    $('#tags, #filter').on('itemAdded', e => setTimeout(() => $(e.currentTarget).siblings('.bootstrap-tagsinput').children('input').val(''), 0));

    tagsinput.on('beforeItemAdd', e => {
        for(let tag of video.tags) {
            if(tag.toLowerCase() === e.item.toLowerCase()) {
                e.cancel = true;
                flash('info', 'Tag already exists');
                return;
            }
        }
    });
    submit.on('click touchdown', e => {
        e.preventDefault();
        video.tag(tagsinput.tagsinput('items'), (success, error, warnings, cb) => {
            if(success) {
                flash('success', 'Tags saved successfully');
                var tags = [];
                for(let tag of cb.tags)
                    tags.push('<span class="label label-default"><a href="/index?q=' + tag.normalized + '" class="default-link">' + tag.name + '</a>' + (cb.can_edit_video ? ' <a class="delete-tag default-link" href="#"><i class="fa fa-times"></i></a>' : '') + '</span>');
                tagdisplay.empty();
                tagdisplay.append(tags.join(" "));
                tagsinput.tagsinput('removeAll');
                $('.delete-tag').on('click', tagDeleteHandler);
                tagmd();
            }
            else
                error ? flash(error.type, error.text) : flash('error', 'Unknown exception');
        });
    });

    // Filter
    var filter = $('#filter'),
        submitfilter = $('#submitfilter');
    submitfilter.on('click touchdown', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: submitfilter.attr('href'),
            data: filter.serialize()
        }).done(function() {
            flash('success', 'Filter successfully updated');
            $('#filterselectmodal').modal('hide');
        }).fail(function(data) {
            flash('error', 'Error updating tags');
        });
    });
})(jQuery);

(function ($) {
    function updaterow(ctx, video) {
        if($('video').length) {
            var info = [];
            if(video.interpret) {
                info.push(' <strong>Artist:</strong> ' + video.interpret);
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
    $(".commentwrapper, .tags").mCustomScrollbar({
        axis: 'y',
        theme: 'minimal',
        scrollInertia: 0
    });
})(jQuery);

var alertrm = function ($) {
    $('.alert').each(function (index) {
        $(this).delay(3000 + index * 1000).slideUp(300, function() { $(this).remove(); });
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

// kadse :D greetz gz
/*(function() {
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
    $(".aside").toggle(comments);
    $("#toggle").click(function(){$(".aside").fadeToggle(localStorage.comments = !(localStorage.comments == "true"))});
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
    s.allowFuture = true;
    s.localeTitle = true;
    //same format as laravel diffForHumans()
    str.seconds = "%d seconds";
    str.minute = "1 minute";
    str.hour = "1 hour";
    str.hours = "%d hours";
    str.day = "1 day";
    str.month = "1 month";
    str.year = "1 year";
    str.suffixFromNow = null;
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
        if(typeof Handlebars == "undefined" || !$('#msglist').length) return; // only on profilelayout

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
        if(reason === null)
            return;
        reason = reason.trim();
    } while(!reason);
    $.ajax({
        url: '/api/comments/' + id + '/delete',
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
        if(reason === null)
            return;
        reason = reason.trim();
    } while(!reason);
    $.ajax({
        url: '/api/comments/' + id + '/restore',
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
                                body.find('.comment_clickable_timestamp').on('click', commentClickableTimestamp);
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
    $('[class^="vjs"]').on('mouseleave', function (e) {
        if(e.relatedTarget == $('video').get(0) || $(e.relatedTarget).is('[class^="vjs"]') || !cBarStatus) return;
        cBar.hide();
        cBarStatus = false;
    });
});

//upload
$(function() {
    if(!/\/upload/.test(location.href))
        return;
    var defaultPreview = $('#dragndrop-text').html();
    var defaultDragNDropColor = $('#dragndrop').css('color');
    var defaultDragNDropBorderColor = $('#dragndrop').css('border-left-color');
    var defaultDragNDropBackgroundColor = $('#dragndrop').css('background-color');
    var counter = 0;
    var currentFile;
    var jqXHR;
    var tags = $('#tags_upload');
    var nsfwCheckbox = $('#nsfw');
    function applyDefaultDragNDropCSS() {
        $('#dragndrop').css({
            'color': defaultDragNDropColor,
            'border-color': defaultDragNDropBorderColor,
            'background-color': defaultDragNDropBackgroundColor
        });
    }
    function humanFileSize(size) {
        var i = Math.floor(Math.log(size) / Math.log(1024));
        return (size / Math.pow(1024, i)).toFixed(2) + ' ' + ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'][i];
    }
    function dragndropLinkClickHandler(e) {
        e.preventDefault();
        $('input[type="file"]').trigger('click');
    }
    function restoreDefaultPreview() {
        $('#dragndrop-link').on('click', dragndropLinkClickHandler);
        $('#dragndrop-link').attr('href', '#');
        $('#dragndrop-text').html(defaultPreview);
    }
    function createPreview(file) {
        $('#dragndrop-link').removeAttr('href').off('click');
        $('#dragndrop-text').html('<video id="video_preview" src="' + URL.createObjectURL(file) + '" autoplay controls loop></video><br><span class="upload-info">' + file.name + ' &mdash; ' + humanFileSize(file.size) + ' &mdash; <a id="dragndrop-clear" class="fa fa-times" href="#"></a></span><br><div class="progress progress-striped" style="display: none; margin-left: 10px; margin-right: 10px;"><div class="progress-bar progress-bar-custom" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span class="upload-info sr-only">0%</span></div></div><span class="upload-info"><span id="upload-stats" style="display: none;"></span></span>');
        $('#video_preview').prop('volume', 0);
        $('#dragndrop-clear').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            currentFile = null;
            $(this).off('click');
            applyDefaultDragNDropCSS();
            restoreDefaultPreview();
            if(jqXHR && jqXHR.statusText != "abort") {
                jqXHR.abort();
                jqXHR = null;
            }
        });
    }
    function checkFile(file) {
        var tooBig = file.size > 31457280;
        var invalid = file.type !== "video/webm";
        if((tooBig && $('#dragndrop').data('uploadlimit')) || invalid) {
            flash('error', invalid ? 'Invalid file' : 'File too big. Max 30MB');
            applyDefaultDragNDropCSS();
            return false;
        }
        return true;
    }
    function submitForm(interpret, songtitle, imgsource, category, tags, file) {
        var lastState = {
            'loaded': 0,
            'secondsElapsed': 0
        };
        var speed = [];
        var lastSpeedIndex = 0;
        function interval() {
            var avgSpeed = 0;
            var length = speed.length;
            var i;
            for(i = lastSpeedIndex; i < length; i++)
                avgSpeed += speed[i];
            avgSpeed = avgSpeed / (i - lastSpeedIndex);
            lastSpeedIndex = i;
            $('#upload-stats').text('Speed: ' + humanFileSize(Math.floor(avgSpeed)) + '/s Uploaded: ' + humanFileSize(lastState.loaded));
        }
        var statsInterval;
        var formData = new FormData();
        formData.append('interpret', interpret);
        formData.append('songtitle', songtitle);
        formData.append('imgsource', imgsource);
        formData.append('category', category);
        formData.append('tags', tags);
        formData.append('file', file);
        $('.progress-striped, #upload-stats').css('opacity', 0).slideDown('fast').animate({opacity: 1}, {queue: false, duration: 'fast'});
        jqXHR = $.ajax({
            url: '/api/upload',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(cb) {
                switch(cb.error) {
                    case 'null':
                        if(cb.video_id) {
                            flash('success', 'Upload successful: <a href="/' + cb.video_id + '">/' + cb.video_id + '</a>. Redirect in 3 seconds...');
                            setTimeout(function() {
                                location.href = '/' + cb.video_id;
                            }, 3000);
                        }
                        else
                            flash('error', 'Unexpected Exception');
                        break;
                    case 'invalid_request':
                        flash('error', 'Invalid request');
                        break;
                    case 'not_logged_in':
                        flash('error', 'Not logged in');
                        break;
                    case 'uploadlimit_reached':
                        flash('error', 'Uploadlimit reached');
                        break;
                    case 'invalid_file':
                        flash('error', 'Invalid file');
                        break;
                    case 'file_too_big':
                        flash('error', 'File too big. Max 30MB');
                        break;
                    case 'already_exists':
                        if(cb.video_id)
                            flash('error', 'Video already exists: <a href="/' + cb.video_id + '">/' + cb.video_id + '</a>');
                        else
                            flash('error', 'Video already existed but has been deleted');
                        break;
                    case 'erroneous_file_encoding':
                        flash('error', 'Erroneous file encoding. <a href="/webm">Try reencoding it</a>');
                        break;
                    default:
                        flash('error', 'Unexpected exception');
                        break;
                }
                if(cb.error != 'null') {
                    $('.progress-bar-custom').css('background-color', 'red');
                    $('.progress-bar-custom').text('Upload failed');
                }
                $('#upload-stats').text('Speed: ' + humanFileSize(Math.floor(speed.average())) + '/s Uploaded: ' + humanFileSize(currentFile.size));
            },
            error: function(jqXHR, status, error) {
                jqXHR = null;
                if(error == 'abort') {
                    flash('info', 'Upload aborted');
                    return;
                }
                flash('error', 'Upload failed');
                flash('error', status);
                flash('error', error);
                $('.progress-bar-custom').css('background-color', 'red');
                $('.progress-bar-custom').text('Upload failed');
            },
            complete: function() {
                clearInterval(statsInterval);
            },
            xhr: function() {
                var xhr = $.ajaxSettings.xhr();
                var started_at = new Date();
                $('.progress-bar-custom').css('background-color', 'rgba(47, 196, 47, 1)');
                xhr.upload.onprogress = function(e) {
                    var percentage = Math.floor(e.loaded / e.total * 100);
                    var secondsElapsed = (new Date().getTime() - started_at.getTime()) / 1000;
                    var bytesPerSecond = (e.loaded - lastState.loaded) / (secondsElapsed - lastState.secondsElapsed);
                    $('.progress-bar-custom').css('width', percentage + '%');
                    $('.progress-bar-custom').text(percentage + '%');
                    lastState.secondsElapsed = secondsElapsed;
                    lastState.loaded = e.loaded;
                    speed.push(bytesPerSecond);
                    if(!statsInterval) {
                        interval();
                        statsInterval = setInterval(interval, 500);
                    }
                };
                return xhr;
            }
        });
    }
    $('input[type="file"]').on('change', function(e) {
        if(!this.files.length)
            return;
        var file = this.files[0];
        if(checkFile(file)) {
            currentFile = file;
            createPreview(file);
        }
        $(this).wrap('<form>').closest('form').get(0).reset();
        $(this).unwrap();
    });
    $('#dragndrop-link').on('click', dragndropLinkClickHandler);
    $(document).on('dragenter', function(e) {
        e.preventDefault();
        counter++;
        var dt = e.originalEvent.dataTransfer;
        if(dt.types != null && (dt.types.indexOf ? dt.types.indexOf('Files') === 0 : dt.types.contains('application/x-moz-file'))) {
            $('#dragndrop').css({
                'color': '#BBB',
                'border-color': '#656464',
                'background-color': '#323234'
            });
        }
    }).on('dragleave', function() {
        counter--;
        if(counter === 0)
            applyDefaultDragNDropCSS();
    }).on('dragover', function(e) {
        e.preventDefault();
    }).on('drop', function(e) {
        e.preventDefault();
        if(!$(e.target).is('#dragndrop-text')) {
            applyDefaultDragNDropCSS();
        }
    });
    $('#dragndrop-text').on('dragover', function(e) {
        var dt = e.originalEvent.dataTransfer;
        var effect = dt.effectAllowed;
        dt.dropEffect = 'move' === effect || 'linkMove' === effect ? 'move' : 'copy';
    }).on('drop', function(e) {
        if(!e.originalEvent.dataTransfer.files.length)
            return;
        if(jqXHR && jqXHR.statusText != "abort") {
            jqXHR.abort();
            currentFile = null;
            restoreDefaultPreview();
        }
        var file = e.originalEvent.dataTransfer.files[0];
        applyDefaultDragNDropCSS();
        if(checkFile(file)) {
            currentFile = file;
            createPreview(file);
            counter = 0;
        }
    });
    $('button#btn-upload').on('click', function() {
        if(!currentFile) {
            flash('error', 'No file selected');
            return;
        }
        if(jqXHR && (jqXHR.readyState == 0 || jqXHR.readyState == 1 || jqXHR.readyState == 3)) {
            flash('info', 'Already uploading');
            return;
        }
        submitForm($('#interpret').val(), $('#songtitle').val(), $('#imgsource').val(), $('#category').val(), tags.tagsinput('items'), currentFile);
    });
    tags.on('itemRemoved', function(e) {
        if(e.item === 'nsfw') {
            nsfwCheckbox.prop('checked', false);
            $(this).tagsinput('add', 'sfw');
        }
        else if(e.item === 'sfw') {
            nsfwCheckbox.prop('checked', true);
            $(this).tagsinput('add', 'nsfw');
        }
    });
    nsfwCheckbox.on('change', function() {
        if(this.checked) {
            tags.tagsinput('remove', 'sfw');
            tags.tagsinput('add', 'nsfw');
        }
        else {
            tags.tagsinput('remove', 'nsfw');
            tags.tagsinput('add', 'sfw');
        }
    });
    nsfwCheckbox.trigger('change');
});

$(function() {
    $('#delete_video').on('click', function(e) {
        e.preventDefault();
        do {
            var reason = prompt('Reason for deleting video ' + video.id + ' by ' + video.user);
            if(reason === null)
                return;
            reason = reason.trim();
        } while(!reason);
        video.delete(reason, (success, error, warnings) => {
            if(success) {
                flash('success', 'Video deleted. Redirect in 3 seconds...');
                setTimeout(() => location.href = '/', 3000);
                for(let warn of warnings)
                    flash('warning', warn);
            }
            else
                error ? flash(error.type, error.text) : flash('error', 'Unknown exception');
        });
    });
});
