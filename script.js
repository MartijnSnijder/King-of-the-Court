$(function () {
    //init
    eliminated = [];
    masterList = [];
    score = [//score - means eliminated
        0, //team1
        0, //team2
        0, //team3
        0, //team4
        0 //team5
    ];
    round = 1;
    playorder = [
        0, //winnersside
        1, //challengers
        2, //next up
        3,
        4
    ];
    info = fillInfoFromCookie();

    currentTime = 20 * 60;

    $('#start-round').click(function () {
        startRound(round);
    });

    $('#winnersside').click(function () {
        awardPoint();
    });

    $('#challengers').click(function () {
        challengerSuccess();
    });
});