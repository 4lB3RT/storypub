$(document).ready(function(){

    $("#login").click(function () {

        //get value from form login
        var email = $(":input[name=email]").val();
        var pass = $(":input[name=pass]").val();
        //encripting pass
        var pass = md5(pass);

        //method ajax pass to controller values
        $.ajax({
            type: "POST",
            url: "/login/login",
            data:{ pass : pass,email:email },
            success: function (data) {
                //if return true go to dashboard
                if(data){
                    window.location.href = "/";
                }
                //else redirect to login again
                window.location.href = "/login";
            }
        })
    })

})