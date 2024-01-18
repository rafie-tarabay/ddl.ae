
function nice_alert(type,text,errors){

    //clear Classes
    $("#nice_alert").find(".alert-icon").removeClass("fa-times-circle text-danger fa-check-circle text-success fa-spin fa-circle-notch text-info fa-info-circle fa-exclamation-triangle text-warning");
    $("#nice_alert").find(".close-button").removeClass("btn-danger btn-primary btn-info btn-warning");            

    // set classes
    if(type == "error"){
        $("#nice_alert").find(".alert-icon").addClass("fa-times-circle text-danger");
        $("#nice_alert").find(".close-button").addClass("btn-danger");        
    }else if(type == "success"){
        $("#nice_alert").find(".alert-icon").addClass("fa-check-circle text-success");
        $("#nice_alert").find(".close-button").addClass("btn-primary");
    }else if(type == "loading"){        
        $("#nice_alert").find(".alert-icon").addClass("fa-spin fa-circle-notch text-info");
        $("#nice_alert").find(".close-button").addClass("btn-info");
    }else if(type == "info"){        
        $("#nice_alert").find(".alert-icon").addClass("fa-info-circle text-info");
        $("#nice_alert").find(".close-button").addClass("btn-info");        
    }else{        
        $("#nice_alert").find(".alert-icon").addClass("fa-exclamation-triangle text-warning");
        $("#nice_alert").find(".close-button").addClass("btn-warning");        
    }

    // text
    $("#nice_alert").find(".alert-text").html(text);

    if(errors){
        $("#nice_alert").find(".nice_alert_errors").html(errors);
    }else{
        $("#nice_alert").find(".nice_alert_errors").html("");
    }

    // show
    $('.modal#nice_alert').modal('show');

}


function colorize_req_fields(){

    $(".req_field").each(function( index ){

        if( $(this).val() && $(this).val() != "__placeholder" ){
            $(this).removeClass("red_border").addClass("green_border");
        }else{
            $(this).removeClass("green_border").addClass("red_border");
        }

    });

}

$(document).ready(function(){

    $(document).on("submit",'.check_submit',function(event){  
        $().check_submit($(this),event);                         
    });    
    
    (function( $ ){
        $.fn.check_submit = function(my_form,event) {
            
            var error = false;
            var input_type = false;

            my_form.find(".req_field").each(function( index ){

                input_type = $(this).attr('type');

                if( input_type != "radio" && input_type != "checkbox"){

                    if(!$(this).val() || $(this).val() == "__placeholder" ){                
                        error = false;                
                        // alert($(this).attr("id"));                
                      //  console.log('Id : '+$(this).attr("id"));
                    }                             

                }else if( input_type == "radio"){

                    if( !( $("input[name="+$(this).attr("name")+"]").is(':checked') ) ){
                        error = true;                
                    }                
                }else if( input_type == "checkbox"){
                    if( !($("#"+$(this).attr("id")+":checked").length > 0) ){
                        error = true;                
                    }
                }       

            });

            if(error == false){               
                if(my_form.attr("release") == "true"){
                    console.log("Good Release !");
                    return true;
                }else{                
                    event.preventDefault();   
                    console.log("Good No Release !");
                }            
            }else{                    
                my_form.find(':input').attr("disabled",false);                     
                event.preventDefault();
                nice_alert("error",plz_fill_all) ;                                 
                console.log("Error Here !");
                return false;
            }              

        };
    })( jQuery );     
    

    colorize_req_fields();

    $(document).on("focusout keyup mouseout",'.req_field', function(){                              
        colorize_req_fields();  
    });



    $(document).on("focusout change",'.num_field',function(event){ 
        var field = $(this);        
        var field_val = field.val();        
        var correct_val;
        var flt = field.data("float");
        var max = (flt == 1) ? parseFloat( field.data("max") ) : parseInt( field.data("max") );
        var min = (flt == 1) ? parseFloat( field.data("min") ) : parseInt( field.data("min") );

        if(field_val){
            //correct_val = field_val.replace(/[^0-9]/g, '');
            correct_val = flt == 1 ? parseFloat(field_val) : parseInt(field_val);

            if(max > 0 && max < correct_val) correct_val = "";            
            if(min > 0 && min > correct_val)  correct_val = "";            
            field.val(correct_val);
        }
    });    


    $( ".limited_chars" ).each(function( index ) {                    
        var current_lenght = $( this ).val().length;
        var maxchars = $( this ).data("maxchars");
        var remaining;
        var charscounter = $( this ).data("charscounter");// id of the element where the count appears
        if(charscounter){
            if(current_lenght){
                remaining = maxchars - current_lenght;
            }else{
                remaining = maxchars;
            }

            $("#"+charscounter).html(remaining);

            if(remaining <= 10)            
                $("#"+charscounter).addClass("exceeding");                
        }
    }); 


    $(document).on("keydown keyup focusout change mousedown mouseup click",".limited_chars",function(event){            

        var my_input = $(this);
        var maxchars = $( this ).data("maxchars");
        var charscounter = $( this ).data("charscounter");// id of the element where the count appears

        if(my_input.val().length > maxchars){
            my_input.val($(this).val().substr(0, maxchars));
        }
        var remaining = maxchars -  my_input.val().length;
        $("#"+charscounter).html(remaining);

        if(remaining <= 5){            
            $("#"+charscounter).addClass("exceeding");                
        }else{            
            $("#"+charscounter).removeClass("exceeding");                
        }

    });                       

    $(document).on("keydown keyup focusout change mousedown mouseup click",".limited_words",function(event){            
        var my_input = $(this);
        var maxwords = $( this ).data("maxwords");

        var str = my_input.val();        
        str = str.split(/\s+/).slice(0,maxwords).join(" ");    
        my_input.val(str);
    });                       



});