$(document).ready(function(){

    $("#sign_up").click(function () {

        //take value of input from template
        var email = $(":input[name=email]").val();
        var pass = $(":input[name=pass]").val();
        var pass_confirm = $(":input[name=pass_confirm]").val();
        var username = $(":input[name=username]").val();
        var Roles = $(":input[name=Roles]").val();

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
                    roles:Roles
                };
                $.ajax({
                    type: "POST",
                    url: '/register/adduser',
                    data:dataString,
                    success: function(data) {
                        var data=JSON.parse(data);
                        $("#msg").fadeIn();
                        $("#msg").html("<h3>"+data.msg+"</h3>");
                    }
                })

            }else{

            }

        }
    })
});