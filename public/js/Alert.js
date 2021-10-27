function Alert({status, message}){
    let template = `
    <div class="alert alert-${status?'success':'danger'} alert-dismissible fade show" role="alert" style="
        position:fixed;
        width:80%;
        top: 0;
        right:0;
        z-index: 99999;

    ">
        ${message}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    `
    $('body').append(template)
}