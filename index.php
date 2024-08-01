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
                    // Create an array of words
                    $words = array("apple", "banana", "grape", "orange", "peach", "pear", "plum", "mango", "kiwi", "cherry", "pineapple", "watermelon", "raspberry", "fig", "blueberry", "blackberry", "papaya", "pomegranate", "strawberry", "lychee");

                    // Function to shuffle letters of a word
                    function shuffleWord($word)
                    {
                        $letters = str_split($word);
                        shuffle($letters);
                        return implode('', $letters);
                    }

                    // Start session to store the original word
                    session_start();

                    // Select a random word and shuffle it if not already set
                    if (!isset($_SESSION['originalWord'])) {
                        $randomIndex = array_rand($words);
                        $_SESSION['originalWord'] = $words[$randomIndex];
                    }

                    $originalWord = $_SESSION['originalWord'];
                    $shuffledWord = shuffleWord($originalWord);

                    // Initialize message variable
                    $message = "";

                    // Check if the form has been submitted
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (isset($_POST['b2'])) {
                            $userGuess = trim($_POST['b1']);
                            if (strcasecmp($userGuess, $originalWord) == 0) {
                                $message = "<p class='text-success'>" . "Correct! The word was: " . strtoupper($originalWord) . "<p>";
                                // Optionally reset the game
                                unset($_SESSION['originalWord']);
                            } else {
                                $message = "<p class='text-danger'>" . "Incorrect! Try again." . "<p>";
                            }
                        } elseif (isset($_POST['refresh'])) {
                            // Clear the message and reload the page to get a new word
                            unset($_SESSION['originalWord']); // Clear the original word
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
            element.style.display = "none"; // Correctly hides the element
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>