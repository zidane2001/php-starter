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
<body class="bg-gray-50">
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
    </script>
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
    <!-- Étapes de progression - AJUSTÉES POUR 5 ÉTAPES -->
    <div class="mb-6 sm:mb-10">
        <div class="flex justify-center items-center space-x-1 sm:space-x-4">
            <!-- Étape 1 : Site -->
            <div class="flex flex-col items-center">
                <div class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold shadow-lg transition-all duration-300 text-white" style="background-color: #8B6914;" animate-[pulse_0.7s_ease-in-out_infinite]="" scale-125"="">1</div>
                <span class="mt-1 sm:mt-2 text-[10px] sm:text-xs font-medium" style="color: #8B6914;">Site</span>
            </div>
            <div class="w-4 sm:w-16 h-0.5 sm:h-1 bg-gray-300 rounded"></div>

            <!-- Étape 2 : Conditions -->
            <div class="flex flex-col items-center">
                <div class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold shadow-lg transition-all duration-300 bg-gray-300 text-gray-600 cursor-not-allowed">2</div>
                <span class="mt-1 sm:mt-2 text-[10px] sm:text-xs font-medium text-gray-500">Conditions</span>
            </div>
            <div class="w-4 sm:w-16 h-0.5 sm:h-1 bg-gray-300 rounded"></div>

            <!-- Étape 3 : Identification -->
            <div class="flex flex-col items-center">
                <div class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold shadow-lg transition-all duration-300 bg-gray-300 text-gray-600 cursor-not-allowed">3</div>
                <span class="mt-1 sm:mt-2 text-[10px] sm:text-xs font-medium text-gray-500">Identification</span>
            </div>
            <div class="w-4 sm:w-16 h-0.5 sm:h-1 bg-gray-300 rounded"></div>

            <!-- Étape 4 : Parcelle -->
            <div class="flex flex-col items-center">
                <div class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold shadow-lg transition-all duration-300 bg-gray-300 text-gray-600 cursor-not-allowed">4</div>
                <span class="mt-1 sm:mt-2 text-[10px] sm:text-xs font-medium text-gray-500">Parcelle</span>
            </div>
            <div class="w-4 sm:w-16 h-0.5 sm:h-1 bg-gray-300 rounded"></div>

            <!-- Étape 5 : Paiement -->
            <div class="flex flex-col items-center">
                <div class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold shadow-lg transition-all duration-300 bg-gray-300 text-gray-600 cursor-not-allowed">5</div>
                <span class="mt-1 sm:mt-2 text-[10px] sm:text-xs font-medium text-gray-500">Paiement</span>
            </div>
        </div>
    </div>

    <!-- Boutons de navigation -->
    <div class="flex justify-between items-center mt-4 sm:mt-8 max-w-4xl mx-auto px-2 sm:px-0">
        <!-- Bouton Précédent (désactivé à la première étape) -->
        <button class="opacity-50 cursor-not-allowed px-3 sm:px-6 py-2 sm:py-3 text-white rounded-lg flex items-center transition-all duration-300 text-xs sm:text-base" style="background-color: #8B6914;">
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
        <button class="opacity-50 cursor-not-allowed bg-gray-400 px-3 sm:px-6 py-2 sm:py-3 text-white rounded-lg flex items-center transition-all duration-300 text-xs sm:text-base">
            <span>Suivant</span>
            <i class="fas fa-arrow-right ml-1 sm:ml-2"></i>
        </button>
    </div>

    <div class="mt-16">
        <div class="text-center mb-8">
            <h2 class="text-2xl sm:text-3xl font-bold mb-2">Opérations disponibles</h2>
            <p class="text-gray-600">Découvrez nos opérations de souscription et commencez votre processus de souscription</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-6">
                                                <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform hover:scale-105 h-full flex flex-col">
                                                    <img src="assets/images/anuttc-logo.jpeg" alt="Vente de parcelles - Grand Libreville" class="w-full h-48 object-cover">
                                                
                        <div class="p-6 flex-grow">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-bold text-gray-800">Vente de parcelles - Grand Libreville</h3>
                                <span class="text-xs px-2 py-1 rounded-full text-white" style="background-color: #8B6914;">Active</span>
                            </div>
                            
                            <p class="text-gray-600 mb-4">
                                <i class="fas fa-map-marker-alt mr-2" style="color: #8B6914;"></i>Grand Libreville                            </p>
                            
                                                            <p class="text-gray-700 mb-4">Nouveau lotissement ANUTTC Grand Libreville - Zone Centre avec viabilisation complète...</p>
                                                        
                            <div class="mt-4 space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Date de début:</span>
                                    <span class="text-gray-800">15/09/2025</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Date de fin:</span>
                                    <span class="text-gray-800">23/09/2026</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Frais de souscription:</span>
                                    <span class="font-semibold" style="color: #8B6914;">50 000 FCFA</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6 bg-gray-50 border-t">
                            <button onclick="selectOperationJS({&quot;id&quot;:&quot;9&quot;,&quot;intitule&quot;:&quot;Vente de parcelles - Grand Libreville&quot;,&quot;localite&quot;:&quot;Grand Libreville&quot;,&quot;description&quot;:&quot;Nouveau lotissement ANUTTC Grand Libreville - Zone Centre avec viabilisation compl\u00e8te&quot;,&quot;date_debut&quot;:&quot;2025-09-15&quot;,&quot;date_fin&quot;:&quot;2026-09-23&quot;,&quot;montant_souscription&quot;:&quot;50000.00&quot;,&quot;statut&quot;:&quot;active&quot;,&quot;image&quot;:&quot;assets\/images\/libreville.jpg&quot;})" class="w-full text-white" style="background-color: #8B6914;" py-3="" px-4="" rounded-lg="" font-medium="" flex="" items-center="" justify-center"="">
                                <i class="fas fa-check-circle mr-2"></i>
                                <span>Sélectionner</span>
                            </button>
                        </div>
                    </div>
                                    <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform hover:scale-105 h-full flex flex-col">
                                                    <img src="assets/images/anuttc-logo.jpeg" alt="Vente de parcelles - Okolassi" class="w-full h-48 object-cover">
                                                
                        <div class="p-6 flex-grow">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-bold text-gray-800">Vente de parcelles - Okolassi</h3>
                                <span class="text-xs px-2 py-1 rounded-full text-white" style="background-color: #8B6914;">Active</span>
                            </div>
                            
                            <p class="text-gray-600 mb-4">
                                <i class="fas fa-map-marker-alt mr-2" style="color: #8B6914;"></i>Okolassi                            </p>
                            
                                                            <p class="text-gray-700 mb-4">Lotissement ANUTTC Okolassi - Zone Résidentielle, parcelles viabilisées...</p>
                                                        
                            <div class="mt-4 space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Date de début:</span>
                                    <span class="text-gray-800">15/09/2025</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Date de fin:</span>
                                    <span class="text-gray-800">23/09/2026</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Frais de souscription:</span>
                                    <span class="font-semibold" style="color: #8B6914;">50 000 FCFA</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6 bg-gray-50 border-t">
                            <button onclick="selectOperationJS({&quot;id&quot;:&quot;10&quot;,&quot;intitule&quot;:&quot;Vente de parcelles - Okolassi&quot;,&quot;localite&quot;:&quot;Okolassi&quot;,&quot;description&quot;:&quot;Lotissement ANUTTC Okolassi - Zone R\u00e9sidentielle, parcelles viabilis\u00e9es&quot;,&quot;date_debut&quot;:&quot;2025-09-15&quot;,&quot;date_fin&quot;:&quot;2026-09-23&quot;,&quot;montant_souscription&quot;:&quot;50000.00&quot;,&quot;statut&quot;:&quot;active&quot;,&quot;image&quot;:&quot;assets\/images\/port-gentil.jpg&quot;})" class="w-full text-white" style="background-color: #8B6914;" py-3="" px-4="" rounded-lg="" font-medium="" flex="" items-center="" justify-center"="">
                                <i class="fas fa-check-circle mr-2"></i>
                                <span>Sélectionner</span>
                            </button>
                        </div>
                    </div>
                                    <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform hover:scale-105 h-full flex flex-col">
                                                    <img src="assets/images/anuttc-logo.jpeg" alt="Vente de parcelles - Bolokoboué" class="w-full h-48 object-cover">
                                                
                        <div class="p-6 flex-grow">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-bold text-gray-800">Vente de parcelles - Bolokoboué</h3>
                                <span class="text-xs px-2 py-1 rounded-full text-white" style="background-color: #8B6914;">Active</span>
                            </div>
                            
                            <p class="text-gray-600 mb-4">
                                <i class="fas fa-map-marker-alt mr-2" style="color: #8B6914;"></i>Bolokoboué                            </p>
                            
                                                            <p class="text-gray-700 mb-4">Opération de lotissement ANUTTC Bolokoboué - Zone Industrielle, terrains aménagés...</p>
                                                        
                            <div class="mt-4 space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Date de début:</span>
                                    <span class="text-gray-800">15/09/2025</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Date de fin:</span>
                                    <span class="text-gray-800">23/09/2026</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Frais de souscription:</span>
                                    <span class="font-semibold" style="color: #8B6914;">50 000 FCFA</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6 bg-gray-50 border-t">
                            <button onclick="selectOperationJS({&quot;id&quot;:&quot;11&quot;,&quot;intitule&quot;:&quot;Vente de parcelles - Bolokobou\u00e9&quot;,&quot;localite&quot;:&quot;Bolokobou\u00e9&quot;,&quot;description&quot;:&quot;Op\u00e9ration de lotissement ANUTTC Bolokobou\u00e9 - Zone Industrielle, terrains am\u00e9nag\u00e9s&quot;,&quot;date_debut&quot;:&quot;2025-09-15&quot;,&quot;date_fin&quot;:&quot;2026-09-23&quot;,&quot;montant_souscription&quot;:&quot;50000.00&quot;,&quot;statut&quot;:&quot;active&quot;,&quot;image&quot;:&quot;assets\/images\/franceville.jpg&quot;})" class="w-full text-white" style="background-color: #8B6914;" py-3="" px-4="" rounded-lg="" font-medium="" flex="" items-center="" justify-center"="">
                                <i class="fas fa-check-circle mr-2"></i>
                                <span>Sélectionner</span>
                            </button>
                        </div>
                    </div>
                                    </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Nettoyer le localStorage pour une nouvelle souscription
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
</script><footer class="bg-gray-900 text-white mt-20">
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