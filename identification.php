<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Identification - AFOR Côte d'Ivoire</title>
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

        /* Styles spécifiques pour le formulaire */
        .form-input,
        .form-select,
        .form-textarea {
            height: 2.5rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.95rem;
            border-width: 1px;
            border-radius: 0.5rem;
            border: 1px solid #D1D5DB;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            ring: 2px;
            ring-color: #FF6F00;
            border-color: #FF6F00;
        }

        .form-label {
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
            color: #374151;
            font-weight: 500;
        }

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
                    <a href="index.php?page=apropos" class="block text-white hover:bg-orange-600 px-3 py-2 rounded-md">À propos</a>
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

    <main class="max-w-7xl mx-auto px-4 py-16" x-data="{ 
    etape: 3,
    maxEtape: localStorage.getItem('maxEtape') ? parseInt(localStorage.getItem('maxEtape')) : 3,
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
    formData: {
        // Personne physique uniquement
        nom_complet: '',
        telephone: '',
        date_naissance: '',
        lieu_naissance: '',
        profession: '',
        genre: '',
        document: '',
        numero_piece: '',
        lieu_etablissement: '',
        date_etablissement: '',
        pays: 'Côte d\'Ivoire',
        region: '',
        ville: '',
        adresse: ''
    },
    errors: [],
    init() {
        // Vérifier si les conditions sont acceptées
        const conditionsAccepted = localStorage.getItem('conditionsAccepted');
        if (conditionsAccepted !== 'true') {
            alert('Veuillez d\'abord accepter les conditions de l\'opération.');
            window.location.href = 'index.php?page=conditions';
            return;
        }

        // Récupérer les données de l'opération du localStorage
        const operationData = localStorage.getItem('operation');
        if (!operationData) {
            alert('Veuillez d\'abord sélectionner une opération.');
            window.location.href = 'index.php?page=souscrire';
            return;
        }
        
        this.souscriptionData.operation = JSON.parse(operationData);
        
        // Récupérer les données d'identification si elles existent
        const identificationData = localStorage.getItem('identification');
        if (identificationData) {
            this.souscriptionData.identification = JSON.parse(identificationData);
            
            // Remplir le formulaire avec les données existantes
            this.formData.nom_complet = this.souscriptionData.identification.nom_complet || '';
            this.formData.telephone = this.souscriptionData.identification.telephone || '';
            this.formData.date_naissance = this.souscriptionData.identification.date_naissance || '';
            this.formData.lieu_naissance = this.souscriptionData.identification.lieu_naissance || '';
            this.formData.profession = this.souscriptionData.identification.profession || '';
            this.formData.genre = this.souscriptionData.identification.genre || '';
            this.formData.document = this.souscriptionData.identification.document || '';
            this.formData.numero_piece = this.souscriptionData.identification.numero_piece || '';
            this.formData.lieu_etablissement = this.souscriptionData.identification.lieu_etablissement || '';
            this.formData.date_etablissement = this.souscriptionData.identification.date_etablissement || '';
            this.formData.pays = this.souscriptionData.identification.pays || 'Côte d\'Ivoire';
            this.formData.region = this.souscriptionData.identification.region || '';
            this.formData.ville = this.souscriptionData.identification.ville || '';
            this.formData.adresse = this.souscriptionData.identification.adresse || '';
        }
    },
    validateForm() {
        this.errors = [];

        // Champs obligatoires
        if (!this.formData.nom_complet) this.errors.push('Le nom complet est obligatoire');
        if (!this.formData.telephone) this.errors.push('Le téléphone est obligatoire');
        if (!this.formData.date_naissance) this.errors.push('La date de naissance est obligatoire');
        if (!this.formData.lieu_naissance) this.errors.push('Le lieu de naissance est obligatoire');
        if (!this.formData.profession) this.errors.push('La profession est obligatoire');
        if (!this.formData.genre) this.errors.push('Le genre est obligatoire');
        if (!this.formData.document) this.errors.push('Le type de document est obligatoire');
        if (!this.formData.numero_piece) this.errors.push('Le numéro de pièce est obligatoire');
        if (!this.formData.date_etablissement) this.errors.push('La date d\'établissement est obligatoire');
        if (!this.formData.lieu_etablissement) this.errors.push('Le lieu d\'établissement est obligatoire');
        if (!this.formData.pays) this.errors.push('Le pays est obligatoire');

        return this.errors.length === 0;
    },
    submitForm() {
        console.log('✅ submitForm appelé !');
        
        if (!this.validateForm()) {
            return;
        }

        let formData = {
            type_personne: 'physique',
            nom_complet: this.formData.nom_complet.trim(),
            telephone: this.formData.telephone.trim(),
            date_naissance: this.formData.date_naissance.trim(),
            lieu_naissance: this.formData.lieu_naissance.trim(),
            profession: this.formData.profession.trim(),
            genre: this.formData.genre,
            document: this.formData.document,
            numero_piece: this.formData.numero_piece.trim(),
            date_etablissement: this.formData.date_etablissement.trim(),
            lieu_etablissement: this.formData.lieu_etablissement.trim(),
            pays: this.formData.pays,
            region: this.formData.region.trim(),
            ville: this.formData.ville.trim(),
            adresse: this.formData.adresse.trim()
        };

        console.log('Données à envoyer :', formData);

        // Sauvegarde locale
        localStorage.setItem('identification', JSON.stringify(formData));
        localStorage.setItem('identificationValid', 'true');

        // Redirection vers l'étape suivante
        window.location.href = 'index.php?page=type-parcelle';
    }
}">
    <!-- Étapes de progression -->
    <div class="mb-6 sm:mb-10">
        <div class="flex justify-center items-center space-x-1 sm:space-x-4">
            <!-- Étape 1 : Site -->
            <div class="flex flex-col items-center">
                <button @click="window.location.href = 'index.php?page=souscrire'" 
                    class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold shadow-lg transition-all duration-300 step-completed" 
                    style="cursor: pointer;">
                    1
                </button>
                <span class="mt-1 sm:mt-2 text-[10px] sm:text-xs font-medium" style="color: #FF6F00;">Site</span>
            </div>
            <div class="w-4 sm:w-16 h-0.5 sm:h-1 rounded" style="background-color: #FF6F00;"></div>

            <!-- Étape 2 : Conditions -->
            <div class="flex flex-col items-center">
                <button @click="window.location.href = 'index.php?page=conditions'" 
                    class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold shadow-lg transition-all duration-300 step-completed" 
                    style="cursor: pointer;">
                    2
                </button>
                <span class="mt-1 sm:mt-2 text-[10px] sm:text-xs font-medium" style="color: #FF6F00;">Conditions</span>
            </div>
            <div class="w-4 sm:w-16 h-0.5 sm:h-1 rounded" style="background-color: #FF6F00;"></div>

            <!-- Étape 3 : Identification -->
            <div class="flex flex-col items-center">
                <div class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold shadow-lg step-active">
                    3
                </div>
                <span class="mt-1 sm:mt-2 text-[10px] sm:text-xs font-medium" style="color: #FF6F00;">Identification</span>
            </div>
            <div class="w-4 sm:w-16 h-0.5 sm:h-1 bg-gray-300 rounded"></div>

            <!-- Étape 4 : Parcelle -->
            <div class="flex flex-col items-center">
                <div class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold shadow-lg step-pending">
                    4
                </div>
                <span class="mt-1 sm:mt-2 text-[10px] sm:text-xs font-medium text-gray-500">Parcelle</span>
            </div>
            <div class="w-4 sm:w-16 h-0.5 sm:h-1 bg-gray-300 rounded"></div>

            <!-- Étape 5 : Paiement -->
            <div class="flex flex-col items-center">
                <div class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold shadow-lg step-pending">
                    5
                </div>
                <span class="mt-1 sm:mt-2 text-[10px] sm:text-xs font-medium text-gray-500">Paiement</span>
            </div>
        </div>
    </div>

    <!-- Boutons de navigation -->
    <div class="flex justify-between items-center mt-4 sm:mt-8 max-w-4xl mx-auto px-2 sm:px-0">
        <!-- Bouton Précédent -->
        <button @click="window.location.href = 'index.php?page=conditions'"
            class="btn-afor-outline px-3 sm:px-6 py-2 sm:py-3">
            <i class="fas fa-arrow-left mr-1 sm:mr-2"></i>
            Précédent
        </button>

        <!-- Messages d'erreur -->
        <div class="text-center mx-2 sm:mx-4 hidden sm:block">
            <div x-show="errors.length > 0" class="text-red-600 text-xs sm:text-sm" style="display: none;">
                <i class="fas fa-exclamation-circle mr-1"></i>
                <span x-text="errors[0]"></span>
            </div>
        </div>

        <!-- Bouton Suivant -->
        <button @click="submitForm()"
            class="btn-afor px-3 sm:px-6 py-2 sm:py-3">
            <span>Suivant</span>
            <i class="fas fa-arrow-right ml-1 sm:ml-2"></i>
        </button>
    </div>

    <div class="max-w-2xl mx-auto mt-16">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Identification</h2>

        <!-- Affichage des erreurs -->
        <div x-show="errors.length > 0" class="bg-red-50 border-l-4 border-red-500 p-4 mb-6" style="display: none;">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-500"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Veuillez corriger les erreurs suivantes :</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        <template x-for="error in errors" :key="error">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Formulaire Personne Physique -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Informations personnelles</h3>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nom complet -->
                    <div>
                        <label for="nom_complet" class="form-label block">Nom complet <span class="text-red-500">*</span></label>
                        <input type="text" id="nom_complet" x-model="formData.nom_complet" 
                            class="form-input w-full rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    </div>
                    
                    <!-- Téléphone -->
                    <div>
                        <label for="telephone" class="form-label block">Téléphone <span class="text-red-500">*</span></label>
                        <input type="tel" id="telephone" x-model="formData.telephone" 
                            class="form-input w-full rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Date de naissance -->
                    <div>
                        <label for="date_naissance" class="form-label block">Date de naissance <span class="text-red-500">*</span></label>
                        <input type="date" id="date_naissance" x-model="formData.date_naissance" 
                            class="form-input w-full rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    </div>
                    
                    <!-- Lieu de naissance -->
                    <div>
                        <label for="lieu_naissance" class="form-label block">Lieu de naissance <span class="text-red-500">*</span></label>
                        <input type="text" id="lieu_naissance" x-model="formData.lieu_naissance" 
                            class="form-input w-full rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Profession -->
                    <div>
                        <label for="profession" class="form-label block">Profession <span class="text-red-500">*</span></label>
                        <input type="text" id="profession" x-model="formData.profession" 
                            class="form-input w-full rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    </div>
                    
                    <!-- Genre -->
                    <div>
                        <label for="genre" class="form-label block">Genre <span class="text-red-500">*</span></label>
                        <select id="genre" x-model="formData.genre" 
                            class="form-select w-full rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                            <option value="">Sélectionner</option>
                            <option value="M">Masculin</option>
                            <option value="F">Féminin</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <h3 class="text-lg font-semibold mt-8 mb-4 text-gray-800">Pièce d'identité</h3>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Type de document -->
                    <div>
                        <label for="document" class="form-label block">Type de document <span class="text-red-500">*</span></label>
                        <select id="document" x-model="formData.document" 
                            class="form-select w-full rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                            <option value="">Sélectionner</option>
                            <option value="CNI">CNI</option>
                            <option value="Passeport">Passeport</option>
                            <option value="Permis de conduire">Permis de conduire</option>
                        </select>
                    </div>
                    
                    <!-- Numéro de pièce -->
                    <div>
                        <label for="numero_piece" class="form-label block">Numéro de pièce <span class="text-red-500">*</span></label>
                        <input type="text" id="numero_piece" x-model="formData.numero_piece" 
                            class="form-input w-full rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Date d'établissement -->
                    <div>
                        <label for="date_etablissement" class="form-label block">Date d'établissement <span class="text-red-500">*</span></label>
                        <input type="date" id="date_etablissement" x-model="formData.date_etablissement" 
                            class="form-input w-full rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    </div>
                    
                    <!-- Lieu d'établissement -->
                    <div>
                        <label for="lieu_etablissement" class="form-label block">Lieu d'établissement <span class="text-red-500">*</span></label>
                        <input type="text" id="lieu_etablissement" x-model="formData.lieu_etablissement" 
                            class="form-input w-full rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    </div>
                </div>
            </div>
            
            <h3 class="text-lg font-semibold mt-8 mb-4 text-gray-800">Adresse</h3>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Pays -->
                    <div>
                        <label class="form-label block">Pays <span class="text-red-500">*</span></label>
                        <input type="text" value="Côte d'Ivoire" readonly
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed">
                    </div>
                    
                    <!-- Région -->
                    <div>
                        <label for="region" class="form-label block">Région</label>
                        <input type="text" id="region" x-model="formData.region" 
                            class="form-input w-full rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Ville -->
                    <div>
                        <label for="ville" class="form-label block">Ville</label>
                        <input type="text" id="ville" x-model="formData.ville" 
                            class="form-input w-full rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                    
                    <!-- Adresse -->
                    <div>
                        <label for="adresse" class="form-label block">Adresse complète</label>
                        <input type="text" id="adresse" x-model="formData.adresse" 
                            class="form-input w-full rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                </div>
            </div>
            
            <!-- Bouton de soumission -->
            <div class="mt-8">
                <button @click="submitForm()" class="btn-afor w-full py-3">
                    <i class="fas fa-save mr-2"></i>
                    Sauvegarder et continuer
                </button>
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
                        <a href="index.php?page=apropos" class="text-gray-400 hover:text-orange-300 transition-colors">À propos</a>
                    </li>
                    <li>
                        <a href="index.php?page=souscrire" class="text-gray-400 hover:text-orange-300 transition-colors">Comment souscrire</a>
                    </li>
                    <li>
                        <a href="index.php#pourquoi-nous" class="text-gray-400 hover:text-orange-300 transition-colors">Pourquoi nous choisir</a>
                    </li>
                    <li>
                        <a href="index.php?page=contact" class="text-gray-400 hover:text-orange-300 transition-colors">Contact</a>
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