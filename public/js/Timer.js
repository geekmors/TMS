var _rnd = value => Math.round(value),
    _flr = value => Math.floor(value),
    _pad = num => num - 9 > 0 ? num : '0' + num
class Timer{
    constructor(startTime=Date.now()){
        this.startTime = startTime
        
    }
    
    elapsed(currentTime = Date.now()){       
        let hours = 0, seconds = 0, mins = 0
             
        seconds = _rnd((currentTime - this.startTime)/(1000)),
        hours = _flr(seconds / 3600)
        seconds = _rnd(seconds % 3600)
        mins = _flr( seconds / 60)
        seconds = _rnd(seconds % 60)

        return `${_pad(hours)}:${_pad(mins)}:${_pad(seconds)}`
    }
    padNumber(number){
        return number - 9 > 0 ? number : '0' + number
    }
    set startTime(startTime=Date.now()){
        this._startTime = startTime
        this._startDate = new Date(this._startTime)
    }
    get startTime(){
        return this._startTime
    }
    get startDateTime(){
        return this._startDate
    }
    get timeString(){
        
        return `${_pad(this._startDate.getHours())}:${_pad(this._startDate.getMinutes())}`
    }
}