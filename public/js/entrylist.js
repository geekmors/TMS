//--- Jquery utility function definitions
$.fn.setValueUsingAttr = function (attr) {
    this.each(function (i) {
        $(this).val($(this).attr(attr))
    });
    return this
}
$.fn.setTextUsingAttr = function (attr) {
    this.each(function (i, $el) {
        $(this).text($(this).attr(attr))
    })
    return this
}
$.fn.setAttrs = function (value, attrs) {
    this.each(function (i) {
        for (let attr of attrs) {
            $(this).attr(attr, value)
        }
    })
    return this
}
//------
// gets the elapsed time given a start and end time
function getElapsedTime(timeIn, timeOut) {
    //conver to int arrays [0->hours, 1->mins, 2->seconds]
    timeIn = timeIn.split(':').map(item => parseInt(item))
    timeOut = timeOut.split(':').map(item => parseInt(item))

    let hours = timeOut[0] - timeIn[0]
    hours = hours >= 0 ? hours : (24 + hours)//if timeIn hours is more than timeOut hours
    let mins = timeOut[1] - timeIn[1]
    hours = mins < 0 ? hours - 1 : hours
    mins = mins >= 0 ? mins : (60 + mins)//if timeIn minits is more than timeOut mins
    let seconds = timeOut[2] - timeIn[2]
    mins = seconds < 0 ? mins - 1 : mins
    seconds = seconds >= 0 ? seconds : 60 + seconds //if timeIn seconds is more than timeOut seconds

    return `${_pad(hours)}:${_pad(mins)}:${_pad(seconds)}`
}
// updates the elapsed time on the DOM
function updateElapsedTime($entry) {
    let $startTime = $entry.find('input[name="entry_start_time"]'),
        $endTime = $entry.find('input[name="entry_end_time"]'),
        elapsedTime = getElapsedTime($startTime.val(), $endTime.val())
    $entry.find('.entry_elapsed_time').text(elapsedTime)
}
// handles any changes made to an entry
function handleEdits(e) {
    $(this).removeClass('invalid').siblings('.invalid-feedback-message').hide()

    //check if the entry name is blank
    if ($(this).is('[name="entry_name"]') && $(this).val().trim().length == 0) {
        $(this).addClass('invalid').siblings('.invalid-feedback-message').show()
    }
    if ($(this).is('[name="entry_start_time"]') || $(this).is('[name="entry_end_time"]')) {
        // incase the start_time or end_time were updated, update the elapsed time on the UI
        updateElapsedTime($(this).parent().parent())
    }
    $(this).parent().siblings('.save,.cancel').show()
}
// gets a list of jquery objects to be used to access the time entry's data on the DOM
function getEntryDataSelectors($ListItem) {
    return {
        _prnt: $ListItem,
        $entryName: $ListItem.find('input[name="entry_name"]'),
        $entryTimeIn: $ListItem.find('input[name="entry_start_time"]'),
        $entryTimeOut: $ListItem.find('input[name="entry_end_time"]'),
        $entryDate: $ListItem.find('input[name="entry_date"]'),
        $elapsedTime: $ListItem.find('.entry_elapsed_time')
    }
}
// uses the list of jquery objects from getEntryDataSelectors to get the data for the time entry
function getDataForUpdate($_) {//param is the object returned by getEntryDataSelectors
    return {
        id: $_._prnt.attr('data-id'),
        entry_name: $_.$entryName.val(),
        entry_date: $_.$entryDate.val(),
        entry_start_time: $_.$entryTimeIn.val(),
        entry_end_time: $_.$entryTimeOut.val(),

    }
}
// sends the changed data to the server for saving
// expects a data object and a callback function to which the response data is passed
function sendUpdateData(data, cb) {
    $.post('/timesheet/update', data, function (response) {
        cb(response.data)
        Alert({
            status: true,
            message: response.message
        })

    }).fail(function (xhr, status, error) {// will display the server error
        Alert({
            status: false,
            message: `Could not save changes to entry: ${xhr.responseText}`
        })
    })
}


