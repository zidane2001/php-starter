<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Souscription - AFOR Côte d'Ivoire</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.0/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="assets/images/AFOR2.png" type="image/png">
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

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
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

        /* Styles spécifiques pour les étapes */
        .step-active {
            background-color: #FF6F00;
            color: white;
            transform: scale(1.1);
        }

        .step-completed {
            background-color: #FF6F00;
            color: white;
        }

        .step-pending {
            background-color: #D1D5DB;
            color: #6B7280;
        }

        .operation-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            border-top: 4px solid #FF6F00;
        }

        .operation-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        /* Icônes avec couleur orange */
        .icon-orange {
            color: #FF6F00;
        }

        /* Badges orange */
        .badge-orange {
            background-color: #FF6F00;
            color: white;
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
                    <img src="assets/images/logo_MCLU.png" alt="Logo AFOR" class="h-14 w-auto">
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

    <main class="max-w-7xl mx-auto px-4 py-16" x-data="{ 
    etape: 1,
    maxEtape: 1,
    isFinalized: false,
    siteSelected: false,
    conditionsAccepted: false,
    identificationValid: false,
    typeSelected: false,
    positionSelected: false,
    paiementValid: false,
    souscriptionData: {
        operation: null,
        conditions: null,
        identification: null,
        typeParcelle: null,
        parcelle: null,
        paiement: null
    },
    selectOperation(operation) {
        console.log('Sélection de l\'opération:', operation);
        this.souscriptionData.operation = operation;
        localStorage.setItem('operation', JSON.stringify(operation));
        localStorage.setItem('siteSelected', 'true');
        localStorage.setItem('currentEtape', '1');
        localStorage.setItem('maxEtape', '1');
        this.siteSelected = true;
        
        // Rediriger vers l'étape 2
        window.location.href = 'index.php?page=conditions';
    }
}">
        <!-- Étapes de progression -->
        <div class="mb-6 sm:mb-10">
            <div class="flex justify-center items-center space-x-1 sm:space-x-4">
                <!-- Étape 1 : Site -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold shadow-lg step-active">
                        1
                    </div>
                    <span class="mt-1 sm:mt-2 text-[10px] sm:text-xs font-medium" style="color: #FF6F00;">Site</span>
                </div>
                <div class="w-4 sm:w-16 h-0.5 sm:h-1 bg-gray-300 rounded"></div>

                <!-- Étape 2 : Conditions -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold shadow-lg step-pending">
                        2
                    </div>
                    <span class="mt-1 sm:mt-2 text-[10px] sm:text-xs font-medium text-gray-500">Conditions</span>
                </div>
                <div class="w-4 sm:w-16 h-0.5 sm:h-1 bg-gray-300 rounded"></div>

                <!-- Étape 3 : Identification -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold shadow-lg step-pending">
                        3
                    </div>
                    <span class="mt-1 sm:mt-2 text-[10px] sm:text-xs font-medium text-gray-500">Identification</span>
                </div>
                <div class="w-4 sm:w-16 h-0.5 sm:h-1 bg-gray-300 rounded"></div>

                <!-- Étape 4 : Parcelle -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold shadow-lg step-pending">
                        4
                    </div>
                    <span class="mt-1 sm:mt-2 text-[10px] sm:text-xs font-medium text-gray-500">Parcelle</span>
                </div>
                <div class="w-4 sm:w-16 h-0.5 sm:h-1 bg-gray-300 rounded"></div>

                <!-- Étape 5 : Paiement -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold shadow-lg step-pending">
                        5
                    </div>
                    <span class="mt-1 sm:mt-2 text-[10px] sm:text-xs font-medium text-gray-500">Paiement</span>
                </div>
            </div>
        </div>

        <!-- Boutons de navigation -->
        <div class="flex justify-between items-center mt-4 sm:mt-8 max-w-4xl mx-auto px-2 sm:px-0">
            <!-- Bouton Précédent (désactivé à la première étape) -->
            <button class="opacity-50 cursor-not-allowed btn-afor-outline px-3 sm:px-6 py-2 sm:py-3">
                <i class="fas fa-arrow-left mr-1 sm:mr-2"></i>
                Précédent
            </button>

            <!-- Messages d'erreur -->
            <div class="text-center mx-2 sm:mx-4 hidden sm:block">
                <div x-show="!siteSelected" class="text-red-600 text-xs sm:text-sm">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    Veuillez sélectionner un site
                </div>
            </div>

            <!-- Bouton Suivant (désactivé tant qu'un site n'est pas sélectionné) -->
            <button
                class="opacity-50 cursor-not-allowed bg-gray-400 px-3 sm:px-6 py-2 sm:py-3 text-white rounded-lg flex items-center transition-all duration-300 text-xs sm:text-base">
                <span>Suivant</span>
                <i class="fas fa-arrow-right ml-1 sm:ml-2"></i>
            </button>
        </div>

        <div class="mt-16">
            <div class="text-center mb-8">
                <h2 class="text-2xl sm:text-3xl font-bold mb-2 text-gray-800">Opérations disponibles</h2>
                <p class="text-gray-600">Découvrez nos opérations de souscription et commencez votre processus de
                    souscription</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <!-- Opération Abidjan -->
                <div class="operation-card">
                    <img src="assets/images/terrain1.jpg"
                        alt="Vente de parcelles - Abidjan" class="w-full h-48 object-cover rounded-t-lg">
                    <div class="p-6 flex-grow">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-bold text-gray-800">Vente de parcelles - Abidjan</h3>
                            <span class="text-xs px-2 py-1 rounded-full text-white badge-orange">Active</span>
                        </div>

                        <p class="text-gray-600 mb-4">
                            <i class="fas fa-map-marker-alt mr-2" style="color: #FF6F00;"></i>Abidjan
                        </p>

                        <p class="text-gray-700 mb-4">Nouveau lotissement AFOR Abidjan - Zone Centre avec viabilisation
                            complète...</p>

                        <div class="mt-4 space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Date de début:</span>
                                <span class="text-gray-800">14/10/2025</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Date de fin:</span>
                                <span class="text-gray-800">28/10/2025</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Frais de souscription:</span>
                                <span class="font-semibold" style="color: #FF6F00;">50 000 FCFA</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-orange-50 border-t">
                        <button onclick="selectOperationJS({
                        'id': '1',
                        'intitule': 'Vente de parcelles - Abidjan',
                        'localite': 'Abidjan',
                        'description': 'Nouveau lotissement AFOR Abidjan - Zone Centre avec viabilisation complète',
                        'date_debut': '2025-10-14',
                        'date_fin': '2025-10-28',
                        'montant_souscription': '50000.00',
                        'statut': 'active',
                        'image': 'assets/images/abidjan-terrain.jpg'
                    })" class="btn-afor w-full py-3">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>Sélectionner</span>
                        </button>
                    </div>
                </div>

                <!-- Opération Bouaké -->
                <div class="operation-card">
                    <img src="assets/images/A vendre un terrain sur le prolongement de VDN à….jpeg"
                        alt="Vente de parcelles - Bouaké" class="w-full h-48 object-cover rounded-t-lg">
                    <div class="p-6 flex-grow">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-bold text-gray-800">Vente de parcelles - Bouaké</h3>
                            <span class="text-xs px-2 py-1 rounded-full text-white badge-orange">Active</span>
                        </div>

                        <p class="text-gray-600 mb-4">
                            <i class="fas fa-map-marker-alt mr-2" style="color: #FF6F00;"></i>Bouaké
                        </p>

                        <p class="text-gray-700 mb-4">Lotissement AFOR Bouaké - Zone Résidentielle, parcelles
                            viabilisées...</p>

                        <div class="mt-4 space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Date de début:</span>
                                <span class="text-gray-800">14/10/2025</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Date de fin:</span>
                                <span class="text-gray-800">28/10/2025</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Frais de souscription:</span>
                                <span class="font-semibold" style="color: #FF6F00;">50 000 FCFA</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-orange-50 border-t">
                        <button onclick="selectOperationJS({
                        'id': '2',
                        'intitule': 'Vente de parcelles - Bouaké',
                        'localite': 'Bouaké',
                        'description': 'Lotissement AFOR Bouaké - Zone Résidentielle, parcelles viabilisées',
                        'date_debut': '2025-10-14',
                        'date_fin': '2025-10-28',
                        'montant_souscription': '50000.00',
                        'statut': 'active',
                        'image': 'assets/images/bouake-terrain.jpg'
                    })" class="btn-afor w-full py-3">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>Sélectionner</span>
                        </button>
                    </div>
                </div>

                <!-- Opération Korhogo -->
                <div class="operation-card">
                    <img src="assets/images/terrain2.jpg" alt="Vente de parcelles - Korhogo"
                        class="w-full h-48 object-cover rounded-t-lg">
                    <div class="p-6 flex-grow">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-bold text-gray-800">Vente de parcelles - Korhogo</h3>
                            <span class="text-xs px-2 py-1 rounded-full text-white badge-orange">Active</span>
                        </div>

                        <p class="text-gray-600 mb-4">
                            <i class="fas fa-map-marker-alt mr-2" style="color: #FF6F00;"></i>Korhogo
                        </p>

                        <p class="text-gray-700 mb-4">Opération de lotissement AFOR Korhogo - Zone Agricole,
                            terrains aménagés...</p>

                        <div class="mt-4 space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Date de début:</span>
                                <span class="text-gray-800">14/10/2025</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Date de fin:</span>
                                <span class="text-gray-800">28/10/2025</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Frais de souscription:</span>
                                <span class="font-semibold" style="color: #FF6F00;">50 000 FCFA</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-orange-50 border-t">
                        <button onclick="selectOperationJS({
                        'id': '3',
                        'intitule': 'Vente de parcelles - Korhogo',
                        'localite': 'Korhogo',
                        'description': 'Opération de lotissement AFOR Korhogo - Zone Agricole, terrains aménagés',
                        'date_debut': '2025-10-14',
                        'date_fin': '2025-10-28',
                        'montant_souscription': '50000.00',
                        'statut': 'active',
                        'image': 'assets/images/korhogo-terrain.jpg'
                    })" class="btn-afor w-full py-3">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>Sélectionner</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

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
                        <li>Tél: +225 27 20 21 22 23</li>
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
                            class="text-gray-400 hover:text-orange-300 transition-colors" aria-label="Facebook"
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
                <p>© 2025 AFOR Côte d'Ivoire. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const header = document.querySelector('header');

            window.addEventListener('scroll', function () {
                if (window.scrollY > 50) {
                       header.style.backgroundColor = 'rgba(27, 94, 32, 0.95)';
                } else {
                    header.style.backgroundColor = '#1B5E20';
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

        // Nettoyer le localStorage pour une nouvelle souscription
        document.addEventListener('DOMContentLoaded', function () {
            localStorage.clear();
        });

        // Fonction JavaScript standard pour la sélection de l'opération
        function selectOperationJS(operation) {
            console.log('Sélection de l\'opération via JS:', operation);

            // Stocker les données dans localStorage
            localStorage.setItem('operation', JSON.stringify(operation));
            localStorage.setItem('siteSelected', 'true');
            localStorage.setItem('currentEtape', '1');
            localStorage.setItem('maxEtape', '1');

            // Rediriger vers l'étape 2
            window.location.href = 'index.php?page=conditions';
        }

        // Empêcher la perte des données lors du rafraîchissement
        window.addEventListener('beforeunload', function (e) {
            const currentEtape = parseInt(localStorage.getItem('currentEtape') || '0');
            if (currentEtape > 0 && currentEtape < 7) {
                return;
            }
        });
    </script>

</body>

</html>