<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Failed</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex flex-col h-screen justify-center items-center">
    <h1 class="text-3xl font-bold text-green-600 mb-4">Your Payment is failed!</h1>
    <p class="text-gray-600">Redirecting you to the homepage in <span id="countdown"
            class="text-orange-500 font-bold text-3xl">3</span> seconds...</p>

    <script>
        // Function to update the countdown
        function updateCountdown() {
            var countdownElement = document.getElementById("countdown");
            var countdownValue = parseInt(countdownElement.innerText);

            // Decrease the countdown value
            countdownValue--;

            // Update the countdown element
            countdownElement.innerText = countdownValue;

            // Redirect when countdown reaches 0
            if (countdownValue <= 0) {
                window.location.href = "http://127.0.0.1:8000/";
            }
        }

        // Call the updateCountdown function every second
        setInterval(updateCountdown, 1000);
    </script>
</body>

</html>
