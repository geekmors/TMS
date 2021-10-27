(function(){
    /**
     * Todo:
     *  1. on date changed
     *  2. on entry name changed
     */
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var cron = null // holds the setInterval process

    function clearEntryForm(){ // will clear the time sheet entry form
        $('#entry-name').val('') // clear entry name
        $('#entry-date').val((new Date()).toJSON().split('T')[0]) //set back to default
        $('#start-time').val('')
        
        $('#elapsed-time').text('00:00:00')
    }
    
    $('.start-timer').click(function(e){
        // check first if a title has been added before starting
        if($('#entry-name').val().trim().length == 0){
            Alert({status:false, message:'Please enter an entry name before starting.'})
            $('#entry-name').css('border','red 1px solid')
            return
        }
        $('#entry-name').css('border','')
        
        try{ // see if there is a start time to use for the timer
            var entryData = appDB.get('timesheet_entry')
            var timer = new Timer(entryData.startTime)
        }catch(e){
            console.log(e.message)
            var timer = new Timer()
        }
        cron = setInterval(function(){
            $('#elapsed-time').text(timer.elapsed())
        }, 500)
        $('#start-time').val(timer.timeString)     
        $(this).hide()
        $('.stop-timer').show()
        
        appDB.set('timesheet_entry', {
            date: $('#entry-date').val(),
            name: $('#entry-name').val(),
            startTimeString: timer.timeString,
            startTime: timer.startTime
        })
    })
    $('.stop-timer').click(function(e){
        let endTime = new Timer()
        clearInterval(cron)
        var data = {
            entry_name :$('#entry-name').val(),
            entry_date: $('#entry-date').val(),
            entry_start_time: $('#start-time').val(),
            entry_end_time: endTime.timeString,
            entry_elapsed_time: $('#elapsed-time').text()
        }
        sendData(data)
        clearEntryForm()
        $(this).hide()
        $('.start-timer').show()
        appDB.resetKey('timesheet_entry')
    })
    var sendData = data =>{
       
        $.post('/timesheet', data, function(response){
            Alert({status:true, message:'Entry successfully saved!'})
            console.log(response)
            addEntryToList(response.data)
        }).fail(function(){
            Alert({status:false, message:'The timesheet entry could not be saved.'})
        })
    }
    var addEntryToList = data => {
        let template = `
        <li class="list-group-item">
            Entry Name: ${data.entry_name} |
             Date: ${data.entry_date} |
             Time Start: <input type="time" name="" id="" value="${data.entry_start_time}"> |
             Time End: <input type="time" name="" id="" value="${data.entry_end_time}">
            </li>
        `
        $('#EntryList').append(template)
    }
    function startTimerWith(entry){
        $('#entry-name').val(entry.name)
        $('#start-time').val(entry.startTimeString)
        $('#entry-date').val(entry.date)
        $('.start-timer').click()
    }
    try{
        var entryData = appDB.get('timesheet_entry')
        startTimerWith(entryData)
    }
    catch(e){
        // do nothing
    }
})()