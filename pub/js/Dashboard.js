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

    })
})