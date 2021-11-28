(function(){
    const timeEntryStrToken = 'timesheet_entry_00' + $('meta[name="ctms-ux-int"]').attr('content')
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    cron = null // holds the setInterval process, GLOBAL var

    function clearEntryForm(){ 
        let currentDate = (new Date()).toLocaleDateString().split('/')
        // will clear the time sheet entry form
        $('#entry-name').val('') // clear entry name
        $('#entry-date').val(`${_pad(currentDate[2])}-${currentDate[0]}-${_pad(currentDate[1])}`) //set back to default
        $('#start-time').val('')
        $('#current-time').val('')
        $('#elapsed-time').text('00:00:00')
    }
    
    $("#holdWhileSendingData").on("resume", function(e){
        $('#entry-name').val($(this).val()).focus()
        $('.start-timer').click()
        $(this).val('')

    })

    $('.start-timer').click(function(e){
        
        // check first if a title has been added before starting
        if($('#entry-name').val().trim().length == 0){
            Alert({status:false, message:'Please enter an entry name before starting.'})
            $('#entry-name').css('border','red 1px solid')
            return
        }
        $('#entry-name').css('border','')
        
        try{ // see if there is a start time to use for the timer
            var entryData = appDB.get(timeEntryStrToken)
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
        
        appDB.set(timeEntryStrToken, {
            date: $('#entry-date').val(),
            name: $('#entry-name').val(),
            startTimeString: timer.timeString,
            startTime: timer.startTime
        })
    })
    $('.stop-timer').click(async function(e){
        if (!cron) return //only stop the timer if the timer is running

        // create a Timer instance to parse time and prep before sending to database
        let endTime = new Timer()
        
        // get the data from the UI
        var data = {
            entry_name : $('#entry-name').val(),
            entry_date : $('#entry-date').val(),
            entry_start_time : $('#start-time').val(),
            entry_end_time : endTime.timeString,
            entry_elapsed_time : $('#elapsed-time').text()
        }
        var $this = $(this)

        // call the send data function to send the data to the server
        sendData(data, function(){ // after success completion
            clearEntryForm()
            $this.hide()
            $('.start-timer').show()
            appDB.resetKey(timeEntryStrToken)

            // stop the timer
            clearInterval(cron)
            cron = false
           
            if($("#holdWhileSendingData").val().trim().length > 0)
                $("#holdWhileSendingData").trigger("resume")
           
        })
    })
    // make the ajax request
    var sendData = (data, cb) =>{
        // send the data to the server using a POST request    
        $.post('/timesheet/create', data, function(response){
            Alert({status:true, message:'Entry successfully saved!'})
            console.log(response)
            cb() // call the callback function
            // update the UI's entry log history section
            renderEntrySummaryList()
        }).fail(function(xhr, status, error){
            // show any errors that may occur
            console.log(xhr.responseText)
            Alert({status:false, message:`The timesheet entry could not be saved. Try reloading and saving again. If issue persists, have admin review error logs.`})
        })
    }
    
    function startTimerWith(entry){
        $('#entry-name').val(entry.name)
        $('#start-time').val(entry.startTimeString)
        $('#entry-date').val(entry.date)
        $('.start-timer').click()
    }
    try{
        var entryData = appDB.get(timeEntryStrToken)
        startTimerWith(entryData)
    }
    catch(e){
        // do nothing
    }
})()