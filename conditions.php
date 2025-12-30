<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conditions - AFOR Côte d'Ivoire</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.0/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="assets/images/logo_MCLU.png" type="image/png">
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

        /* Styles pour les conditions */
        .conditions-container {
            max-height: 500px;
            overflow-y: auto;
            scrollbar-width: thin;
        }

        .conditions-container::-webkit-scrollbar {
            width: 6px;
        }

        .conditions-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .conditions-container::-webkit-scrollbar-thumb {
            background: #FF6F00;
            border-radius: 10px;
        }

        .conditions-section {
            background: #f8f9fa;
            border-left: 4px solid #FF6F00;
            margin-bottom: 1rem;
        }

        .error-message {
            background: #fee;
            border: 1px solid #fcc;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        /* Icônes avec couleur orange */
        .icon-orange {
            color: #FF6F00;
        }

        /* Arrière-plan orange clair */
        .bg-orange-light {
            background-color: #FFF3E0;
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
                    <a href="index.php?page=apropos" class="text-white hover:text-orange-200 transition py-2">À propos</a>
                    <a href="index.php?page=souscrire" class="text-white hover:text-orange-200 transition py-2">Comment
                        souscrire</a>
                    <a href="index.php#pourquoi-nous" class="text-white hover:text-orange-200 transition py-2">Pourquoi
                        nous choisir</a>
                    <a href="index.php?page=contact" class="text-white hover:text-orange-200 transition py-2">Contact</a>
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

    <script>
        // Fonction pour formater les nombres
        function formatNumber(number) {
            return new Intl.NumberFormat('fr-FR').format(number);
        }

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
<main class="max-w-7xl mx-auto px-4 py-16" x-data="{ 
    etape: 2,
    maxEtape: localStorage.getItem('maxEtape') ? parseInt(localStorage.getItem('maxEtape')) : 2,
    isFinalized: localStorage.getItem('isFinalized') === 'true' || false,
    siteSelected: localStorage.getItem('siteSelected') === 'true' || false,
    conditionsAccepted: localStorage.getItem('conditionsAccepted') === 'true' || false,
    identificationValid: localStorage.getItem('identificationValid') === 'true' || false,
    typeSelected: localStorage.getItem('typeSelected') === 'true' || false,
    positionSelected: localStorage.getItem('positionSelected') === 'true' || false,
    paiementValid: localStorage.getItem('paiementValid') === 'true' || false,
    souscriptionData: {
        operation: null,
        conditions: null,
        identification: null,
        typeParcelle: null,
        parcelle: null,
        paiement: null
    },
    init() {
        // Récupérer les données de l'opération du localStorage
        const operationData = localStorage.getItem('operation');
        if (!operationData) {
            alert('Veuillez d\'abord sélectionner une opération.');
            window.location.href = 'index.php?page=souscrire';
            return;
        }
        
        this.souscriptionData.operation = JSON.parse(operationData);
        
        // Récupérer les conditions de l'opération sélectionnée via AJAX
        fetch('api/operations.php?action=get_conditions&id=' + this.souscriptionData.operation.id)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                console.log(data.condition);
                    this.souscriptionData.operation.condition = data.condition;
                    // Mettre à jour l'opération dans le localStorage avec les conditions
                    localStorage.setItem('operation', JSON.stringify(this.souscriptionData.operation));
                } else {
                    console.error('Erreur lors de la récupération des conditions:', data.message);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
    },
    acceptConditions() {
        if (!this.souscriptionData.operation) {
            alert('Veuillez d\'abord sélectionner une opération');
            return;
        }
        
        this.souscriptionData.conditions = {
            acceptees: true,
            date_acceptation: new Date().toISOString(),
            operation_id: this.souscriptionData.operation.id
        };
        
        localStorage.setItem('conditions', JSON.stringify(this.souscriptionData.conditions));
        localStorage.setItem('conditionsAccepted', 'true');
        
        // Mettre à jour l'étape
        this.etape = 3;
        this.maxEtape = Math.max(this.maxEtape, 3);
        localStorage.setItem('currentEtape', '3');
        localStorage.setItem('maxEtape', this.maxEtape.toString());
        
        // Rediriger vers l'étape suivante
        window.location.href = 'index.php?page=identification';
    }
}">
    <!-- Étapes de progression - AJUSTÉ POUR 5 ÉTAPES -->
    <div class="mb-6 sm:mb-10">
        <div class="flex justify-center items-center space-x-1 sm:space-x-4">
            <!-- Étape 1 : Site -->
            <div class="flex flex-col items-center">
                <button @click="window.location.href = 'index.php?page=souscrire'"
                    class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold shadow-lg transition-all duration-300 text-white cursor-pointer hover:scale-105"
                    style="background-color: #FF6F00;">1</button>
                <span class="mt-1 sm:mt-2 text-xs sm:text-sm font-medium" style="color: #FF6F00;">Site</span>
            </div>
            <div class="w-4 sm:w-16 h-0.5 sm:h-1 rounded" style="background-color: #FF6F00;"></div>

            <!-- Étape 2 : Conditions -->
            <div class="flex flex-col items-center">
                <div class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold shadow-lg transition-all duration-300 text-white animate-pulse transform scale-125"
                    style="background-color: #FF6F00;">2
                </div>
                <span class="mt-1 sm:mt-2 text-xs sm:text-sm font-medium" style="color: #FF6F00;">Conditions</span>
            </div>
            <div class="w-4 sm:w-16 h-0.5 sm:h-1 bg-gray-300 rounded"></div>

            <!-- Étape 3 : Identification -->
            <div class="flex flex-col items-center">
                <div
                    class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold shadow-lg transition-all duration-300 bg-gray-300 text-gray-600 cursor-not-allowed">
                    3</div>
                <span class="mt-1 sm:mt-2 text-xs sm:text-sm font-medium text-gray-500">Identification</span>
            </div>
            <div class="w-4 sm:w-16 h-0.5 sm:h-1 bg-gray-300 rounded"></div>

            <!-- Étape 4 : Parcelle (Fusionné Type + Position) -->
            <div class="flex flex-col items-center">
                <div
                    class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold shadow-lg transition-all duration-300 bg-gray-300 text-gray-600 cursor-not-allowed">
                    4</div>
                <span class="mt-1 sm:mt-2 text-xs sm:text-sm font-medium text-gray-500">Parcelle</span>
            </div>
            <div class="w-4 sm:w-16 h-0.5 sm:h-1 bg-gray-300 rounded"></div>

            <!-- Étape 5 : Paiement -->
            <div class="flex flex-col items-center">
                <div
                    class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold shadow-lg transition-all duration-300 bg-gray-300 text-gray-600 cursor-not-allowed">
                    5</div>
                <span class="mt-1 sm:mt-2 text-xs sm:text-sm font-medium text-gray-500">Paiement</span>
            </div>
        </div>
    </div>

    <!-- Boutons de navigation -->
    <div class="flex justify-between items-center mt-4 sm:mt-8 max-w-4xl mx-auto px-2 sm:px-0">
        <!-- Bouton Précédent -->
        <button @click="window.location.href = 'index.php?page=souscrire'"
            class="px-3 sm:px-6 py-2 sm:py-3 text-white rounded-lg flex items-center transition-all duration-300 text-xs sm:text-base"
            style="background-color: #FF6F00;">
            <i class="fas fa-arrow-left mr-1 sm:mr-2"></i>
            Précédent
        </button>

        <!-- Messages d'erreur -->
        <div class="text-center mx-2 sm:mx-4 hidden sm:block">
            <div x-show="!conditionsAccepted" class="text-red-600 text-xs sm:text-sm">
                <i class="fas fa-exclamation-circle mr-1"></i>
                Veuillez accepter les conditions
            </div>
        </div>

        <!-- Bouton Suivant (désactivé tant que les conditions ne sont pas acceptées) -->
        <button @click="conditionsAccepted ? window.location.href = 'index.php?page=identification' : null"
            :class="conditionsAccepted ? 'hover:bg-opacity-90' : 'opacity-50 cursor-not-allowed bg-gray-400'"
            class="px-3 sm:px-6 py-2 sm:py-3 text-white rounded-lg flex items-center transition-all duration-300 text-xs sm:text-base"
            :style="conditionsAccepted ? 'background-color: #FF6F00;' : ''">
            <span>Suivant</span>
            <i class="fas fa-arrow-right ml-1 sm:ml-2"></i>
        </button>
    </div>

    <div class=" align-center justify-center bg-white rounded-lg shadow-md p-6 w-full max-w-4xl mx-auto mt-8 sm:mt-12">
        <div class="w-full justify-center flex flex-wrap gap-4 text-sm text-gray-600  mb-4">
            <div>
                <i class="fas fa-map-marker-alt mr-2" style="color: #FF6F00;"></i>
                <span x-text="souscriptionData.operation.localite || 'Localité non spécifiée'">Abidjan</span>
            </div>
            <div>
                <i class="fas fa-calendar-alt mr-2" style="color: #FF6F00;"></i>
                <span
                    x-text="'Jusqu\'au ' + (souscriptionData.operation.date_fin ? new Date(souscriptionData.operation.date_fin).toLocaleDateString('fr-FR') : 'Non spécifiée')">Jusqu'au
                    30/10/2026</span>
            </div>
            <div>
                <i class="fas fa-money-bill-wave mr-2" style="color: #FF6F00;"></i>
                <span
                    x-text="'Frais: ' + (souscriptionData.operation.montant_souscription ? formatNumber(parseFloat(souscriptionData.operation.montant_souscription)) + ' FCFA' : '50 000 FCFA')">Frais: 50 000 FCFA</span>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="prose max-h-96 overflow-y-auto px-4" style="scrollbar-width: thin;">
                <!-- Vérifier si une opération est sélectionnée -->
                <template x-if="!souscriptionData.operation">
                    <p class="text-gray-500 text-center">Veuillez d'abord sélectionner une opération</p>
                </template>

                <!-- Afficher les conditions de l'opération sélectionnée -->
                <template x-if="souscriptionData.operation && souscriptionData.operation.condition">
                    <div>
                        <div class="mb-6">
                            <h3 class="text-xl font-bold mb-2" style="color: #FF6F00;"
                                x-text="souscriptionData.operation.intitule || 'Opération sélectionnée'"></h3>
                        </div>

                        <div class="space-y-6">

                            <!-- Conditions de souscription -->
                            <div class="bg-orange-50 p-4 rounded-lg">
                                <h4 class="font-bold text-lg mb-2" style="color: #FF6F00;">
                                    <i class="fas fa-check-circle mr-2"></i>Conditions de souscription
                                </h4>
                                <div class="text-gray-600"
                                    x-html="souscriptionData.operation.condition?.condition_souscription || 'Conditions en cours de chargement...'">
                                </div>
                            </div>

                            <!-- Méthode de souscription -->
                            <div class="bg-orange-50 p-4 rounded-lg">
                                <h4 class="font-bold text-lg mb-2" style="color: #FF6F00;">
                                    <i class="fas fa-random mr-2"></i>Méthode de souscription
                                </h4>
                                <div class="text-gray-600"
                                    x-html="souscriptionData.operation.condition?.methode_attribution || 'Méthode en cours de chargement...'">
                                </div>
                            </div>

                            <!-- Documents requis -->
                            <div class="bg-orange-50 p-4 rounded-lg">
                                <h4 class="font-bold text-lg mb-2" style="color: #FF6F00;">
                                    <i class="fas fa-file-alt mr-2"></i>Documents requis
                                </h4>
                                <div class="text-gray-600"
                                    x-html="souscriptionData.operation.condition?.documents_requis || 'Documents en cours de chargement...'">
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <!-- Contenu statique par défaut (affiché si pas de données dynamiques) -->
                <template x-if="!souscriptionData.operation || !souscriptionData.operation.condition">
                    <div>
                        <div class="mb-6">
                            <h3 class="text-xl font-bold mb-2" style="color: #FF6F00;"
                                x-text="souscriptionData.operation?.intitule || 'Vente de parcelles rurales - AFOR'">
                            </h3>
                        </div>

                        <div class="space-y-6">

                            <!-- Conditions de souscription -->
                            <div class="bg-orange-50 p-4 rounded-lg">
                                <h4 class="font-bold text-lg mb-2" style="color: #FF6F00;">
                                    <i class="fas fa-check-circle mr-2"></i>Conditions de souscription
                                </h4>
                                <div class="text-gray-600">
                                    <p><strong>Conditions de participation à l'acquisition d'une parcelle rurale :</strong>
                                    </p>

                                    <p>1. Toute souscription donne automatiquement droit à l'attribution d'une
                                        parcelle.
                                    </p>

                                    <p>2. Pour confirmer votre intérêt et sécuriser votre parcelle, vous devez
                                        procéder
                                        au paiement des frais de réservation pour la parcelle désirée.</p>

                                    <p>3. Les frais de réservation à régler sont de <strong>50 000 FCFA</strong> pour toutes les parcelles.</p>

                                    <p>4. Un reçu officiel vous sera délivré après paiement. Ce document devra être
                                        présenté lors du dépôt physique de votre dossier.</p>

                                    <p>5. Le solde restant du prix total de la parcelle devra être réglé dans un
                                        délai
                                        de douze (12) mois à compter de la date de vente. Le paiement peut
                                        s'effectuer
                                        par tranches.</p>

                                    <p>6. Vous disposez d'un délai de cinq (5) jours à compter de la date de votre
                                        souscription pour effectuer le paiement des frais de réservation.</p>

                                    <p><strong>Passé ce délai :</strong><br>
                                        – La souscription sera automatiquement annulée ;<br>
                                        – Une pénalité sera appliquée avant tout remboursement éventuel des frais
                                        engagés.</p>
                                </div>
                            </div>

                            <!-- Méthode de souscription -->
                            <div class="bg-orange-50 p-4 rounded-lg">
                                <h4 class="font-bold text-lg mb-2" style="color: #FF6F00;">
                                    <i class="fas fa-random mr-2"></i>Méthode de souscription
                                </h4>
                                <div class="text-gray-600">
                                    <p>La vente des parcelles rurales se fera par ordre d'arrivée et ce, dans la limite du
                                        stock disponible.</p>
                                </div>
                            </div>

                            <!-- Documents requis -->
                            <div class="bg-orange-50 p-4 rounded-lg">
                                <h4 class="font-bold text-lg mb-2" style="color: #FF6F00;">
                                    <i class="fas fa-file-alt mr-2"></i>Documents requis
                                </h4>
                                <div class="text-gray-600">
                                    <p>Pièces à fournir au plus tard le 22 Octobre 2025 :<br>- Le récépissé de
                                        souscription<br>- L'original et une copie du reçu fournis par notre service
                                        technique en ligne<br>- Trois (03) photocopies légalisées de la
                                        carte nationale d'identité ou du passeport en cours de validité (personne
                                        physique) ou de l'acte de naissance (enfant mineur), des Statuts et du RCCM
                                        (personne morale)<br>- Un timbre fiscal de cinq cent (1000) francs CFA.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Bouton d'acceptation -->
        <div class="mt-6">
            <button @click="acceptConditions()" class="w-full text-white py-2 px-4 rounded-lg"
                style="background-color: #FF6F00;">
                <i class="fas fa-check mr-2"></i>J'ai lu et j'accepte les conditions de l'opération
            </button>
        </div>
    </div>
