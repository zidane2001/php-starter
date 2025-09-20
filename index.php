<?php
if (isset($_GET['page'])) {
    $page = $_GET['page'];

    if ($page === "souscrire") {
        include "souscrire.php"; // Load souscrire.php
    } else if ($page === "conditions") {
        include "conditions.php"; // Load conditions.php
    }else if ($page === "identification") {
        include "identification.php"; // Load identification.php
    } else if ($page === "apropos") {
        include "apropos.php"; // Load apropos.php
    } else  if ($page === "type-parcelle") {
        include "type-parcelle.php"; // Load type-parcelle.php
    }else if ($page === "paiement") {
        include "paiement.php"; // Load paiement.php
        
    }
    
    
} else {
    echo "Welcome to the homepage!";
}
?>


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
<main class="mx-auto max-w-7xl px-4 py-12">
    <!-- Section Hero -->
    <section id="accueil" class="flex flex-col md:flex-row items-center justify-between py-16 md:py-24">
        <div class="md:w-1/2 mb-10 md:mb-0">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">Réservez votre parcelle ANUTTC en ligne</h1>
            <p class="text-lg text-gray-600 mb-8">Accédez à la propriété foncière simplement et rapidement. Notre plateforme vous permet de souscrire à une parcelle depuis le confort de votre domicile.</p>
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="index.php?page=souscrire" class="btn-anuttc inline-block">
                    <i class="fas fa-home mr-2"></i>Souscrire maintenant
                </a>
                <a href="#comment-souscrire" class="btn-anuttc-outline inline-block">
                    <i class="fas fa-info-circle mr-2"></i>En savoir plus
                </a>
            </div>
        </div>
        <div class="md:w-1/2">
            <img src="assets/images/hero-image.jpg" alt="Terrains ANUTTC" class="rounded-lg shadow-xl w-full">
        </div>
    </section>

    <!-- Section Opérations -->
    <section class="py-12 md:py-20 bg-gray-50 -mx-4 px-4">
        <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-bold text-center mb-12">Opérations en cours</h2>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                                                            <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:scale-105">
                                                            <img src="assets/images/libreville.jpg" alt="Vente de parcelles - Grand Libreville" class="w-full h-48 object-cover">
                                                        <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Vente de parcelles - Grand Libreville</h3>
                                <p class="text-gray-600 mb-4">Grand Libreville</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-green-600 font-semibold">
                                        50 000 FCFA                                    </span>
                                    <a href="index.php?page=souscrire&amp;operation=9" class="btn-anuttc text-sm">
                                        Souscrire
                                    </a>
                                </div>
                            </div>
                        </div>
                                            <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:scale-105">
                                                            <img src="assets/images/port-gentil.jpg" alt="Vente de parcelles - Okolassi" class="w-full h-48 object-cover">
                                                        <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Vente de parcelles - Okolassi</h3>
                                <p class="text-gray-600 mb-4">Okolassi</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-green-600 font-semibold">
                                        50 000 FCFA                                    </span>
                                    <a href="index.php?page=souscrire&amp;operation=10" class="btn-anuttc text-sm">
                                        Souscrire
                                    </a>
                                </div>
                            </div>
                        </div>
                                            <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:scale-105">
                                                            <img src="assets/images/franceville.jpg" alt="Vente de parcelles - Bolokoboué" class="w-full h-48 object-cover">
                                                        <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Vente de parcelles - Bolokoboué</h3>
                                <p class="text-gray-600 mb-4">Bolokoboué</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-green-600 font-semibold">
                                        50 000 FCFA                                    </span>
                                    <a href="index.php?page=souscrire&amp;operation=11" class="btn-anuttc text-sm">
                                        Souscrire
                                    </a>
                                </div>
                            </div>
                        </div>
                                                </div>
        </div>
    </section>

    <!-- Section À propos -->
    <section id="apropos" class="py-12 md:py-20">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-12">À propos d'ANUTTC</h2>
            
            <div class="flex flex-col md:flex-row items-center gap-12">
                <div class="md:w-1/2">
                    <img src="assets/images/about-image.jpg" alt="ANUTTC" class="rounded-lg shadow-xl w-full">
                </div>
                <div class="md:w-1/2">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Notre mission</h3>
                    <p class="text-gray-600 mb-6">
                        L'Agence Nationale d'Urbanisme et de Travaux de Terrassement et de Construction (ANUTTC) a pour mission principale de faciliter l'accès à la propriété foncière à travers l'aménagement et la commercialisation de parcelles viabilisées.
                    </p>
                    <p class="text-gray-600 mb-6">
                        Créée en 1997, ANUTTC œuvre pour la promotion immobilière et l'aménagement urbain au Burkina Faso. Notre expertise nous permet de proposer des terrains adaptés à tous les projets, qu'ils soient résidentiels ou professionnels.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                <i class="fas fa-map-marker-alt text-green-600"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-800">Terrains viabilisés</h4>
                                <p class="text-gray-600">Parcelles prêtes à construire avec accès aux réseaux essentiels</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                <i class="fas fa-file-signature text-green-600"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-800">Sécurité juridique</h4>
                                <p class="text-gray-600">Titres fonciers garantis et procédures transparentes</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                <i class="fas fa-handshake text-green-600"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-800">Accompagnement personnalisé</h4>
                                <p class="text-gray-600">Suivi administratif et technique tout au long de votre projet</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Comment souscrire -->
    <section id="comment-souscrire" class="py-12 md:py-20 bg-gray-50 -mx-4 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-12">Comment souscrire à une parcelle</h2>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <div class="bg-green-100 mx-auto h-16 w-16 rounded-full flex items-center justify-center mb-4">
                        <span class="text-2xl font-bold text-green-600">1</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Choisissez un site</h3>
                    <p class="text-gray-600">Sélectionnez l'opération qui correspond à vos besoins parmi nos différents sites disponibles.</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <div class="bg-green-100 mx-auto h-16 w-16 rounded-full flex items-center justify-center mb-4">
                        <span class="text-2xl font-bold text-green-600">2</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Complétez votre identification</h3>
                    <p class="text-gray-600">Fournissez vos informations personnelles ou celles de votre entreprise pour créer votre dossier.</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <div class="bg-green-100 mx-auto h-16 w-16 rounded-full flex items-center justify-center mb-4">
                        <span class="text-2xl font-bold text-green-600">3</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Sélectionnez votre parcelle</h3>
                    <p class="text-gray-600">Choisissez le type de parcelle et l'emplacement qui conviennent à votre projet.</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <div class="bg-green-100 mx-auto h-16 w-16 rounded-full flex items-center justify-center mb-4">
                        <span class="text-2xl font-bold text-green-600">4</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Effectuez le paiement</h3>
                    <p class="text-gray-600">Payez les frais de souscription par mobile money et recevez votre quittance.</p>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <a href="index.php?page=souscrire" class="anuttc-green text-white px-8 py-4 rounded-lg font-semibold hover:opacity-90 transition inline-block">
                    <i class="fas fa-check-circle mr-2"></i>Je commence ma souscription
                </a>
            </div>
        </div>
    </section>

    <!-- Section Pourquoi nous choisir -->
    <section id="pourquoi-nous" class="py-12 md:py-20">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-12">Pourquoi choisir ANUTTC</h2>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="flex flex-col items-center text-center">
                    <div class="h-20 w-20 bg-green-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-3xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Sécurité juridique</h3>
                    <p class="text-gray-600">Tous nos terrains disposent d'une documentation légale complète, vous assurant une sécurité juridique totale pour votre investissement.</p>
                </div>
                
                <div class="flex flex-col items-center text-center">
                    <div class="h-20 w-20 bg-green-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-road text-3xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Terrains viabilisés</h3>
                    <p class="text-gray-600">Nos parcelles sont aménagées avec des voies d'accès et prédisposées au raccordement aux réseaux d'eau et d'électricité.</p>
                </div>
                
                <div class="flex flex-col items-center text-center">
                    <div class="h-20 w-20 bg-green-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-hand-holding-usd text-3xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Prix compétitifs</h3>
                    <p class="text-gray-600">Nous proposons des parcelles à des tarifs accessibles avec des options de paiement adaptées à vos possibilités.</p>
                </div>
            </div>
            
            <div class="bg-gray-50 p-8 rounded-lg shadow-md mt-16 flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-8 md:mb-0 md:pr-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Ils nous font confiance</h3>
                    <p class="text-gray-600 mb-4">
                        Rejoignez les milliers de familles et d'entreprises qui ont fait confiance à ANUTTC pour leur projet immobilier. Notre expérience et notre professionnalisme font de nous le partenaire idéal pour concrétiser votre rêve d'accès à la propriété.
                    </p>
                    <div class="flex items-center">
                        <div class="flex -space-x-2">
                            <img src="assets/images/testimonial-1.jpg" alt="Client" class="h-10 w-10 rounded-full border-2 border-white">
                            <img src="assets/images/testimonial-2.jpg" alt="Client" class="h-10 w-10 rounded-full border-2 border-white">
                            <img src="assets/images/testimonial-3.jpg" alt="Client" class="h-10 w-10 rounded-full border-2 border-white">
                        </div>
                        <span class="ml-4 text-sm text-gray-500">Plus de 10 000 clients satisfaits</span>
                    </div>
                </div>
                <div class="md:w-1/2 grid grid-cols-2 gap-4">
                    <div class="bg-white p-4 rounded-lg">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                        </div>
                        <p class="text-gray-600 text-sm">"Processus simple et rapide. J'ai pu acquérir ma parcelle en toute sécurité."</p>
                        <p class="text-gray-800 font-medium mt-2">- Ousmane D.</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                        </div>
                        <p class="text-gray-600 text-sm">"Un excellent accompagnement du début à la fin. Merci ANUTTC !"</p>
                        <p class="text-gray-800 font-medium mt-2">- Mariam K.</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star-half-alt text-yellow-400"></i>
                        </div>
                        <p class="text-gray-600 text-sm">"Des parcelles bien situées et un personnel professionnel."</p>
                        <p class="text-gray-800 font-medium mt-2">- Ibrahim T.</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                        </div>
                        <p class="text-gray-600 text-sm">"La meilleure décision que j'ai prise pour investir dans l'immobilier."</p>
                        <p class="text-gray-800 font-medium mt-2">- Fatou S.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Contact -->
    <section id="contact" class="py-12 md:py-20 bg-gray-50 -mx-4 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-12">Contactez-nous</h2>
            
            <div class="grid md:grid-cols-2 gap-12">
                <div>
                    <div class="bg-white p-8 rounded-lg shadow-md">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">Envoyez-nous un message</h3>
                        
                        <form action="index.php?page=contact" method="post" class="space-y-4">
                            <div>
                                <label for="nom" class="block text-gray-700 mb-2">Nom complet</label>
                                <input type="text" id="nom" name="nom" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required="">
                            </div>
                            
                            <div>
                                <label for="email" class="block text-gray-700 mb-2">Adresse e-mail</label>
                                <input type="email" id="email" name="email" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required="">
                            </div>
                            
                            <div>
                                <label for="telephone" class="block text-gray-700 mb-2">Téléphone</label>
                                <input type="tel" id="telephone" name="telephone" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required="">
                            </div>
                            
                            <div>
                                <label for="sujet" class="block text-gray-700 mb-2">Sujet</label>
                                <input type="text" id="sujet" name="sujet" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required="">
                            </div>
                            
                            <div>
                                <label for="message" class="block text-gray-700 mb-2">Message</label>
                                <textarea id="message" name="message" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required=""></textarea>
                            </div>
                            
                            <button type="submit" class="anuttc-green text-white px-6 py-3 rounded-lg font-semibold hover:opacity-90 transition w-full">
                                <i class="fas fa-paper-plane mr-2"></i>Envoyer le message
                            </button>
                        </form>
                    </div>
                </div>
                
                <div>
                    <div class="bg-white p-8 rounded-lg shadow-md mb-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">Coordonnées</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="fas fa-map-marker-alt text-green-600"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-800">Adresse</h4>
                                    <p class="text-gray-600">Boulevard Léon M'Ba, Libreville, Gabon</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="fas fa-phone-alt text-green-600"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-800">Téléphone</h4>
                                    <p class="text-gray-600">+241 07 12 34 56</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="fas fa-envelope text-green-600"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-800">Email</h4>
                                    <p class="text-gray-600">contact@anuttc.ga</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="fas fa-clock text-green-600"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-800">Heures d'ouverture</h4>
                                    <p class="text-gray-600">Lundi - Vendredi: 8h00 - 17h00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Carte Google Maps -->
                    <div class="bg-white p-2 rounded-lg shadow-md">
                        <div class="aspect-video w-full">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3896.4944333147258!2d-1.5201349999999999!3d12.373056!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTLCsDIyJzIwLjIiTiAxwrAzMScxNi4xIlc!5e0!3m2!1sfr!2sbf!4v1652788909228!5m2!1sfr!2sbf" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><footer class="bg-gray-900 text-white mt-20">
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
