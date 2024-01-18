var onesingnal_message  = (word.onesingnal_message !== 'undefined')   ?  word.onesingnal_message   : "اشترك في التنبيهات ليصلك كل جديد بشأن مكتبة دبي الرقمية تلقائياً";
var onesingnal_ok       = (word.onesingnal_ok      !== 'undefined')   ?  word.onesingnal_ok        : "اشترك الآن!";
var onesingnal_cancel   = (word.onesingnal_cancel  !== 'undefined')   ?  word.onesingnal_cancel    : "لا أرغب!";

var onesingnal_wlcm_title   = (word.onesingnal_wlcm_title  !== 'undefined')     ?  word.onesingnal_wlcm_title    : "مكتبة دبي الرقمية!";
var onesingnal_wlcm_msg     = (word.onesingnal_wlcm_msg  !== 'undefined')       ?  word.onesingnal_wlcm_msg      : "!شكراً لتفعيل التنبيهات";
var onesingnal_wlcm_url     = (word.onesingnal_wlcm_url  !== 'undefined')       ?  word.onesingnal_wlcm_url      : false;






function onManageWebPushSubscriptionButtonClicked(event) {
    getSubscriptionState().then(function(state) {
        if (state.isPushEnabled) {
            /* Subscribed, opt them out */
            OneSignal.setSubscription(false);
        } else {
            if (state.isOptedOut) {
                /* Opted out, opt them back in */
                OneSignal.setSubscription(true);
            } else {
                /* Unsubscribed, subscribe them */
                OneSignal.registerForPushNotifications();
            }
        }
    });
    event.preventDefault();
}



function getSubscriptionState() {
    return Promise.all([
        OneSignal.isPushNotificationsEnabled(),
        OneSignal.isOptedOut()
    ]).then(function(result) {
        var isPushEnabled = result[0];
        var isOptedOut = result[1];

        return {
            isPushEnabled: isPushEnabled,
            isOptedOut: isOptedOut
        };
    });
}

       
var OneSignal = window.OneSignal || [];


OneSignal.push(function() {

    if (OneSignal.isPushNotificationsSupported()) {

        OneSignal.isPushNotificationsEnabled(function(isEnabled) {
            if (isEnabled) {

            } else {        
                if (Notification.permission != "denied") {
                    $('#onesingnal_modal').modal('show');
                }
            }

        });        

        OneSignal.init({
            appId: "a6606bf7-a3c9-44a3-933e-fd418e23df71",
            autoResubscribe: true,  
            promptOptions: {
                actionMessage: onesingnal_message,
                acceptButtonText: onesingnal_ok,            
                cancelButtonText: onesingnal_cancel
            },        
            welcomeNotification: {
                disable: false,
                title: onesingnal_wlcm_title,            
                message: onesingnal_wlcm_msg,
                url: onesingnal_wlcm_url,
            }
        });    


    }

}); 



$(document).on("click","#enableOneSignal",function(){
    OneSignal.push(function() {
        OneSignal.registerForPushNotifications();  
        OneSignal.setSubscription(true);
    })
});    

$(document).on("click","#disableOneSignal",function(){

    $.post(base_url+"misc/disableOneSignal", {
        csrf_token : csrf_token,
        }, function(my_data) {    
    });        

    OneSignal.push(function() {
        OneSignal.setSubscription(false);
    });
});    





