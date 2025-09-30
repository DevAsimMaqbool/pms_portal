<!-- Celebration Styles -->
<style>
    #celebration {
        position: fixed;
        inset: 0;
        pointer-events: none;
        overflow: hidden;
        z-index: 9999;
        background: rgba(0, 0, 0, 0.25);
        display: none;
    }

    /* Balloons */
    .balloon {
        position: absolute;
        bottom: -120px;
        width: 60px;
        height: 80px;
        border-radius: 50% 50% 45% 45%;
        animation: floatUp 8s ease-in forwards;
    }

    .balloon::after {
        content: "";
        position: absolute;
        bottom: -35px;
        left: 50%;
        width: 2px;
        height: 35px;
        background: #444;
        transform: translateX(-50%);
    }

    @keyframes floatUp {
        0% {
            transform: translateY(0) scale(0.9);
            opacity: 1;
        }

        50% {
            transform: translateY(-50vh) scale(1);
        }

        100% {
            transform: translateY(-110vh) scale(1.1);
            opacity: 0;
        }
    }

    /* Confetti */
    .confetti {
        position: absolute;
        width: 10px;
        height: 16px;
        opacity: 0.9;
        transform: scale(0);
        animation: explode 2.4s ease-out forwards;
    }

    @keyframes explode {
        0% {
            transform: scale(0) translate(0, 0) rotate(0deg);
            opacity: 1;
        }

        80% {
            opacity: 1;
        }

        100% {
            transform: scale(1) translate(var(--x), var(--y)) rotate(900deg);
            opacity: 0;
        }
    }

    /* Streamers */
    .streamer {
        position: absolute;
        top: -60px;
        width: 6px;
        height: 120px;
        background: linear-gradient(to bottom, #ff4081, #ffeb3b, #2196f3);
        border-radius: 3px;
        animation: fallTwist 7s linear forwards;
    }

    @keyframes fallTwist {
        0% {
            transform: rotate(0) translateY(0);
            opacity: 1;
        }

        100% {
            transform: rotate(1080deg) translateY(120vh);
            opacity: 0;
        }
    }

    /* Ribbons */
    .ribbon {
        position: absolute;
        width: 4px;
        height: 100px;
        background: linear-gradient(to bottom, gold, red, purple);
        border-radius: 50%;
        animation: fallRibbon 6s linear forwards;
    }

    @keyframes fallRibbon {
        0% {
            transform: rotate(0deg) translateY(0);
            opacity: 1;
        }

        100% {
            transform: rotate(720deg) translateY(120vh);
            opacity: 0;
        }
    }

    /* Party Hats */
    .party-hat {
        position: absolute;
        width: 0;
        height: 0;
        border-left: 20px solid transparent;
        border-right: 20px solid transparent;
        border-bottom: 35px solid #e91e63;
        animation: fallHat 6s linear forwards;
    }

    @keyframes fallHat {
        0% {
            transform: rotate(0) translateY(0);
            opacity: 1;
        }

        100% {
            transform: rotate(720deg) translateY(120vh);
            opacity: 0;
        }
    }

    /* Lights */
    .light {
        position: absolute;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        opacity: 0.7;
        animation: pulse 1.5s infinite alternate;
    }

    @keyframes pulse {
        0% {
            transform: scale(0.8);
            opacity: 0.4;
        }

        100% {
            transform: scale(1.8);
            opacity: 1;
        }
    }

    /* Foil Sparkles */
    .sparkle {
        position: absolute;
        width: 6px;
        height: 6px;
        background: white;
        border-radius: 50%;
        opacity: 0.8;
        animation: sparkleAnim 3s linear forwards;
    }

    @keyframes sparkleAnim {
        0% {
            transform: scale(0.5);
            opacity: 1;
        }

        100% {
            transform: scale(2) translateY(100vh);
            opacity: 0;
        }
    }

    /* Fireworks */
    .firework {
        position: absolute;
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background: yellow;
        animation: fireworkAnim 1.5s ease-out forwards;
    }

    @keyframes fireworkAnim {
        0% {
            transform: scale(0);
            opacity: 1;
        }

        100% {
            transform: scale(5) translate(var(--fx), var(--fy));
            opacity: 0;
        }
    }

    /* Banner */
    .banner {
        position: absolute;
        top: 40%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.8);
        font-size: 3.2rem;
        font-weight: bold;
        color: #fff;
        padding: 20px 50px;
        background: linear-gradient(90deg, #ff4081, #ffeb3b, #4caf50, #2196f3);
        border-radius: 16px;
        animation: popBanner 1.2s ease-out forwards, fadeOut 5.5s ease-in forwards;
        text-shadow: 2px 2px 12px rgba(0, 0, 0, 0.6);
    }

    @keyframes popBanner {
        0% {
            transform: translate(-50%, -50%) scale(0);
            opacity: 0;
        }

        60% {
            transform: translate(-50%, -50%) scale(1.25);
            opacity: 1;
        }

        100% {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }
    }

    @keyframes fadeOut {

        0%,
        70% {
            opacity: 1;
        }

        100% {
            opacity: 0;
        }
    }
</style>

<!-- Celebration container -->
<div id="celebration"></div>

<!-- Script -->
<script>
    function launchCelebration() {
        const wrap = document.getElementById("celebration");
        wrap.style.display = "block";

        // Confetti
        for (let i = 0; i < 120; i++) {
            const c = document.createElement("div");
            c.className = "confetti";
            const angle = Math.random() * 2 * Math.PI;
            const radius = 180 + Math.random() * 420;
            c.style.setProperty("--x", `${Math.cos(angle) * radius}px`);
            c.style.setProperty("--y", `${Math.sin(angle) * radius}px`);
            c.style.left = "50%";
            c.style.top = "50%";
            c.style.backgroundColor = ["#ff4081", "#ffeb3b", "#4caf50", "#2196f3", "#ff5722"][Math.floor(Math.random() * 5)];
            wrap.appendChild(c);
            setTimeout(() => c.remove(), 2500);
        }

        // Balloons
        for (let i = 0; i < 15; i++) {
            const b = document.createElement("div");
            b.className = "balloon";
            b.style.left = `${10 + Math.random() * 80}vw`;
            b.style.background = `radial-gradient(circle at 30% 30%, 
                ${["#ff4e50", "#ff9a9e", "#82ccdd", "#78e08f", "#f6b93b"][Math.floor(Math.random() * 5)]}, 
                #c44569)`;
            b.style.animationDuration = `${6 + Math.random() * 5}s`;
            wrap.appendChild(b);
            setTimeout(() => b.remove(), 9000);
        }

        // Streamers
        for (let i = 0; i < 20; i++) {
            const s = document.createElement("div");
            s.className = "streamer";
            s.style.left = `${Math.random() * 100}vw`;
            wrap.appendChild(s);
            setTimeout(() => s.remove(), 7000);
        }

        // Ribbons
        for (let i = 0; i < 12; i++) {
            const r = document.createElement("div");
            r.className = "ribbon";
            r.style.left = `${Math.random() * 100}vw`;
            wrap.appendChild(r);
            setTimeout(() => r.remove(), 6000);
        }

        // Party Hats
        for (let i = 0; i < 7; i++) {
            const hat = document.createElement("div");
            hat.className = "party-hat";
            hat.style.left = `${Math.random() * 100}vw`;
            hat.style.top = `${-50 - Math.random() * 200}px`;
            hat.style.borderBottomColor = ["#e91e63", "#2196f3", "#4caf50", "#ffeb3b"][Math.floor(Math.random() * 4)];
            wrap.appendChild(hat);
            setTimeout(() => hat.remove(), 6500);
        }

        // Lights
        for (let i = 0; i < 30; i++) {
            const l = document.createElement("div");
            l.className = "light";
            l.style.left = `${Math.random() * 100}vw`;
            l.style.top = `${Math.random() * 100}vh`;
            l.style.background = ["#ff4081", "#ffeb3b", "#4caf50", "#2196f3"][Math.floor(Math.random() * 4)];
            wrap.appendChild(l);
            setTimeout(() => l.remove(), 5000);
        }

        // Sparkles
        for (let i = 0; i < 40; i++) {
            const sp = document.createElement("div");
            sp.className = "sparkle";
            sp.style.left = `${Math.random() * 100}vw`;
            sp.style.top = `${Math.random() * 100}vh`;
            wrap.appendChild(sp);
            setTimeout(() => sp.remove(), 3000);
        }

        // Fireworks
        for (let i = 0; i < 6; i++) {
            setTimeout(() => {
                for (let j = 0; j < 20; j++) {
                    const f = document.createElement("div");
                    f.className = "firework";
                    f.style.left = "50%";
                    f.style.top = "50%";
                    const ang = Math.random() * 2 * Math.PI;
                    const rad = 80 + Math.random() * 100;
                    f.style.setProperty("--fx", `${Math.cos(ang) * rad}px`);
                    f.style.setProperty("--fy", `${Math.sin(ang) * rad}px`);
                    f.style.background = ["#ff4081", "#ffeb3b", "#4caf50", "#2196f3", "#ff5722"][Math.floor(Math.random() * 5)];
                    wrap.appendChild(f);
                    setTimeout(() => f.remove(), 1500);
                }
            }, i * 500);
        }

        // Banner
        const banner = document.createElement("div");
        banner.className = "banner";
        banner.textContent = "🎉 Congratulations! 🎊";
        wrap.appendChild(banner);
        setTimeout(() => banner.remove(), 6000);

        // Sound
        const audio = new Audio("https://www.soundjay.com/buttons/sounds/button-09.mp3");
        audio.play().catch(() => { });

        // Remove overlay
        setTimeout(() => {
            wrap.innerHTML = "";
            wrap.style.display = "none";
        }, 7000);
    }

    // Example trigger
    document.getElementById('swalCongrats').addEventListener('click', launchCelebration);
</script>