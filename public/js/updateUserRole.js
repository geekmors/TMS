$(document).ready(function(){
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
     });

    //AJAX User Role Update
    $(".chRole").on('change', function(){
        //*getting the id of the selected user 
        $tr = $(this).closest('tr');
        /*var userData = $tr.children("td").map(function(){
            return $(this).text();
        }).get();*/
        var UID = $(this).attr('data-user-id')//userData[0];
        //alert("user id: "+selUserID);

        //*get the selected value from the dropdown
        var newRoleVal = $(this).val();
        //alert("new role: "+newRoleVal);



        $.ajax({
            type: "POST",
            url: "/updateRole/"+UID,
            data: {
                newRoleVal:newRoleVal
                },
            success: function(response) {
                console.log(response);
                alert("data updated");
                //location.reload();
            },
            error: function(error) {
                console.log(error);
                //location.reload();
            }
        });
    });
});