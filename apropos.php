<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À propos - AFOR Côte d'Ivoire</title>
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

        /* Styles spécifiques pour la page À propos */
        .mission-card {
            background: linear-gradient(135deg, #FF6F00 0%, #FF8F00 100%);
            color: white;
            border-radius: 15px;
            padding: 40px;
            margin-bottom: 40px;
        }

        .value-card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            height: 100%;
            border-top: 4px solid #FF6F00;
        }

        .value-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #FF6F00;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -38px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #FF6F00;
            border: 3px solid white;
            box-shadow: 0 0 0 3px #FF6F00;
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
                    <a href="index.php?page=apropos" class="text-white border-b-2 border-white transition py-2">À propos</a>
                    <a href="index.php?page=souscrire" class="text-white hover:text-orange-200 transition py-2">Comment souscrire</a>
                    <a href="index.php#pourquoi-nous" class="text-white hover:text-orange-200 transition py-2">Pourquoi nous choisir</a>
                    <a href="index.php?page=contact" class="text-white hover:text-orange-200 transition py-2">Contact</a>
                    <a href="index.php?page=recherche-quittance" class="text-white hover:text-orange-200 transition py-2">Rechercher une quittance</a>
                    <a href="index.php?page=souscrire" onclick="localStorage.clear()"
                        class="bg-white text-orange-600 px-6 py-2 rounded-lg hover:bg-orange-50 transition font-medium">Souscrire</a>
                </div>
            </div>

            <!-- Mobile menu -->
            <div class="hidden md:hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="index.php" class="block text-white hover:bg-orange-600 px-3 py-2 rounded-md">Accueil</a>
                    <a href="index.php?page=apropos" class="block text-white bg-orange-600 px-3 py-2 rounded-md">À propos</a>
                    <a href="index.php?page=souscrire" class="block text-white hover:bg-orange-600 px-3 py-2 rounded-md">Comment souscrire</a>
                    <a href="index.php#pourquoi-nous" class="block text-white hover:bg-orange-600 px-3 py-2 rounded-md">Pourquoi nous choisir</a>
                    <a href="index.php?page=contact" class="block text-white hover:bg-orange-600 px-3 py-2 rounded-md">Contact</a>
                    <a href="index.php?page=recherche-quittance" class="block text-white hover:bg-orange-600 px-3 py-2 rounded-md">Rechercher une quittance</a>
                    <a onclick="localStorage.clear()" href="index.php?page=souscrire"
                        class="block bg-white text-orange-600 px-3 py-2 rounded-md mt-4 text-center">Souscrire</a>
                </div>
            </div>
        </nav>
    </header>

    <div class="h-20"></div>

    <main class="mx-auto max-w-7xl px-4 py-12">
        <!-- Section Hero À propos -->
        <section class="py-16 md:py-24">
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">À propos de l'AFOR Côte d'Ivoire</h1>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Découvrez l'Agence Foncière Rurale, institution clé pour l'accès à la propriété foncière rurale en Côte d'Ivoire.
                </p>
            </div>
        </section>

        <!-- Section Mission et Vision -->
        <section class="py-12 md:py-20">
            <div class="max-w-7xl mx-auto">
                <div class="mission-card">
                    <div class="grid md:grid-cols-2 gap-8 items-center">
                        <div>
                            <h2 class="text-3xl font-bold mb-4">Notre Mission</h2>
                            <p class="text-lg mb-6">
                                L'AFOR a pour mission principale de faciliter l'accès sécurisé à la propriété foncière rurale 
                                pour tous les citoyens ivoiriens, à travers l'aménagement, la gestion et la commercialisation 
                                de parcelles viabilisées dans les zones rurales du pays.
                            </p>
                            <p class="text-lg">
                                Nous œuvrons pour une gestion transparente et efficace du domaine foncier rural de l'État, 
                                contribuant ainsi au développement agricole et économique de la Côte d'Ivoire.
                            </p>
                        </div>
                        <div class="text-center">
                            <i class="fas fa-bullseye text-6xl opacity-80"></i>
                        </div>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-8 mt-8">
                    <div class="value-card">
                        <div class="text-center mb-4">
                            <i class="fas fa-eye text-4xl text-orange-600 mb-3"></i>
                            <h3 class="text-xl font-bold text-gray-800">Notre Vision</h3>
                        </div>
                        <p class="text-gray-600">
                            Devenir la référence en matière de gestion foncière rurale en Afrique de l'Ouest, en offrant 
                            des services innovants et accessibles qui répondent aux besoins des populations rurales.
                        </p>
                    </div>
                    <div class="value-card">
                        <div class="text-center mb-4">
                            <i class="fas fa-chart-line text-4xl text-orange-600 mb-3"></i>
                            <h3 class="text-xl font-bold text-gray-800">Nos Objectifs</h3>
                        </div>
                        <ul class="text-gray-600 space-y-2">
                            <li>• Démocratiser l'accès à la propriété foncière rurale</li>
                            <li>• Moderniser la gestion du domaine rural de l'État</li>
                            <li>• Promouvoir un développement rural durable</li>
                            <li>• Assurer la sécurité juridique des transactions foncières</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Historique -->
        <section class="py-12 md:py-20 bg-orange-50 -mx-4 px-4">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl font-bold text-center mb-12">Notre Historique</h2>
                
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <div class="timeline">
                            <div class="timeline-item">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">2016</h3>
                                <p class="text-gray-600">Création de l'AFOR sous l'impulsion du Ministère de l'Agriculture et du Développement Rural</p>
                            </div>
                            <div class="timeline-item">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">2018</h3>
                                <p class="text-gray-600">Lancement des premières opérations de lotissement rural à Abidjan</p>
                            </div>
                            <div class="timeline-item">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">2020</h3>
                                <p class="text-gray-600">Extension des activités aux principales régions rurales de Côte d'Ivoire</p>
                            </div>
                            <div class="timeline-item">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">2023</h3>
                                <p class="text-gray-600">Mise en place de la plateforme de souscription en ligne</p>
                            </div>
                            <div class="timeline-item">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">2024</h3>
                                <p class="text-gray-600">Plus de 3 000 parcelles rurales attribuées à des agriculteurs et entreprises</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <img src="assets/images/afor-cote-ivoire.jpg" alt="Historique AFOR" class="rounded-lg shadow-xl w-full">
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Valeurs -->
        <section class="py-12 md:py-20">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl font-bold text-center mb-12">Nos Valeurs</h2>
                
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="value-card text-center">
                        <i class="fas fa-shield-alt text-4xl text-orange-600 mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Transparence</h3>
                        <p class="text-gray-600">
                            Nous garantissons des processus clairs et accessibles à tous, avec une information 
                            complète sur les opérations en cours.
                        </p>
                    </div>
                    <div class="value-card text-center">
                        <i class="fas fa-users text-4xl text-orange-600 mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Équité</h3>
                        <p class="text-gray-600">
                            L'égalité des chances pour tous les citoyens ivoiriens dans l'accès à la propriété foncière rurale.
                        </p>
                    </div>
                    <div class="value-card text-center">
                        <i class="fas fa-gem text-4xl text-orange-600 mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Qualité</h3>
                        <p class="text-gray-600">
                            Des parcelles bien aménagées et des services d'accompagnement de haute qualité.
                        </p>
                    </div>
                    <div class="value-card text-center">
                        <i class="fas fa-handshake text-4xl text-orange-600 mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Engagement</h3>
                        <p class="text-gray-600">
                            Un accompagnement personnalisé tout au long du processus d'acquisition.
                        </p>
                    </div>
                    <div class="value-card text-center">
                        <i class="fas fa-leaf text-4xl text-orange-600 mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Durabilité</h3>
                        <p class="text-gray-600">
                            Promotion d'un développement rural respectueux de l'environnement.
                        </p>
                    </div>
                    <div class="value-card text-center">
                        <i class="fas fa-lightbulb text-4xl text-orange-600 mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Innovation</h3>
                        <p class="text-gray-600">
                            Adoption des technologies modernes pour améliorer nos services.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Chiffres clés -->
        <section class="py-12 md:py-20 bg-orange-600 text-white -mx-4 px-4">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl font-bold text-center mb-12">L'AFOR en Chiffres</h2>
                
                <div class="grid md:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="text-4xl font-bold mb-2">3 000+</div>
                        <div class="text-lg">Parcelles rurales attribuées</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold mb-2">15</div>
                        <div class="text-lg">Régions couvertes</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold mb-2">96%</div>
                        <div class="text-lg">Clients satisfaits</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold mb-2">8</div>
                        <div class="text-lg">Années d'expérience</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Équipe -->
        <section class="py-12 md:py-20">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl font-bold text-center mb-12">Notre Équipe</h2>
                
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="value-card text-center">
                        <div class="w-24 h-24 bg-orange-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <i class="fas fa-user-tie text-3xl text-orange-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Experts Fonciers</h3>
                        <p class="text-gray-600">
                            Des spécialistes du domaine foncier rural avec une expertise reconnue dans le secteur agricole.
                        </p>
                    </div>
                    <div class="value-card text-center">
                        <div class="w-24 h-24 bg-orange-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <i class="fas fa-cogs text-3xl text-orange-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Ingénieurs Topographes</h3>
                        <p class="text-gray-600">
                            Professionnels qualifiés pour l'aménagement et la délimitation des parcelles rurales.
                        </p>
                    </div>
                    <div class="value-card text-center">
                        <div class="w-24 h-24 bg-orange-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <i class="fas fa-headset text-3xl text-orange-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Service Client</h3>
                        <p class="text-gray-600">
                            Une équipe dédiée à l'accompagnement et au suivi de nos clients en milieu rural.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section CTA -->
        <section class="py-12 md:py-20 bg-orange-50 -mx-4 px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Prêt à concrétiser votre projet en milieu rural ?</h2>
                <p class="text-lg text-gray-600 mb-8">
                    Rejoignez les milliers d'Ivoiriens qui ont fait confiance à l'AFOR pour leur acquisition foncière rurale.
                </p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="index.php?page=souscrire" class="btn-afor">
                        <i class="fas fa-home mr-2"></i>Commencer ma souscription
                    </a>
                    <a href="index.php?page=contact" class="btn-afor-outline">
                        <i class="fas fa-envelope mr-2"></i>Nous contacter
                    </a>
                </div>
            </div>
        </section>
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
                            <a href="index.php" class="text-gray-400 hover:text-orange-300 transition-colors">Accueil</a>
                        </li>
                        <li>
                            <a href="index.php?page=apropos" class="text-white transition-colors">À propos</a>
                        </li>
                        <li>
                            <a href="index.php?page=souscrire" class="text-gray-400 hover:text-orange-300 transition-colors">Comment souscrire</a>
                        </li>
                        <li>
                            <a href="index.php?page=contact" class="text-gray-400 hover:text-orange-300 transition-colors">Contact</a>
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
                    <p class="text-gray-400 mb-4">Abonnez-vous à notre page Facebook pour suivre toutes nos actualités</p>
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
    </script>

</body>

</html>