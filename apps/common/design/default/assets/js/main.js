var hightcomp;    
    
function adjust_height(hc){
    
    hc = hc ? hc : 568;

    var min_h = ($(window).height() - hc);
    if(min_h < 100){min_h = 100;}
    $("#main-container").css("min-height",min_h+"px");
}

var dynamic_loading = false;

$( document ).ready(function() {
         
    adjust_height(hightcomp);
    $(window).on("resize",function(){        
        adjust_height(hightcomp);
    });     

    $("[rel=tooltip]").tooltip({html:true});

    if ($.fn.cuteTime) {
        $('.timeago').cuteTime({ refresh: 1000*20 });        
    }    

    $(document).on("submit", '.dynamic_form' , function(event){    

        var good = $().check_submit($(this),event);

        if(good == false){
            event.preventDefault();
            return false;
        }
        console.log("Test");
        var form = $(this);            
        var icon = form.find(".submit_button").find(".loading-icon");
        var icon_class = icon.attr('class');
        icon.removeClass(icon_class).addClass("fa fa-spin fa-circle-o-notch loading-icon");

        var action = form.attr("action");            
        var container = form.data("container");            
        var after = form.data("after");            
        var append = form.data("append");            
        var resubmitable = form.data("resubmitable");                    
        var removable = form.data("removable");            
        var btnsubmit = form.data("btnsubmit");            
        var callback = form.data("callback");            
        var callback2 = form.data("callback2");            

        var sent_data = {csrf_token : csrf_token};
        var input_type;
        var input_name;
        form.find(':input').each(function(){

            input_type = $(this).attr('type');
            input_name = $(this).attr("name");


            if( input_type != "button" && input_type != "submit" ){                

                if( input_type != "checkbox" && input_name ){                               
                    sent_data[input_name] = $(this).val();                
                }

                if( input_type == "checkbox" && $("#"+$(this).attr("id")+":checked").length > 0){                        
                    sent_data[input_name] = $(this).val();                    
                }


                if( input_type == "radio" && $("input[name="+input_name+"]:checked").length > 0){                                           
                    sent_data[input_name] = $("input[name="+input_name+"]:checked").val();          
                }   

            }

        });     

        form.find(':input').attr("disabled",true);   

        dynamic_loading = true; // flag form loading

        $.post(action, sent_data, function(my_data) {

            dynamic_loading = false; // flag form not loading

            try{

                var data = jQuery.parseJSON(my_data);  

                if(data){

                    if(data.status == "error"){                            
                        nice_alert("error",data.alert , data.errors) ; 
                        form.find(':input').attr("disabled",false);                                  
                    }else if(data.status == "success" || data.status == "loading"){                            

                        if(data.alert){
                            nice_alert(data.status,data.alert) ;                                
                        }

                        if(data.url){
                            setTimeout("location.href='"+data.url+"'", 1000);   
                        }

                        if(data.view){ 

                            if(after){   
                                $(data.view).hide().insertAfter("#"+container+" #"+after).fadeIn(500);
                            }else if(append){        
                                $(data.view).hide().appendTo("#"+container).fadeIn(500);                            
                            }else{                                         
                                $(data.view).hide().prependTo("#"+container).fadeIn(500);                            
                            }
                            $('.timeago').cuteTime({ refresh: 1000*20 });  

                            $().refresh_audio();


                            $("#"+container).find(".no-items").remove();

                        }

                        if(resubmitable){ 
                            form.find('.form_attach_container').html("");        
                            form.find('.'+removable).remove();                                   
                            if(data.status == "success"){
                                form.find('.reset_me').val("");                                                    
                            }
                        }                               

                        if(data.remove_id){
                            $("#"+data.remove_id).slideUp(200);
                        }

                        if(callback){

                            var cb = eval(callback)
                            if (typeof cb == 'function') {
                                cb();
                            }                    
                        }

                        if(callback2){
                            var cb2 = eval(callback2)
                            if (typeof cb2 == 'function') {
                                cb2();
                            }                    
                        }

                    }    

                }        

            }catch(e){ 
                form.find(':input').attr("disabled",false);                                     
            }            


            if(resubmitable){ // for any resubmitable 
                form.find(':input').attr("disabled",false);                     
                $(".elastic").trigger('updateHeight');
            }     
            icon.removeClass("fa fa-spin fa-circle-o-notch loading-icon").addClass(icon_class);

        }).fail(
            function(jqXHR, textStatus, errorThrown) {
                nice_alert("error",error_cant_send_now) ; 
                form.find(':input').attr("disabled",false);  
                icon.removeClass("fa fa-spin fa-circle-o-notch loading-icon").addClass(icon_class);
            }
        );   

    });          



    $("form#search_faceting input:checkbox").change( function(){        
        //$("form#search_faceting").submit();
        //$("form#search_faceting input:checkbox").attr("disabled",true);
    });
    
                   
    $(document).on("change", '.search_for_selector' , function(event){                            
        var box_id = $(this).data("box");
        var box = $("#box_"+box_id);
        var checked_item = box.find(".search_for_selector:checked");
        var title = checked_item.data("title");      
        box.find(".search_for_label").text(title);
    });
                              
    $(".search_for_selector").each(function(){
      $(this).change();
    });
    
    $(document).on("change", '.search_operator_selector' , function(event){                            
        var box_id = $(this).data("box");   
        var box = $("#box_"+box_id);
        var title = box.find(".search_operator_selector:checked").data("title");      
        box.find(".search_operator_label").text(title);
    });

    $(".search_operator_selector").each(function(){
      $(this).change();
    });
    
        
    $(document).on("change", '.match_selector' , function(event){                            
        var box_id = $(this).data("box");   
        var box = $("#box_"+box_id);
        var title = box.find(".match_selector:checked").data("title");      
        box.find(".match_label").text(title);
    });

    $(".match_selector").each(function(){
      $(this).change();
    });
    
    

    $(document).on("click", '.sure' , function(event){            
        var msg = $(this).data("msg");
        msg = msg ? msg : "هل أنت متأكد ؟";
        var x=window.confirm(msg);
        if (x){                            
            return true;
        }else{
            event.preventDefault();
            return false;
        }           
    });     

    $(document).on("click",".rate_book",function(event){
        var item_id = $(this).data("id");
        var value = $(this).data("value");

        var icon = $(this).find(".fa");
        var icon_class = icon.attr('class');
        icon.removeClass(icon_class).addClass("fas fa-spin fa-circle-notch loading-icon");                    

        $.post(front_base+"post/social_actions/rate", {
            csrf_token : csrf_token,
            item_id : item_id,
            value : value,
            }, function(my_data) {                    

                var data = jQuery.parseJSON(my_data);  

                if(data.status == "success"){          
                    $("#rating_widget_"+item_id+" .rate_book").removeClass("active");
                    $("#rating_widget_"+item_id).find(".rate_book").each(function(){
                        if($(this).data("value") <= value){
                            $(this).addClass("active");
                        }
                    });            
                }else{
                    nice_alert(data.status,data.alert) ;
                }

                icon.removeClass("fas fa-spin fa-circle-notch loading-icon").addClass(icon_class);        

        });    


    });    


    $(document).on("click",".fav_book",function(event){
        var fav_btn = $(this);
        var item_id = fav_btn.data("id");        
        var removable = fav_btn.data("removable");        

        var icon = $(this).find(".fa");
        var icon_class = icon.attr('class');
        icon.removeClass(icon_class).addClass("fas fa-spin fa-circle-notch loading-icon");                                    

        $.post(front_base+"post/social_actions/fav", {
            csrf_token : csrf_token,
            item_id : item_id,
            }, function(my_data) {                    

                var data = jQuery.parseJSON(my_data);  

                if(data.status == "success"){     
                    fav_btn.removeClass("btn-default btn-danger").html(data.btntext);
                    if(data.action == "added"){                        
                        fav_btn.addClass("btn-danger");
                    }else if(removable == 1 && data.action == "removed"){
                        $("#fav_"+item_id).remove();
                    }
                }else{
                    nice_alert(data.status,data.alert) ;
                }

                icon.removeClass("fas fa-spin fa-circle-notch loading-icon").addClass(icon_class);                
        });    


    });    

    $(document).on("click",".cart_toggle",function(event){
        var cart_btn = $(this);
        var item_id = cart_btn.data("id");                

        var icon = $(this).find(".fa");
        var icon_class = icon.attr('class');
        icon.removeClass(icon_class).addClass("fas fa-spin fa-circle-notch loading-icon");                                            

        $.post("cart/toggle_cart_item", {
            csrf_token : csrf_token,
            item_id : item_id,
            }, function(my_data) {                    

                var data = jQuery.parseJSON(my_data);  

                if(data.status == "success"){     
                    $("#cart_count").text(data.cart_count);
                    cart_btn.find(".btn").removeClass("btn-info btn-success");
                    cart_btn.find(".btn.text").html(data.btntext);
                    if(data.action == "added"){                        
                        cart_btn.find(".btn").addClass("btn-success");
                    }else{
                        cart_btn.find(".btn").addClass("btn-info");
                    }
                }else{
                    nice_alert(data.status,data.alert) ;
                }

                icon.removeClass("fas fa-spin fa-circle-notch loading-icon").addClass(icon_class);                
        });    


    });    

    $(document).on("click","#search_results .single_book",function(event){
        /// prevent expand on item click
        if($(event.target).is("a") == false && $(event.target).is("button") == false && $(event.target).is("img") == false){            
            var book = $(this);
            var shown = book.data("shown");
            if(shown != true){           
                book_id = book.data("id"); 
                book.data("shown",true); 
                book.data("timer",0);            
                $("#book_"+book_id).find(".card-footer").slideDown(300);            
                $("#timer_"+book_id).hide();
            }
        }
    });

    $(document).on("click","#faceting .show_more_content",function(event){
        var content = $(this).data("id");        
        $("#more_"+content).toggle();                                    
    });


    var timer;
    var timer_book_id;
    $( "#search_results .single_book" ).hover(
        function(e) {         
            var book = $(this);
            timer_book_id = book.data("id");            
            var current;
            var shown = book.data("shown");
            if(shown != true){                
                book.data("timer",2);            
                timer = setInterval(function(){ 
                    current = book.data("timer")
                    book.data("timer", current - 1 )
                    console.log(book.data("timer"));
                    if(parseInt(current) <= 0){
                        $("#book_"+timer_book_id).find(".card-footer").slideDown(300);            
                        $("#timer_"+timer_book_id).hide();
                        book.data("shown",true);
                    }else{
                        $("#timer_"+timer_book_id).show().find(".txt").text(current);
                    }
                    }, 1000);         
            } 
        }, function() {
            clearInterval(timer);
            $("#timer_"+timer_book_id).hide();
        }                     
    );    

        
    $('#disclaimer').on('closed.bs.alert', function () {
        $.post(front_base+"misc/disclaimer", { csrf_token : csrf_token,}, function(my_data) {  } );  
    })    
    


    $("#sort_by_selector").change( function(){                
        $("form#search_faceting").find("#sort_by").val($(this).val());
        $("form#search_faceting").submit();
        $("#sort-loading").removeClass("fas fa-sort-alpha-up").addClass("fas fa-spin fa-cog text-danger");
        //$("form#search_faceting").find("input#sort_by").submit();
        //$("form#search_faceting input:checkbox").attr("disabled",true);
    });
    
    
    $(document).on("click",".share_results",function(event){
        var btn = $(this);
        var loaded = btn.data("loaded");
        if(loaded == 0){
            var url = btn.data("url");
            btn.find("i").removeClass("far fa-share-square").addClass("fas fa-spin fa-circle-notch loading-icon");                                            
            $.post(front_base+"misc/sharing_content", {
                csrf_token : csrf_token,
                url : url,
                }, function(my_data) {                    

                var data = jQuery.parseJSON(my_data);      
                if(data.status == "success"){     
                    btn.find("i").removeClass("fas fa-spin fa-circle-notch loading-icon").addClass("far fa-share-square");                                                            
                    $("body").append(data.view);
                    $('#sharing_modal').modal('show');  
                    
                    btn.data("loaded",1);
                }else{
                    nice_alert("error","حدث خطأ أثناء العملية");
                }
            });            
        }else{
            $('#sharing_modal').modal('show');
        }

    });
    
    
    $(document).on("click",".fake-upload", function(){
        var target = $(this).data("target");
        var placeholder = $(this).data("placeholder");
        $("#"+target).click();
        $("#"+target).bind( "change", function(e) {
            var fileName = e.target.files[0].name;
            $("#"+placeholder).val(fileName);
        });
        
    });
             
             
    $(document).on("submit",".check_agree",function(event){
        
        var agree = $(this).find("#i_agree");
        //console.log(agree.is(':checked'));
        if(agree.is(':checked') == false){
            nice_alert("error",plz_accept_terms);
            event.preventDefault();
        }
        
    });
    
                 
    $(document).on("click","#side_slider .slider_btn .toggler",function(event){
        
        var status = $(this).data("status");
        
        if(status == "closed"){
            $("#side_slider").addClass("active");
            $(this).data("status","opened")
        }else{
            $("#side_slider").removeClass("active");
            $(this).data("status","closed")            
        }
        
    });
    
    
    
    

});