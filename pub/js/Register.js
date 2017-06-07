$(document).ready(function(){

    $("#sign_up").click(function () {

        //get value of input from template
        var email = $(":input[name=email]").val();
        var pass = $(":input[name=pass]").val();
        var pass_confirm = $(":input[name=pass_confirm]").val();
        var username = $(":input[name=username]").val();

        if(email != '' && pass != ''&& pass_confirm != ''&& username != ''){

            //encrypting value with md5
            pass = md5(pass);
            pass_confirm = md5(pass_confirm);

            //Check if pass are identical
            if(pass === pass_confirm){
                var dataString = {
                    email:email,
                    pass:pass,
                    pass_confirm:pass_confirm,
                    username:username,
                };
                $.ajax({
                    type: "POST",
                    url: '/register/adduser',
                    data:dataString,
                    success: function(data) {
                        console.log(data);
                        if(data){
                            window.location.href = "/";
                        }else {
                            $("#msg").empty();
                            $("#msg").fadeIn();
                            $("#msg").html("<h3>Not registry</h3>");
                        }
                    }
                })

            }else{
                $("#msg").empty();
                $("#msg").fadeIn();
                $("#msg").html("<h3>The passwords do not match. </h3>");
            }

        }
    })
});