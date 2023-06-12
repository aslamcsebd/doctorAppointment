(function($) {
    "use strict";
    
    /* 
    ------------------------------------------------
    Bootstraps Native Carousels
    ------------------------------------------------*/
    $(document).ready(function(){
        $('#carouselExampleIndicators, #carouselExampleIndicators2').carousel();	
        //$('.bd-example-modal-lg').modal();		
        
    });

    $(document).ready(function(){
        $('.carousel').carousel({
            touch: false
        })		
        
    });

    /* 
    ------------------------------------------------
    Sidebar open close animated humberger icon
    ------------------------------------------------*/

    $(".hamburger").on('click', function() {
        $(this).toggleClass("is-active");
    });


    /*  
    -------------------
    List item active
    -------------------*/
    $('.header li, .sidebar li').on('click', function() {
        $(".header li.active, .sidebar li.active").removeClass("active");
        $(this).addClass('active');
    });

    $(".header li").on("click", function(event) {
        event.stopPropagation();
    });

    $(document).on("click", function() {
        $(".header li").removeClass("active");

    });

    /*  
    -------------------
    Owl Carousels
    -------------------*/
    $(document).ready(function(){
        $(".owl-carousel-offer").owlCarousel({
            loop:true,
            margin:20,
            autoplay:true,
            autoplayTimeout:2000,
            autoplayHoverPause:true,
            nav:true,
            responsive:{
                0:{
                    items:2
                },
                600:{
                    items:2
                },
                900:{
                    items:4
                },
                1100:{
                    items:6
                },
                1400:{
                    items: 7,
                    nav: true
                }
            
            }
        });

        $(".owl-carousel-tesimonial").owlCarousel({
            loop:true,
            margin:10,
            autoplay:true,
            autoplayTimeout:2000,
            autoplayHoverPause:true,
            nav:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                900:{
                    items:4
                },
                1100:{
                    items:6
                }
            
            }
        });
    });


    /* 
    ------------------------------------------------
    Mini Cart
    ------------------------------------------------*/
    $(document).ready(function(){
        var menuRight = document.getElementById( 'cbp-spmenu-s2' ),
            showRight = document.getElementById( 'showRight' ),
            body = document.body;

        
        showRight.onclick = function() {
            classie.toggle( this, 'active' );
            classie.toggle( menuRight, 'cbp-spmenu-open' );
            disableOther( 'showRight' );
        };

        function disableOther( button ) {
            
            if( button !== 'showRight' ) {
                classie.toggle( showRight, 'disabled' );
            }
        }		
        
    });


    /* 
    ------------------------------------------------
    User login panel modal toggle
    ------------------------------------------------*/
   
    $('#clickbtn').click(function() {
        $('#userLoginModalCenter').modal('toggle')
    });
    $('#clickbtn2').click(function() {
        $('#single-product-display-modal').modal('toggle')
    });
    

    /* 
    ------------------------------------------------
    Image Zoom
    ------------------------------------------------*/
    $(document).ready(function(){    
        function magnify(imgID, zoom) {
            var img, glass, w, h, bw;
            img = document.getElementById(imgID);
          
            /* Create magnifier glass: */
            glass = document.createElement("DIV");
            glass.setAttribute("class", "img-magnifier-glass");
          
            /* Insert magnifier glass: */
            img.parentElement.insertBefore(glass, img);
          
            /* Set background properties for the magnifier glass: */
            glass.style.backgroundImage = "url('" + img.src + "')";
            glass.style.backgroundRepeat = "no-repeat";
            glass.style.backgroundSize = (img.width * zoom) + "px " + (img.height * zoom) + "px";
            bw = 3;
            w = glass.offsetWidth / 2;
            h = glass.offsetHeight / 2;
          
            /* Execute a function when someone moves the magnifier glass over the image: */
            glass.addEventListener("mousemove", moveMagnifier);
            img.addEventListener("mousemove", moveMagnifier);
          
            /*and also for touch screens:*/
            glass.addEventListener("touchmove", moveMagnifier);
            img.addEventListener("touchmove", moveMagnifier);
            function moveMagnifier(e) {
              var pos, x, y;
              /* Prevent any other actions that may occur when moving over the image */
              e.preventDefault();
              /* Get the cursor's x and y positions: */
              pos = getCursorPos(e);
              x = pos.x;
              y = pos.y;
              /* Prevent the magnifier glass from being positioned outside the image: */
              if (x > img.width - (w / zoom)) {x = img.width - (w / zoom);}
              if (x < w / zoom) {x = w / zoom;}
              if (y > img.height - (h / zoom)) {y = img.height - (h / zoom);}
              if (y < h / zoom) {y = h / zoom;}
              /* Set the position of the magnifier glass: */
              glass.style.left = (x - w) + "px";
              glass.style.top = (y - h) + "px";
              /* Display what the magnifier glass "sees": */
              glass.style.backgroundPosition = "-" + ((x * zoom) - w + bw) + "px -" + ((y * zoom) - h + bw) + "px";
            }
          
            function getCursorPos(e) {
              var a, x = 0, y = 0;
              e = e || window.event;
              /* Get the x and y positions of the image: */
              a = img.getBoundingClientRect();
              /* Calculate the cursor's x and y coordinates, relative to the image: */
              x = e.pageX - a.left;
              y = e.pageY - a.top;
              /* Consider any page scrolling: */
              x = x - window.pageXOffset;
              y = y - window.pageYOffset;
              return {x : x, y : y};
            }
        }

        /* Execute the magnify function: */
        magnify("myimage",3);
        magnify("myimage1", 3);
        magnify("myimage2", 3);
        magnify("myimage3", 3);
        magnify("myimage4", 3);
        magnify("myimage5", 3);
        magnify("myimage6", 3);
        magnify("myimage7", 3);
        /* Specify the id of the image, and the strength of the magnifier glass: */ 
    });

})(jQuery);