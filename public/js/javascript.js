$(document).ready(function(){
    // function inactivityTime(){
    //     onlineuser();
    //     function onlineuser(){
    //         $.ajax({
    //             url: '/onlineuser',
    //             method: 'GET',
    //             data: {
    //                 _token:"{{ csrf_token() }}"
    //             },
    //             success: function(data){
    //             },
    //         })
    //     }
    //     setInterval(function(){
    //         onlineuser();
    //     }, 60000);
    //     }

    // // run the function
    // inactivityTime();

    setTimeout(function() {
    $("#idfail").fadeOut(7000);
    });

    setTimeout(function() {
    $("#idsuccess").fadeOut(7000);
    });

});
