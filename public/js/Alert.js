/**
 * Will append a bootstrap alert message to the DOM, will display it at the top right of the screen.
 * @param {{status:boolean, message:string}} options if status is true then the alert-success is used, if false then alert-danger is used.
 *  message refers to the message to show in the alert
 * @returns JQuery object referencing the alert Div in the DOM
 */
function Alert({status, message}){
    $('alert-custom').remove()
    let $template = $(`
    <div class="alert alert-${status?'success':'danger'} alert-dismissible fade show alert-custom" role="alert" style="
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
    `)
    $('body').append($template)
    setTimeout(function(){
        $template.remove()
    }, 8000)
    return $template
}
