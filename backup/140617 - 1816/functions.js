function fillInfoFromCookie() {
    var info = [];
    if (getCookie('team1-info') === "") {
        return info;
    }

    for (var i = 0; i < 5; i++) {
        var c = getCookie('team' + i + '-info')
                .replace(/%3D/g, '=')
                .replace(/\+/g, ' ')
                .replace(/%2F/g, '/')
                .replace(/%23/g, '#')
                .split('--');
        var name = c[0].split('=')[1];
        var bgcolor = c[1].split('=')[1].split('-')[0];
        var color = c[1].split('=')[1].split('-')[1];
        var img = c[2].split('=')[1];
        info[i] = {
            'name': name,
            'bgcolor': bgcolor,
            'color': color,
            'img': img
        };
    }
    return info;
}

function startRound(round) {
    //init
    if (round == 1) {
        //don't eliminate yet
        currentTime = 20 * 60;
    } else if (round == 2) {
        currentTime = 15 * 60;
        var eliminate = eliminateTeam(score);
        score = eliminate[1]; //reset to 0
        score[eliminate[0]] = '-';
        eliminated.push(eliminate[0]);
        $('#nr4').addClass('eliminated');
        alert('Team ' + (eliminate[0] + 1) + ' (' + info[eliminate[0]]['name'] + ') is eliminated!');
    } else if (round == 3) {
        currentTime = -1;
        var eliminate = eliminateTeam(score);
        score = eliminate[1]; //reset to 0
        score[eliminate[0]] = '-';
        eliminated.push(eliminate[0]);
        $('#nr3').addClass('eliminated');
        alert('Team ' + (eliminate[0] + 1) + ' (' + info[eliminate[0]]['name'] + ') is eliminated!');
    }
    $('#roundnr').html('Round ' + round);
    setHtmlRanking();
    setHtmlOrder();

    alert('Round starts when you close this alert!');
    startTimer();
}

function setHtmlRanking() {
    //first create a sortable array
    masterList = [];
    for (var i = 1; i <= score.length; i++) {
        masterList.push({key: i, val: score[i - 1]});
    }
    masterList = masterList.sort(function (a, b) {
        if(isNaN(a.val) || isNaN(b.val)){
            return ('' + a.val).localeCompare('' + b.val);
        }else{
            if (parseInt(a.val) < parseInt(b.val)) {
                return -1;
            }
            if (parseInt(a.val) > parseInt(b.val)) {
                return 1;
            }
            // a must be equal to b
            return 0;
        }});

    masterList.reverse();

    for (var i = 0; i < masterList.length; i++) {
        var team = masterList[i]['key'];
        var points = masterList[i]['val'];
        var bgcolor = info[team - 1]['bgcolor'];
        var color = info[team - 1]['color'];
        var name = info[team - 1]['name'];
        $('#nr' + (i)).html('<h1 class="w3-col m10" style="background-color: ' + bgcolor + '; color: ' + color + '; font-size: 70px">' + name + '</h1><h1 class="w3-col m1"> </h1><h1 style="color:white; font-size: 70px" class="w3-col m1">' + points + '</h1>')
    }
}

function setHtmlOrder() {
    //first check for eliminated teams
    if (eliminated !== []) {
        for (var j = 0; j < eliminated.length; j++) {//repeat for each eliminated team
            var until = playorder.length -1;
            for (var i = 0; i < until; i++) {
                if (score[playorder[i]] == '-') {
                    var tmp = playorder[i + 1];
                    playorder[i + 1] = playorder[i];
                    playorder[i] = tmp;
                }
            }
        }
    }
    //now update html
    for (var i = 0; i < playorder.length; i++) {
        var src = info[playorder[i]]['img'];
        $('img.order-' + i).attr('src', src);
    }
}

function awardPoint() {
    var winnerssideTeam = playorder[0];
    score[winnerssideTeam]++;
    if (score[winnerssideTeam] == 15 && round == 3) {
        alert('Team ' + (winnerssideTeam + 1) + ' (' + info[winnerssideTeam]['name'] + ') won the game!');
    }
    winnerssideTeam = playorder.shift();
    playorder.push(playorder.shift());
    playorder.unshift(winnerssideTeam);
    setHtmlOrder();
    setHtmlRanking();
}

function challengerSuccess() {
    playorder.push(playorder.shift());
    setHtmlOrder();
}

function startTimer() {
    $('#start-round').disable(true);
    if (currentTime > 0) {
        timerObj = setInterval(function () {
            currentTime--;
            var mins = Math.floor(currentTime / 60);
            var secs = Math.floor(currentTime % 60);

            $('#time-left').html(mins + ':' + secs);
            if (currentTime < 0) {
                round++;
                $('#time-left').html('00:00');
                clearInterval(timerObj);
                $('#start-round').disable(false);
                alert("TIME'S UP!");
            }
        }, 1000);
    } else {
        $('#time-left').html('--:--');
    }
}

function setCookie(cname, cvalue) {
    document.cookie = cname + "=" + cvalue;
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

// returns "" if doesn't exist
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function eliminateTeam(arr) {
    if (arr.length === 0) {
        return -1;
    }

    var min = arr[0];
    arr[0] = 0;
    if (min == '-') {
        min = 20;
    }
    var minIndex = 0;

    for (var i = 1; i < arr.length; i++) {
        if (arr[i] != '-') {
            if (arr[i] < min) {
                minIndex = i;
                min = arr[i];
            }
            arr[i] = 0;
        }
    }

    return [minIndex, arr];
}

$.fn.extend({
    disable: function (state) {
        return this.each(function () {
            this.disabled = state;
        });
    }
});