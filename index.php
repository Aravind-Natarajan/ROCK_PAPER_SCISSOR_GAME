
<?php
session_start();

if (!isset($_SESSION['player'])) {
    $_SESSION['player'] = 0;
    $_SESSION['computer'] = 0;
    $_SESSION['highscore'] = 0;
    $_SESSION['streak'] = 0;
}

$result = "";
$player = "";
$computer = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['reset'])) {
        $_SESSION['player'] = 0;
        $_SESSION['computer'] = 0;
        $_SESSION['streak'] = 0;
    }

    if (isset($_POST['choice'])) {

        $player = $_POST['choice'];

        $choices = ["rock", "paper", "scissors"];
        $computer = $choices[array_rand($choices)];

        if ($player == $computer) {
            $result = "DRAW 🤝";
            $_SESSION['streak'] = 0;
        }
        elseif (
            ($player == "rock" && $computer == "scissors") ||
            ($player == "paper" && $computer == "rock") ||
            ($player == "scissors" && $computer == "paper")
        ) {
            $result = "YOU WIN! 🎉";
            $_SESSION['player']++;
            $_SESSION['streak']++;

            if ($_SESSION['player'] > $_SESSION['highscore']) {
                $_SESSION['highscore'] = $_SESSION['player'];
            }
        }
        else {
            $result = "YOU LOSE! 😢";
            $_SESSION['computer']++;
            $_SESSION['streak'] = 0;
        }
    }
}

$icons = [
    "rock" => "✊",
    "paper" => "✋",
    "scissors" => "✌️"
];
?>

<!DOCTYPE html>
<html>
<head>
<title>Rock Paper Scissors</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg,#101025,#252553);
    color: white;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.game {
    width: 100%;
    max-width: 750px;
    background: #191932;
    padding: 35px;
    border-radius: 25px;
    box-shadow: 0 15px 50px #0008;
    text-align: center;
}

h1 {
    font-size: 32px;
    color: #ffcc4d;
}

.subtitle {
    color: #aaa;
    margin: 12px 0 30px;
}

.scoreboard {
    display: grid;
    grid-template-columns: repeat(3,1fr);
    gap: 12px;
    margin-bottom: 30px;
}

.score {
    background: #29294c;
    padding: 18px 8px;
    border-radius: 15px;
}

.score h3 {
    color: #aaa;
    font-size: 13px;
}

.score p {
    font-size: 30px;
    font-weight: bold;
    color: #ffcc4d;
    margin-top: 10px;
}

h2 {
    margin: 20px 0;
    font-size: 20px;
}

.choices {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
}

.choice {
    width: 130px;
    height: 130px;
    background: #30305a;
    border: 2px solid #55558a;
    border-radius: 20px;
    color: white;
    font-size: 55px;
    cursor: pointer;
    transition: .3s;
}

.choice:hover {
    transform: translateY(-10px) scale(1.05);
    background: #5757a5;
    border-color: #ffcc4d;
}

.result {
    background: #29294c;
    padding: 22px;
    margin-top: 30px;
    border-radius: 15px;
}

.result h2 {
    color: #ffcc4d;
    font-size: 26px;
}

.result p {
    color: #ccc;
    margin-top: 12px;
    font-size: 18px;
}

.reset {
    margin-top: 25px;
    padding: 13px 30px;
    border: none;
    border-radius: 10px;
    background: #ff5959;
    color: white;
    font-size: 16px;
    cursor: pointer;
}

.reset:hover {
    background: #e63939;
}

.streak {
    color: #ff9f43;
    margin-top: 20px;
    font-weight: bold;
}

@media(max-width:500px) {
    .game {
        padding: 20px;
    }

    .choice {
        width: 90px;
        height: 90px;
        font-size: 40px;
    }

    .score p {
        font-size: 23px;
    }
}
</style>
</head>

<body>

<div class="game">

    <h1>🎮 ROCK PAPER SCISSORS</h1>
    <p class="subtitle">Challenge the Computer & Become a Champion!</p>

    <div class="scoreboard">

        <div class="score">
            <h3>YOUR SCORE</h3>
            <p><?= $_SESSION['player'] ?></p>
        </div>

        <div class="score">
            <h3>COMPUTER</h3>
            <p><?= $_SESSION['computer'] ?></p>
        </div>

        <div class="score">
            <h3>HIGH SCORE</h3>
            <p><?= $_SESSION['highscore'] ?></p>
        </div>

    </div>

    <h2>Choose Your Weapon ⚔️</h2>

    <form method="POST" class="choices">

        <button class="choice" name="choice" value="rock">
            ✊
        </button>

        <button class="choice" name="choice" value="paper">
            ✋
        </button>

        <button class="choice" name="choice" value="scissors">
            ✌️
        </button>

    </form>

    <?php if ($result != ""): ?>

    <div class="result">

        <h2><?= $result ?></h2>

        <p>
            You:
            <?= $icons[$player] ?>
            VS
            Computer:
            <?= $icons[$computer] ?>
        </p>

    </div>

    <?php endif; ?>

    <p class="streak">
        🔥 Winning Streak: <?= $_SESSION['streak'] ?>
    </p>

    <form method="POST">
        <button class="reset" name="reset">
            🔄 Reset Game
        </button>
    </form>

</div>

</body>
</html>
