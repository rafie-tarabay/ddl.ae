$(document).ready(function() {

    //recalculate_price();

    function recalculate_price(){

        var plan = $(".subscribe_plan input[name='subscribe_plan']:checked").val();
        var total_price = 0;
        $( ".single-package .packs" ).each( function( index, element ){            
            if($(this).prop("checked") == true){
                total_price += $(this).data("price-"+plan);
            }                        
        });        
        $("#total_price").text(total_price);        
        if(total_price){
            $("button#create_order").attr("disabled",false);   
        }else{
            $("button#create_order").attr("disabled",true);   
        }
    }


    $(document).on("click keydown","#coupon",function(){  
        $("button#pay_now").attr("disabled",true);             
    });


    $(document).on("focusout","#coupon",function(){                           
        $("#validate_coupon").click();
    });

    var coupon = $("form#order_summary #coupon").val();

    $(document).on("click","#validate_coupon",function(){

        var new_value = $("form#order_summary #coupon").val();

        if(new_value !== coupon){

            var order_id = $("form#order_summary #order_id").val();
            coupon = $("form#order_summary #coupon").val();

            $.post(front_base+"orders/validate_coupon", {
                csrf_token : csrf_token,
                order_id : order_id,
                coupon : coupon,
                }, function(my_data) {                    

                    var data = jQuery.parseJSON(my_data);  

                    if(data.status == "success"){          
                        nice_alert(data.status,data.alert) ;
                        $("form#order_summary #total_price").addClass("discounted");
                        $("form#order_summary #discounted_price").removeClass("d-none").text(data.new_price);                        
                    }else{
                        nice_alert(data.status,data.alert) ;                        
                        $("form#order_summary #total_price").removeClass("discounted");
                        $("form#order_summary #discounted_price").addClass("d-none");
                        coupon = false;
                    }

                    $("button#pay_now").attr("disabled",false);             
            });  

        }        

    });





});