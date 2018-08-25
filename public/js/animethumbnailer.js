window.onload = function (){
    var video = document.getElementById('video_html5_api');
    var thecanvas = document.getElementById('thecanvas');
    var img = document.getElementById('thumbnail_img');

    video.addEventListener('pause', function(){
        draw( video, thecanvas, img);
    }, false);
};

function draw( video, thecanvas, img ){
    img.setAttribute('crossOrigin', 'anonymous');
    var context = thecanvas.getContext('2d');
    context.drawImage( video, 0, 0, thecanvas.width, thecanvas.height);
    var dataURL = thecanvas.toDataURL();
    img.setAttribute('src', dataURL);
    video.setAttribute('crossOrigin', 'anonymous');
}
