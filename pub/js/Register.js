$(function () {

    $("#sign_up").click(function () {

        //take value of input from template
        var email = $(":input[name=email]").val();
        var pass = $(":input[name=pass]").val();
        var pass_confirm = $(":input[name=pass_confirm]").val();
        var username = $(":input[name=username]").val();

        if(email != '' && pass != ''&& pass_confirm != ''&& username != ''){

            //encrypting value of variable with md5
            email = md5(email);
            pass = md5(pass);
            pass_confirm = md5(pass_confirm);
            username = md5(username);

            //Check if pass are identical
            if(pass === pass_confirm){
                var dataString='email='+email;
                $.ajax({
                    type: "POST",
                    url: "app/controllers/register.php/adduser",
                    data:dataString,
                    success: function(data) {
                        dat=JSON.parse(data);
                        $("#msg").html("<h3>"+dat.msg+"</h3>");
                    }
                })

            }else{

            }

        }
    })
});