<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CÔTE D'IVOIRE - Agence Foncière Rurale</title>
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

    <main class="mx-auto max-w-7xl px-4 py-12">
        <!-- Section Hero -->
        <section id="accueil" class="flex flex-col md:flex-row items-center justify-between py-16 md:py-24">
            <div class="md:w-1/2 mb-10 md:mb-0">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">Réservez votre parcelle CÔTE D'IVOIRE en ligne</h1>
                <p class="text-lg text-gray-600 mb-8">Accédez à la propriété foncière simplement et rapidement en Côte
                    d'Ivoire.
                    Notre plateforme vous permet de souscrire à une parcelle depuis le confort de votre domicile.</p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="index.php?page=souscrire" class="btn-afor">
                        <i class="fas fa-home mr-2"></i>Souscrire maintenant
                    </a>
                    <a href="#comment-souscrire" class="btn-afor-outline">
                        <i class="fas fa-info-circle mr-2"></i>En savoir plus
                    </a>
                </div>
            </div>
            <div class="md:w-1/2">
                <img src="assets/images/AFOR3.png" alt="Terrains AFOR" class="rounded-lg shadow-xl w-full">
            </div>
        </section>

        <!-- Section Opérations -->
        <section class="py-12 md:py-20 bg-orange-50 -mx-4 px-4">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl font-bold text-center mb-12">Opérations en cours</h2>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div
                        class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:scale-105 card-orange">
                        <img src="assets/images/terrain1.jpg" alt="Vente de parcelles - Abidjan"
                            class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Vente de parcelles - Abidjan</h3>
                            <p class="text-gray-600 mb-4">Abidjan</p>
                            <div class="flex justify-between items-center">
                                <span class="text-orange-600 font-semibold">50 000 FCFA</span>
                                <a href="index.php?page=souscrire&operation=1" class="btn-afor text-sm">Souscrire</a>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:scale-105 card-orange">
                        <img src="assets/images/A vendre un terrain sur le prolongement de VDN à….jpeg" alt="Vente de parcelles - Bouaké"
                            class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Vente de parcelles - Bouaké</h3>
                            <p class="text-gray-600 mb-4">Bouaké</p>
                            <div class="flex justify-between items-center">
                                <span class="text-orange-600 font-semibold">50 000 FCFA</span>
                                <a href="index.php?page=souscrire&operation=2" class="btn-afor text-sm">Souscrire</a>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:scale-105 card-orange">
                        <img src="assets/images/terrain2.jpg"
                            alt="Vente de parcelles - Korhogo" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Vente de parcelles - Korhogo</h3>
                            <p class="text-gray-600 mb-4">Korhogo</p>
                            <div class="flex justify-between items-center">
                                <span class="text-orange-600 font-semibold">50 000 FCFA</span>
                                <a href="index.php?page=souscrire&operation=3" class="btn-afor text-sm">Souscrire</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section À propos -->
        <section id="apropos" class="py-12 md:py-20">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl font-bold text-center mb-12">À propos de CÔTE D'IVOIRE</h2>

                <div class="flex flex-col md:flex-row items-center gap-12">
                    <div class="md:w-1/2">
                        <img src="assets/images/AFOR1.png" alt="CÔTE D'IVOIRE" class="rounded-lg shadow-xl w-full">
                    </div>
                    <div class="md:w-1/2">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Notre mission</h3>
                        <p class="text-gray-600 mb-6">
                            CÔTE D'IVOIRE a pour mission principale de
                            faciliter l'accès à la propriété foncière rurale à travers l'aménagement et la
                            commercialisation de
                            parcelles viabilisées dans les zones rurales ivoiriennes.
                        </p>
                        <p class="text-gray-600 mb-6">
                            Sous la tutelle du Ministère de l'Agriculture et du Développement Rural, CÔTE D'IVOIRE œuvre pour la
                            promotion
                            du développement rural et l'aménagement foncier en Côte d'Ivoire. Notre expertise nous
                            permet de proposer des
                            terrains adaptés à tous les projets agricoles et résidentiels en milieu rural.
                        </p>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div
                                    class="flex-shrink-0 h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center">
                                    <i class="fas fa-map-marker-alt text-orange-600"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-800">Terrains ruraux viabilisés</h4>
                                    <p class="text-gray-600">Parcelles prêtes à l'exploitation avec accès aux réseaux
                                        essentiels</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div
                                    class="flex-shrink-0 h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center">
                                    <i class="fas fa-file-signature text-orange-600"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-800">Sécurité juridique</h4>
                                    <p class="text-gray-600">Titres fonciers garantis et procédures transparentes</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div
                                    class="flex-shrink-0 h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center">
                                    <i class="fas fa-handshake text-orange-600"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-800">Accompagnement personnalisé</h4>
                                    <p class="text-gray-600">Suivi administratif et technique tout au long de votre
                                        projet</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Comment souscrire -->
        <section id="comment-souscrire" class="py-12 md:py-20 bg-orange-50 -mx-4 px-4">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl font-bold text-center mb-12">Comment souscrire à une parcelle</h2>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow-md text-center card-orange">
                        <div class="bg-orange-100 mx-auto h-16 w-16 rounded-full flex items-center justify-center mb-4">
                            <span class="text-2xl font-bold text-orange-600">1</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Choisissez un site</h3>
                        <p class="text-gray-600">Sélectionnez l'opération qui correspond à vos besoins parmi nos
                            différents sites disponibles en Côte d'Ivoire.</p>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md text-center card-orange">
                        <div class="bg-orange-100 mx-auto h-16 w-16 rounded-full flex items-center justify-center mb-4">
                            <span class="text-2xl font-bold text-orange-600">2</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Complétez votre identification</h3>
                        <p class="text-gray-600">Fournissez vos informations personnelles ou celles de votre entreprise
                            pour créer votre dossier.</p>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md text-center card-orange">
                        <div class="bg-orange-100 mx-auto h-16 w-16 rounded-full flex items-center justify-center mb-4">
                            <span class="text-2xl font-bold text-orange-600">3</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Sélectionnez votre parcelle</h3>
                        <p class="text-gray-600">Choisissez le type de parcelle et l'emplacement qui conviennent à votre
                            projet.</p>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md text-center card-orange">
                        <div class="bg-orange-100 mx-auto h-16 w-16 rounded-full flex items-center justify-center mb-4">
                            <span class="text-2xl font-bold text-orange-600">4</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Effectuez le paiement</h3>
                        <p class="text-gray-600">Payez les frais de souscription par mobile money et recevez votre
                            quittance.</p>
                    </div>
                </div>

                <div class="text-center mt-12">
                    <a href="index.php?page=souscrire" class="btn-afor">
                        <i class="fas fa-check-circle mr-2"></i>Je commence ma souscription
                    </a>
                </div>
            </div>
        </section>

        <!-- Section Pourquoi nous choisir -->
        <section id="pourquoi-nous" class="py-12 md:py-20">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl font-bold text-center mb-12">Pourquoi choisir CÔTE D'IVOIRE</h2>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="flex flex-col items-center text-center">
                        <div class="h-20 w-20 bg-orange-100 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-shield-alt text-3xl text-orange-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Sécurité juridique</h3>
                        <p class="text-gray-600">Tous nos terrains disposent d'une documentation légale complète, vous
                            assurant une sécurité juridique totale pour votre investissement en Côte d'Ivoire.</p>
                    </div>

                    <div class="flex flex-col items-center text-center">
                        <div class="h-20 w-20 bg-orange-100 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-road text-3xl text-orange-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Terrains viabilisés</h3>
                        <p class="text-gray-600">Nos parcelles rurales sont aménagées avec des voies d'accès et
                            prédisposées au
                            raccordement aux réseaux d'eau et d'électricité.</p>
                    </div>

                    <div class="flex flex-col items-center text-center">
                        <div class="h-20 w-20 bg-orange-100 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-hand-holding-usd text-3xl text-orange-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Prix compétitifs</h3>
                        <p class="text-gray-600">Nous proposons des parcelles rurales à des tarifs accessibles avec des
                            options
                            de paiement adaptées à vos possibilités.</p>
                    </div>
                </div>

                <div class="bg-orange-50 p-8 rounded-lg shadow-md mt-16 flex flex-col md:flex-row items-center">
                    <div class="md:w-1/2 mb-8 md:mb-0 md:pr-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Ils nous font confiance</h3>
                        <p class="text-gray-600 mb-4">
                            Rejoignez les milliers d'agriculteurs, d'éleveurs et d'entreprises ivoiriennes qui ont fait
                            confiance à CÔTE D'IVOIRE
                            pour leur projet en milieu rural. Notre expérience et notre professionnalisme font de nous
                            le
                            partenaire idéal pour concrétiser votre rêve d'accès à la propriété foncière rurale.
                        </p>
                        <div class="flex items-center">
                            <span class="ml-4 text-sm text-gray-500">Plus de 3 000 clients satisfaits</span>
                        </div>
                    </div>
                    <div class="md:w-1/2 grid grid-cols-2 gap-4">
                        <div class="bg-white p-4 rounded-lg card-orange">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                            </div>
                            <p class="text-gray-600 text-sm">"Processus simple et rapide. J'ai pu acquérir ma parcelle
                                agricole en toute sécurité."</p>
                            <p class="text-gray-800 font-medium mt-2">- Kouamé A.</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg card-orange">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                            </div>
                            <p class="text-gray-600 text-sm">"Un excellent accompagnement du début à la fin. Merci CÔTE D'IVOIRE
                                !"</p>
                            <p class="text-gray-800 font-medium mt-2">- Aïcha T.</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg card-orange">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star-half-alt text-yellow-400"></i>
                            </div>
                            <p class="text-gray-600 text-sm">"Des parcelles bien situées et un personnel professionnel."
                            </p>
                            <p class="text-gray-800 font-medium mt-2">- Jean-Baptiste K.</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg card-orange">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                            </div>
                            <p class="text-gray-600 text-sm">"La meilleure décision que j'ai prise pour investir dans
                                l'agriculture."</p>
                            <p class="text-gray-800 font-medium mt-2">- Fatou D.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Contact -->
        <section id="contact" class="py-12 md:py-20 bg-orange-50 -mx-4 px-4">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl font-bold text-center mb-12">Contactez-nous</h2>

                <div class="grid md:grid-cols-2 gap-12">
                    <div>
                        <div class="bg-white p-8 rounded-lg shadow-md card-orange">
                            <h3 class="text-xl font-bold text-gray-800 mb-6">Envoyez-nous un message</h3>

                            <form action="index.php?page=contact" method="post" class="space-y-4">
                                <div>
                                    <label for="nom" class="block text-gray-700 mb-2">Nom complet</label>
                                    <input type="text" id="nom" name="nom"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500"
                                        required>
                                </div>

                                <div>
                                    <label for="email" class="block text-gray-700 mb-2">Adresse e-mail</label>
                                    <input type="email" id="email" name="email"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500"
                                        required>
                                </div>

                                <div>
                                    <label for="telephone" class="block text-gray-700 mb-2">Téléphone</label>
                                    <input type="tel" id="telephone" name="telephone"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500"
                                        required>
                                </div>

                                <div>
                                    <label for="sujet" class="block text-gray-700 mb-2">Sujet</label>
                                    <input type="text" id="sujet" name="sujet"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500"
                                        required>
                                </div>

                                <div>
                                    <label for="message" class="block text-gray-700 mb-2">Message</label>
                                    <textarea id="message" name="message" rows="4"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500"
                                        required></textarea>
                                </div>

                                <button type="submit" class="btn-afor w-full">
                                    <i class="fas fa-paper-plane mr-2"></i>Envoyer le message
                                </button>
                            </form>
                        </div>
                    </div>

                    <div>
                        <div class="bg-white p-8 rounded-lg shadow-md mb-8 card-orange">
                            <h3 class="text-xl font-bold text-gray-800 mb-6">Coordonnées</h3>

                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center">
                                        <i class="fas fa-map-marker-alt text-orange-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-medium text-gray-800">Adresse</h4>
                                        <p class="text-gray-600">Ministère de l'Agriculture et du Développement Rural,
                                            Abidjan</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center">
                                        <i class="fas fa-phone-alt text-orange-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-medium text-gray-800">Téléphone</h4>
                                        <p class="text-gray-600">+225 05 96 58 28 65</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center">
                                        <i class="fas fa-envelope text-orange-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-medium text-gray-800">Email</h4>
                                        <p class="text-gray-600">contact@afor.ci</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center">
                                        <i class="fas fa-clock text-orange-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-medium text-gray-800">Heures d'ouverture</h4>
                                        <p class="text-gray-600">Lundi - Vendredi: 8h00 - 17h00</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Carte Google Maps -->
                        <div class="bg-white p-4 rounded-lg shadow-md card-orange">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Notre localisation</h3>
                            <div class="map-container">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.159685693286!2d-4.008949!3d5.3599517!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xfc1eb6d5c5c5c5c%3A0x5c5c5c5c5c5c5c5c!2sMinist%C3%A8re%20de%20l&#39;Agriculture%20et%20du%20D%C3%A9veloppement%20Rural%2C%20Abidjan%2C%20C%C3%B4te%20d&#39;Ivoire!5e0!3m2!1sfr!2sci!4v1758534712892!5m2!1sfr!2sci"
                                    width="600" height="350" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-gray-900 text-white mt-20">
        <div class="max-w-7xl mx-auto px-6 py-12 lg:px-8">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">
                <div>
                    <h3 class="text-lg font-semibold mb-4">SOUSCRIPTION CÔTE D'IVOIRE</h3>
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

        // Empêcher la perte des données lors du rafraîchissement
        window.addEventListener('beforeunload', function (e) {
            // Si on est dans le processus de souscription (étapes 1 à 6)
            const currentEtape = parseInt(localStorage.getItem('currentEtape') || '0');
            if (currentEtape > 0 && currentEtape < 7) {
                return;
            }
        });
    </script>

</body>

</html>