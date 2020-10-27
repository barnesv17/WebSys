function addNewScore() {
    var highScores = (localStorage.getItem("highScores"));
    highScores = JSON.parse(highScores);
    for (i in highScores) {
        console.log(highScores[i]);
    }
}

if (typeof (Storage) !== "undefined") {
    if (localStorage.highScores) {
        addNewScore();
    }
    else {
        var emptyHighScores = {
            1: { user: "Player Name", score: 0, time: 0.000 }, 2: { user: "Player Name", score: 0, time: 0.000 },
            3: { user: "Player Name", score: 0, time: 0.000 }, 4: { user: "Player Name", score: 0, time: 0.000 }, 5: { user: "Player Name", score: 0, time: 0.000 },
            6: { user: "Player Name", score: 0, time: 0.000 }, 7: { user: "Player Name", score: 0, time: 0.000 }, 8: { user: "Player Name", score: 0, time: 0.000 },
            9: { user: "Player Name", score: 0, time: 0.000 }, 10: { user: "Player Name", score: 0, time: 0.000 }
        }
        localStorage.setItem("highScores", JSON.stringify(emptyHighScores))
    }
} 