function Countdown() {
    this.counters = Array();
    this.interval = null;
}
Countdown.prototype.run = function () {
    var getCounters = document.querySelectorAll('.countdown');

    var self = this;

    if (getCounters.length != 0) {
        for (var i = 0; i < getCounters.length; i++) {
            this.counters.push(getCounters[i]);
        }
        this.interval = setInterval(function () {
            if (self.counters.length != 0) {
                for (var counter = 0; counter < self.counters.length; counter++) {
                    var element = self.counters[counter];
                    var remain = self.getRemainTime(element.dataset.time);
                    if (remain > 0) {
                        element.innerHTML = '<span class="timer">' + self.convert(remain) + '</span>';
                    } else {
                        element.innerHTML = '<span class="label label-danger">Expired</span>';
                        self.counters.splice(counter, 1);
                    }
                    if (self.counters.length == 0) {
                        clearInterval(self.interval);
                    }
                }
            }

        }, 1000);
    }

};
Countdown.prototype.convert = function (distance) {
    var hours = Math.floor(distance / 3600);
    var minutes = Math.floor((distance - hours * 3600) / 60);
    var seconds = distance - hours * 3600 - minutes * 60;
    return ("0" + hours).slice(-2) + ':' + ("0" + minutes).slice(-2) + ':' + ("0" + seconds).slice(-2);
}

Countdown.prototype.getRemainTime = function (timer) {
    var now = new Date;
    var local = parseInt(now.getTime() / 1000);
    return timer - local;
}
$(document).ready(function () {
    var countdown = new Countdown();
    countdown.run();
});