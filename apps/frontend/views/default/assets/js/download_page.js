$( document ).ready(function() {

    var encrypted_string = $("#encrypted_string").val();

    $.post(front_base+"file/handler_ajax", {
        csrf_token : csrf_token,
        encrypted_string : encrypted_string,
        }, function(my_data) {                    

            var data = jQuery.parseJSON(my_data);  

            if(data.status == "success"){     
                $("#file_loading").find(".loading_icon").removeClass("fa-spin fa-circle-notch").addClass("fa-check-circle text-success");
                $("#msg1").html(data.msg1);
                $("#msg2").html(data.msg2);

                var timer = setInterval(function(){ 
                    var current = $("#valid_timer").data("timer")
                    $("#valid_timer").data("timer", current - 1 )
                    //console.log($("#valid_timer").data("timer"));
                    if(parseInt(current) <= 0){

                        nice_alert("loading","جاري الرجوع إلى صفحة التحميل");
                        setTimeout(function(){ 
                            window.location = data.back_url;
                            }, 2000);        

                        clearInterval(timer);

                    }else{
                        $("#valid_timer").text(current);
                    }
                    }, 1000);                     

            }else{
                $("#file_loading").find(".loading_icon").removeClass("fa-spin fa-circle-notch").addClass("fa-times-circle text-danger");
                $("#msg1").html(data.msg1);
                $("#msg2").html(data.msg2);
            }
            
            if(data.msg3){
                $("#msg3").html(data.msg3);
            }

    });           


});