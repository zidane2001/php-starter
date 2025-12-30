<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AFOR - Agence Foncière Rurale</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.0/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="assets/images/AFOR2.png" type="image/png">
    <script>
        // Fonction pour formater les nombres
        function formatNumber(number) {
            return new Intl.NumberFormat('fr-FR').format(number);
        }
    </script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #FF6F00 0%, #FF8F00 100%);
        }

        .afor-orange {
            background-color: #FF6F00;
        }

        .afor-orange-light {
            background-color: #FF8F00;
        }

        .afor-orange-hover:hover {
            background-color: #E65100;
        }

        .header-scroll {
            transition: background-color 0.3s ease;
        }

        /* Écran de chargement */
        .loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.95);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease;
        }

        .loader-container {
            text-align: center;
        }

        .loader {
            width: 80px;
            height: 80px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #FF6F00;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .loading-text {
            margin-top: 20px;
            font-size: 18px;
            color: #FF6F00;
        }

        .loading-dots:after {
            content: '';
            animation: dots 1.5s infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes dots {

            0%,
            20% {
                content: '';
            }

            40% {
                content: '.';
            }

            60% {
                content: '..';
            }

            80%,
            100% {
                content: '...';
            }
        }

        /* Styles pour les boutons */
        .btn-afor {
            background-color: #FF6F00;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-afor:hover {
            background-color: #E65100;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 111, 0, 0.3);
        }

        .btn-afor-outline {
            border: 2px solid #FF6F00;
            color: #FF6F00;
            padding: 10px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-afor-outline:hover {
            background-color: #FF6F00;
            color: white;
        }

        /* Styles pour la page de paiement */
        .recap-info-subscriber {
            display: flex !important;
            flex-direction: column;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .afor-bg {
            background: #FF6F00;
        }

        .afor-bg-hover:hover {
            background: #E65100;
        }

        .header {
            background: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-bottom: 4px solid #FF6F00;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            width: 80px;
            height: 80px;
            background: #FF6F00;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }

        .title {
            text-align: center;
            flex-grow: 1;
            margin: 0 20px;
        }

        .title h1 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .cote-ivoire-logo {
            width: 80px;
            height: 80px;
            background: url('https://upload.wikimedia.org/wikipedia/commons/f/fe/Flag_of_C%C3%B4te_d%27Ivoire.svg') center/cover;
        }

        .nav-bar {
            background: #FF6F00;
            padding: 15px 20px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-title {
            font-size: 18px;
            font-weight: 500;
        }

        .timer {
            background: rgba(255, 255, 255, 0.1);
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: bold;
        }

        .return-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .return-btn:hover {
            background: #c82333;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* Timer Component */
        .timer-component {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            border: 2px solid #FF6F00;
        }

        .timer-display {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            text-align: center;
        }

        .timer-display.warning {
            color: #ff4444;
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }

            100% {
                opacity: 1;
            }
        }

        /* Styles pour la page de récapitulatif */
        .recap-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .recap-section h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .recap-section h3 {
            color: #FF6F00;
            margin-bottom: 15px;
            font-size: 18px;
            border-bottom: 2px solid #FF6F00;
            padding-bottom: 5px;
        }

        .recap-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .recap-info p {
            margin-bottom: 8px;
            color: #666;
        }

        .recap-info strong {
            color: #333;
        }

        .price-info {
            background: #FFF3E0;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #FF6F00;
        }

        .price-info .total {
            font-size: 20px;
            font-weight: bold;
            color: #FF6F00;
            margin-top: 10px;
        }

        .info-alert {
            background: #E3F2FD;
            border: 1px solid #2196F3;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }

        .info-alert h3 {
            color: #1976D2;
            margin-bottom: 10px;
        }

        .info-alert p {
            color: #1976D2;
            margin-bottom: 0;
        }

        .payment-btn {
            background: #FF6F00;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
            display: block;
            margin: 20px auto;
        }

        .payment-btn:hover {
            background: #E65100;
        }

        /* Styles pour la page de paiement */
        .payment-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .payment-option {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.3s ease;
            border: 3px solid transparent;
        }

        .payment-option:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .payment-option.selected {
            border-color: #FF6F00;
            background: #FFF3E0;
        }

        .payment-icon {
            width: 120px;
            height: 80px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            border-radius: 10px;
            flex-wrap: wrap;
            padding: 10px;
        }

        .mobile-money-icons {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 5px;
            width: 100%;
        }

        .mobile-money-icons img {
            width: 35px;
            height: 25px;
            object-fit: contain;
        }

        .payment-title {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-top: 15px;
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal.hidden {
            display: none;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 15px;
            width: 90%;
            max-width: 500px;
            position: relative;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-close {
            position: absolute;
            top: 15px;
            right: 20px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #666;
        }

        .modal-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .modal-icons img {
            width: 60px;
            height: 40px;
            object-fit: contain;
        }

        .dropdown {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .instructions {
            background: #FFF3E0;
            border: 1px solid #FF6F00;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }

        .instructions h3 {
            color: #FF6F00;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .instructions ol {
            margin-left: 20px;
        }

        .instructions li {
            margin-bottom: 8px;
            line-height: 1.5;
        }

        .whatsapp-btn {
            display: inline-block;
            background: #25D366;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
            margin-top: 15px;
        }

        .whatsapp-btn:hover {
            background: #128C7E;
            color: white;
        }

        .print-btn {
            display: inline-block;
            background: #FF6F00;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
            margin-top: 15px;
            margin-left: 10px;
            border: none;
            cursor: pointer;
        }

        .print-btn:hover {
            background: #E65100;
        }

        .hidden {
            display: none;
        }

        /* Styles pour le reçu d'impression */
        @media print {
            body * {
                visibility: hidden;
            }

            .receipt-print,
            .receipt-print * {
                visibility: visible;
            }

            .receipt-print {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 20px;
                background: white;
            }

            .no-print {
                display: none !important;
            }
        }

        .receipt-print {
            display: none;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 20px auto;
            border: 2px solid #FF6F00;
        }

        .receipt-header {
            text-align: center;
            border-bottom: 2px solid #FF6F00;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .receipt-header h1 {
            color: #FF6F00;
            font-size: 24px;
            margin-bottom: 5px;
        }

        .receipt-header p {
            color: #666;
            margin-bottom: 5px;
        }

        .receipt-content {
            margin-bottom: 20px;
        }

        .receipt-section {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .receipt-section h3 {
            color: #FF6F00;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .receipt-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .receipt-detail {
            margin-bottom: 5px;
        }

        .receipt-detail strong {
            color: #333;
        }

        .receipt-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #FF6F00;
        }

        .receipt-qrcode {
            display: inline-block;
            width: 100px;
            height: 100px;
            background: #f5f5f5;
            margin: 10px auto;
            text-align: center;
            line-height: 100px;
            color: #999;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 20px;
            }

            .title h1 {
                font-size: 20px;
            }

            .nav-bar {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }

            .payment-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .recap-info {
                grid-template-columns: 1fr;
            }

            .timer-component {
                position: relative;
                top: auto;
                right: auto;
                margin: 20px auto;
                width: fit-content;
            }

            .receipt-details {
                grid-template-columns: 1fr;
            }
        }

        /* Icônes avec couleur orange */
        .icon-orange {
            color: #FF6F00;
        }
    </style>
</head>

<body class="bg-white" x-data="paymentApp()">
    <!-- Écran de chargement -->
    <div id="loading-screen" class="loading-screen" style="display: none; opacity: 0;">
        <div class="loader-container">
            <div class="loader"></div>
        </div>
    </div>

    <header class="afor-orange shadow-lg fixed w-full top-0 z-50 header-scroll">
        <nav class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-20">
                <a href="index.php" class="flex items-center space-x-3">
                    <img src="assets/images/AFOR2.png" alt="Logo AFOR" class="h-14 w-auto">
                </a>

                <!-- Mobile menu button -->
                <div class="flex md:hidden">
                    <button type="button" class="text-white hover:text-orange-200" id="mobile-menu-button">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <!-- Desktop menu -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="index.php" class="text-white hover:text-orange-200 transition py-2">Accueil</a>
                    <a href="index.php?page=apropos" class="text-white hover:text-orange-200 transition py-2">À propos</a>
                    <a href="souscrire" class="text-white hover:text-orange-200 transition py-2">Comment souscrire</a>
                    <a href="index.php#pourquoi-nous" class="text-white hover:text-orange-200 transition py-2">Pourquoi
                        nous choisir</a>
                    <a href="index.php?page=contact" class="text-white hover:text-orange-200 transition py-2">Contact</a>
                    <a href="index.php?page=recherche-quittance"
                        class="text-white hover:text-orange-200 transition py-2">Rechercher une quittance</a>
                    <a href="souscrire" onclick="localStorage.clear()"
                        class="bg-white text-orange-600 px-6 py-2 rounded-lg hover:bg-orange-50 transition font-medium">Souscrire</a>
                </div>
            </div>

            <!-- Mobile menu -->
            <div class="hidden md:hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="index.php" class="block text-white hover:bg-orange-600 px-3 py-2 rounded-md">Accueil</a>
                    <a href="index.php?page=apropos" class="block text-white hover:bg-orange-600 px-3 py-2 rounded-md">À
                        propos</a>
                    <a href="souscrire" class="block text-white hover:bg-orange-600 px-3 py-2 rounded-md">Comment
                        souscrire</a>
                    <a href="index.php#pourquoi-nous"
                        class="block text-white hover:bg-orange-600 px-3 py-2 rounded-md">Pourquoi nous choisir</a>
                    <a href="index.php?page=contact"
                        class="block text-white hover:bg-orange-600 px-3 py-2 rounded-md">Contact</a>
                    <a href="index.php?page=recherche-quittance"
                        class="block text-white hover:bg-orange-600 px-3 py-2 rounded-md">Rechercher une quittance</a>
                    <a onclick="localStorage.clear()" href="souscrire"
                        class="block bg-white text-orange-600 px-3 py-2 rounded-md mt-4 text-center">Souscrire</a>
                </div>
            </div>
        </nav>
    </header>

    <div class="h-20"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const header = document.querySelector('header');

            window.addEventListener('scroll', function () {
                if (window.scrollY > 50) {
                    header.style.backgroundColor = 'rgba(255, 111, 0, 0.95)';
                } else {
                    header.style.backgroundColor = '#FF6F00';
                }
            });

            function toggleMenu() {
                if (mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.remove('hidden');
                } else {
                    mobileMenu.classList.add('hidden');
                }
            }

            mobileMenuButton.addEventListener('click', toggleMenu);
        });

        // Gestion de l'écran de chargement
        document.addEventListener('DOMContentLoaded', function () {
            const loadingScreen = document.getElementById('loading-screen');

            // S'assurer que l'écran de chargement est visible au début
            loadingScreen.style.display = 'flex';
            loadingScreen.style.opacity = '1';

            // Attendre que tout soit chargé
            window.addEventListener('load', function () {
                setTimeout(function () {
                    loadingScreen.style.opacity = '0';
                    setTimeout(() => {
                        loadingScreen.style.display = 'none';
                    }, 500);
                }, 500);
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const positionSelected = localStorage.getItem("positionSelected");
            if (positionSelected !== "true") {
                alert("Veuillez d'abord sélectionner une parcelle.");
                window.location.href = "index.php?page=type-parcelle";
            }

            // Démarrer/continuer le timer avec 20 minutes
            const timeLeft = localStorage.getItem("timeLeft");
            const endTime = localStorage.getItem("endTime");
            const sessionId = localStorage.getItem("sessionId");

            if (endTime) {
                const now = new Date().getTime();
                const end = new Date(endTime).getTime();

                if (now < end) {
                    // Il reste du temps, activer le timer existant
                    setTimeout(function () {
                        window.dispatchEvent(new CustomEvent("start-timer", {
                            detail: {
                                duree: Math.max(1, Math.ceil((end - now) / 60000)),  // Au moins 1 minute
                                sessionId: sessionId || ("session-" + Date.now())
                            }
                        }));
                    }, 500);
                } else {
                    // Le timer existant a expiré, en démarrer un nouveau de 20 minutes
                    setTimeout(function () {
                        window.dispatchEvent(new CustomEvent("start-timer", {
                            detail: {
                                duree: 20,  // Nouveau timer de 20 minutes
                                sessionId: sessionId || ("session-" + Date.now())
                            }
                        }));
                    }, 500);
                }
            } else {
                // Aucun timer existant, démarrer un nouveau timer de 20 minutes
                setTimeout(function () {
                    window.dispatchEvent(new CustomEvent("start-timer", {
                        detail: {
                            duree: 20,  // 20 minutes
                            sessionId: sessionId || ("session-" + Date.now())
                        }
                    }));
                }, 500);
            }

            // Démarrer l'enregistrement automatique si pas déjà fait
            const paiementValid = localStorage.getItem("paiementValid");
            if (paiementValid !== "true") {
                // Déclencher l'enregistrement automatique
                setTimeout(function () {
                    window.dispatchEvent(new CustomEvent("auto-register-payment"));
                }, 1000);
            }
        });
    </script>

    <!-- Timer Component -->
    <div x-data="timer" x-show="shouldShowTimer"
        @start-timer.window="start($event.detail.duree, $event.detail.sessionId)" @stop-timer.window="stop()"
        @refresh-timer.window="refreshTimer()" @timer-expired.window="handleExpiration()" x-init="initTimer()"
        class="timer-component" style="">
        <div class="flex items-center gap-2 mb-2">
            <i class="fas fa-clock text-gray-500"
                :class="timeLeft <= 60 ? 'text-red-500 animate-pulse' : 'text-gray-500'"></i>
            <span class="font-medium text-gray-700">Temps restant</span>
        </div>
        <div class="timer-display" :class="timeLeft <= 60 ? 'warning' : ''" x-text="displayTime">19:48</div>
        <div class="mt-2 h-1 bg-gray-200 rounded-full overflow-hidden">
            <div class="h-full" :class="{ 'bg-red-500': timeLeft <= 60 }" :style="`width: ${calculatePercentage()}%`"
                style="width: 99%"></div>
        </div>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="title">
                <h1>AFOR - Souscription de Parcelles Rurales</h1>
            </div>
            <div class="cote-ivoire-logo"></div>
        </div>
    </header>

    <!-- Navigation Bar -->
    <nav class="nav-bar">
        <div class="nav-title" x-text="currentPageTitle">Récapitulatif de votre souscription</div>
        <button class="return-btn" @click="customBack()">Retour</button>
    </nav>

    <!-- Modal de timeout -->
    <div x-data="{
        showTimeoutModal: false,
        modalTriggered: false
    }" x-show="showTimeoutModal" @show-timeout-modal.window="
            if (!modalTriggered) {
                modalTriggered = true;
                showTimeoutModal = true;
            }
         " @hide-timeout-modal.window="
            showTimeoutModal = false; 
            modalTriggered = false;
         " class="modal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
        <div class="modal-content">
            <div class="flex items-center justify-center mb-4">
                <i class="fas fa-clock text-red-600 text-3xl mr-2"></i>
                <h3 class="text-xl font-bold">Temps écoulé !</h3>
            </div>
            <div class="text-center mb-6">
                <p class="text-gray-600 mb-4">Votre session a expiré, mais vous pouvez toujours continuer à consulter
                    les informations de votre souscription.</p>
                <p class="text-blue-600 font-semibold">Pour effectuer le paiement, suivez les instructions affichées sur
                    cette page.</p>
            </div>
            <div class="flex gap-3">
                <button @click="
                        showTimeoutModal = false;
                        modalTriggered = false;
                    " class="flex-1 payment-btn">
                    Continuer sur cette page
                </button>
                <button @click="
                        localStorage.clear();
                        window.location.href = 'index.php?page=souscrire'
                    "
                    class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-3 px-4 rounded-lg text-lg font-semibold transition-all duration-200 hover:scale-[1.02]">
                    Recommencer
                </button>
            </div>
        </div>
    </div>

    <!-- Page de Récapitulatif -->
    <div id="recapPage" class="container" x-show="currentPage === 'recap'">
        <div class="recap-section">
            <h2>Récapitulatif de votre souscription</h2>

            <!-- Information importante -->
            <div class="info-alert">
                <h3><i class="fas fa-info-circle"></i> INFORMATION :</h3>
                <p>Votre souscription a été <strong>automatiquement enregistrée</strong>. Veuillez maintenant procéder
                    au paiement en cliquant sur le bouton ci-dessous.</p>
                <p style="margin-top: 10px;"><strong>Une fois le paiement effectué, envoyez la capture d'écran sur
                        WhatsApp pour finaliser votre souscription.</strong></p>
            </div>

            <!-- Opération et Projet -->
            <div class="recap-info">
                <div>
                    <h3>Opération et Projet</h3>
                    <p><strong>Opération:</strong> <span x-text="souscriptionData.operation?.intitule">Vente de
                            parcelles rurales - Abidjan</span></p>
                    <p><strong>Localité:</strong> <span x-text="souscriptionData.operation?.localite">Abidjan</span></p>
                </div>
            </div>

            <!-- Informations du souscripteur -->
            <div class="recap-info">
                <div>
                    <h3>Informations du souscripteur</h3>
                    <!-- Pour personne physique -->
                    <div class="recap-info-subscriber"
                        x-show="souscriptionData.identification?.typePersonne === 'physique'" x-cloak>
                        <p><strong>Type:</strong> Personne Physique</p>
                        <p><strong>Nom complet:</strong> <span
                                x-text="souscriptionData.identification?.nom_complet"></span></p>
                        <p><strong>Type de document:</strong> <span
                                x-text="souscriptionData.identification?.document"></span></p>
                        <p><strong>Numéro de pièce:</strong> <span
                                x-text="souscriptionData.identification?.numero_piece"></span></p>
                        <p><strong>Date d'expiration:</strong> <span
                                x-text="souscriptionData.identification?.date_expiration"></span></p>
                        <p><strong>Pays:</strong> <span x-text="souscriptionData.identification?.pays"></span></p>
                        <p><strong>Téléphone:</strong> <span x-text="souscriptionData.identification?.telephone"></span>
                        </p>
                    </div>

                    <!-- Pour personne morale -->
                    <div x-show="souscriptionData.identification?.typePersonne === 'morale'" style="display: none;">
                        <p><strong>Type:</strong> Personne Morale</p>
                        <p><strong>Raison sociale:</strong> <span
                                x-text="souscriptionData.identification?.raison_sociale"></span></p>
                        <p><strong>Forme juridique:</strong> <span
                                x-text="souscriptionData.identification?.forme_juridique"></span></p>
                        <p><strong>RCCM:</strong> <span x-text="souscriptionData.identification?.rccm"></span></p>
                        <p><strong>IFU:</strong> <span x-text="souscriptionData.identification?.ifu"></span></p>
                        <p><strong>Nom du représentant:</strong> <span
                                x-text="souscriptionData.identification?.nom_representant + ' ' + souscriptionData.identification?.prenom_representant">undefined
                                undefined</span></p>
                        <p><strong>Pays:</strong> <span x-text="souscriptionData.identification?.pays">Côte d'Ivoire</span></p>
                        <p><strong>Téléphone:</strong> <span
                                x-text="souscriptionData.identification?.telephone">22507000000</span></p>
                    </div>
                </div>
            </div>

            <!-- Parcelle sélectionnée -->
            <div class="recap-info">
                <div>
                    <h3>Parcelle sélectionnée</h3>
                    <p><strong>Type:</strong> <span x-text="souscriptionData.typeParcelle?.nom">
                        </span></p>
                    <p><strong>Zone:</strong> <span x-text="souscriptionData.parcelle?.zone"></span></p>
                    <p><strong>Section:</strong> <span x-text="souscriptionData.parcelle?.section"></span></p>
                    <p><strong>Lot:</strong> <span x-text="souscriptionData.parcelle?.lot"></span></p>
                    <p><strong>Parcelle:</strong> <span x-text="souscriptionData.parcelle?.parcelle"></span></p>
                    <p><strong>Surface:</strong> <span
                            x-text="souscriptionData.parcelle?.surface ? formatNumber(souscriptionData.parcelle.surface) + ' m²' : ''"></span>
                    </p>
                </div>
                <div class="price-info">
                    <p><strong>Coût/m²:</strong> <span
                            x-text="souscriptionData.parcelle?.coutUnitaire ? formatNumber