//---- event handler definitions
//--- listen to input updates
$('.entry-log-list').on("keyup", 'input.entry-data[type="text"]', handleEdits)
$('.entry-log-list').on('change', 'input.entry-data[type="date"], input.entry-data[type="time"]', handleEdits)
//--- Listen for cancel, save and resume button clicks
$('.entry-log-list').on('click', '.cancel', function (e) {
    $(this).hide().siblings('.save').hide()
    $(this).parent().find('input').setValueUsingAttr('data-backup')
    $(this).parent().find('span.entry_elapsed_time').setTextUsingAttr('data-backup')
})
$('.entry-log-list').on('click', '.resume', function (e) {
    const timeEntryStrToken = 'timesheet_entry_00' + $('meta[name="ctms-ux-int"]').attr('content')
    
    var entryName = $(this).siblings('span.item').find('input[name="entry_name"]').val()

    try {
        if (appDB.get(timeEntryStrToken)) {
            $("#holdWhileSendingData").val(entryName)
            $('.stop-timer').click()
        }
    }
    catch (e) {
        $('#entry-name').val(entryName)
        $('.start-timer').click()
    }


})
$('.entry-log-list').on('click', '.save', function (e) {
    // check that entry name is not blank
    let $_ = getEntryDataSelectors($(this).parent())

    if ($_.$entryName.val().trim().length == 0) {
        Alert({ status: false, message: 'Entry cannot have a blank entry name.' })
        return
    }
    // re calculate elapsed time
    let elapsedTime = getElapsedTime($_.$entryTimeIn.val(), $_.$entryTimeOut.val()),
        // ajax to the server, send upate info
        data = getDataForUpdate($_)
    data["entry_elapsed_time"] = elapsedTime

    // send the data with the changes

    sendUpdateData(data, function (resData /*server response data*/) {
        // handle ui updates after server responds back
        //NOTE: if date is changed then more serious updates required
        /*let attrs = ['data-backup', 'value']

        $_.$entryDate.setAttrs(resData.date_worked, attrs)
        $_.$entryName.setAttrs(resData.entry, attrs)
        $_.$entryTimeIn.setAttrs(resData.time_in, attrs)
        $_.$entryTimeOut.setAttrs(resData.time_out, attrs)
        $_.$elapsedTime.attr('data-backup', resData.total_hours).text(resData.total_hours)
        $_._prnt.find('.save, .cancel').hide() // hide the save and cancel button*/

        // Per if date was changed or start time
        renderEntrySummaryList()
    })
})

$('body').on('click', '.toggle-entry-log-entry-list', function (e) {
    $(this).find('span.fa').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up')
})


function renderEntrySummaryList() {

    let current_route = window.location.pathname + window.location.search + `${window.location.search == '' ? '?' : '&'}json=true`
    $('#no-entries').hide()
    $.get(current_route, function (data) {

        data = data.data
        if(data.length == 0){
            $('#no-entries').show()
        }
        let content = $('#entrySummaryTemplate').html()
        content = ejs.render(content, {
            data: data,
            toReadableDate: datets => {
                datets = datets.split('-').map(item => parseInt(item))
                datets = (new Date(datets[0], datets[1] - 1, datets[2])).toDateString()
                return datets
                /*var readableDate = datets
                readableDate = readableDate.split(' ')
                readableDate[2] = readableDate[2] + ',';
                return readableDate.join(' ')*/
            },
            ts_format: timeString => {
                let fmt = timeString.split(':')
                return `${fmt[0]}h ${fmt[1]}m ${fmt[2]}s`
            },
            isFirst(key, data) {
                return key == Object.keys(data)[0]
            }
        })
        $('.entry-log-list').empty().append(content)
        

    }).fail(function (xhr, status, error) {
        console.log(xhr.responseText)
        Alert({ status: false, message: `Unable to get data from server.` })
    })

}

renderEntrySummaryList()
