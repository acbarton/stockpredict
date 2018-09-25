jQuery(document).ready(function ($) {

    //What happen on window scroll
    function back_to_top(){
        var scrollTop = $(window).scrollTop();
        var offset = 500;
        if (scrollTop < offset) {
            $('.evision-back-to-top').hide();
        } else {
            $('.evision-back-to-top').show();
        }
    }
    $(window).on("scroll", function (e) {
        back_to_top();
    });
    back_to_top();
    $('.evision-back-to-top').on('click', function(event){
        if ($(this.hash).length){
            event.preventDefault();
            $("html, body").stop().animate({scrollTop: $(this.hash).offset().top - 70}, 2e3, "easeInOutExpo");
        }
    });

    /*wow js*/
    wow = new WOW({
            boxClass: 'evision-animate'
        }
    );
    wow.init();

    // mmenu
    jQuery("#site-navigation").mmenu({
       // options
       "classes": "mm-slide mm-light",
       "counters": true,
       "header": true,
       "offCanvas": {
          "position"  : "right",
          "zposition": "back"
           },
       "extensions" : [ 'effect-slide-menu', 'pageshadow' ],
       "navbar"         : {
        "title"     : 'MENU'
       },
       "navbars"        : [{
            "position"  : 'top',
            "content"       : [
                'prev',
                'title',
                'close'
            ]
        }
       ]
    }, {
       // configuration
       clone: true
    });


    //header search
    var searchBox = false;
    var selector = $('#search-box');
    jQuery('.search-box-btn').click(function(){
     
      if( searchBox ){
        selector.css({'width':'0px'});
        searchBox = false;
      }else{
        selector.css({'width':'100%'});
        searchBox = true;
      }

      selector.find('.search-submit').remove('.search-submit');

    });

    jQuery( 'body' ).on( "click",function( ele ){

      ele.stopPropagation();

      if( !jQuery(ele.target).hasClass('search-field') && !jQuery(ele.target).hasClass('search-box-btn') ){
        selector.css({'width':'0px'});
        searchBox = false;
      }

    });

});
