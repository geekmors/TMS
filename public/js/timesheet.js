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
    cron = null // holds the setInterval process, GLOBAL var

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
            $('#current-time').val(timer.currentTimeString)
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
        if (!cron) return //only stop the timer if the timer is running
        
        let endTime = new Timer()
        
        var data = {
            entry_name :$('#entry-name').val(),
            entry_date: $('#entry-date').val(),
            entry_start_time: $('#start-time').val(),
            entry_end_time: endTime.timeString,
            entry_elapsed_time: $('#elapsed-time').text()
        },
        $this = $(this)
        sendData(data, function(){ // after success completion
            clearEntryForm()
            $this.hide()
            $('.start-timer').show()
            appDB.resetKey('timesheet_entry')
            clearInterval(cron)
            cron = false
        })
    })
    var sendData = (data, cb) =>{
       
        $.post('/timesheet/create', data, function(response){
            Alert({status:true, message:'Entry successfully saved!'})
            console.log(response)
            addEntryToList(response.data)
            cb()
        }).fail(function(xhr, status, error){
            console.log(xhr.responseText)
            Alert({status:false, message:`The timesheet entry could not be saved. Try reloading and saving again. If issue persists, have admin review error logs.`})
        })
    }
    var addEntryToList = data => {
        let template = `
        <li class="list-group-item d-flex justify-content-around" data-id="${data.id}">
                <span class="item">
                    Entry Name:
                    <input class="entry-data entry-inputs" type="text" name="entry_name" value="${data.entry}" data-backup="${data.entry}">
                    <div style="display:none" class="invalid-feedback-message text-center">Entry name cannot be blank</div>
                
                    </span>
                <span class="item">
                    Date: <input class="entry-data entry-inputs" type="date" name="entry_date" value="${data.date_worked}" data-backup="${data.date_worked}">
                </span>
                <span class="item">
                    Time Start: <input class="entry-data entry-inputs" step="1" type="time" name="entry_start_time" id="" value="${data.time_in}" data-backup="${data.time_in}">
                </span>
                <span class="item">
                    Time End: <input class="entry-data entry-inputs" step="1" type="time" name="entry_end_time" id="" value="${data.time_out}" data-backup="${data.time_out}">
                </span>
                <span class="item">
                    Total Time: <span class="entry_elapsed_time" data-backup="${data.total_hours}">${data.total_hours}</span>
                </span>
                <button class="save btn btn-outline-primary" title="save" data-id="${data.id}" style="display:none;">
                    save
                    <span class="fa fa-save"></span>
                </button>
                <button data-id="${data.id}" class="cancel btn btn-outline-warning" title="cancel edits" style="display:none;">
                    cancel
                    <span class="fa fa-times">
                    </span>
                </button>
                <button data-id="${data.id}" class="resume btn btn-outline-success" title="resume entry">
                    Resume
                    <span class="fa fa-play"></span>
                </button>
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