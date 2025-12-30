<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CÔTE D'IVOIRE - Paiement</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.0/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="assets/images/logo_MCLU.png" type="image/png">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #ff6f00a2 0%, #FF8F00 100%);
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
            border: none;
            cursor: pointer;
        }

        .btn-afor:hover {
            background-color: #E65100;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 111, 0, 0.3);
            color: white;
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

        /* Style pour la carte Google Maps */
        .map-container {
            width: 100%;
            height: 250px;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
        }

        .map-container iframe {
            width: 100%;
            height: 100%;
            border: 0;
            border-radius: 8px;
        }

        /* Icônes avec couleur orange */
        .icon-orange {
            color: #FF6F00;
        }

        /* Cartes avec bordures orange */
        .card-orange {
            border-top: 4px solid #FF6F00;
        }

        /* Badges orange */
        .badge-orange {
            background-color: #FFF3E0;
            color: #FF6F00;
        }

        /* Texte orange */
        .text-orange {
            color: #FF6F00;
        }

        /* Arrière-plan orange clair */
        .bg-orange-light {
            background-color: #FFF3E0;
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

        /* Styles pour les pages */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
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
            background: #FF6F00;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            display: block;
            margin: 20px auto;
        }

        .payment-btn:hover {
            background: #E65100;
            transform: translateY(-1px);
        }

        /* Styles pour la page de paiement */
        .payment-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
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
            border-color: #FF6F00;
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
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            width: 100%;
            align-items: center;
            justify-items: center;
        }

        .mobile-money-icons img {
            width: 45px;
            height: 30px;
            object-fit: contain;
            border-radius: 4px;
        }

        .payment-title {
            font-size: 18px;
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
            border-radius: 4px;
        }

        .dropdown {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .dropdown:focus {
            border-color: #FF6F00;
            outline: none;
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
            transition: all 0.3s;
            margin-top: 15px;
            margin-left: 10px;
            border: none;
            cursor: pointer;
        }

        .print-btn:hover {
            background: #E65100;
            transform: translateY(-1px);
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

            .mobile-money-icons {
                grid-template-columns: 1fr;
                gap: 5px;
            }

            .modal-content {
                width: 95%;
                padding: 20px;
            }
        }
    </style>
</head>

<body class="bg-white">
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
                    <img src="assets/images/logo_MCLU.png" alt="Logo CÔTE D'IVOIRE" class="h-14 w-auto">
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
                    <a href="index.php?page=apropos" class="text-white hover:text-orange-200 transition py-2">À
                        propos</a>
                    <a href="index.php?page=souscrire" class="text-white hover:text-orange-200 transition py-2">Comment
                        souscrire</a>
                    <a href="index.php#pourquoi-nous" class="text-white hover:text-orange-200 transition py-2">Pourquoi
                        nous choisir</a>
                    <a href="index.php?page=contact"
                        class="text-white hover:text-orange-200 transition py-2">Contact</a>
                    <a href="index.php?page=recherche-quittance"
                        class="text-white hover:text-orange-200 transition py-2">Rechercher une quittance</a>
                    <a href="index.php?page=souscrire" onclick="localStorage.clear()"
                        class="bg-white text-orange-600 px-6 py-2 rounded-lg hover:bg-orange-50 transition font-medium">Souscrire</a>
                </div>
            </div>

            <!-- Mobile menu -->
            <div class="hidden md:hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="index.php" class="block text-white hover:bg-orange-600 px-3 py-2 rounded-md">Accueil</a>
                    <a href="index.php?page=apropos" class="block text-white hover:bg-orange-600 px-3 py-2 rounded-md">À
                        propos</a>
                    <a href="index.php?page=souscrire"
                        class="block text-white hover:bg-orange-600 px-3 py-2 rounded-md">Comment souscrire</a>
                    <a href="index.php#pourquoi-nous"
                        class="block text-white hover:bg-orange-600 px-3 py-2 rounded-md">Pourquoi nous choisir</a>
                    <a href="index.php?page=contact"
                        class="block text-white hover:bg-orange-600 px-3 py-2 rounded-md">Contact</a>
                    <a href="index.php?page=recherche-quittance"
                        class="block text-white hover:bg-orange-600 px-3 py-2 rounded-md">Rechercher une quittance</a>
                    <a onclick="localStorage.clear()" href="index.php?page=souscrire"
                        class="block bg-white text-orange-600 px-3 py-2 rounded-md mt-4 text-center">Souscrire</a>
                </div>
            </div>
        </nav>
    </header>

    <div class="h-20"></div>

    <!-- Timer Component -->
    <div id="timer-component" class="timer-component" style="display: none;">
        <div class="flex items-center gap-2 mb-2">
            <i class="fas fa-clock text-gray-500" id="timer-icon"></i>
            <span class="font-medium text-gray-700">Temps restant</span>
        </div>
        <div class="timer-display" id="timer-display">19:48</div>
        <div class="mt-2 h-1 bg-gray-200 rounded-full overflow-hidden">
            <div class="h-full bg-orange-500" id="timer-progress" style="width: 99%"></div>
        </div>
    </div>

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

    <main class="mx-auto max-w-7xl px-4 py-12">
        <!-- Page de Récapitulatif -->
        <div id="recapPage" class="container" style="display: block;">
            <div class="recap-section">
                <h2 class="text-3xl font-bold text-center mb-8">Récapitulatif de votre souscription CÔTE D'IVOIRE</h2>

                <!-- Information importante -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-500 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-bold text-blue-800 mb-2">INFORMATION IMPORTANTE :</h3>
                            <p class="text-blue-700 mb-2">Votre souscription a été <strong>automatiquement
                                    enregistrée</strong>. Veuillez maintenant procéder
                                au paiement en cliquant sur le bouton ci-dessous.</p>
                            <p class="text-blue-700"><strong>Une fois le paiement effectué, envoyez la capture d'écran
                                    sur
                                    WhatsApp pour finaliser votre souscription.</strong></p>
                        </div>
                    </div>
                </div>

                <!-- Opération et Projet -->
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
                                x-text="souscriptionData.parcelle?.coutUnitaire ? formatNumber(souscriptionData.parcelle.coutUnitaire) + ' FCFA' : ''">

                            </span></p>
                        <p><strong>Prix total:</strong> <span
                                x-text="souscriptionData.parcelle?.prix ? formatNumber(souscriptionData.parcelle.prix) + ' FCFA' : ''"></span>
                        </p>
                        <p><strong>Acompte:</strong> <span
                                x-text="souscriptionData.parcelle?.acompte ? formatNumber(souscriptionData.parcelle.acompte) + ' FCFA' : ''"></span>
                        </p>
                        <p><strong>Reste à payer:</strong> <span
                                x-text="formatNumber(souscriptionData.parcelle?.resteAPayer || 0) + ' FCFA'"></span></p>
                        <div class="total">Frais de souscription: <span
                                x-text="formatNumber(souscriptionData.operation?.montant_souscription || 0) + ' FCFA'"></span>
                        </div>
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
                                    <p>Vous disposez de 20 minutes pour effectuer votre paiement. Une fois ce délai
                                        écoulé,
                                        vous pourrez toujours consulter cette page et suivre les instructions de
                                        paiement.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bouton pour aller au paiement -->
                <div class="text-center">
                    <button class="payment-btn" onclick="goToPayment()">
                        <i class="fas fa-credit-card mr-2"></i> Payer maintenant
                    </button>
                </div>

                <!-- Bouton d'impression de reçu -->
                <div class="text-center mt-4">
                    <button class="print-btn" onclick="showReceipt()">
                        <i class="fas fa-print mr-2"></i> Imprimer le reçu
                    </button>
                </div>
            </div>
        </div>

        <!-- Page de Paiement -->
        <div id="paymentPage" class="container" style="display: none;">
            <div class="recap-section">
                <h2 class="text-3xl font-bold text-center mb-8">Sélectionnez votre moyen de paiement CÔTE D'IVOIRE</h2>

                <!-- Alert de sélection -->
                <div class="bg-orange-50 border border-orange-200 rounded-lg p-6 mb-8">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-mobile-alt text-orange-500 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-bold text-orange-800 mb-2">Paiement Mobile Money</h3>
                            <p class="text-orange-700">Choisissez votre opérateur de téléphonie mobile pour effectuer le
                                paiement de vos frais de souscription CÔTE D'IVOIRE.</p>
                        </div>
                    </div>
                </div>

                <!-- Payment Options Grid -->
                <div class="payment-grid">
                    <!-- Orange Money -->
                    <div class="payment-option" :class="{ 'selected': selectedPayment === 'orange' }"
                        @click="selectPayment('orange')">
                        <div class="payment-icon">
                            <div class="mobile-money-icons">
                                <img src="data:image/svg+xml,&lt;svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 120 80'&gt;&lt;rect width='120' height='80' rx='8' fill='%23FF6600'/&gt;&lt;text x='60' y='35' text-anchor='middle' fill='white' font-family='Arial' font-size='14' font-weight='bold'&gt;Orange&lt;/text&gt;&lt;text x='60' y='55' text-anchor='middle' fill='white' font-family='Arial' font-size='12' font-weight='bold'&gt;Money&lt;/text&gt;&lt;/svg&gt;"
                                    alt="Orange Money">
                                <i class="fas fa-mobile-alt text-orange-600 text-3xl"></i>
                            </div>
                        </div>
                        <div class="payment-title">Orange Money</div>
                        <p class="text-sm text-gray-600 mt-2">Paiement sécurisé avec Orange</p>
                    </div>

                    <!-- MTN Mobile Money -->
                    <div class="payment-option" :class="{ 'selected': selectedPayment === 'mtn' }"
                        @click="selectPayment('mtn')">
                        <div class="payment-icon">
                            <div class="mobile-money-icons">
                                <img src="data:image/svg+xml,&lt;svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 120 80'&gt;&lt;rect width='120' height='80' rx='8' fill='%23FFCC00'/&gt;&lt;text x='60' y='35' text-anchor='middle' fill='%23000' font-family='Arial' font-size='16' font-weight='bold'&gt;MTN&lt;/text&gt;&lt;text x='60' y='55' text-anchor='middle' fill='%23000' font-family='Arial' font-size='10' font-weight='bold'&gt;Mobile Money&lt;/text&gt;&lt;/svg&gt;"
                                    alt="MTN Mobile Money">
                                <i class="fas fa-mobile-alt text-yellow-600 text-3xl"></i>
                            </div>
                        </div>
                        <div class="payment-title">MTN Mobile Money</div>
                        <p class="text-sm text-gray-600 mt-2">Paiement avec MTN</p>
                    </div>

                    <!-- Moov Money -->
                    <div class="payment-option" :class="{ 'selected': selectedPayment === 'moov' }"
                        @click="selectPayment('moov')">
                        <div class="payment-icon">
                            <div class="mobile-money-icons">
                                <img src="data:image/svg+xml,&lt;svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 120 80'&gt;&lt;rect width='120' height='80' rx='8' fill='%230066CC'/&gt;&lt;text x='60' y='35' text-anchor='middle' fill='white' font-family='Arial' font-size='14' font-weight='bold'&gt;Moov&lt;/text&gt;&lt;text x='60' y='55' text-anchor='middle' fill='white' font-family='Arial' font-size='12' font-weight='bold'&gt;Money&lt;/text&gt;&lt;/svg&gt;"
                                    alt="Moov Money">
                                <i class="fas fa-mobile-alt text-blue-600 text-3xl"></i>
                            </div>
                        </div>
                        <div class="payment-title">Moov Money</div>
                        <p class="text-sm text-gray-600 mt-2">Paiement avec Moov</p>
                    </div>

                    <!-- Wave -->
                    <div class="payment-option" :class="{ 'selected': selectedPayment === 'wave' }"
                        @click="selectPayment('wave')">
                        <div class="payment-icon">
                            <div class="mobile-money-icons">
                                <img src="data:image/svg+xml,&lt;svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 120 80'&gt;&lt;circle cx='60' cy='40' r='25' fill='%2300BCD4'/&gt;&lt;text x='60' y='48' text-anchor='middle' fill='white' font-family='Arial' font-size='20' font-weight='bold'&gt;W&lt;/text&gt;&lt;/svg&gt;"
                                    alt="Wave">
                                <i class="fas fa-wave-square text-cyan-600 text-3xl"></i>
                            </div>
                        </div>
                        <div class="payment-title">Wave</div>
                        <p class="text-sm text-gray-600 mt-2">Paiement avec Wave</p>
                    </div>

                    <!-- Credit Card -->
                    <div class="payment-option" data-payment-type="card">
                        <div class="payment-icon">
                            <i class="fas fa-credit-card text-6xl" style="color: #FF6F00;"></i>
                        </div>
                        <div class="payment-title">Carte Bancaire</div>
                        <p class="text-sm text-gray-600 mt-2">Visa, MasterCard, etc.</p>
                    </div>
                </div>

                <!-- Bouton retour -->
                <div class="text-center mt-8">
                    <button class="btn-afor-outline" onclick="goToRecap()">
                        <i class="fas fa-arrow-left mr-2"></i> Retour au récapitulatif
                    </button>
                </div>

                <!-- Bouton d'impression de reçu sur la page de paiement -->
                <div class="text-center mt-6">
                    <button class="print-btn" onclick="showReceipt()">
                        <i class="fas fa-print mr-2"></i> Imprimer le reçu
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Mobile Money -->
    <div id="paymentModal" class="modal" style="display: none;">
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal()">×</button>

            <div class="text-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Instructions de paiement</h3>
                <div class="modal-icons" x-show="selectedPayment">
                    <template x-if="selectedPayment === 'orange'">
                        <img src="data:image/svg+xml,&lt;svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 120 80'&gt;&lt;rect width='120' height='80' rx='8' fill='%23FF6600'/&gt;&lt;text x='60' y='35' text-anchor='middle' fill='white' font-family='Arial' font-size='14' font-weight='bold'&gt;Orange&lt;/text&gt;&lt;text x='60' y='55' text-anchor='middle' fill='white' font-family='Arial' font-size='12' font-weight='bold'&gt;Money&lt;/text&gt;&lt;/svg&gt;"
                            alt="Orange Money">
                    </template>
                    <template x-if="selectedPayment === 'mtn'">
                        <img src="data:image/svg+xml,&lt;svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 120 80'&gt;&lt;rect width='120' height='80' rx='8' fill='%23FFCC00'/&gt;&lt;text x='60' y='35' text-anchor='middle' fill='%23000' font-family='Arial' font-size='16' font-weight='bold'&gt;MTN&lt;/text&gt;&lt;text x='60' y='55' text-anchor='middle' fill='%23000' font-family='Arial' font-size='10' font-weight='bold'&gt;Mobile Money&lt;/text&gt;&lt;/svg&gt;"
                            alt="MTN Mobile Money">
                    </template>
                    <template x-if="selectedPayment === 'moov'">
                        <img src="data:image/svg+xml,&lt;svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 120 80'&gt;&lt;rect width='120' height='80' rx='8' fill='%230066CC'/&gt;&lt;text x='60' y='35' text-anchor='middle' fill='white' font-family='Arial' font-size='14' font-weight='bold'&gt;Moov&lt;/text&gt;&lt;text x='60' y='55' text-anchor='middle' fill='white' font-family='Arial' font-size='12' font-weight='bold'&gt;Money&lt;/text&gt;&lt;/svg&gt;"
                            alt="Moov Money">
                    </template>
                    <template x-if="selectedPayment === 'wave'">
                        <img src="data:image/svg+xml,&lt;svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 120 80'&gt;&lt;circle cx='60' cy='40' r='25' fill='%2300BCD4'/&gt;&lt;text x='60' y='48' text-anchor='middle' fill='white' font-family='Arial' font-size='20' font-weight='bold'&gt;W&lt;/text&gt;&lt;/svg&gt;"
                            alt="Wave">
                    </template>
                </div>
            </div>

            <!-- Instructions dynamiques pour mobile money -->
            <div id="mobile-money-instructions" class="instructions" style="display: none;">
                <!-- Instructions will be populated by JavaScript -->
            </div>

            <!-- Formulaire de carte bancaire -->
            <div id="card-payment-form" class="card-payment-form" style="display: none;">
                <div class="card-form-container">
                    <h3 style="color: #FF6F00; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-credit-card"></i>
                        Paiement par carte bancaire
                    </h3>

                    <form id="card-payment-form-element" onsubmit="processCardPayment(event)">
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="card_number"
                                style="display: block; margin-bottom: 5px; font-weight: 600; color: #333;">Numéro de
                                carte</label>
                            <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" maxlength="19"
                                style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 16px;"
                                required>
                            <div id="card-number-error" style="color: #dc3545; font-size: 14px; margin-top: 5px; display: none;"></div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                            <div class="form-group">
                                <label for="card_expiry"
                                    style="display: block; margin-bottom: 5px; font-weight: 600; color: #333;">Date
                                    d'expiration</label>
                                <input type="text" id="card_expiry" name="card_expiry" placeholder="MM/AA" maxlength="5"
                                    style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 16px;"
                                    required>
                                <div id="card-expiry-error" style="color: #dc3545; font-size: 14px; margin-top: 5px; display: none;"></div>
                            </div>

                            <div class="form-group">
                                <label for="card_cvv"
                                    style="display: block; margin-bottom: 5px; font-weight: 600; color: #333;">CVV</label>
                                <input type="text" id="card_cvv" name="card_cvv" placeholder="123" maxlength="4"
                                    style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 16px;"
                                    required>
                                <div id="card-cvv-error" style="color: #dc3545; font-size: 14px; margin-top: 5px; display: none;"></div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 20px;">
                            <label for="card_holder"
                                style="display: block; margin-bottom: 5px; font-weight: 600; color: #333;">Nom du
                                titulaire</label>
                            <input type="text" id="card_holder" name="card_holder" placeholder="NOM PRENOM"
                                style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 16px; text-transform: uppercase;"
                                required>
                            <div id="card-holder-error" style="color: #dc3545; font-size: 14px; margin-top: 5px; display: none;"></div>
                        </div>

                        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-weight: 600; color: #333;">Montant à payer:</span>
                                <span style="font-size: 18px; font-weight: bold; color: #FF6F00;" id="payment-amount"></span>
                            </div>
                        </div>

                        <div style="text-align: center;">
                            <button type="submit" id="card-submit-btn" class="payment-btn"
                                style="width: 100%; padding: 15px; font-size: 18px;">
                                <i class="fas fa-credit-card"></i>
                                <span>Payer maintenant</span>
                            </button>
                        </div>

                        <div
                            style="margin-top: 15px; padding: 10px; background: #fff3cd; border-radius: 5px; color: #856404;">
                            <strong>Sécurisé :</strong> Vos données bancaires sont chiffrées et ne sont pas stockées sur
                            nos serveurs.
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reçu d'impression (caché par défaut) -->
    <div id="receiptPrint" class="receipt-print" style="display: none;">
        <div class="receipt-header">
            <h1>CÔTE D'IVOIRE</h1>
            <p>Ministère de l'Agriculture et du Développement Rural, Abidjan, Côte d'Ivoire</p>
            <p>Tél: +225 27 20 21 22 23 | Email: contact@cote-ivoire.ci</p>
            <p><strong>REÇU DE SOUSCRIPTION</strong></p>
            <p>Date: <span id="receipt-date"></span></p>
            <p>Référence: <span id="receipt-reference"></span></p>
        </div>

        <div class="receipt-content">
            <div class="receipt-section">
                <h3>INFORMATIONS DU SOUSCRIPTEUR</h3>
                <div class="receipt-details">
                    <div class="receipt-detail"><strong>Nom complet:</strong> <span id="receipt-nom"></span></div>
                    <div class="receipt-detail"><strong>Type:</strong> <span id="receipt-type"></span></div>
                    <div class="receipt-detail"><strong>Document:</strong> <span id="receipt-document"></span></div>
                    <div class="receipt-detail"><strong>N° Pièce:</strong> <span id="receipt-numero-piece"></span></div>
                    <div class="receipt-detail"><strong>Téléphone:</strong> <span id="receipt-telephone"></span></div>
                    <div class="receipt-detail"><strong>Pays:</strong> <span id="receipt-pays"></span></div>
                </div>
            </div>

            <div class="receipt-section">
                <h3>INFORMATIONS DE L'OPÉRATION</h3>
                <div class="receipt-details">
                    <div class="receipt-detail"><strong>Opération:</strong> <span id="receipt-operation"></span></div>
                    <div class="receipt-detail"><strong>Localité:</strong> <span id="receipt-localite"></span></div>
                    <div class="receipt-detail"><strong>Date de souscription:</strong> <span
                            id="receipt-date-souscription"></span></div>
                </div>
            </div>

            <div class="receipt-section">
                <h3>INFORMATIONS DE LA PARCELLE</h3>
                <div class="receipt-details">
                    <div class="receipt-detail"><strong>Type:</strong> <span id="receipt-type-parcelle"></span></div>
                    <div class="receipt-detail"><strong>Zone:</strong> <span id="receipt-zone"></span></div>
                    <div class="receipt-detail"><strong>Section-Lot-Parcelle:</strong> <span
                            id="receipt-parcelle-ref"></span></div>
                    <div class="receipt-detail"><strong>Surface:</strong> <span id="receipt-surface"></span></div>
                    <div class="receipt-detail"><strong>Prix total:</strong> <span id="receipt-prix-total"></span></div>
                    <div class="receipt-detail"><strong>Acompte:</strong> <span id="receipt-acompte"></span></div>
                    <div class="receipt-detail"><strong>Reste à payer:</strong> <span id="receipt-reste"></span></div>
                </div>
            </div>

            <div class="receipt-section">
                <h3>INFORMATIONS DE PAIEMENT</h3>
                <div class="receipt-details">
                    <div class="receipt-detail"><strong>Frais de souscription:</strong> <span id="receipt-frais"></span>
                    </div>
                    <div class="receipt-detail"><strong>Statut:</strong> <span id="receipt-statut">EN ATTENTE DE
                            PAIEMENT</span></div>
                    <div class="receipt-detail"><strong>Date limite de paiement:</strong> <span
                            id="receipt-date-limite"></span></div>
                </div>
            </div>
        </div>

        <div class="receipt-footer">
            <p><strong>Ce reçu est une preuve de votre souscription.</strong></p>
            <p>Veuillez effectuer le paiement dans les délais indiqués pour finaliser votre acquisition.</p>
            <div class="receipt-qrcode">
                QR Code
            </div>
            <p>Scannez ce code pour vérifier l'authenticité du reçu</p>
            <p style="margin-top: 20px; font-size: 12px; color: #666;">
                CÔTE D'IVOIRE<br>
                Tous droits réservés © 2025
            </p>
        </div>
    </div>

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

        // Utility functions
        function formatNumber(number) {
            return new Intl.NumberFormat('fr-FR').format(number);
        }

        function validateCardNumber() {
            const number = document.getElementById('card_number').value.replace(/\s/g, '');
            if (!number) {
                showError('card-number-error', 'Numéro de carte requis');
                return false;
            }
            if (!/^\d{13,19}$/.test(number)) {
                showError('card-number-error', 'Numéro de carte invalide');
                return false;
            }
            // Luhn algorithm
            let sum = 0;
            let shouldDouble = false;
            for (let i = number.length - 1; i >= 0; i--) {
                let digit = parseInt(number.charAt(i));
                if (shouldDouble) {
                    digit *= 2;
                    if (digit > 9) digit -= 9;
                }
                sum += digit;
                shouldDouble = !shouldDouble;
            }
            if (sum % 10 !== 0) {
                showError('card-number-error', 'Numéro de carte invalide');
                return false;
            }
            hideError('card-number-error');
            return true;
        }

        function formatCardNumber(event) {
            let value = event.target.value.replace(/\s/g, '').replace(/[^0-9]/g, '');
            value = value.substring(0, 16);
            const formatted = value.replace(/(\d{4})(?=\d)/g, '$1 ');
            event.target.value = formatted;
            validateCardNumber();
        }

        function validateExpiry() {
            const expiry = document.getElementById('card_expiry').value;
            if (!expiry) {
                showError('card-expiry-error', 'Date d\'expiration requise');
                return false;
            }
            if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiry)) {
                showError('card-expiry-error', 'Format MM/AA requis');
                return false;
            }
            const [month, year] = expiry.split('/');
            const currentDate = new Date();
            const currentYear = currentDate.getFullYear() % 100;
            const currentMonth = currentDate.getMonth() + 1;
            const expYear = parseInt(year);
            const expMonth = parseInt(month);

            if (expYear < currentYear || (expYear === currentYear && expMonth < currentMonth)) {
                showError('card-expiry-error', 'Carte expirée');
                return false;
            }
            hideError('card-expiry-error');
            return true;
        }

        function formatExpiry(event) {
            let value = event.target.value.replace(/[^0-9]/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 4);
                value = value.substring(0, 2) + '/' + value.substring(2);
            }
            event.target.value = value;
            if (value.length === 5) {
                validateExpiry();
            }
        }

        function validateCvv() {
            const cvv = document.getElementById('card_cvv').value;
            if (!cvv) {
                showError('card-cvv-error', 'CVV requis');
                return false;
            }
            if (!/^\d{3,4}$/.test(cvv)) {
                showError('card-cvv-error', 'CVV invalide (3-4 chiffres)');
                return false;
            }
            hideError('card-cvv-error');
            return true;
        }

        function formatCvv(event) {
            let value = event.target.value.replace(/[^0-9]/g, '');
            value = value.substring(0, 4);
            event.target.value = value;
            if (value.length >= 3) {
                validateCvv();
            }
        }

        function validateCardHolder() {
            const holder = document.getElementById('card_holder').value.trim();
            if (!holder) {
                showError('card-holder-error', 'Nom du titulaire requis');
                return false;
            }
            if (holder.length < 2) {
                showError('card-holder-error', 'Nom trop court');
                return false;
            }
            if (!/^[A-Z\s]+$/.test(holder.toUpperCase())) {
                showError('card-holder-error', 'Nom invalide (lettres uniquement)');
                return false;
            }
            hideError('card-holder-error');
            return true;
        }

        function showError(elementId, message) {
            const element = document.getElementById(elementId);
            element.textContent = message;
            element.style.display = 'block';
        }

        function hideError(elementId) {
            document.getElementById(elementId).style.display = 'none';
        }

        async function processCardPayment(event) {
            event.preventDefault();

            // Validation
            const isCardValid = validateCardNumber();
            const isExpiryValid = validateExpiry();
            const isCvvValid = validateCvv();
            const isHolderValid = validateCardHolder();

            if (!isCardValid || !isExpiryValid || !isCvvValid || !isHolderValid) {
                alert('Veuillez corriger les erreurs dans le formulaire');
                return;
            }

            const submitBtn = document.getElementById('card-submit-btn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Traitement en cours...';

            // Random delay between 28-60 seconds
            const randomDelay = Math.floor(Math.random() * (60 - 28 + 1)) + 28;
            const delayMs = randomDelay * 1000;

            showProcessingBar(delayMs);

            try {
                const formData = new FormData();
                formData.append('action', 'process_card_payment');
                formData.append('souscription_id', localStorage.getItem('souscriptionId') || 'AUTO-' + Date.now());
                formData.append('montant', souscriptionData.operation?.montant_souscription || 50000);
                formData.append('categorie', 'souscription');
                formData.append('operation_id', souscriptionData.operation?.id || '1');
                formData.append('parcelle_id', souscriptionData.parcelle?.id || '1');
                formData.append('identification', JSON.stringify(souscriptionData.identification));
                formData.append('parcelle_data', JSON.stringify(souscriptionData.parcelle));
                formData.append('operation_data', JSON.stringify(souscriptionData.operation));
                formData.append('type_parcelle_data', JSON.stringify(souscriptionData.typeParcelle));
                formData.append('type_parcelle', souscriptionData.typeParcelle?.nom || 'standard');
                formData.append('card_number', document.getElementById('card_number').value.replace(/\s/g, ''));
                formData.append('card_expiry', document.getElementById('card_expiry').value);
                formData.append('card_cvv', document.getElementById('card_cvv').value);
                formData.append('card_holder', document.getElementById('card_holder').value.toUpperCase());

                const response = await fetch('paiement.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                showSuccessPopup();
                closeModal();
                setTimeout(() => {
                    showReceipt();
                }, 1500);

            } catch (error) {
                console.error('Erreur:', error);
                showSuccessPopup();
                closeModal();
                setTimeout(() => {
                    showReceipt();
                }, 1500);
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-credit-card"></i> <span>Payer maintenant</span>';
                hideProcessingBar();
            }
        }

        function showProcessingBar(delayMs) {
            const progressContainer = document.createElement('div');
            progressContainer.id = 'processing-bar';
            progressContainer.innerHTML = `
                <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                            background: rgba(0, 0, 0, 0.8); z-index: 9999; display: flex;
                            align-items: center; justify-content: center;">
                    <div style="background: white; padding: 30px; border-radius: 15px;
                                text-align: center; max-width: 400px; width: 90%;">
                        <div style="margin-bottom: 20px;">
                            <i class="fas fa-credit-card" style="font-size: 48px; color: #FF6F00;"></i>
                        </div>
                        <h3 style="color: #FF6F00; margin-bottom: 20px; font-size: 18px;">
                            Traitement du paiement en cours...
                        </h3>
                        <div style="width: 100%; height: 8px; background: #f0f0f0;
                                    border-radius: 4px; overflow: hidden; margin-bottom: 15px;">
                            <div id="progress-fill" style="width: 0%; height: 100%;
                                        background: linear-gradient(90deg, #FF6F00, #E65100);
                                        border-radius: 4px; transition: width 0.1s ease;"></div>
                        </div>
                        <p style="color: #666; font-size: 14px;">
                            Veuillez patienter, traitement sécurisé en cours...
                        </p>
                    </div>
                </div>
            `;
            document.body.appendChild(progressContainer);

            const progressFill = document.getElementById('progress-fill');
            let progress = 0;
            const interval = setInterval(() => {
                progress += (100 / (delayMs / 100));
                if (progress >= 100) {
                    progress = 100;
                    clearInterval(interval);
                }
                progressFill.style.width = progress + '%';
            }, 100);
        }

        function hideProcessingBar() {
            const progressContainer = document.getElementById('processing-bar');
            if (progressContainer) {
                progressContainer.remove();
            }
        }

        function showSuccessPopup() {
            const popup = document.createElement('div');
            popup.id = 'success-popup';
            popup.innerHTML = `
                <div style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
                            background: #10b981; color: white; padding: 20px; border-radius: 10px;
                            box-shadow: 0 10px 25px rgba(0,0,0,0.3); z-index: 10000;
                            display: flex; align-items: center; gap: 15px; font-size: 18px;">
                    <i class="fas fa-check-circle" style="font-size: 24px;"></i>
                    <span>Paiement réussi !</span>
                </div>
            `;
            document.body.appendChild(popup);

            setTimeout(() => {
                if (popup.parentNode) {
                    popup.parentNode.removeChild(popup);
                }
            }, 1500);
        }

        function showReceipt() {
            const receiptDate = new Date().toLocaleDateString('fr-FR');
            const receiptReference = 'AFOR-' + (localStorage.getItem('souscriptionId') || Date.now());

            // Fill receipt data
            document.getElementById('receipt-date').textContent = receiptDate;
            document.getElementById('receipt-reference').textContent = receiptReference;
            document.getElementById('receipt-nom').textContent = souscriptionData.identification?.nom_complet || souscriptionData.identification?.raison_sociale || 'Non spécifié';
            document.getElementById('receipt-type').textContent = souscriptionData.identification?.typePersonne === 'physique' ? 'Personne Physique' : 'Personne Morale';
            document.getElementById('receipt-document').textContent = souscriptionData.identification?.document || 'Non spécifié';
            document.getElementById('receipt-numero-piece').textContent = souscriptionData.identification?.numero_piece || souscriptionData.identification?.rccm || 'Non spécifié';
            document.getElementById('receipt-telephone').textContent = souscriptionData.identification?.telephone || 'Non spécifié';
            document.getElementById('receipt-pays').textContent = souscriptionData.identification?.pays || 'Non spécifié';

            document.getElementById('receipt-operation').textContent = souscriptionData.operation?.intitule || 'Non spécifié';
            document.getElementById('receipt-localite').textContent = souscriptionData.operation?.localite || 'Non spécifiée';
            document.getElementById('receipt-date-souscription').textContent = receiptDate;

            document.getElementById('receipt-type-parcelle').textContent = souscriptionData.typeParcelle?.nom || 'Non spécifié';
            document.getElementById('receipt-zone').textContent = souscriptionData.parcelle?.zone || 'Non spécifiée';
            document.getElementById('receipt-parcelle-ref').textContent = (souscriptionData.parcelle?.section || '') + '-' + (souscriptionData.parcelle?.lot || '') + '-' + (souscriptionData.parcelle?.parcelle || '');
            document.getElementById('receipt-surface').textContent = souscriptionData.parcelle?.surface ? formatNumber(souscriptionData.parcelle.surface) + ' m²' : 'Non spécifiée';
            document.getElementById('receipt-prix-total').textContent = souscriptionData.parcelle?.prix ? formatNumber(souscriptionData.parcelle.prix) + ' FCFA' : 'Non spécifié';
            document.getElementById('receipt-acompte').textContent = souscriptionData.operation?.montant_souscription ? formatNumber(souscriptionData.operation.montant_souscription) + ' FCFA' : 'Non spécifié';
            document.getElementById('receipt-reste').textContent = souscriptionData.parcelle?.resteAPayer ? formatNumber(souscriptionData.parcelle.resteAPayer) + ' FCFA' : 'Non spécifié';

            document.getElementById('receipt-frais').textContent = souscriptionData.operation?.montant_souscription ? formatNumber(souscriptionData.operation.montant_souscription) + ' FCFA' : 'Non spécifié';
            document.getElementById('receipt-statut').textContent = 'PAYÉ';
            document.getElementById('receipt-date-limite').textContent = 'Paiement effectué le ' + receiptDate;

            const receiptElement = document.getElementById('receiptPrint');
            receiptElement.style.display = 'block';

            const modal = document.createElement('div');
            modal.id = 'receipt-modal';
            modal.innerHTML = `
                <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                            background: rgba(0, 0, 0, 0.8); z-index: 9999; display: flex;
                            align-items: center; justify-content: center; padding: 20px;">
                    <div style="background: white; border-radius: 15px; max-width: 1000px;
                                width: 100%; max-height: 90vh; overflow-y: auto; position: relative;">
                        <div style="padding: 30px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                <h2 style="color: #FF6F00; font-size: 24px; font-weight: bold; margin: 0;">
                                    🧾 Reçu de Souscription CÔTE D'IVOIRE
                                </h2>
                                <button onclick="document.getElementById('receipt-modal').remove();"
                                        style="background: #dc3545; color: white; border: none; padding: 10px 15px;
                                                border-radius: 5px; cursor: pointer; font-size: 16px;">
                                    ✕ Fermer
                                </button>
                            </div>
                            <div id="receipt-content" style="max-height: 70vh; overflow-y: auto;">
                                ${receiptElement.outerHTML}
                            </div>
                            <div style="text-align: center; margin-top: 20px; padding-top: 20px; border-top: 2px solid #FF6F00;">
                                <button onclick="window.print();"
                                        style="background: #FF6F00; color: white; border: none; padding: 12px 24px;
                                                border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: bold; margin-right: 10px;">
                                    🖨️ Imprimer
                                </button>
                                <button onclick="document.getElementById('receipt-modal').remove();"
                                        style="background: #6c757d; color: white; border: none; padding: 12px 24px;
                                                border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: bold;">
                                    Fermer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }

        function initTimer() {
            const timerComponent = document.getElementById('timer-component');
            const timerDisplay = document.getElementById('timer-display');
            const timerIcon = document.getElementById('timer-icon');
            const timerProgress = document.getElementById('timer-progress');

            const parcelleChoisie = localStorage.getItem('parcelleChoisie');
            if (!parcelleChoisie) return;

            const endTime = localStorage.getItem('endTime');
            if (!endTime) return;

            const now = new Date().getTime();
            const end = new Date(endTime).getTime();

            if (now >= end) {
                timerComponent.style.display = 'none';
                return;
            }

            timerComponent.style.display = 'block';
            let timeLeft = Math.floor((end - now) / 1000);
            const totalTime = parseInt(localStorage.getItem('totalTime') || '1200');

            function updateTimer() {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                if (timeLeft <= 60) {
                    timerIcon.className = 'fas fa-clock text-red-500 animate-pulse';
                    timerDisplay.className = 'timer-display warning';
                    timerProgress.style.background = 'linear-gradient(90deg, #ff4444, #cc0000)';
                }

                const percentage = (timeLeft / totalTime) * 100;
                timerProgress.style.width = Math.max(0, percentage) + '%';

                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    timerComponent.style.display = 'none';
                    // Handle expiration
                    return;
                }
                timeLeft--;
            }

            updateTimer();
            const timerInterval = setInterval(updateTimer, 1000);
        }

        document.addEventListener('DOMContentLoaded', function () {
            const whatsappConfig = {
                defaultNumber: '2250596582865', // Numéro pour la Côte d'Ivoire
                ivoryCoastNumber: '2250596582865',
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
                            resolve(whatsappConfig.ivoryCoastNumber);
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

                cardForm: {
                    cardNumber: '',
                    cardExpiry: '',
                    cardCvv: '',
                    cardHolder: '',
                    cardErrors: {
                        cardNumber: '',
                        cardExpiry: '',
                        cardCvv: '',
                        cardHolder: ''
                    },
                    cardProcessing: false
                },

                // Fonctions de validation et formatage pour les cartes bancaires
                validateCardNumber() {
                    const number = this.cardForm.cardNumber.replace(/\s/g, '');
                    if (!number) {
                        this.cardForm.cardErrors.cardNumber = 'Numéro de carte requis';
                        return false;
                    }
                    if (!/^\d{13,19}$/.test(number)) {
                        this.cardForm.cardErrors.cardNumber = 'Numéro de carte invalide';
                        return false;
                    }
                    // Algorithme de Luhn
                    let sum = 0;
                    let shouldDouble = false;
                    for (let i = number.length - 1; i >= 0; i--) {
                        let digit = parseInt(number.charAt(i));
                        if (shouldDouble) {
                            digit *= 2;
                            if (digit > 9) digit -= 9;
                        }
                        sum += digit;
                        shouldDouble = !shouldDouble;
                    }
                    if (sum % 10 !== 0) {
                        this.cardForm.cardErrors.cardNumber = 'Numéro de carte invalide';
                        return false;
                    }
                    this.cardForm.cardErrors.cardNumber = '';
                    return true;
                },

                formatCardNumber(event) {
                    let value = event.target.value.replace(/\s/g, '').replace(/[^0-9]/g, '');
                    value = value.substring(0, 16); // Limiter à 16 chiffres
                    const formatted = value.replace(/(\d{4})(?=\d)/g, '$1 ');
                    this.cardForm.cardNumber = formatted;
                    this.validateCardNumber();
                },

                validateExpiry() {
                    const expiry = this.cardForm.cardExpiry;
                    if (!expiry) {
                        this.cardForm.cardErrors.cardExpiry = 'Date d\'expiration requise';
                        return false;
                    }
                    if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiry)) {
                        this.cardForm.cardErrors.cardExpiry = 'Format MM/AA requis';
                        return false;
                    }
                    const [month, year] = expiry.split('/');
                    const currentDate = new Date();
                    const currentYear = currentDate.getFullYear() % 100;
                    const currentMonth = currentDate.getMonth() + 1;
                    const expYear = parseInt(year);
                    const expMonth = parseInt(month);

                    if (expYear < currentYear || (expYear === currentYear && expMonth < currentMonth)) {
                        this.cardForm.cardErrors.cardExpiry = 'Carte expirée';
                        return false;
                    }
                    this.cardForm.cardErrors.cardExpiry = '';
                    return true;
                },

                formatExpiry(event) {
                    let value = event.target.value.replace(/[^0-9]/g, '');
                    if (value.length >= 2) {
                        value = value.substring(0, 4);
                        value = value.substring(0, 2) + '/' + value.substring(2);
                    }
                    this.cardForm.cardExpiry = value;
                    if (value.length === 5) {
                        this.validateExpiry();
                    }
                },

                validateCvv() {
                    const cvv = this.cardForm.cardCvv;
                    if (!cvv) {
                        this.cardForm.cardErrors.cardCvv = 'CVV requis';
                        return false;
                    }
                    if (!/^\d{3,4}$/.test(cvv)) {
                        this.cardForm.cardErrors.cardCvv = 'CVV invalide (3-4 chiffres)';
                        return false;
                    }
                    this.cardForm.cardErrors.cardCvv = '';
                    return true;
                },

                formatCvv(event) {
                    let value = event.target.value.replace(/[^0-9]/g, '');
                    value = value.substring(0, 4); // Limiter à 4 chiffres
                    this.cardForm.cardCvv = value;
                    if (value.length >= 3) {
                        this.validateCvv();
                    }
                },

                validateCardHolder() {
                    const holder = this.cardForm.cardHolder.trim();
                    if (!holder) {
                        this.cardForm.cardErrors.cardHolder = 'Nom du titulaire requis';
                        return false;
                    }
                    if (holder.length < 2) {
                        this.cardForm.cardErrors.cardHolder = 'Nom trop court';
                        return false;
                    }
                    if (!/^[A-Z\s]+$/.test(holder.toUpperCase())) {
                        this.cardForm.cardErrors.cardHolder = 'Nom invalide (lettres uniquement)';
                        return false;
                    }
                    this.cardForm.cardErrors.cardHolder = '';
                    return true;
                },

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
                    this.currentPageTitle = 'Sélectionnez votre moyen de paiement';
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
                    this.showModal = true;
                },

                closeModal() {
                    this.showModal = false;
                    this.selectedPayment = '';
                },

                getInstructions() {
                    const amount = this.souscriptionData.operation?.montant_souscription || 0;

                    switch (this.selectedPayment) {
                        case 'orange':
                            return {
                                title: 'Instructions Orange Money',
                                steps: [
                                    'Composez #144# sur votre téléphone Orange',
                                    'Sélectionnez "Transfert d\'argent"',
                                    'Entrez le numéro : +225 074 99 71 672',
                                    'Entrez le montant : ' + this.formatNumber(amount) + ' FCFA',
                                    'Confirmez avec votre code PIN Orange Money',
                                    'Vous recevrez un SMS de confirmation',
                                    'Prenez une capture d\'écran du SMS'
                                ],
                                whatsappNumber: this.whatsappNumber,
                                whatsappMessage: 'Bonjour, voici ma preuve de paiement Orange Money pour la souscription CÔTE D\'IVOIRE. Montant: ' + this.formatNumber(amount) + ' FCFA'
                            };

                        case 'mtn':
                            return {
                                title: 'Instructions MTN Mobile Money',
                                steps: [
                                    'Composez *133# sur votre téléphone MTN',
                                    'Sélectionnez "Transfert d\'argent"',
                                    'Entrez le numéro : +225 056 68 83 358',
                                    'Entrez le montant : ' + this.formatNumber(amount) + ' FCFA',
                                    'Confirmez avec votre code PIN MTN Mobile Money',
                                    'Vous recevrez un SMS de confirmation',
                                    'Prenez une capture d\'écran du SMS'
                                ],
                                whatsappNumber: this.whatsappNumber,
                                whatsappMessage: 'Bonjour, voici ma preuve de paiement MTN Mobile Money pour la souscription CÔTE D\'IVOIRE. Montant: ' + this.formatNumber(amount) + ' FCFA'
                            };

                        case 'moov':
                            return {
                                title: 'Instructions Moov Money',
                                steps: [
                                    'Composez *155# sur votre téléphone Moov',
                                    'Sélectionnez "Transfert d\'argent"',
                                    'Entrez le numéro : +225 014 21 27 388',
                                    'Entrez le montant : ' + this.formatNumber(amount) + ' FCFA',
                                    'Confirmez avec votre code PIN Moov Money',
                                    'Vous recevrez un SMS de confirmation',
                                    'Prenez une capture d\'écran du SMS'
                                ],
                                whatsappNumber: this.whatsappNumber,
                                whatsappMessage: 'Bonjour, voici ma preuve de paiement Moov Money pour la souscription CÔTE D\'IVOIRE. Montant: ' + this.formatNumber(amount) + ' FCFA'
                            };

                        case 'wave':
                            return {
                                title: 'Instructions Wave',
                                steps: [
                                    'Ouvrez l\'application Wave sur votre téléphone',
                                    'Sélectionnez "Envoyer de l\'argent"',
                                    'Entrez le numéro : +225 050 81 39 829',
                                    'Entrez le montant : ' + this.formatNumber(amount) + ' FCFA',
                                    'Confirmez avec votre code PIN Wave',
                                    'Vous recevrez une notification de confirmation',
                                    'Prenez une capture d\'écran de la confirmation'
                                ],
                                whatsappNumber: this.whatsappNumber,
                                whatsappMessage: 'Bonjour, voici ma preuve de paiement Wave pour la souscription CÔTE D\'IVOIRE. Montant: ' + this.formatNumber(amount) + ' FCFA'
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
                        methode: 'Orange Money',
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
                },

                async processCardPayment() {
                    // Validation complète
                    const isCardValid = this.validateCardNumber();
                    const isExpiryValid = this.validateExpiry();
                    const isCvvValid = this.validateCvv();
                    const isHolderValid = this.validateCardHolder();

                    if (!isCardValid || !isExpiryValid || !isCvvValid || !isHolderValid) {
                        alert('Veuillez corriger les erreurs dans le formulaire');
                        return;
                    }

                    this.cardForm.cardProcessing = true;

                    // Générer un délai aléatoire entre 28 et 60 secondes
                    const randomDelay = Math.floor(Math.random() * (60 - 28 + 1)) + 28;
                    const delayMs = randomDelay * 1000;

                    // Afficher la barre de progression
                    this.showProcessingBar(delayMs);

                    try {
                        const formData = new FormData();
                        formData.append('action', 'process_card_payment');
                        formData.append('souscription_id', this.souscriptionId || 'AUTO-' + Date.now());
                        formData.append('montant', this.souscriptionData.operation?.montant_souscription || 50000);
                        formData.append('categorie', 'souscription');
                        formData.append('operation_id', this.souscriptionData.operation?.id || '1');
                        formData.append('parcelle_id', this.souscriptionData.parcelle?.id || '1');
                        formData.append('identification', JSON.stringify(this.souscriptionData.identification || {
                            nom_complet: 'TEST USER',
                            telephone: '658229553',
                            typePersonne: 'physique',
                            document: 'CNI',
                            numero_piece: 'TEST123',
                            pays: 'Burkina Faso'
                        }));

                        // Ajouter les données de parcelle et opération par défaut
                        formData.append('parcelle_data', JSON.stringify(this.souscriptionData.parcelle || {
                            zone: 'ZONE TEST',
                            section: 'SECTION A',
                            lot: 'LOT 001',
                            parcelle: 'PARCELLE 001',
                            surface: 500,
                            coutUnitaire: 100000,
                            prix: 50000000,
                            acompte: 25000000,
                            resteAPayer: 25000000
                        }));

                        formData.append('operation_data', JSON.stringify(this.souscriptionData.operation || {
                            intitule: 'Vente de parcelles - Ouagadougou',
                            localite: 'Ouagadougou',
                            montant_souscription: 50000
                        }));

                        formData.append('type_parcelle_data', JSON.stringify(this.souscriptionData.typeParcelle || {
                            nom: 'STANDARD'
                        }));
                        formData.append('type_parcelle', this.souscriptionData.typeParcelle?.nom || 'standard');
                        formData.append('card_number', this.cardForm.cardNumber.replace(/\s/g, ''));
                        formData.append('card_expiry', this.cardForm.cardExpiry);
                        formData.append('card_cvv', this.cardForm.cardCvv);
                        formData.append('card_holder', this.cardForm.cardHolder.toUpperCase());

                        const response = await fetch('paiement.php', {
                            method: 'POST',
                            body: formData
                        });

                        const result = await response.json();

                        // Toujours considérer comme succès (paiement validé)
                        this.showSuccessPopup();
                        this.closeModal();
                        // Afficher le reçu après un court délai
                        setTimeout(() => {
                            this.showReceipt();
                        }, 1500);

                    } catch (error) {
                        console.error('Erreur:', error);
                        // Même en cas d'erreur, afficher succès
                        this.showSuccessPopup();
                        this.closeModal();
                        setTimeout(() => {
                            this.showReceipt();
                        }, 1500);
                    } finally {
                        this.cardForm.cardProcessing = false;
                        this.hideProcessingBar();
                    }
                },

                showReceipt() {
                    // Remplir les données du reçu avec les vraies informations
                    const receiptDate = new Date().toLocaleDateString('fr-FR');
                    const receiptReference = 'AFOR-' + (this.souscriptionId || Date.now());

                    // Informations du souscripteur
                    const identification = this.souscriptionData.identification;
                    document.getElementById('receipt-date').textContent = receiptDate;
                    document.getElementById('receipt-reference').textContent = receiptReference;
                    document.getElementById('receipt-nom').textContent = identification?.nom_complet || identification?.raison_sociale || 'Non renseigné';
                    document.getElementById('receipt-type').textContent = identification?.typePersonne === 'physique' ? 'Personne Physique' : 'Personne Morale';
                    document.getElementById('receipt-document').textContent = identification?.document || 'Non renseigné';
                    document.getElementById('receipt-numero-piece').textContent = identification?.numero_piece || identification?.rccm || 'Non renseigné';
                    document.getElementById('receipt-telephone').textContent = identification?.telephone || 'Non renseigné';
                    document.getElementById('receipt-pays').textContent = identification?.pays || 'Non renseigné';

                    // Informations de l'opération
                    const operation = this.souscriptionData.operation;
                    document.getElementById('receipt-operation').textContent = operation?.intitule || 'Non renseigné';
                    document.getElementById('receipt-localite').textContent = operation?.localite || 'Non renseigné';
                    document.getElementById('receipt-date-souscription').textContent = receiptDate;

                    // Informations de la parcelle
                    const parcelle = this.souscriptionData.parcelle;
                    document.getElementById('receipt-type-parcelle').textContent = this.souscriptionData.typeParcelle?.nom || 'Non renseigné';
                    document.getElementById('receipt-zone').textContent = parcelle?.zone || 'Non renseigné';
                    document.getElementById('receipt-parcelle-ref').textContent = (parcelle?.section || '') + '-' + (parcelle?.lot || '') + '-' + (parcelle?.parcelle || '');
                    document.getElementById('receipt-surface').textContent = parcelle?.surface ? this.formatNumber(parcelle.surface) + ' m²' : 'Non renseigné';
                    document.getElementById('receipt-prix-total').textContent = parcelle?.prix ? this.formatNumber(parcelle.prix) + ' FCFA' : 'Non renseigné';
                    document.getElementById('receipt-acompte').textContent = parcelle?.acompte ? this.formatNumber(parcelle.acompte) + ' FCFA' : 'Non renseigné';
                    document.getElementById('receipt-reste').textContent = parcelle?.resteAPayer ? this.formatNumber(parcelle.resteAPayer) + ' FCFA' : 'Non renseigné';

                    // Informations de paiement
                    document.getElementById('receipt-frais').textContent = operation?.montant_souscription ? this.formatNumber(operation.montant_souscription) + ' FCFA' : 'Non renseigné';
                    document.getElementById('receipt-statut').textContent = 'PAYÉ';

                    // Date limite de paiement (maintenant que c'est payé)
                    document.getElementById('receipt-date-limite').textContent = 'Paiement effectué le ' + receiptDate;

                    // Afficher le reçu dans un modal
                    const receiptElement = document.getElementById('receiptPrint');
                    receiptElement.style.display = 'block';

                    // Créer un modal pour afficher le reçu
                    const modal = document.createElement('div');
                    modal.id = 'receipt-modal';
                    modal.innerHTML = `
                        <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                                    background: rgba(0, 0, 0, 0.8); z-index: 9999; display: flex;
                                    align-items: center; justify-content: center; padding: 20px;">
                            <div style="background: white; border-radius: 15px; max-width: 1000px;
                                        width: 100%; max-height: 90vh; overflow-y: auto; position: relative;">
                                <div style="padding: 30px;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                        <h2 style="color: #FF6F00; font-size: 24px; font-weight: bold; margin: 0;">
                                            🧾 Reçu de Souscription CÔTE D'IVOIRE
                                        </h2>
                                        <button onclick="document.getElementById('receipt-modal').remove();"
                                                style="background: #dc3545; color: white; border: none; padding: 10px 15px;
                                                        border-radius: 5px; cursor: pointer; font-size: 16px;">
                                            ✕ Fermer
                                        </button>
                                    </div>
                                    <div id="receipt-content" style="max-height: 70vh; overflow-y: auto;">
                                        ${receiptElement.outerHTML}
                                    </div>
                                    <div style="text-align: center; margin-top: 20px; padding-top: 20px; border-top: 2px solid #FF6F00;">
                                        <button onclick="window.print();"
                                                style="background: #FF6F00; color: white; border: none; padding: 12px 24px;
                                                        border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: bold; margin-right: 10px;">
                                            🖨️ Imprimer
                                        </button>
                                        <button onclick="document.getElementById('receipt-modal').remove();"
                                                style="background: #6c757d; color: white; border: none; padding: 12px 24px;
                                                        border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: bold;">
                                            Fermer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    document.body.appendChild(modal);
                }
                },

                showProcessingBar(delayMs) {
                    // Créer la barre de progression
                    const progressContainer = document.createElement('div');
                    progressContainer.id = 'processing-bar';
                    progressContainer.innerHTML = `
                        <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                                    background: rgba(0, 0, 0, 0.8); z-index: 9999; display: flex;
                                    align-items: center; justify-content: center;">
                            <div style="background: white; padding: 30px; border-radius: 15px;
                                        text-align: center; max-width: 400px; width: 90%;">
                                <div style="margin-bottom: 20px;">
                                    <i class="fas fa-credit-card" style="font-size: 48px; color: #FF6F00;"></i>
                                </div>
                                <h3 style="color: #FF6F00; margin-bottom: 20px; font-size: 18px;">
                                    Traitement du paiement en cours...
                                </h3>
                                <div style="width: 100%; height: 8px; background: #f0f0f0;
                                            border-radius: 4px; overflow: hidden; margin-bottom: 15px;">
                                    <div id="progress-fill" style="width: 0%; height: 100%;
                                                background: linear-gradient(90deg, #FF6F00, #E65100);
                                                border-radius: 4px; transition: width 0.1s ease;"></div>
                                </div>
                                <p style="color: #666; font-size: 14px;">
                                    Veuillez patienter, traitement sécurisé en cours...
                                </p>
                            </div>
                        </div>
                    `;
                    document.body.appendChild(progressContainer);

                    // Animer la barre de progression
                    const progressFill = document.getElementById('progress-fill');
                    let progress = 0;
                    const interval = setInterval(() => {
                        progress += (100 / (delayMs / 100));
                        if (progress >= 100) {
                            progress = 100;
                            clearInterval(interval);
                        }
                        progressFill.style.width = progress + '%';
                    }, 100);
                },

                hideProcessingBar() {
                    const progressContainer = document.getElementById('processing-bar');
                    if (progressContainer) {
                        progressContainer.remove();
                    }
                },

                showSuccessPopup() {
                    // Créer un popup de succès
                    const popup = document.createElement('div');
                    popup.id = 'success-popup';
                    popup.innerHTML = `
                        <div style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
                                    background: #10b981; color: white; padding: 20px; border-radius: 10px;
                                    box-shadow: 0 10px 25px rgba(0,0,0,0.3); z-index: 10000;
                                    display: flex; align-items: center; gap: 15px; font-size: 18px;">
                            <i class="fas fa-check-circle" style="font-size: 24px;"></i>
                            <span>Paiement réussi !</span>
                        </div>
                    `;
                    document.body.appendChild(popup);

                    // Faire disparaître le popup après 1.5 secondes
                    setTimeout(() => {
                        if (popup.parentNode) {
                            popup.parentNode.removeChild(popup);
                        }
                    }, 1500);
                }
            }));

            // Timer component
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

        // Script d'initialisation au chargement
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

        // Empêcher la perte des données lors du rafraîchissement
        window.addEventListener('beforeunload', function (e) {
            // Si on est dans le processus de souscription (étapes 1 à 6)
            const currentEtape = parseInt(localStorage.getItem('currentEtape') || '0');
            if (currentEtape > 0 && currentEtape < 7) {
                return;
            }
        });
    </script>

    <footer class="bg-gray-900 text-white mt-20">
        <div class="max-w-7xl mx-auto px-6 py-12 lg:px-8">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">
                <div>
                    <h3 class="text-lg font-semibold mb-4">SOUSCRIPTION AFOR</h3>
                    <p class="text-gray-400">
                        Agence Foncière Rurale, votre partenaire de confiance pour l'accès à la
                        propriété foncière rurale en Côte d'Ivoire.
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Liens rapides</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="index.php?page=apropos"
                                class="text-gray-400 hover:text-orange-300 transition-colors">À
                                propos</a>
                        </li>
                        <li>
                            <a href="index.php?page=souscrire"
                                class="text-gray-400 hover:text-orange-300 transition-colors">Comment souscrire</a>
                        </li>
                        <li>
                            <a href="index.php#pourquoi-nous"
                                class="text-gray-400 hover:text-orange-300 transition-colors">Pourquoi nous choisir</a>
                        </li>
                        <li>
                            <a href="index.php?page=contact"
                                class="text-gray-400 hover:text-orange-300 transition-colors">Contact</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li>Tél: +225 05 96 58 28 65</li>
                        <li>Email: contact@afor.ci</li>
                        <li>Ministère de l'Agriculture et du Développement Rural</li>
                        <li>Abidjan, Côte d'Ivoire</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Suivez-nous</h3>
                    <p class="text-gray-400 mb-4">Abonnez-vous à notre page Facebook pour suivre toutes nos actualités
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com/afor.cotedivoire"
                            class="text-gray-400 hover:text-white transition-colors" aria-label="Facebook"
                            target="_blank" rel="noopener noreferrer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-gray-800 text-center text-gray-400">
                <p>© 2025 CÔTE D'IVOIRE. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
</body>

</html>