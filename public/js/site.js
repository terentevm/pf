
$("#but1").on("click", function(){
    $.ajax({
        method: "GET",
        url: "/site/settings",
        success: function(data){
            console.log(data);
        },
        error: function(xhr, desc, err){
           console.log(err) ;
        }
    });
});


