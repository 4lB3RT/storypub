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
})