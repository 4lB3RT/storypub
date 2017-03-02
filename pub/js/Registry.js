$(function () {

    $("#sign_up").click(function () {

        //take value of input from template
        var email = $(":input[name=email]").val();
        var pass = md5($(":input[name=pass]").val());
        var pass_confirm = md5($(":input[name=pass_confirm]").val());
        var username = $(":input[name=usename]").val();

        alert(email)
        console.log(1);
        if($(email).empty()){
            alert(email);
            if(pass === pass_confirm){
                console.log(pass);
                console.log(pass_confirm);
            }

        }
    })
});