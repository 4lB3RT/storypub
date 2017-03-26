$(document).ready(function(){

    $("#login").click(function () {
        var pass = $(":input[name=pass]").val();
        var pass = md5(pass);
        $("input[name=pass]").val(pass);
        alert(pass);
        $("#form-login").submit();
    })

})