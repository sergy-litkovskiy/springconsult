/*----------------------------------------------------*/
/*	Magnific Popup
 /*----------------------------------------------------*/
$('body').magnificPopup({
    type: 'image',
    delegate: 'a.mfp-gallery',
    fixedContentPos: true,
    fixedBgPos: true,
    overflowY: 'auto',
    closeBtnInside: true,
    preloader: true,
    removalDelay: 0,
    mainClass: 'mfp-fade',
    gallery:{enabled:true},
    callbacks: {
        buildControls: function() {
            console.log('inside'); this.contentContainer.append(this.arrowLeft.add(this.arrowRight));
        }
    }
});

$('.mfp-image').magnificPopup({
    type: 'image',
    closeOnContentClick: true,
    mainClass: 'mfp-fade',
    image: {
        verticalFit: true
    }
});