</main>
<footer class="bg-gray-900 text-white mt-20">
    <div class="max-w-7xl mx-auto px-6 py-12 lg:px-8">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">
            <div>
                <h3 class="text-lg font-semibold mb-4">SOUSCRIPTION AFOR</h3>
                <p class="text-gray-400">
                    Agence Foncière Rurale, votre partenaire de confiance pour l'accès à la propriété foncière rurale en Côte d'Ivoire.
                </p>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4">Liens rapides</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="index.php?page=apropos" class="text-gray-400 hover:text-orange-300 transition-colors">
                            À propos
                        </a>
                    </li>
                    <li>
                        <a href="index.php?page=souscrire" class="text-gray-400 hover:text-orange-300 transition-colors">
                            Comment souscrire
                        </a>
                    </li>
                    <li>
                        <a href="index.php#pourquoi-nous" class="text-gray-400 hover:text-orange-300 transition-colors">
                            Pourquoi nous choisir
                        </a>
                    </li>
                    <li>
                        <a href="index.php?page=contact" class="text-gray-400 hover:text-orange-300 transition-colors">
                            Contact
                        </a>
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
                        class="text-gray-400 hover:text-orange-300 transition-colors" aria-label="Facebook" target="_blank"
                        rel="noopener noreferrer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
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