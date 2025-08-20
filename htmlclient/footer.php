<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UpStudy Footer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Footer */
        .footer {
            background: linear-gradient(135deg, #032b56 0%, #021a36 100%);
            padding: 4rem 0 1rem;
            color: #fff;
            position: relative;
            overflow: hidden;
            margin-top: 30px;
        }

        .footer::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #00d4aa, #0066ff);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 1;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-section h3 {
            font-size: 1.0rem;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }

        .footer-section h3::after {
            content: "";
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 50px;
            height: 3px;
            background: #00d4aa;
            border-radius: 3px;
        }

        .footer-section h4 {
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            color: #fff;
            position: relative;
        }

        .footer-section h4::after {
            content: "";
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 40px;
            height: 2px;
            background: #00d4aa;
            border-radius: 2px;
        }

        .footer-section p {
            color: #c0c9d1;
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }

        .footer-section ul {
            list-style: none;
            padding-left: 0;
        }

        .footer-section ul li {
            margin-bottom: 0.8rem;
            position: relative;
            padding-left: 15px;
        }

        .footer-section ul li::before {
            content: "→";
            position: absolute;
            left: 0;
            color: #00d4aa;
            font-size: 0.9rem;
        }

        .footer-section ul li a {
            color: #c0c9d1;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .footer-section ul li a:hover {
            color: #00d4aa;
            transform: translateX(5px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 1.5rem;
            text-align: center;
            color: #c0c9d1;
            font-size: 0.9rem;
        }
        .logo-container {
    width: 100px;
    height: 100px;
    margin-right: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.logo-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
   animation: 
        fadeIn 1s ease-in-out forwards,
        float 4s ease-in-out infinite,
        pulse 2s ease-in-out infinite 1s;
    transition: all 0.3s ease;
}

/* Float animation */
@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0px); }
}

/* Pulse animation */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

/* Optional hover effect */
.logo-image:hover {
    animation: float 3s ease-in-out infinite, pulse 1s ease-in-out infinite;
    filter: brightness(1.1);
}

        .logo-section {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .logo {
            width: 50px;
            height: 50px;
            margin-right: 15px;
            animation: float 4s ease-in-out infinite;
        }

        .logo-circle {
            fill: none;
            stroke: #00d4aa;
            stroke-width: 2;
            stroke-dasharray: 150;
            stroke-dashoffset: 150;
            animation: draw 2s ease-in-out forwards, pulse 2s ease-in-out infinite 2s;
        }

        .logo-letter {
            fill: #00d4aa;
            opacity: 0;
            animation: fadeIn 1s ease-in-out forwards 1s;
        }

        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 1.5rem;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            color: #fff;
            text-decoration: none;
        }

        .social-icon:hover {
            background: #00d4aa;
            transform: translateY(-3px);
        }

        /* Animations */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        @keyframes draw {
            to { stroke-dashoffset: 0; }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        @keyframes fadeIn {
            to { opacity: 1; }
        }

        /* Floating shapes in background */
        .shape {
            position: absolute;
            opacity: 0.05;
        }

        .shape-1 {
            top: 10%;
            left: 5%;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #00d4aa;
            animation: move 15s linear infinite;
        }

        .shape-2 {
            bottom: 15%;
            right: 10%;
            width: 80px;
            height: 80px;
            background: #0066ff;
            clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
            animation: move 20s linear infinite reverse;
        }

        @keyframes move {
            0% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(50px, 50px) rotate(90deg); }
            50% { transform: translate(100px, 0) rotate(180deg); }
            75% { transform: translate(50px, -50px) rotate(270deg); }
            100% { transform: translate(0, 0) rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Footer -->
    <footer class="footer">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="logo-section">
    <div class="logo-container">
        <img src="../images/image1.png" class="logo-image" alt="UpStudy Logo">
    </div>
    <h3>EDULINKHUB</h3>
</div>
                    <p>Transforming education through innovative online learning experiences.</p>
                    <div class="social-icons">
    <a href="#" class="social-icon">
        <i class="fab fa-facebook-f"></i>
    </a>
    <a href="#" class="social-icon">
        <i class="fab fa-twitter"></i>
    </a>
    <a href="#" class="social-icon">
        <i class="fab fa-instagram"></i>
    </a>
    <a href="#" class="social-icon">
        <i class="fab fa-linkedin-in"></i>
    </a>
</div>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#courses">Courses</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Categories</h4>
                    <ul>
                        <li><a href="#">Web Development</a></li>
                        <li><a href="#">Data Science</a></li>
                        <li><a href="#">Digital Marketing</a></li>
                        <li><a href="#">Design</a></li>
                        <li><a href="#">Business</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Support</h4>
                    <ul>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 EDULINKHUB. All rights reserved. | Designed with ❤️ for better learning</p>
            </div>
        </div>
    </footer>
</body>
</html>