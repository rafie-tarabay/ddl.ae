
function refreshMasonary(e) {                                          
    $(".grid").masonry("reloadItems"), $(".grid").masonry("layout");
    setTimeout(function() {
        $(".grid").masonry("reloadItems"), 
        $(".grid").masonry("layout"),
        console.log("refreshed");
        }
        , e);        
}    


$( document ).ready(function() {            

    if( window.innerWidth >= 768 ){  

        var $grid = $('.grid').masonry({
            itemSelector: '.grid-item',
            percentPosition: true ,
            isOriginLeft: false
        });

    }


    var resizeTimer;

    $(window).on('resize', function(e) {


        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {

            refreshMasonary(1000);

            }, 250);

    });

    refreshMasonary(2000);
    refreshMasonary(5000);
    refreshMasonary(10000);
    refreshMasonary(20000);
    refreshMasonary(30000);

});


