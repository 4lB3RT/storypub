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

    $("#edit").click(function () {
        var idstory = $('input[name="storyid"]:checkbox:checked').val();

        if(idstory != ''){
            alert("test");
            $("#edit").attr("data-toggle","modal").attr("data-target","#modal_edit").attr("data-whatever","@mdo");
        }


    })

})