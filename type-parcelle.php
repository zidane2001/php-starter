<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AFOR - Agence Foncière Rurale</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.0/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="assets/images/logo_MCLU.png" type="image/png">
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

        /* Styles réduits pour interface plus compacte */
        .btn-compact {
            font-size: 16px;
            padding: 16px 24px;
            min-height: 50px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .btn-compact:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .type-card-compact {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
            min-height: 140px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .type-card-compact:hover {
            border-color: #FF6F00;
            box-shadow: 0 4px 16px rgba(255, 111, 0, 0.15);
            transform: translateY(-2px);
        }

        .type-card-compact.selected {
            border-color: #FF6F00;
            background: #FFF3E0;
            box-shadow: 0 4px 16px rgba(255, 111, 0, 0.2);
        }

        .parcelle-grid {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .parcelle-grid:hover {
            border-color: #FF6F00;
            box-shadow: 0 2px 8px rgba(255, 111, 0, 0.1);
        }

        .parcelle-grid.selected {
            border-color: #FF6F00;
            background: #FFF3E0;
        }

        .section-compact {
            background: white;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        }

        .section-title-compact {
            font-size: 20px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 16px;
            text-align: center;
        }

        .zone-badge {
            display: inline-block;
            background: #FF6F00;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        @media (max-width: 640px) {
            .btn-compact {
                font-size: 14px;
                padding: 12px 20px;
                min-height: 45px;
            }

            .type-card-compact {
                padding: 16px;
                min-height: 120px;
            }

            .section-title-compact {
                font-size: 18px;
            }

            .section-compact {
                padding: 16px;
            }
        }

        /* Icônes avec couleur orange */
        .icon-orange {
            color: #FF6F00;
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

    <main class="max-w-6xl mx-auto px-4 py-8" x-data="parcelleSimple">
        <!-- Étapes de progression - FORMAT STANDARD -->
        <div class="mb-6 sm:mb-10">
            <div class="flex justify-center items-center space-x-1 sm:space-x-4">
                <!-- Étape 1 : Site -->
                <div class="flex flex-col items-center">
                    <button @click="window.location.href = 'index.php?page=souscrire'"
                        class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold shadow-lg transition-all duration-300 text-white"
                        style="background-color: #FF6F00;" cursor-pointer="" hover:scale-105"="">1</button>
                    <span class="mt-1 sm:mt-2 text-[10px] sm:text-xs font-medium " style="color: #FF6F00;">Site</span>
                </div>
                <div class="w-4 sm:w-16 h-0.5 sm:h-1 rounded" style="background-color: #FF6F00;"></div>

                <!-- Étape 2 : Conditions -->
                <div class="flex flex-col items-center">
                    <button @click="window.location.href = 'index.php?page=conditions'"
                        class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold shadow-lg transition-all duration-300 text-white"
                        style="background-color: #FF6F00;" cursor-pointer="" hover:scale-105"="">2</button>
                    <span class="mt-1 sm:mt-2 text-[10px] sm:text-xs font-medium "
                        style="color: #FF6F00;">Conditions</span>
                </div>
                <div class="w-4 sm:w-16 h-0.5 sm:h-1 rounded" style="background-color: #FF6F00;"></div>

                <!-- Étape 3 : Identification -->
                <div class="flex flex-col items-center">
                    <button @click="window.location.href = 'index.php?page=identification'"
                        class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold shadow-lg transition-all duration-300 text-white"
                        style="background-color: #FF6F00;" cursor-pointer="" hover:scale-105"="">3</button>
                    <span class="mt-1 sm:mt-2 text-[10px] sm:text-xs font-medium "
                        style="color: #FF6F00;">Identification</span>
                </div>
                <div class="w-4 sm:w-16 h-0.5 sm:h-1 rounded" style="background-color: #FF6F00;"></div>

                <!-- Étape 4 : Parcelle -->
                <div class="flex flex-col items-center">
                    <div class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold shadow-lg transition-all duration-300 text-white"
                        style="background-color: #FF6F00;" animate-[pulse_0.7s_ease-in-out_infinite]="" scale-125"="">4
                    </div>
                    <span class="mt-1 sm:mt-2 text-[10px] sm:text-xs font-medium "
                        style="color: #FF6F00;">Parcelle</span>
                </div>
                <div class="w-4 sm:w-16 h-0.5 sm:h-1 bg-gray-300 rounded"></div>

                <!-- Étape 6 : Paiement -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold shadow-lg transition-all duration-300 bg-gray-300 text-gray-600 cursor-not-allowed">
                        5</div>
                    <span class="mt-1 sm:mt-2 text-[10px] sm:text-xs font-medium text-gray-500">Paiement</span>
                </div>
            </div>
        </div>

        <!-- Boutons de navigation - FORMAT STANDARD -->
        <div class="flex justify-between items-center mt-4 sm:mt-8 max-w-4xl mx-auto px-2 sm:px-0">
            <!-- Bouton Précédent -->
            <button @click="window.location.href = 'index.php?page=identification'"
                class="px-3 sm:px-6 py-2 sm:py-3 text-white"
                style="background-color: #FF6F00;" rounded-lg="" flex="" items-center="" transition-all="" duration-300="" text-xs="" sm:text-base"="">
                <i class="fas fa-arrow-left mr-1 sm:mr-2"></i>
                Précédent
            </button>

            <!-- Messages d'erreur -->
            <div class="text-center mx-2 sm:mx-4 hidden sm:block">
                <div x-show="!selectedParcelle" class="text-red-600 text-xs sm:text-sm" style="display: none;">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    Veuillez sélectionner une parcelle
                </div>
            </div>

            <!-- Bouton Suivant -->
            <button @click="finalizeSelection()"
                :class="selectedParcelle ? ' ' : 'opacity-50 cursor-not-allowed bg-gray-400'"
                class="px-3 sm:px-6 py-2 sm:py-3 text-white" style="background-color: #FF6F00;" rounded-lg="" flex=""
                items-center="" transition-all="" duration-300="" text-xs="" sm:text-base"="">
                <span>Suivant</span>
                <i class="fas fa-arrow-right ml-1 sm:ml-2"></i>
            </button>
        </div>

        <!-- Message d'information compact -->
        <div class="mt-8 mb-6 border-l-4 border-gray-300 p-4 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-info-circle" style="color: #FF6F00;" mr-2="" text-lg"=""></i>
                <div>
                    <h3 class="text-lg font-semibold" style="color: #FF6F00;">Choisissez votre parcelle</h3>
                    <p style="color: #FF6F00;">Sélectionnez d'abord le type d'habitation, puis choisissez votre
                        parcelle.</p>
                </div>
            </div>
        </div>

        <!-- SECTION 1: Type de Parcelle -->
        <div x-show="step === 1" class="section-compact" style="display: none;">
            <div class="section-title-compact">
                <i class="fas fa-home" style="color: #FF6F00;" mr-2"=""></i>
                Type de parcelle
            </div>

            <div x-show="loading" class="text-center py-8" style="display: none;">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-4 border-b-4 border-gray-300">
                </div>
                <p class="mt-4 text-gray-600">Chargement...</p>
            </div>

            <!-- Grid de types -->
            <div x-show="!loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" style="">
                <template x-for="type in typesParcelles" :key="type.id">
                    <div @click="selectTypeAndNext(type)" :class="{'selected': selectedType?.id === type.id}"
                        class="type-card-compact">

                        <div class="mb-3">
                            <i class="fas fa-home text-2xl" style="color: #FF6F00;" mb-2"=""></i>
                            <h3 class="text-lg font-bold" x-text="type.nom"></h3>
                        </div>

                        <div class="text-xl" style="color: #FF6F00;" x-text="type.description"></div>

                        <div x-show="selectedType?.id === type.id" class="mt-2">
                            <i class="fas fa-check-circle" style="color: #FF6F00;" text-xl"=""></i>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- SECTION 2: Parcelles avec zones -->
        <div x-show="step === 2" class="section-compact">
            <div class="section-title-compact">
                <i class="fas fa-th-large" style="color: #FF6F00;" mr-2"=""></i>
                Parcelles disponibles
            </div>

            <!-- Résumé compact -->
            <div class="border border-gray-300 rounded-lg p-3 mb-6 text-center">
                <span style="color: #FF6F00;" font-medium"="">Type: </span>
                <span style="color: #FF6F00;" x-text="selectedType?.nom">Habitation</span>
                <button @click="step = 1" class="ml-3" style="color: #FF6F00;" hover:"="" text-sm"="">
                    <i class="fas fa-edit"></i> Modifier
                </button>
            </div>

            <div x-show="loading" class="text-center py-8" style="display: none;">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-4 border-b-4 border-gray-300">
                </div>
                <p class="mt-4 text-gray-600">Chargement des parcelles...</p>
            </div>

            <!-- Aucune parcelle -->
            <div x-show="!loading &amp;&amp; parcelles.length === 0" class="text-center py-8" style="display: none;">
                <i class="fas fa-exclamation-circle text-gray-400 text-4xl mb-4"></i>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Aucune parcelle trouvée</h3>
                <button @click="step = 1" class="btn-compact text-white" style="background-color: #FF6F00;">
                    Changer de type
                </button>
            </div>

            <!-- Grid de parcelles avec zones -->
            <div x-show="!loading &amp;&amp; parcelles.length &gt; 0" style="">
                <p class="text-center text-lg text-gray-600 mb-6">
                    <span x-text="parcelles.length">1050</span> parcelle(s) disponible(s)
                </p>

                <!-- Grid responsive -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <template x-for="parcelle in parcelles.slice(0, showAllParcelles ? parcelles.length : 6)"
                        :key="parcelle.id">
                        <div @click="selectParcelleAndNext(parcelle)"
                            :class="{'selected': selectedParcelle?.id === parcelle.id}" class="parcelle-grid">

                            <!-- Badge de zone -->
                            <div class="zone-badge" x-text="parcelle.zone_nom"></div>

                            <!-- En-tête avec numéro et check -->
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="text-lg font-bold text-gray-800">
                                    <span
                                        x-text="parcelle.section + '-' + parcelle.lot + '-' + parcelle.parcelle"></span>
                                </h4>
                                <div x-show="selectedParcelle?.id === parcelle.id" style="color: #FF6F00;">
                                    <i class="fas fa-check-circle text-xl"></i>
                                </div>
                            </div>

                            <!-- Infos en grid -->
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div>
                                    <span class="text-gray-500">Surface:</span>
                                    <div class="font-semibold" x-text="formatNumber(parcelle.surface) + ' m²'"></div>
                                </div>
                                <div>
                                    <span class="text-gray-500">Prix/m²:</span>
                                    <div class="font-semibold" x-text="formatNumber(parcelle.cout_unitaire)"></div>
                                </div>
                                <div class="col-span-2">
                                    <span class="text-gray-500">Prix total:</span>
                                    <div class="font-bold" style="color: #FF6F00;" text-lg"=""
                                        x-text="formatNumber(parcelle.prix) + ' FCFA'"></div>
                                </div>
                            </div>

                            <!-- Bouton sélection -->
                            <div class="mt-3">
                                <button @click.stop="selectParcelleAndNext(parcelle)"
                                    :class="selectedParcelle?.id === parcelle.id ? 'bg-orange-600' : 'bg-green-700' "
                                    class="w-full btn-compact text-white hover:opacity-90">
                                    <span
                                        x-text="selectedParcelle?.id === parcelle.id ? 'Sélectionnée' : 'Choisir'"></span>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Bouton "Voir plus" -->
                <div x-show="parcelles.length &gt; 6 &amp;&amp; !showAllParcelles" class="text-center mt-6" style="">
                    <button @click="showAllParcelles = true"
                        class="btn-compact bg-gray-600 text-white hover:bg-gray-700">
                        Voir tout (<span x-text="parcelles.length">1050</span>)
                        <i class="fas fa-chevron-down ml-1"></i>
                    </button>
                </div>

                <div x-show="showAllParcelles &amp;&amp; parcelles.length &gt; 6" class="text-center mt-6"
                    style="display: none;">
                    <button @click="showAllParcelles = false; window.scrollTo({top: 0, behavior: 'smooth'})"
                        class="btn-compact bg-gray-600 text-white hover:bg-gray-700">
                        Voir moins
                        <i class="fas fa-chevron-up ml-1"></i>
                    </button>
                </div>
            </div>

            <div class="text-center mt-6">
                <button @click="step = 1" class="btn-compact bg-gray-200 text-gray-800 hover:bg-gray-300">
                    <i class="fas fa-arrow-left mr-2"></i>Retour
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
                        Agence Foncière Rurale, votre partenaire de confiance pour l'accès à la
                        propriété foncière rurale en Côte d'Ivoire.
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Liens rapides</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="index.php?page=apropos" class="text-gray-400 hover:text-orange-300 transition-colors">À
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

        document.addEventListener("DOMContentLoaded", function () {
            const identificationValid = localStorage.getItem("identificationValid");
            if (identificationValid !== "true") {
                alert("Veuillez d'abord compléter votre identification.");
                window.location.href = "index.php?page=identification";
            }
        });
    </script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('parcelleSimple', () => {
                return {
                    // Navigation simplifiée (seulement 2 étapes maintenant)
                    step: 1,

                    // Données
                    operation: null,
                    typesParcelles: [],
                    parcelles: [],

                    // Sélections
                    selectedType: null,
                    selectedParcelle: null,

                    // États
                    loading: false,
                    showAllParcelles: false,

                    init() {
                        // Récupérer l'opération
                        const operationData = localStorage.getItem('operation');
                        if (!operationData) {
                            alert('Veuillez d\'abord sélectionner une opération.');
                            window.location.href = 'index.php?page=souscrire';
                            return;
                        }

                        this.operation = JSON.parse(operationData);

                        this.loadSavedData();
                        this.loadTypesParcelles();
                    },

                    loadSavedData() {

                        const typeData = localStorage.getItem('typeParcelle');
                        if (typeData) {
                            this.selectedType = JSON.parse(typeData);
                        }

                        const parcelleData = localStorage.getItem('parcelleChoisie');
                        if (parcelleData) {
                            this.selectedParcelle = JSON.parse(parcelleData);
                            if (this.selectedParcelle && this.selectedType) {
                                this.step = 2;
                                this.loadParcelles();
                            }
                        }
                    },

                    async loadTypesParcelles() {
                        this.loading = true;
                        try {
                            const response = await fetch(`https://urbantrade.tradexbot.fun/api/operations.php?action=get_types_parcelles&id=${this.operation.id}`);
                            const data = await response.json();
                            if (data.success) {
                                this.typesParcelles = data.types;
                            } else {
                                alert('Erreur lors du chargement des types de parcelles');
                            }
                        } catch (error) {
                            console.log('An error occurs ', error);
                            // alert('Erreur de communication avec le serveur');
                        } finally {
                            this.loading = false;
                        }
                    },

                    async loadParcelles() {
                        this.loading = true;
                        try {
                            console.log('Chargement des parcelles pour le type:', this.selectedType.id);
                            console.log('Opération:', this.operation.id);
                            // Nouvelle URL pour récupérer toutes les parcelles d'un type avec leurs zones
                            const url = `https://urbantrade.tradexbot.fun/api/parcelles.php?action=get_parcelles_by_type&operation_id=${this.operation.id}&type_parcelle_id=${this.selectedType.id}`;
                            const response = await fetch(url);
                            const data = await response.json();
                            console.log('Réponse des parcelles:', data);
                            if (data.success) {
                                this.parcelles = data.parcelles.map(parcelle => ({
                                    ...parcelle,
                                    statut: 'disponible'
                                }));
                            } else {
                                this.parcelles = [];
                            }
                        } finally {
                            this.loading = false;
                        }
                    },

                    // Sélectionner type et charger les parcelles
                    async selectTypeAndNext(type) {
                        this.selectedType = type;
                        this.autoSave();

                        // Réinitialiser la sélection de parcelle
                        this.selectedParcelle = null;

                        // Passer automatiquement à l'étape parcelles
                        this.step = 2;
                        await this.loadParcelles();
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    },

                    // Sélectionner parcelle et rediriger
                    selectParcelleAndNext(parcelle) {
                        console.log('Sélection parcelle et redirection:', parcelle);

                        this.selectedParcelle = {
                            id: parcelle.id,
                            section: parcelle.section,
                            lot: parcelle.lot,
                            parcelle: parcelle.parcelle,
                            surface: parcelle.surface,
                            coutUnitaire: parcelle.cout_unitaire,
                            prix: parcelle.prix,
                            acompte: Math.min(parcelle.prix * 0.3, 1000000),
                            resteAPayer: parcelle.prix - Math.min(parcelle.prix * 0.3, 1000000),
                            zone: parcelle.zone_nom,
                            statut: 'disponible',
                            typeParcelle: {
                                id: this.selectedType.id,
                                nom: this.selectedType.nom
                            }
                        };

                        this.autoSave();

                        // Redirection automatique après 500ms
                        setTimeout(() => {
                            this.finalizeSelection();
                        }, 500);
                    },

                    autoSave() {
                        if (this.selectedType) {
                            localStorage.setItem('typeParcelle', JSON.stringify(this.selectedType));
                            localStorage.setItem('typeSelected', 'true');
                        }

                        if (this.selectedParcelle) {
                            localStorage.setItem('parcelleChoisie', JSON.stringify(this.selectedParcelle));
                            localStorage.setItem('positionSelected', 'true');
                        }
                    },

                    finalizeSelection() {
                        if (!this.selectedParcelle) {
                            alert('Veuillez sélectionner une parcelle');
                            return;
                        }

                        this.autoSave();

                        const maxEtape = Math.max(parseInt(localStorage.getItem('maxEtape') || '0'), 5);
                        localStorage.setItem('maxEtape', maxEtape.toString());
                        localStorage.setItem('currentEtape', '5');

                        window.location.href = 'index.php?page=paiement';
                    },

                    formatNumber(number) {
                        if (!number) return '0';
                        return new Intl.NumberFormat('fr-FR').format(number);
                    }
                };
            });
        });

        function formatNumber(number) {
            return new Intl.NumberFormat('fr-FR').format(number);
        }

        // Empêcher la perte des données lors du rafraîchissement
        window.addEventListener('beforeunload', function (e) {
            // Si on est dans le processus de souscription (étapes 1 à 5)
            const currentEtape = parseInt(localStorage.getItem('currentEtape') || '0');
            if (currentEtape > 0 && currentEtape < 7) {
                return;
            }
        });
    </script>

</body>

</html>