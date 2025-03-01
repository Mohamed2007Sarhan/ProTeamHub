<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" href="https://i.postimg.cc/fyZ0fqZK/proteamhub-logo.png" type="image/png">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProTeamHub - Error</title>
    <style>
        body {
            background-color: #0d0d0d;
            color: #fff;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        .container {
            text-align: center;
            animation: fadeIn 3s ease-in-out;
        }

        h1 {
            font-size: 4em;
            margin-bottom: 0.5em;
            animation: bounce 1.5s infinite alternate;
        }

        p {
            font-size: 1.5em;
            margin-top: 0;
            opacity: 0;
            animation: fadeInText 2s forwards;
            animation-delay: 2s;
        }

        /* Keyframes for effects */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes bounce {
            0% { transform: translateY(0); }
            100% { transform: translateY(-20px); }
        }

        @keyframes fadeInText {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .animation-wrapper {
            position: absolute;
            top: 10%;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            animation: moveParticle 3s infinite ease-in-out;
        }

        @keyframes moveParticle {
            0% { transform: translate(0, 0); opacity: 1; }
            100% { transform: translate(100px, 100px); opacity: 0; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Oops! Something Went Wrong.</h1>
        <p>We couldn't find the page you're looking for, but don't worry, we are here to help!</p>
        <div class="animation-wrapper">
            <!-- JavaScript will add animated particles here -->
        </div>
    </div>

    <script>
        // Particle animation effect
        const particleContainer = document.querySelector('.animation-wrapper');
        
        function createParticles() {
            for (let i = 0; i < 20; i++) {
                let particle = document.createElement('div');
                particle.classList.add('particle');
                const size = Math.random() * 10 + 5;  // Random size
                const startX = Math.random() * 100 + '%';
                const startY = Math.random() * 100 + '%';
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = startX;
                particle.style.top = startY;

                particleContainer.appendChild(particle);

                // Add delay for animation to start
                setTimeout(() => {
                    particle.style.animationDelay = Math.random() * 2 + 's';
                }, 100);
            }
        }

        createParticles();
    </script>
</body>
</html>
