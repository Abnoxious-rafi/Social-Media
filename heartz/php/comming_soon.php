<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #74ABE2 0%, #5563DE 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-align: center;
            padding: 20px;
        }

        .container {
            max-width: 600px;
        }

        h1 {
            font-size: 3rem;
            font-weight: 600;
            margin-bottom: 10px;
            animation: fadeInDown 1s ease;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            animation: fadeInUp 1s ease;
        }

        .countdown {
            display: flex;
            justify-content: space-between;
            margin: 0 auto 30px;
            max-width: 400px;
            animation: fadeIn 1s ease;
        }

        .countdown div {
            background: rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 8px;
            width: 80px;
        }

        .countdown div span {
            display: block;
            font-size: 2rem;
            font-weight: 600;
        }

        .subscribe {
            animation: fadeInUp 1s ease;
        }

        .subscribe input {
            padding: 10px;
            width: 60%;
            border: none;
            border-radius: 4px 0 0 4px;
            outline: none;
        }

        .subscribe button {
            padding: 10px;
            border: none;
            background: #fff;
            color: #5563DE;
            font-weight: 600;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Coming Soon...!!!</h1>
        <p>We're working hard to bring you our new website. Stay tuned for something amazing!</p>
        <div class="countdown">
            <div><span id="days">00</span>Days</div>
            <div><span id="hours">00</span>Hours</div>
            <div><span id="minutes">00</span>Min</div>
            <div><span id="seconds">00</span>Sec</div>
        </div>
        <div class="subscribe">
            <input type="email" placeholder="Enter your email" />
            <button>Notify Me</button>
        </div>
    </div>
    <script>
        // Countdown timer
        const targetDate = new Date();
        targetDate.setDate(targetDate.getDate() + 30);
        const daysEl = document.getElementById('days');
        const hoursEl = document.getElementById('hours');
        const minutesEl = document.getElementById('minutes');
        const secondsEl = document.getElementById('seconds');

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = targetDate - now;
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            daysEl.textContent = days.toString().padStart(2, '0');
            hoursEl.textContent = hours.toString().padStart(2, '0');
            minutesEl.textContent = minutes.toString().padStart(2, '0');
            secondsEl.textContent = seconds.toString().padStart(2, '0');
        }
        setInterval(updateCountdown, 1000);
        updateCountdown();
    </script>
</body>

</html>