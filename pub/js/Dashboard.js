$(document).ready(function(){
    
    $("#delete").click(function () {

        //get all inputs are checked
        var idstory = [];
            $(':checkbox:checked').each(function(i){
                idstory[i] = $(this).val();
            });

            $.ajax({
                type: "POST",
                url: '/dashboard/del_story',
                data: { data : idstory },
                success: function(data) {
                    window.location.href = "/";
                }
            })
        })
    $(".edit",this).click(function () {
        var id = $('.id',this).val();
        $("#id_reloadstory").val(id);
        $.ajax({
            type: "POST",
            url: "/dashboard/list_story",
            data :{id:id},
            success : function (data) {
                var story = JSON.parse(data);
                $("#title-edit").val(story[0].title);
                $("#story-edit").val(story[0].history);
                $("#tags-edit").val(story[0].title);
            }
        })

    })

    $("#edit-profile").click(function () {
        $(".user-info,#disconnect,#edit-profile").hide();
        $(".user-edit,#exit-button").show();
    })

    $("#exit-button").click(function () {
        $(".user-info,#disconnect,#edit-profile").show();
        $(".user-edit,#exit-button").hide();
    })

    $("#save-user").click(function () {

        //get value of input from template
        var email = $(":input[name=email]").val();
        var pass = $(":input[name=pass]").val();
        var username = $(":input[name=username]").val();
        var id = $(":input[name=id_user]").val();

        //check if are empty
        if(email != '' && pass != '' && username != ''  && id != ''){

            //encrypting value with md5
            pass = md5(pass);

                //fill array
                var dataString = {
                    email:email,
                    pass:pass,
                    username:username,
                    id:id
                };
                $.ajax({
                    type: "POST",
                    url: '/users/edit',
                    async: false,
                    data:dataString,
                    success: function(data) {
                        console.log(data);
                        if(data){
                            window.location.href = "/";
                        }else{
                            $("#msg").empty();
                            $("#msg").fadeIn();
                            $("#msg").html("<h3>Not update info</h3>");
                        }
                    }
                })

        }
    })
})