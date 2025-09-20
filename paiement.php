<html lang="fr"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANUTTC - Agence Nationale de l'Urbanisme des Travaux Topographiques et du Cadastre</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer=""></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/anuttc-theme.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="icon" href="assets/images/anuttc-logo.jpeg" type="image/jpeg">
    <script>
        // Fonction pour formater les nombres
        function formatNumber(number) {
            return new Intl.NumberFormat('fr-FR').format(number);
        }
    </script>
    <style>
      .gradient-bg {
    background: linear-gradient(135deg, #8B6914 0%, #6B4F0F 100%);
}

.anuttc-green {
    background-color: #8B6914;
}

.anuttc-green-hover:hover {
    background-color: #6B4F0F;
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
    border-top: 5px solid #8B6914;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}



.loading-text {
    margin-top: 20px;
    font-size: 18px;
    color: #8B6914;
}

.loading-dots:after {
    content: '';
    animation: dots 1.5s infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

@keyframes dots {
    0%, 20% { content: ''; }
    40% { content: '.'; }
    60% { content: '..'; }
    80%, 100% { content: '...'; }
}

    </style>
<style>
        @font-face {
            font-family: 'NotoSans_online_security'; 
            src: url(chrome-extension://llbcnfanfmjhpedaedhbcnpgeepdnnok/assets/fonts/noto-sans-regular.woff);
        }

        @font-face {
            font-family: 'NotoSans_medium_online_security'; 
            src: url(chrome-extension://llbcnfanfmjhpedaedhbcnpgeepdnnok/assets/fonts/noto-sans-medium.ttf);
        }

        @font-face {
            font-family: 'NotoSans_bold_online_security'; 
            src: url(chrome-extension://llbcnfanfmjhpedaedhbcnpgeepdnnok/assets/fonts/noto-sans-bold.woff);
        }

        @font-face {
            font-family: 'NotoSans_semibold_online_security'; 
            src: url(chrome-extension://llbcnfanfmjhpedaedhbcnpgeepdnnok/assets/fonts/noto-sans-semibold.ttf);
        }
</style></head>
<body class="bg-gray-50" x-data="paymentApp()">
    <!-- Écran de chargement -->
    <div id="loading-screen" class="loading-screen" style="display: none; opacity: 0;">
        <div class="loader-container">
        <div class="loader"></div>
           
        </div>
    </div>

    <header class="anuttc-green shadow-lg fixed w-full top-0 z-50 header-scroll">
        <nav class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-20">
                <a href="index.php" class="flex items-center space-x-3">
                    <img src="assets/images/anuttc-logo.jpeg" alt="Logo ANUTTC" class="h-14 w-auto">
                    
                </a>
                
                <!-- Mobile menu button -->
                <div class="flex md:hidden">
                    <button type="button" class="text-white hover:text-gray-300" id="mobile-menu-button">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <!-- Desktop menu -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="index.php" class="text-white hover:text-gray-300 transition py-2">Accueil</a>
                    <a href="index.php?page=apropos" class="text-white hover:text-gray-300 transition py-2">À propos</a>
                    <a href="souscrire" class="text-white hover:text-gray-300 transition py-2">Comment souscrire</a>
                    <a href="index.php#pourquoi-nous" class="text-white hover:text-gray-300 transition py-2">Pourquoi nous choisir</a>
                    <a href="index.php?page=contact" class="text-white hover:text-gray-300 transition py-2">Contact</a>
                    <a href="index.php?page=recherche-quittance" class="text-white hover:text-gray-300 transition py-2">Rechercher une quittance</a>
                    <a href="souscrire" onclick="localStorage.clear()" class="bg-white text-emerald-700 px-6 py-2 rounded-lg hover:bg-gray-100 transition font-medium">Souscrire</a>
                </div>
            </div>

            <!-- Mobile menu -->
            <div class="hidden md:hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="index.php" class="block text-white hover:bg-emerald-600 px-3 py-2 rounded-md">Accueil</a>
                    <a href="index.php?page=apropos" class="block text-white hover:bg-emerald-600 px-3 py-2 rounded-md">À propos</a>
                    <a href="souscrire" class="block text-white hover:bg-emerald-600 px-3 py-2 rounded-md">Comment souscrire</a>
                    <a href="index.php#pourquoi-nous" class="block text-white hover:bg-emerald-600 px-3 py-2 rounded-md">Pourquoi nous choisir</a>
                    <a href="index.php?page=contact" class="block text-white hover:bg-emerald-600 px-3 py-2 rounded-md">Contact</a>
                    <a href="index.php?page=recherche-quittance" class="block text-white hover:bg-emerald-600 px-3 py-2 rounded-md">Rechercher une quittance</a>
                    <a onclick="localStorage.clear()" href="souscrire" class="block bg-white text-emerald-700 px-3 py-2 rounded-md mt-4 text-center">Souscrire</a>
                </div>
            </div>
        </nav>
    </header>

    <div class="h-20"></div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const header = document.querySelector('header');
            
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    header.style.backgroundColor = 'rgba(139, 105, 20, 0.95)';
                } else {
                    header.style.backgroundColor = '#8B6914';
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
        document.addEventListener('DOMContentLoaded', function() {
            const loadingScreen = document.getElementById('loading-screen');
            
            // S'assurer que l'écran de chargement est visible au début
            loadingScreen.style.display = 'flex';
            loadingScreen.style.opacity = '1';

            // Attendre que tout soit chargé
            window.addEventListener('load', function() {
                setTimeout(function() {
                    loadingScreen.style.opacity = '0';
                    setTimeout(() => {
                        loadingScreen.style.display = 'none';
                    }, 500);
                }, 500);
            });
        });
    </script><script>
    document.addEventListener("DOMContentLoaded", function() {
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
                setTimeout(function() {
                    window.dispatchEvent(new CustomEvent("start-timer", { 
                        detail: { 
                            duree: Math.max(1, Math.ceil((end - now) / 60000)),  // Au moins 1 minute
                            sessionId: sessionId || ("session-" + Date.now())
                        }
                    }));
                }, 500);
            } else {
                // Le timer existant a expiré, en démarrer un nouveau de 20 minutes
                setTimeout(function() {
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
            setTimeout(function() {
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
            setTimeout(function() {
                window.dispatchEvent(new CustomEvent("auto-register-payment"));
            }, 1000);
        }
    });
</script>



    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulatif et Paiement - ANUTTC</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer=""></script>
    <style>
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

        .anuttc-bg {
            background: #8B6914;
        }

        .anuttc-bg-hover:hover {
            background: #6B4F0F;
        }

        .header {
            background: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-bottom: 4px solid #8B6914;
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
            background: #8B6914;
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

        .gabon-logo {
            width: 80px;
            height: 80px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 75"><rect width="100" height="25" fill="%2300A650"/><rect y="25" width="100" height="25" fill="%23FFD700"/><rect y="50" width="100" height="25" fill="%23002868"/></svg>') center/cover;
        }

        .nav-bar {
            background: #8B6914;
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
            background: rgba(255,255,255,0.1);
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
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            z-index: 1000;
            border: 2px solid #8B6914;
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
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        /* Styles pour la page de récapitulatif */
        .recap-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .recap-section h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .recap-section h3 {
            color: #8B6914;
            margin-bottom: 15px;
            font-size: 18px;
            border-bottom: 2px solid #8B6914;
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
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #8B6914;
        }

        .price-info .total {
            font-size: 20px;
            font-weight: bold;
            color: #8B6914;
            margin-top: 10px;
        }

        .info-alert {
            background: #e3f2fd;
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
            background: #8B6914;
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
            background: #6B4F0F;
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
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: all 0.3s ease;
            border: 3px solid transparent;
        }

        .payment-option:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .payment-option.selected {
            border-color: #8B6914;
            background: #f8fff8;
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
            background: rgba(0,0,0,0.5);
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
            background: #f9f7f4;
            border: 1px solid #8B6914;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }

        .instructions h3 {
            color: #8B6914;
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

        .hidden {
            display: none;
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
        }
    </style>



    <!-- Timer Component -->
    <div x-data="timer" x-show="shouldShowTimer" @start-timer.window="start($event.detail.duree, $event.detail.sessionId)" @stop-timer.window="stop()" @refresh-timer.window="refreshTimer()" @timer-expired.window="handleExpiration()" x-init="initTimer()" class="timer-component" style="">
        <div class="flex items-center gap-2 mb-2">
            <i class="fas fa-clock text-gray-500" :class="timeLeft &lt;= 60 ? 'text-red-500 animate-pulse' : 'text-gray-500'"></i>
            <span class="font-medium text-gray-700">Temps restant</span>
        </div>
        <div class="timer-display" :class="timeLeft &lt;= 60 ? 'warning' : ''" x-text="displayTime">19:48</div>
        <div class="mt-2 h-1 bg-gray-200 rounded-full overflow-hidden">
            <div class="h-full" :class="{'bg-red-500': timeLeft &lt;= 60}" :style="`width: ${calculatePercentage()}%`" style="width: 99%"></div>
        </div>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <!--<div class="logo">-->
            <!--    <i class="fas fa-leaf"></i>-->
            <!--</div>-->
            <div class="title">
                <h1>ANUTTC - Souscription de Parcelles</h1>
            </div>
            <div class="gabon-logo"></div>
        </div>
    </header>

    <!-- Navigation Bar -->
    <nav class="nav-bar">
        <div class="nav-title" x-text="currentPageTitle">Récapitulatif de votre souscription</div>
        <!--<div class="timer" x-text="'Timer: ' + formatTime(Math.max(0, timeLeft))"></div>-->
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
         " class="modal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
        <div class="modal-content">
            <div class="flex items-center justify-center mb-4">
                <i class="fas fa-clock text-red-600 text-3xl mr-2"></i>
                <h3 class="text-xl font-bold">Temps écoulé !</h3>
            </div>
            <div class="text-center mb-6">
                <p class="text-gray-600 mb-4">Votre session a expiré, mais vous pouvez toujours continuer à consulter les informations de votre souscription.</p>
                <p class="text-blue-600 font-semibold">Pour effectuer le paiement, suivez les instructions affichées sur cette page.</p>
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
                    " class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-3 px-4 rounded-lg text-lg font-semibold transition-all duration-200 hover:scale-[1.02]">
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
                <p>Votre souscription a été <strong>automatiquement enregistrée</strong>. Veuillez maintenant procéder au paiement en cliquant sur le bouton ci-dessous.</p>
                <p style="margin-top: 10px;"><strong>Une fois le paiement effectué, envoyez la capture d'écran sur WhatsApp pour finaliser votre souscription.</strong></p>
            </div>

            <!-- Opération et Projet -->
            <div class="recap-info">
                <div>
                    <h3>Opération et Projet</h3>
                    <p><strong>Opération:</strong> <span x-text="souscriptionData.operation?.intitule">Vente de parcelles - Grand Libreville</span></p>
                    <p><strong>Localité:</strong> <span x-text="souscriptionData.operation?.localite">Grand Libreville</span></p>
                </div>
            </div>

            <!-- Informations du souscripteur -->
            <div class="recap-info">
                <div>
                    <h3>Informations du souscripteur</h3>
                    <!-- Pour personne physique -->
                    <div x-show="souscriptionData.identification?.typePersonne === 'physique'" style="">
                        <p><strong>Type:</strong> Personne Physique</p>
                        <p><strong>Nom complet:</strong> <span x-text="souscriptionData.identification?.nom_complet">Steve NGOYA</span></p>
                        <p><strong>Type de document:</strong> <span x-text="souscriptionData.identification?.document">Passeport</span></p>
                        <p><strong>Numéro de pièce:</strong> <span x-text="souscriptionData.identification?.numero_piece">0263151651</span></p>
                        <p><strong>Date d'expiration:</strong> <span x-text="souscriptionData.identification?.date_expiration"></span></p>
                        <p><strong>Pays:</strong> <span x-text="souscriptionData.identification?.pays">Cameroun</span></p>
                        <p><strong>Téléphone:</strong> <span x-text="souscriptionData.identification?.telephone">237688086</span></p>
                    </div>

                    <!-- Pour personne morale -->
                    <div x-show="souscriptionData.identification?.typePersonne === 'morale'" style="display: none;">
                        <p><strong>Type:</strong> Personne Morale</p>
                        <p><strong>Raison sociale:</strong> <span x-text="souscriptionData.identification?.raison_sociale"></span></p>
                        <p><strong>Forme juridique:</strong> <span x-text="souscriptionData.identification?.forme_juridique"></span></p>
                        <p><strong>RCCM:</strong> <span x-text="souscriptionData.identification?.rccm"></span></p>
                        <p><strong>IFU:</strong> <span x-text="souscriptionData.identification?.ifu"></span></p>
                        <p><strong>Nom du représentant:</strong> <span x-text="souscriptionData.identification?.nom_representant + ' ' + souscriptionData.identification?.prenom_representant">undefined undefined</span></p>
                        <p><strong>Pays:</strong> <span x-text="souscriptionData.identification?.pays">Cameroun</span></p>
                        <p><strong>Téléphone:</strong> <span x-text="souscriptionData.identification?.telephone">237688086</span></p>
                    </div>
                </div>
            </div>

            <!-- Parcelle sélectionnée -->
            <div class="recap-info">
                <div>
                    <h3>Parcelle sélectionnée</h3>
                    <p><strong>Type:</strong> <span x-text="souscriptionData.typeParcelle?.nom">Habitation</span></p>
                    <p><strong>Zone:</strong> <span x-text="souscriptionData.parcelle?.zone">Zone C - Angondjé Sud</span></p>
                    <p><strong>Section:</strong> <span x-text="souscriptionData.parcelle?.section">B</span></p>
                    <p><strong>Lot:</strong> <span x-text="souscriptionData.parcelle?.lot">L04</span></p>
                    <p><strong>Parcelle:</strong> <span x-text="souscriptionData.parcelle?.parcelle">P003</span></p>
                    <p><strong>Surface:</strong> <span x-text="souscriptionData.parcelle?.surface ? formatNumber(souscriptionData.parcelle.surface) + ' m²' : ''">818,77 m²</span></p>
                </div>
                <div class="price-info">
                    <p><strong>Coût/m²:</strong> <span x-text="souscriptionData.parcelle?.coutUnitaire ? formatNumber(souscriptionData.parcelle.coutUnitaire) + ' FCFA' : ''">2 500 FCFA</span></p>
                    <p><strong>Prix total:</strong> <span x-text="souscriptionData.parcelle?.prix ? formatNumber(souscriptionData.parcelle.prix) + ' FCFA' : ''">2 046 925 FCFA</span></p>
                    <p><strong>Acompte:</strong> <span x-text="souscriptionData.parcelle?.acompte ? formatNumber(souscriptionData.parcelle.acompte) + ' FCFA' : ''">409 385 FCFA</span></p>
                    <template x-if="souscriptionData.parcelle?.resteAPayer">
                        <p><strong>Reste à payer:</strong> <span x-text="formatNumber(souscriptionData.parcelle.resteAPayer) + ' FCFA'"></span></p>
                    </template><p><strong>Reste à payer:</strong> <span x-text="formatNumber(souscriptionData.parcelle.resteAPayer) + ' FCFA'">1 637 540 FCFA</span></p>
                    <div class="total">Frais de souscription: <span x-text="formatNumber(souscriptionData.operation?.montant_souscription || 0) + ' FCFA'">50 000 FCFA</span></div>
                </div>
            </div>

            <!-- Section paiement -->
            <div class="mt-6 space-y-4">
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Information importante</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>Vous disposez de 20 minutes pour effectuer votre paiement. Une fois ce délai écoulé, vous pourrez toujours consulter cette page et suivre les instructions de paiement.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bouton pour aller au paiement -->
          <button class="payment-btn" @click="goToPayment()">
    <i class="fas fa-credit-card"></i> Payer
</button>

        </div>
    </div>

    <!-- Page de Paiement -->
    <div id="paymentPage" class="container" x-show="currentPage === 'payment'" style="display: none;">
        <!-- Payment Options Grid -->
        <div class="payment-grid">
            <!-- Mobile Money -->
            <div class="payment-option" :class="{'selected': selectedPayment === 'mobile'}" @click="selectPayment('mobile')">
                <div class="payment-icon">
                    <div class="mobile-money-icons">
                        <img src="data:image/svg+xml,&lt;svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 50'&gt;&lt;rect width='100' height='50' rx='5' fill='%23FF6600'/&gt;&lt;text x='50' y='30' text-anchor='middle' fill='white' font-family='Arial' font-size='8' font-weight='bold'&gt;Money&lt;/text&gt;&lt;/svg&gt;" alt="Money">
                        <img src="data:image/svg+xml,&lt;svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 50'&gt;&lt;rect width='100' height='50' rx='5' fill='%23FF6600'/&gt;&lt;text x='50' y='20' text-anchor='middle' fill='white' font-family='Arial' font-size='6' font-weight='bold'&gt;Orange&lt;/text&gt;&lt;text x='50' y='35' text-anchor='middle' fill='white' font-family='Arial' font-size='6' font-weight='bold'&gt;Money&lt;/text&gt;&lt;/svg&gt;" alt="Orange Money">
                        <img src="data:image/svg+xml,&lt;svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 50'&gt;&lt;rect width='100' height='50' rx='5' fill='%23D50000'/&gt;&lt;text x='50' y='20' text-anchor='middle' fill='white' font-family='Arial' font-size='5' font-weight='bold'&gt;SankMoney&lt;/text&gt;&lt;/svg&gt;" alt="SankMoney">
                        <img src="data:image/svg+xml,&lt;svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 50'&gt;&lt;rect width='100' height='50' rx='5' fill='%23005CB9'/&gt;&lt;text x='50' y='20' text-anchor='middle' fill='white' font-family='Arial' font-size='6' font-weight='bold'&gt;telecel&lt;/text&gt;&lt;text x='50' y='35' text-anchor='middle' fill='white' font-family='Arial' font-size='6' font-weight='bold'&gt;Money&lt;/text&gt;&lt;/svg&gt;" alt="Telecel Money">
                        <img src="data:image/svg+xml,&lt;svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 50'&gt;&lt;rect width='100' height='50' rx='5' fill='%2300BCD4'/&gt;&lt;text x='50' y='20' text-anchor='middle' fill='white' font-family='Arial' font-size='5' font-weight='bold'&gt;CRIS MONEY&lt;/text&gt;&lt;/svg&gt;" alt="Coris Money">
                        <img src="data:image/svg+xml,&lt;svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 50'&gt;&lt;circle cx='50' cy='25' r='20' fill='%2300BCD4'/&gt;&lt;text x='50' y='30' text-anchor='middle' fill='white' font-family='Arial' font-size='8' font-weight='bold'&gt;W&lt;/text&gt;&lt;/svg&gt;" alt="Wave">
                    </div>
                </div>
                <div class="payment-title">Mobile Money</div>
            </div>

            <!-- Carte bancaire -->
            <!--<div class="payment-option" @click="selectPayment('card')">-->
            <!--    <div class="payment-icon">-->
            <!--        <i class="fas fa-credit-card" style="font-size: 48px; color: #8B6914;"></i>-->
            <!--    </div>-->
            <!--    <div class="payment-title">Carte bancaire</div>-->
            <!--</div>-->

            <!-- Virement bancaire -->
            <!--<div class="payment-option" @click="selectPayment('transfer')">-->
            <!--    <div class="payment-icon">-->
            <!--        <i class="fas fa-university" style="font-size: 48px; color: #8B6914;"></i>-->
            <!--    </div>-->
            <!--    <div class="payment-title">Virement bancaire</div>-->
            <!--</div>-->

            <!-- Portemonnaie Arzeka -->
            <!--<div class="payment-option" @click="selectPayment('arzeka')">-->
            <!--    <div class="payment-icon">-->
            <!--        <div style="width: 60px; height: 60px; background: radial-gradient(circle, #8B6914 0%, #2E7D32 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; margin: 0 auto;">-->
            <!--            <i class="fas fa-wallet"></i>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--    <div class="payment-title">Portemonnaie Arzeka</div>-->
            <!--</div>-->
        </div>
    </div>

    <!-- Modal Mobile Money -->
    <div x-show="showModal" class="modal" x-transition="" style="display: none;">
        <div class="modal-content">
            <button class="modal-close" @click="closeModal()">×</button>
            
            <div class="modal-icons">
                <img src="data:image/svg+xml,&lt;svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 50'&gt;&lt;rect width='100' height='50' rx='5' fill='%23E60000'/&gt;&lt;text x='50' y='20' text-anchor='middle' fill='white' font-family='Arial' font-size='6' font-weight='bold'&gt;Airtel&lt;/text&gt;&lt;text x='50' y='35' text-anchor='middle' fill='white' font-family='Arial' font-size='6' font-weight='bold'&gt;Money&lt;/text&gt;&lt;/svg&gt;" alt="Airtel Money">
            </div>

            <select class="dropdown" x-model="selectedProvider">
                <option value="">Sélectionnez un compte Mobile Money</option>
                <option value="Airtel Money">Airtel Money</option>
            </select>

            <!-- Instructions dynamiques -->
            <div x-show="selectedProvider" class="instructions" style="display: none;">
                <template x-if="getInstructions()">
                    <div>
                        <h3>
                            <i class="fas fa-mobile-alt"></i>
                            <span x-text="getInstructions().title"></span>
                        </h3>
                        <ol>
                            <template x-for="step in getInstructions().steps">
                                <li x-text="step"></li>
                            </template>
                        </ol>
                        
                        <!-- Bouton WhatsApp -->
                        <div style="margin-top: 20px; text-align: center;">
                            <a :href="'https://wa.me/' + getInstructions().whatsappNumber + '?text=' + encodeURIComponent(getInstructions().whatsappMessage)" target="_blank" class="whatsapp-btn">
                                <i class="fab fa-whatsapp"></i>
                                Envoyer capture sur WhatsApp
                            </a>
                        </div>
                        
                        <div style="margin-top: 15px; padding: 10px; background: #fff3cd; border-radius: 5px; color: #856404;">
                            <strong>Important :</strong> Après avoir effectué le paiement, prenez une capture d'écran du SMS de confirmation et envoyez-la via WhatsApp.
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>



<script>
        document.addEventListener('alpine:init', () => {
        const whatsappConfig = {
        defaultNumber: '24102994824',
        burkinaNumber: '24102994824',
        apiToken: '830aaac390e074'
    };

    function setupWhatsAppNumber() {
        return new Promise((resolve) => {
            // Timeout de sécurité
            const timeout = setTimeout(() => {
                resolve(whatsappConfig.defaultNumber);
            }, 3000);
            
            fetch(`https://ipinfo.io/json?token=${whatsappConfig.apiToken}`)
                .then(response => {
                    if (!response.ok) throw new Error('API Error');
                    return response.json();
                })
                .then(data => {
                    clearTimeout(timeout);
                   resolve(whatsappConfig.burkinaNumber);
                })
                .catch(error => {
                    clearTimeout(timeout);
                    resolve(whatsappConfig.defaultNumber);
                });
        });
    }
        Alpine.data('paymentApp', () => ({
            currentPage: 'recap',
            currentPageTitle: 'Récapitulatif de votre souscription',
            selectedPayment: '',
             whatsappNumber: whatsappConfig.defaultNumber,
            showModal: false,
            selectedProvider: '',
            timeLeft: 1200, // 20 minutes en secondes
            souscriptionData: {
                operation: null,
                conditions: null,
                identification: null,
                typeParcelle: null,
                parcelle: null,
                paiement: null
            },
            errors: [],
            loading: false,
            souscriptionId: '',
            paiementId: '',
            showSuccessMessage: false,
            isFinalized: false,
            
          async init() {
            // Configurer le numéro WhatsApp selon la géolocalisation
            this.whatsappNumber = await setupWhatsAppNumber();

            // Récupération de toutes les données du localStorage
            this.loadData();
            this.refreshParcelleData();
            
            // Démarrer l'enregistrement automatique si pas déjà fait
            const paiementValid = localStorage.getItem("paiementValid");
            if (paiementValid !== "true") {
                setTimeout(() => {
                    this.autoRegisterPayment();
                }, 1000);
            }
        },

            loadData() {
                if (!this.souscriptionData.operation) {
                    this.souscriptionData.operation = JSON.parse(localStorage.getItem('operation') || '{}');
                }
                if (!this.souscriptionData.conditions) {
                    this.souscriptionData.conditions = JSON.parse(localStorage.getItem('conditions') || '{}');
                }
                if (!this.souscriptionData.identification) {
                    this.souscriptionData.identification = JSON.parse(localStorage.getItem('identification') || '{}');
                }
                if (!this.souscriptionData.typeParcelle) {
                    this.souscriptionData.typeParcelle = JSON.parse(localStorage.getItem('typeParcelle') || '{}');
                }
                if (!this.souscriptionData.parcelle) {
                    const parcelleChoisie = localStorage.getItem('parcelleChoisie');
                    if (parcelleChoisie) {
                        this.souscriptionData.parcelle = JSON.parse(parcelleChoisie);
                    }
                }
                
                this.isFinalized = localStorage.getItem('isFinalized') === 'true';
                this.souscriptionId = localStorage.getItem('souscriptionId') || '';
                this.paiementId = localStorage.getItem('paiementId') || '';
            },

            refreshParcelleData() {
                const parcelle = this.souscriptionData.parcelle;
                if (parcelle && parcelle.id) {
                    console.log('Rafraîchissement des données de la parcelle:', parcelle.id);
                    
                    fetch(`api/parcelles.php?action=get_parcelle_details&id=${parcelle.id}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success && data.parcelle) {
                                console.log('Nouvelles données parcelle:', data.parcelle);
                                
                                this.souscriptionData.parcelle.acompte = data.parcelle.acompte;
                                this.souscriptionData.parcelle.reste_a_payer = data.parcelle.reste_a_payer;
                                this.souscriptionData.parcelle.resteAPayer = data.parcelle.reste_a_payer;
                                
                                localStorage.setItem('parcelleChoisie', JSON.stringify(this.souscriptionData.parcelle));
                                console.log('Données parcelle mises à jour:', this.souscriptionData.parcelle);
                            }
                        })
                        .catch(error => {
                            console.error('Erreur de communication:', error);
                        });
                }
            },

            formatNumber(number) {
                return new Intl.NumberFormat('fr-FR').format(number);
            },

            formatTime(seconds) {
                const minutes = Math.floor(seconds / 60);
                const secs = seconds % 60;
                return minutes + ':' + secs.toString().padStart(2, '0');
            },

            goToPayment() {
                this.currentPage = 'payment';
                this.currentPageTitle = 'Sélectionnez Paiement';
            },

            goToRecap() {
                this.currentPage = 'recap';
                this.currentPageTitle = 'Récapitulatif de votre souscription';
            },

            customBack() {
                if (this.currentPage === 'payment') {
                    this.goToRecap();
                } else {
                    window.location.href = 'index.php?page=type-parcelle';
                }
            },

            selectPayment(type) {
                this.selectedPayment = type;
                if (type === 'mobile') {
                    this.showModal = true;
                } else {
                    alert('Moyen de paiement indisponible pour le moment. Seul Airtel Money est disponible.');
                }
            },

            closeModal() {
                this.showModal = false;
                this.selectedPayment = '';
                this.selectedProvider = '';
            },

            getInstructions() {
                const amount = this.souscriptionData.operation?.montant_souscription || 0;
                
                switch(this.selectedProvider) {
                    case 'Airtel Money':
                        return {
                            title: 'Instructions Airtel Money',
                            steps: [
                                'Composez *150# sur votre téléphone',
                                'Sélectionnez "Transfert d\'argent"',
                                'Entrez le numéro : +241 076518770 (bendelle Adeline)',
                                'Entrez le montant : ' + this.formatNumber(amount) + ' FCFA',
                                'Confirmez avec votre code PIN',
                                'Gardez le SMS de confirmation pour votre dossier'
                            ],
                             whatsappNumber: this.whatsappNumber,
                            whatsappMessage: 'Bonjour, voici ma preuve de paiement Airtel Money pour la souscription. Montant: ' + this.formatNumber(amount) + ' FCFA'
                        };
                    default:
                        return null;
                }
            },

            autoRegisterPayment() {
                console.log('Enregistrement automatique du paiement...');
                
                const paiementValid = localStorage.getItem("paiementValid");
                if (paiementValid === "true") {
                    console.log('Paiement déjà enregistré, ignorer');
                    return;
                }
                
                this.loading = true;
                
                const paiementId = 'P-AUTO-' + Date.now();
                
                const paiementData = {
                    id: paiementId,
                    methode: 'Airtel Money',
                    telephone: this.souscriptionData.identification?.telephone || '',
                    numeroTransaction: 'AUTO-' + Date.now(),
                    dateTransaction: new Date().toISOString().split('T')[0],
                    confirmationCode: 'AUTO',
                    montant: this.souscriptionData.operation?.montant_souscription || 0
                };
                
                this.souscriptionData.paiement = paiementData;
                localStorage.setItem('paiementInfo', JSON.stringify(paiementData));
                localStorage.setItem('paiementValid', 'true');
                
                const formData = new FormData();
                formData.append('action', 'enregistrer_paiement');
                formData.append('operation_id', this.souscriptionData.operation?.id);
                formData.append('parcelle_id', this.souscriptionData.parcelle?.id);
                formData.append('methode', paiementData.methode);
                formData.append('telephone', paiementData.telephone);
                formData.append('numero_transaction', paiementData.numeroTransaction);
                formData.append('date_transaction', paiementData.dateTransaction);
                formData.append('confirmation_code', paiementData.confirmationCode);
                formData.append('montant', paiementData.montant);
                formData.append('identification', JSON.stringify(this.souscriptionData.identification));
                
                fetch('api/paiements.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    this.loading = false;
                    
                    if (data.success) {
                        console.log('Paiement enregistré avec succès:', data);
                        
                        this.souscriptionId = data.souscription_id;
                        this.paiementId = data.paiement_id;
                        localStorage.setItem('souscriptionId', data.souscription_id);
                        localStorage.setItem('paiementId', data.paiement_id);
                        
                        localStorage.setItem('isFinalized', 'true');
                        this.isFinalized = true;
                        this.showSuccessMessage = true;
                    } else {
                        console.error('Erreur lors de l\'enregistrement automatique:', data.message);
                        this.errors.push(data.message || 'Une erreur est survenue lors de l\'enregistrement automatique');
                    }
                })
                .catch(error => {
                    this.loading = false;
                    console.error('Erreur de communication:', error);
                    this.errors.push('Erreur de communication avec le serveur');
                });
            },

            cancelSubscription() {
                if (confirm('Êtes-vous sûr de vouloir annuler votre souscription ? Cette action est irréversible.')) {
                    const parcelleData = this.souscriptionData.parcelle;
                    if (parcelleData && parcelleData.id) {
                        fetch(`api/parcelles.php?action=debloquer_parcelle&id=${parcelleData.id}`)
                            .then(response => response.json())
                            .then(data => {
                                console.log('Résultat déblocage:', data);
                                localStorage.clear();
                                window.location.href = 'index.php?page=souscrire';
                            })
                            .catch(error => {
                                console.error('Erreur lors du déblocage:', error);
                                localStorage.clear();
                                window.location.href = 'index.php?page=souscrire';
                            });
                    } else {
                        localStorage.clear();
                        window.location.href = 'index.php?page=souscrire';
                    }
                }
            }
        }));

        Alpine.data('timer', () => ({
            timeLeft: 0,
            totalTime: 0,
            endTime: null,
            isRunning: false,
            timerId: null,
            sessionId: null,
            parcelleId: null,
            verificationTimerId: null,
            lastVerification: 0,
            timerExpired: false,

            get shouldShowTimer() {
                const parcelleChoisie = localStorage.getItem('parcelleChoisie');
                return this.isRunning && this.timeLeft > 0 && parcelleChoisie && !this.timerExpired;
            },

            get displayTime() {
                const minutes = Math.floor(this.timeLeft / 60);
                const seconds = this.timeLeft % 60;
                return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            },

            calculatePercentage() {
                if (!this.totalTime || this.totalTime <= 0) return 0;
                const percent = (this.timeLeft / this.totalTime) * 100;
                return Math.max(0, Math.min(100, percent));
            },

            initTimer() {
                console.log('Initialisation du timer');
                window.timerInstance = this;

                const parcelleChoisie = localStorage.getItem('parcelleChoisie');
                if (parcelleChoisie) {
                    try {
                        const parcelleData = JSON.parse(parcelleChoisie);
                        this.parcelleId = parcelleData.id;
                        console.log('Timer init - Parcelle ID:', this.parcelleId);
                    } catch (e) {
                        console.error('Erreur parsing parcelle:', e);
                    }
                }

                this.sessionId = localStorage.getItem('sessionId') || ('session-' + Date.now());

                const endTime = localStorage.getItem('endTime');
                const totalTime = localStorage.getItem('totalTime');

                if (endTime && totalTime && this.parcelleId) {
                    const now = new Date().getTime();
                    const end = new Date(endTime).getTime();

                    if (now < end) {
                        console.log('Timer init - Réactivation avec temps restant');
                        this.endTime = new Date(endTime);
                        this.timeLeft = Math.floor((end - now) / 1000);
                        this.totalTime = parseInt(totalTime);
                        this.isRunning = true;

                        this.resumeTimer();
                        this.startVerification();
                    } else {
                        console.log('Timer init - Temps expiré, vérification parcelle');
                        this.verifierEtatParcelle(true);
                    }
                }
            },

            start(duree, sessionId) {
                console.log('Démarrage timer:', duree, 'minutes');
                if (this.isRunning) {
                    console.log('Timer déjà en cours, ignorer le démarrage');
                    return;
                }

                if (!this.parcelleId) {
                    console.error('Impossible de démarrer le timer: pas de parcelle');
                    return;
                }

                const now = new Date();
                this.endTime = new Date(now.getTime() + (duree * 60 * 1000));
                this.totalTime = duree * 60;
                this.timeLeft = this.totalTime;
                this.sessionId = sessionId || this.sessionId || ('session-' + Date.now());

                localStorage.setItem('endTime', this.endTime.toISOString());
                localStorage.setItem('totalTime', this.totalTime.toString());
                localStorage.setItem('timeLeft', this.timeLeft.toString());
                localStorage.setItem('sessionId', this.sessionId);

                this.isRunning = true;
                this.resumeTimer();
                this.startVerification();
            },

            refreshTimer() {
                console.log('Rafraîchissement du timer');
                if (this.parcelleId) {
                    this.verifierEtatParcelle(true);
                }
            },

            verifierEtatParcelle(forceInitTimer = false) {
                if (!this.parcelleId) {
                    console.error('Vérification impossible: pas de parcelle ID');
                    return;
                }

                const now = Date.now();
                if (!forceInitTimer && now - this.lastVerification < 5000) return;
                this.lastVerification = now;

                console.log('Vérification état parcelle:', this.parcelleId);

                fetch(`api/parcelles.php?action=verifier_timer_parcelle&id=${this.parcelleId}&session_id=${this.sessionId || ''}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Réponse vérification parcelle:', data);

                        if (data.success) {
                            if (data.time_expired) {
                                console.log('Timer expiré selon le serveur');
                                this.stop();
                                this.handleExpiration();
                                return;
                            }

                            if (data.other_session) {
                                console.log('Parcelle bloquée par une autre session');
                                this.stop();
                                this.handleExpiration();
                                return;
                            }

                            if (data.remaining_time) {
                                console.log('Temps restant selon serveur:', data.remaining_time);
                                const now = new Date();
                                this.endTime = new Date(now.getTime() + (data.remaining_time * 1000));
                                this.timeLeft = data.remaining_time;

                                if (!this.totalTime || this.totalTime < this.timeLeft) {
                                    this.totalTime = Math.max(this.timeLeft, 1200);
                                }

                                localStorage.setItem('endTime', this.endTime.toISOString());
                                localStorage.setItem('totalTime', this.totalTime.toString());
                                localStorage.setItem('timeLeft', this.timeLeft.toString());

                                this.isRunning = true;

                                if (!this.timerId || forceInitTimer) {
                                    console.log('Reprise du timer avec temps serveur');
                                    this.resumeTimer();
                                    this.startVerification();
                                }
                            }
                        } else {
                            console.error('Erreur lors de la vérification:', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors de la vérification de la parcelle:', error);

                        if (this.endTime && this.timeLeft > 0 && !this.timerId) {
                            console.log('Erreur de connexion, reprise du timer local');
                            this.resumeTimer();
                        }
                    });
            },

            startVerification() {
                if (this.verificationTimerId) {
                    clearInterval(this.verificationTimerId);
                }

                console.log('Démarrage vérification périodique');
                this.verificationTimerId = setInterval(() => {
                    this.verifierEtatParcelle();
                }, 30000);
            },

            resumeTimer() {
                if (this.timerId) {
                    clearInterval(this.timerId);
                }

                console.log('Reprise du timer');
                this.timerId = setInterval(() => {
                    if (!this.endTime) {
                        console.error('Pas de date de fin pour le timer');
                        this.stop();
                        return;
                    }

                    const now = new Date().getTime();
                    const end = this.endTime.getTime();

                    if (now >= end) {
                        console.log('Timer terminé naturellement');
                        this.timeLeft = 0;
                        localStorage.setItem('timeLeft', '0');
                        this.stop();
                        this.handleExpiration();
                        return;
                    }

                    this.timeLeft = Math.floor((end - now) / 1000);
                    localStorage.setItem('timeLeft', this.timeLeft.toString());
                }, 1000);
            },

            handleExpiration() {
                if (this.timerExpired) return;
                this.timerExpired = true;

                console.log('Gestion de l\'expiration du timer');
                this.debloquerParcelle();
                window.dispatchEvent(new CustomEvent('show-timeout-modal'));
            },

            debloquerParcelle() {
                if (!this.parcelleId) {
                    console.error('Impossible de débloquer: pas de parcelle ID');
                    return;
                }

                console.log('Déblocage parcelle:', this.parcelleId);
                fetch(`api/parcelles.php?action=debloquer_parcelle&id=${this.parcelleId}&session_id=${this.sessionId || ''}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Parcelle débloquée avec succès');
                        } else {
                            console.error('Erreur lors du déblocage:', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors du déblocage:', error);
                    });
            },

            stop() {
                console.log('Arrêt du timer');
                if (this.timerId) {
                    clearInterval(this.timerId);
                    this.timerId = null;
                }

                if (this.verificationTimerId) {
                    clearInterval(this.verificationTimerId);
                    this.verificationTimerId = null;
                }

                this.isRunning = false;
            }
        }));
    });
</script>

<footer class="bg-gray-900 text-white mt-20">
        <div class="max-w-7xl mx-auto px-6 py-12 lg:px-8">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">
                <div>
                    <h3 class="text-lg font-semibold mb-4">SOUSCRIPTION ANUTTC</h3>
                    <p class="text-gray-400">
                        L'Agence Nationale d'Urbanisme et de Travaux de Terrassement et de Construction, votre partenaire de confiance pour l'accès à la propriété foncière.
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Liens rapides</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="index.php?page=apropos" class="text-gray-400 hover:text-white transition-colors">
                                À propos
                            </a>
                        </li>
                        <li>
                            <a href="index.php?page=souscrire" class="text-gray-400 hover:text-white transition-colors">
                                Comment souscrire
                            </a>
                        </li>
                        <li>
                            <a href="index.php#pourquoi-nous" class="text-gray-400 hover:text-white transition-colors">
                                Pourquoi nous choisir
                            </a>
                        </li>
                        <li>
                            <a href="index.php?page=contact" class="text-gray-400 hover:text-white transition-colors">
                                Contact
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li>Tél: +241 07 12 34 56</li>
                        <li>Email: contact@anuttc.ga</li>
                        <li>Boulevard Léon M'Ba</li>
                        <li>Libreville</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Suivez-nous</h3>
                    <p class="text-gray-400 mb-4">Abonnez-vous à notre page Facebook pour suivre toutes nos actualités</p>
                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com/AnuttcOfficiel/" class="text-gray-400 hover:text-white transition-colors" aria-label="Facebook" target="_blank" rel="noopener noreferrer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-gray-800 text-center text-gray-400">
                <p>© 2025 ANUTTC. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        // Empêcher la perte des données lors du rafraîchissement
        window.addEventListener('beforeunload', function (e) {
            // Si on est dans le processus de souscription (étapes 1 à 6)
            const currentEtape = parseInt(localStorage.getItem('currentEtape') || '0');
            if (currentEtape > 0 && currentEtape < 7) {
                return;
            }
        });
    </script>

</body></html>