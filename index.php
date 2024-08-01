<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Word Scramble Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

    <div class="wrapp h-100 d-flex justify-content-center p-5 mt-5">
        <div class="box p-1">
            <div class="card mt-5">
                <div class="card-header cheader">
                    Word Scramble
                </div>
                <div class="card-body">
                    
                    <?php
                    $words = array("apple", "banana", "grape", "orange", "peach", "pear", "plum", "mango", "kiwi", "cherry", "pineapple", "watermelon", "raspberry", "fig", "blueberry", "blackberry", "papaya", "pomegranate", "strawberry", "lychee");

                 
                    function shuffleWord($word)
                    {
                        $letters = str_split($word);
                        shuffle($letters);
                        return implode('', $letters);
                    }

                   
                    session_start();

                    if (!isset($_SESSION['originalWord'])) {
                        $randomIndex = array_rand($words);
                        $_SESSION['originalWord'] = $words[$randomIndex];
                    }

                    $originalWord = $_SESSION['originalWord'];
                    $shuffledWord = shuffleWord($originalWord);

                    $message = "";

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (isset($_POST['b2'])) {
                            $userGuess = trim($_POST['b1']);
                            if (strcasecmp($userGuess, $originalWord) == 0) {
                                $message = "<p class='text-success'>" . "Correct! The word was: " . strtoupper($originalWord) . "<p>";
                                unset($_SESSION['originalWord']);
                            } else {
                                $message = "<p class='text-danger'>" . "Incorrect! Try again." . "<p>";
                            }
                        } elseif (isset($_POST['refresh'])) {
                            unset($_SESSION['originalWord']); 
                            header("Location: " . $_SERVER['PHP_SELF']);
                            exit();
                        }
                    }
                    ?>
                    <div id="message"><?php echo $message; ?></div>
                    <strong class="spacing"><?php echo strtoupper($shuffledWord); ?></strong>
                    <form method="post" action="" class="mt-3">
                        <input type="text" name="b1" class="form-control" placeholder="Enter a valid word..." autofocus>
                        <input type="submit" name="b2" class="btn btn-primary submitbtn mt-3" value="Submit Guess">
                        <input type="submit" name="refresh" class="btn btn-secondary mt-3" value="Click to Refresh" onblur="hidemsg()">
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
        function hidemsg() {
            var element = document.getElementById("message");
            element.style.display = "none";
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>