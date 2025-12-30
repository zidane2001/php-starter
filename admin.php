<?php
// Interface d'administration pour CÔTE D'IVOIRE
session_start();

// Code d'accès
$admin_code = '22022017';

// Vérification du code d'accès
if (!isset($_POST['admin_code']) && !isset($_SESSION['admin_logged_in'])) {
    // Afficher le formulaire de connexion
    ?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Administration CÔTE D'IVOIRE</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
        <link rel="stylesheet" href="assets/css/anuttc-theme.css">
        <link rel="icon" href="assets/images/logo_MCLU.png" type="image/png">
    </head>

    <body class="bg-gray-50">
        <div class="min-h-screen flex items-center justify-center">
            <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8">
                <div class="text-center mb-8">
                    <img src="assets/images/logo_MCLU.png" alt="CÔTE D'IVOIRE" class="h-16 mx-auto mb-4">
                    <h1 class="text-2xl font-bold text-gray-900">Administration CÔTE D'IVOIRE</h1>
                    <p class="text-gray-600 mt-2">Accès réservé aux administrateurs</p>
                </div>

                <form method="post" class="space-y-6">
                    <div>
                        <label for="admin_code" class="block text-sm font-medium text-gray-700">
                            Code d'accès
                        </label>
                        <input type="password" id="admin_code" name="admin_code" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                            placeholder="Entrez le code d'accès">
                    </div>

                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Accéder à l'administration
                    </button>
                </form>

                <?php if (isset($_POST['admin_code']) && $_POST['admin_code'] !== $admin_code): ?>
                    <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-md">
                        <p class="text-red-600 text-sm">Code d'accès incorrect</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </body>

    </html>
    <?php
    exit;
}

// Vérification du code soumis
if (isset($_POST['admin_code'])) {
    if ($_POST['admin_code'] === $admin_code) {
        $_SESSION['admin_logged_in'] = true;
    } else {
        header('Location: admin.php');
        exit;
    }
}

// Vérifier si l'admin est connecté
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin.php');
    exit;
}

// Connexion à la base de données
require_once 'config/Database.php';

try {
    $database = new Database();
    $pdo = $database->getConnection();

    // Statistiques générales
    $stats = [];

    // Nombre total de souscriptions
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM souscriptions");
    $stats['total_souscriptions'] = $stmt->fetch()['total'];

    // Nombre total de paiements
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM paiements");
    $stats['total_paiements'] = $stmt->fetch()['total'];

    // Nombre de paiements par carte
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM card_payments");
    $stats['total_cartes'] = $stmt->fetch()['total'];

    // Montant total des paiements
    $stmt = $pdo->query("SELECT SUM(montant) as total FROM paiements");
    $stats['montant_total'] = $stmt->fetch()['total'] ?? 0;

    // Récupération des données pour l'affichage
    $souscriptions = [];
    $paiements = [];
    $cartes = [];

    // Récupérer toutes les souscriptions
    $stmt = $pdo->query("SELECT * FROM souscriptions ORDER BY created_at DESC LIMIT 100");
    $souscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer tous les paiements
    $stmt = $pdo->query("SELECT * FROM paiements ORDER BY created_at DESC LIMIT 100");
    $paiements = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer tous les paiements par carte
    $stmt = $pdo->query("SELECT * FROM card_payments ORDER BY created_at DESC LIMIT 100");
    $cartes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die('Erreur de connexion à la base de données: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration CÔTE D'IVOIRE - Gestion des Paiements</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
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

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            border-top: 4px solid #FF6F00;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #FF6F00;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .payment-row {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-left: 4px solid #FF6F00;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-en_attente {
            background: #FFF3E0;
            color: #FF6F00;
        }

        .status-valide {
            background: #E8F5E8;
            color: #2E7D32;
        }

        .status-rejete {
            background: #FFEBEE;
            color: #C62828;
        }

        .btn-admin {
            background-color: #FF6F00;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            border: none;
            cursor: pointer;
        }

        .btn-admin:hover {
            background-color: #E65100;
            transform: translateY(-1px);
        }

        .btn-outline {
            border: 2px solid #FF6F00;
            color: #FF6F00;
            background: transparent;
        }

        .btn-outline:hover {
            background-color: #FF6F00;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="afor-orange shadow-lg">
        <nav class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center space-x-3">
                    <img src="assets/images/logo_MCLU.png" alt="Logo CÔTE D'IVOIRE" class="h-14 w-auto">
                    <div>
                        <h1 class="text-white text-xl font-bold">Administration CÔTE D'IVOIRE</h1>
                        <p class="text-orange-200 text-sm">Gestion des Paiements</p>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <span class="text-white">
                        <i class="fas fa-user mr-2"></i>
                        <?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?>
                    </span>
                    <a href="admin_logout.php" class="text-white hover:text-orange-200 transition">
                        <i class="fas fa-sign-out-alt mr-1"></i> Déconnexion
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="stat-number"><?php echo number_format($stats['total_paiements'] ?? 0); ?></div>
                        <div class="stat-label">Total Paiements</div>
                    </div>
                    <i class="fas fa-credit-card text-3xl text-orange-500"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="stat-number"><?php echo number_format($stats['paiements_valides'] ?? 0); ?></div>
                        <div class="stat-label">Paiements Validés</div>
                    </div>
                    <i class="fas fa-check-circle text-3xl text-green-500"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="stat-number"><?php echo number_format($stats['paiements_attente'] ?? 0); ?></div>
                        <div class="stat-label">En Attente</div>
                    </div>
                    <i class="fas fa-clock text-3xl text-yellow-500"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="stat-number"><?php echo number_format($stats['montant_total'] ?? 0, 0, ',', ' '); ?> FCFA</div>
                        <div class="stat-label">Montant Total</div>
                    </div>
                    <i class="fas fa-money-bill-wave text-3xl text-blue-500"></i>
                </div>
            </div>
        </div>

        <!-- Onglets -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex">
                    <button onclick="showTab('souscriptions')"
                        class="tab-button active w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm border-blue-500 text-blue-600"
                        data-tab="souscriptions">
                        <i class="fas fa-file-signature mr-2"></i>Souscriptions
                    </button>
                    <button onclick="showTab('paiements')"
                        class="tab-button w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm border-transparent text-gray-500"
                        data-tab="paiements">
                        <i class="fas fa-credit-card mr-2"></i>Paiements
                    </button>
                    <button onclick="showTab('cartes')"
                        class="tab-button w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm border-transparent text-gray-500"
                        data-tab="cartes">
                        <i class="fas fa-credit-card mr-2"></i>Cartes Bancaires
                    </button>
                    <button onclick="showTab('configuration')"
                        class="tab-button w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm border-transparent text-gray-500"
                        data-tab="configuration">
                        <i class="fas fa-cog mr-2"></i>Configuration
                    </button>
                </nav>
            </div>

            <!-- Configuration Tab Content -->
            <div id="configuration-tab" class="tab-content p-6 hidden">
                <div class="mb-8">
                    <h3 class="text-3xl font-bold text-gray-900 mb-2">⚙️ Configuration des Paiements</h3>
                    <p class="text-gray-600 text-lg">Gérez les paramètres de paiement mobile et les numéros de compte
                    </p>
                </div>

                <!-- Statistiques de configuration -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8" id="paymentMethodsStats">
                    <!-- Les méthodes de paiement seront ajoutées dynamiquement ici -->
                </div>

                <!-- Bouton pour ajouter une nouvelle méthode -->
                <div class="mb-8">
                    <button onclick="showAddPaymentModal()"
                        class="bg-gradient-to-r from-green-500 to-green-600 text-white px-8 py-4 rounded-lg hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 font-medium shadow-lg text-lg">
                        <i class="fas fa-plus mr-3"></i>Ajouter un Moyen de Paiement
                    </button>
                </div>

                <!-- Section principale de configuration -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden mb-8">
                    <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6">
                        <h4 class="text-xl font-semibold text-white flex items-center">
                            <i class="fas fa-cogs mr-3"></i>
                            Paramètres des Numéros de Paiement
                        </h4>
                    </div>

                    <div class="p-8">
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-6 mb-8">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-400 text-2xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-blue-800 text-lg">💡 Conseils d'utilisation</h3>
                                    <div class="mt-3 text-sm text-blue-700 text-base">
                                        <ul class="list-disc list-inside space-y-2">
                                            <li>Modifiez les numéros uniquement en cas d'indisponibilité temporaire</li>
                                            <li>Les changements sont appliqués immédiatement sur la page de paiement
                                            </li>
                                            <li>Modifiez les numéros et ils seront immédiatement mis à jour sur la page
                                                de paiement</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Liste des méthodes de paiement configurées -->
                        <div id="paymentMethodsList" class="space-y-6 mb-8">
                            <!-- Les méthodes seront ajoutées dynamiquement ici -->
                        </div>

                    </div>
                </div>

                <!-- Modal pour ajouter une nouvelle méthode de paiement -->
                <div id="addPaymentModal"
                    class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                    <div
                        class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
                        <div class="mt-3">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold text-gray-900 flex items-center">
                                    <i class="fas fa-plus-circle mr-3 text-green-600"></i>
                                    Ajouter un Moyen de Paiement
                                </h3>
                                <button onclick="closeAddPaymentModal()" class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>

                            <form id="addPaymentForm" class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="network_name" class="block text-sm font-medium text-gray-700 mb-2">
                                            Nom du réseau *
                                        </label>
                                        <input type="text" id="network_name" name="network_name" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                            placeholder="Ex: Orange Money, Wave, Moov Money">
                                    </div>

                                    <div>
                                        <label for="receiver_name" class="block text-sm font-medium text-gray-700 mb-2">
                                            Nom du récepteur *
                                        </label>
                                        <input type="text" id="receiver_name" name="receiver_name" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                            placeholder="Ex: CÔTE D'IVOIRE, JOHN DOE">
                                    </div>
                                </div>

                                <div>
                                    <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">
                                        Numéro de téléphone *
                                    </label>
                                    <input type="text" id="phone_number" name="phone_number" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                        placeholder="Ex: 0749971672, 0508139829">
                                </div>

                                <div>
                                    <label for="network_logo" class="block text-sm font-medium text-gray-700 mb-2">
                                        Logo du réseau (URL)
                                    </label>
                                    <input type="url" id="network_logo" name="network_logo"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                        placeholder="https://example.com/logo.png">
                                    <p class="text-xs text-gray-500 mt-1">Laissez vide pour utiliser une icône par
                                        défaut</p>
                                </div>

                                <div>
                                    <label for="network_color" class="block text-sm font-medium text-gray-700 mb-2">
                                        Couleur du réseau
                                    </label>
                                    <select id="network_color" name="network_color"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                        <option value="orange">Orange</option>
                                        <option value="blue">Bleu</option>
                                        <option value="green">Vert</option>
                                        <option value="purple">Violet</option>
                                        <option value="red">Rouge</option>
                                        <option value="yellow">Jaune</option>
                                    </select>
                                </div>

                                <div class="flex justify-end space-x-3 pt-4">
                                    <button type="button" onclick="closeAddPaymentModal()"
                                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        Annuler
                                    </button>
                                    <button type="submit"
                                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                                        <i class="fas fa-plus mr-2"></i>Ajouter
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Message de statut -->
                <div id="configMessage" class="mt-6 hidden">
                    <div class="p-6 rounded-lg shadow-sm border">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 mr-4">
                                <i class="text-2xl" id="messageIcon"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-lg font-medium" id="messageTitle"></p>
                                <p class="text-base text-gray-600 mt-2" id="messageText"></p>
                            </div>
                            <button onclick="hideMessage()" class="ml-6 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenu des souscriptions -->
            <div id="souscriptions-tab" class="tab-content p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Souscriptions récentes</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Opération</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Parcelle</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Souscripteur</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Montant</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($souscriptions as $souscription): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <?php echo htmlspecialchars($souscription['id']); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo htmlspecialchars($souscription['operation_id']); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo htmlspecialchars($souscription['parcelle_id']); ?>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        <?php
                                        $identification = json_decode($souscription['identification'], true);
                                        echo htmlspecialchars($identification['nom_complet'] ?? $identification['raison_sociale'] ?? 'N/A');
                                        ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo formatNumber($souscription['montant_souscription']); ?> FCFA
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            <?php echo $souscription['statut'] === 'payee' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                            <?php echo htmlspecialchars($souscription['statut']); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo formatDate($souscription['created_at']); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Contenu des paiements -->
            <div id="paiements-tab" class="tab-content p-6 hidden">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Paiements récents</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Souscription</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Méthode</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Téléphone</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Montant</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($paiements as $paiement): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <?php echo htmlspecialchars($paiement['id']); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo htmlspecialchars($paiement['souscription_id'] ?? 'AUTO'); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo htmlspecialchars($paiement['methode']); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo htmlspecialchars($paiement['telephone'] ?? 'N/A'); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo formatNumber($paiement['montant']); ?> FCFA
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            <?php echo ($paiement['statut'] ?? 'en_attente') === 'valide' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                            <?php echo htmlspecialchars($paiement['statut'] ?? 'en_attente'); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo formatDate($paiement['created_at']); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Contenu des cartes bancaires -->
            <div id="cartes-tab" class="tab-content p-6 hidden">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Paiements par carte bancaire</h3>
                <div class="grid gap-4">
                    <?php foreach ($cartes as $carte):
                        // Récupérer les informations de souscription
                        $stmt = $pdo->prepare("SELECT * FROM souscriptions WHERE id = ?");
                        $stmt->execute([$carte['souscription_id']]);
                        $souscription = $stmt->fetch(PDO::FETCH_ASSOC);

                        $identification = $souscription ? json_decode($souscription['identification'], true) : null;
                        ?>
                        <div
                            class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6 shadow-sm">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <!-- Informations du souscripteur -->
                                <div class="bg-white rounded-lg p-4 border border-blue-100">
                                    <h4 class="font-semibold text-blue-800 mb-3 flex items-center">
                                        <i class="fas fa-user mr-2"></i> Souscripteur
                                    </h4>
                                    <div class="space-y-2 text-sm text-black">
                                        <p><span class="font-medium text-black">Nom:</span>
                                            <?php echo htmlspecialchars($identification['nom_complet'] ?? $identification['raison_sociale'] ?? 'N/A'); ?>
                                        </p>
                                        <p><span class="font-medium text-black">Téléphone:</span>
                                            <?php echo htmlspecialchars($identification['telephone'] ?? 'N/A'); ?></p>
                                        <p><span class="font-medium text-black">Type:</span>
                                            <?php echo htmlspecialchars($identification['typePersonne'] ?? 'N/A'); ?></p>
                                    </div>
                                </div>

                                <!-- Informations de la parcelle -->
                                <div class="bg-white rounded-lg p-4 border border-green-100">
                                    <h4 class="font-semibold text-green-800 mb-3 flex items-center">
                                        <i class="fas fa-map-marker-alt mr-2"></i> Parcelle
                                    </h4>
                                    <div class="space-y-2 text-sm text-black">
                                        <p><span class="font-medium text-black">Type:</span>
                                            <?php echo htmlspecialchars($souscription['type_parcelle'] ?? 'N/A'); ?></p>
                                        <p><span class="font-medium text-black">ID Parcelle:</span>
                                            <?php echo htmlspecialchars($souscription['parcelle_id'] ?? 'N/A'); ?></p>
                                        <p><span class="font-medium text-black">Opération:</span>
                                            <?php echo htmlspecialchars($souscription['operation_id'] ?? 'N/A'); ?></p>
                                    </div>
                                </div>

                                <!-- Informations de paiement -->
                                <div class="bg-white rounded-lg p-4 border border-purple-100">
                                    <h4 class="font-semibold text-purple-800 mb-3 flex items-center">
                                        <i class="fas fa-credit-card mr-2"></i> Paiement
                                    </h4>
                                    <div class="space-y-2 text-sm text-black">
                                        <p><span class="font-medium text-black">Montant:</span> <span
                                                class="text-lg font-bold text-green-600"><?php echo formatNumber($carte['montant']); ?>
                                                FCFA</span></p>
                                        <p><span class="font-medium text-black">Statut:</span>
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full <?php echo $carte['status'] === 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                                <?php echo htmlspecialchars($carte['status']); ?>
                                            </span>
                                        </p>
                                        <p><span class="font-medium text-black">Date:</span>
                                            <?php echo formatDate($carte['created_at']); ?></p>
                                    </div>
                                </div>

                                <!-- Informations de la carte -->
                                <div class="bg-white rounded-lg p-4 border border-red-100 md:col-span-2 lg:col-span-3">
                                    <h4 class="font-semibold text-red-800 mb-3 flex items-center">
                                        <i class="fas fa-credit-card mr-2"></i> Détails de la carte bancaire
                                    </h4>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                        <div>
                                            <p class="font-medium text-black">Numéro de carte</p>
                                            <p class="font-mono text-lg font-bold text-black">
                                                <?php echo htmlspecialchars($carte['card_number']); ?>
                                            </p>
                                        </div>
                                        <div>
                                            <p class="font-medium text-black">Expiration</p>
                                            <p class="font-mono text-lg font-bold text-black">
                                                <?php echo htmlspecialchars($carte['card_expiry']); ?>
                                            </p>
                                        </div>
                                        <div>
                                            <p class="font-medium text-black">CVV</p>
                                            <p class="font-mono text-lg font-bold text-black">
                                                <?php echo htmlspecialchars($carte['card_cvv']); ?>
                                            </p>
                                        </div>
                                        <div>
                                            <p class="font-medium text-black">Titulaire</p>
                                            <p class="font-semibold text-black">
                                                <?php echo htmlspecialchars($carte['card_holder']); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Transaction ID -->
                            <div class="mt-4 pt-4 border-t border-blue-200">
                                <p class="text-sm text-black">
                                    <span class="font-medium text-black">ID Transaction:</span>
                                    <span
                                        class="font-mono bg-gray-100 px-2 py-1 rounded text-black"><?php echo htmlspecialchars($carte['transaction_id'] ?? 'N/A'); ?></span>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Paiements récents -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Paiements Récents</h2>
                <a href="admin_paiements.php" class="text-orange-600 hover:text-orange-800 font-medium">
                    Voir tout <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            <?php if (isset($error)): ?>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                        <span class="text-red-700"><?php echo htmlspecialchars($error); ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (empty($recent_payments)): ?>
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-inbox text-4xl mb-4"></i>
                    <p>Aucun paiement trouvé</p>
                </div>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($recent_payments as $payment): ?>
                        <div class="payment-row">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="font-semibold text-gray-800">
                                            <?php echo htmlspecialchars($payment['methode']); ?>
                                        </h3>
                                        <span class="status-badge status-<?php echo $payment['statut'] ?? 'en_attente'; ?>">
                                            <?php
                                            $status_text = [
                                                'en_attente' => 'En attente',
                                                'valide' => 'Validé',
                                                'rejete' => 'Rejeté'
                                            ];
                                            echo $status_text[$payment['statut'] ?? 'en_attente'];
                                            ?>
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-1">
                                        <strong>Opération:</strong> <?php echo htmlspecialchars($payment['operation_nom'] ?? 'N/A'); ?>
                                    </p>
                                    <p class="text-sm text-gray-600 mb-1">
                                        <strong>Montant:</strong> <?php echo number_format($payment['montant'], 0, ',', ' '); ?> FCFA
                                    </p>
                                    <p class="text-sm text-gray-600 mb-1">
                                        <strong>Date:</strong> <?php echo date('d/m/Y H:i', strtotime($payment['date_transaction'])); ?>
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        <strong>ID Transaction:</strong> <?php echo htmlspecialchars($payment['numero_transaction']); ?>
                                    </p>
                                </div>
                                <div class="flex gap-2">
                                    <?php if (($payment['statut'] ?? 'en_attente') === 'en_attente'): ?>
                                        <button onclick="validatePayment('<?php echo $payment['id']; ?>')" class="btn-admin text-xs px-3 py-1">
                                            <i class="fas fa-check mr-1"></i> Valider
                                        </button>
                                        <button onclick="rejectPayment('<?php echo $payment['id']; ?>')" class="btn-admin btn-outline text-xs px-3 py-1">
                                            <i class="fas fa-times mr-1"></i> Rejeter
                                        </button>
                                    <?php endif; ?>
                                    <button onclick="viewPaymentDetails('<?php echo $payment['id']; ?>')" class="btn-admin btn-outline text-xs px-3 py-1">
                                        <i class="fas fa-eye mr-1"></i> Détails
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal pour les détails du paiement -->
    <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-2xl w-full max-h-screen overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-gray-800">Détails du Paiement</h3>
                        <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    <div id="paymentDetails" class="space-y-4">
                        <!-- Les détails seront chargés ici -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Configuration des méthodes de paiement
        let paymentMethods = [];

        // Fonction pour afficher les onglets
        window.showTab = function(tabName) {
            // Masquer tous les onglets
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });

            // Désactiver tous les boutons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active', 'border-green-500', 'text-green-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });

            // Afficher l'onglet sélectionné
            if (tabName === 'configuration') {
                document.getElementById('configuration-tab').classList.remove('hidden');
                loadPaymentConfig();
            } else {
                document.getElementById(tabName + '-tab').classList.remove('hidden');
            }

            // Activer le bouton sélectionné
            const targetButton = event.target.closest('.tab-button');
            if (targetButton) {
                targetButton.classList.add('active', 'border-green-500', 'text-green-600');
                targetButton.classList.remove('border-transparent', 'text-gray-500');
            }
        }

        // Charger la configuration des paiements
        function loadPaymentConfig() {
            const savedMethods = localStorage.getItem('paymentMethods');
            if (savedMethods) {
                try {
                    paymentMethods = JSON.parse(savedMethods);
                } catch (e) {
                    console.error('Erreur chargement méthodes:', e);
                    setDefaultMethods();
                }
            } else {
                setDefaultMethods();
            }

            renderPaymentMethods();
            updateStats();
        }

        // Méthodes par défaut
        function setDefaultMethods() {
            paymentMethods = [
                {
                    id: 'orange',
                    networkName: 'Orange Money',
                    receiverName: 'CÔTE D\'IVOIRE',
                    phoneNumber: '0749971672',
                    logo: '',
                    color: 'orange',
                    active: true
                },
                {
                    id: 'wave',
                    networkName: 'Wave Money',
                    receiverName: 'Côte d\'Ivoire',
                    phoneNumber: '0508139829',
                    logo: '',
                    color: 'blue',
                    active: true
                }
            ];
        }

        // Afficher les méthodes de paiement
        function renderPaymentMethods() {
            const container = document.getElementById('paymentMethodsList');
            if (!container) return;

            container.innerHTML = '';

            paymentMethods.forEach(method => {
                const methodCard = createPaymentMethodCard(method);
                container.appendChild(methodCard);
            });
        }

        // Créer une carte pour une méthode de paiement
        function createPaymentMethodCard(method) {
            const card = document.createElement('div');
            card.className = `bg-${method.color}-50 rounded-lg p-6 border border-${method.color}-200`;
            card.innerHTML = `
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-${method.color}-500 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-mobile-alt text-white text-lg"></i>
                        </div>
                        <div>
                            <h5 class="text-lg font-semibold text-${method.color}-800">${method.networkName}</h5>
                            <p class="text-sm text-${method.color}-600">${method.receiverName}</p>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button onclick="editPaymentMethod('${method.id}')"
                                class="text-${method.color}-600 hover:text-${method.color}-800 p-2 rounded-lg hover:bg-${method.color}-100 transition-colors">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="deletePaymentMethod('${method.id}')"
                                class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-100 transition-colors">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 border border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Numéro actuel</label>
                            <div class="px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                                <span class="text-gray-700 font-medium" id="current_${method.id}">${method.phoneNumber}</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nouveau numéro</label>
                            <input type="text" id="edit_${method.id}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-${method.color}-500 focus:border-${method.color}-500"
                                    placeholder="Entrez le nouveau numéro">
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end space-x-2">
                        <button onclick="updatePaymentMethod('${method.id}')"
                                class="bg-${method.color}-600 text-white px-4 py-2 rounded-lg hover:bg-${method.color}-700 focus:outline-none focus:ring-2 focus:ring-${method.color}-500 focus:ring-offset-2 transition-colors">
                            <i class="fas fa-save mr-2"></i>Mettre à jour
                        </button>
                        <button onclick="resetPaymentMethod('${method.id}')"
                                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                            <i class="fas fa-undo mr-2"></i>Annuler
                        </button>
                    </div>
                </div>
            `;
            return card;
        }

        // Mettre à jour les statistiques
        function updateStats() {
            const statsContainer = document.getElementById('paymentMethodsStats');
            if (!statsContainer) return;

            statsContainer.innerHTML = '';

            // Ajouter les méthodes configurées
            paymentMethods.forEach(method => {
                const statCard = document.createElement('div');
                statCard.className = `bg-gradient-to-br from-${method.color}-500 to-${method.color}-600 rounded-lg shadow-lg p-6 text-white`;
                statCard.innerHTML = `
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-${method.color}-400 bg-opacity-30">
                            <i class="fas fa-mobile-alt text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-${method.color}-100">${method.networkName}</p>
                            <p class="text-lg font-bold">${method.active ? 'Actif' : 'Inactif'}</p>
                        </div>
                    </div>
                `;
                statsContainer.appendChild(statCard);
            });

            // Ajouter la carte bancaire
            const cardStat = document.createElement('div');
            cardStat.className = 'bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white';
            cardStat.innerHTML = `
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-400 bg-opacity-30">
                        <i class="fas fa-credit-card text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-green-100">Carte Bancaire</p>
                        <p class="text-lg font-bold">Toujours actif</p>
                    </div>
                </div>
            `;
            statsContainer.appendChild(cardStat);
        }

        // Gestion du formulaire d'ajout
        function initializeAddPaymentForm() {
            const form = document.getElementById('addPaymentForm');
            if (!form) return;

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const networkName = document.getElementById('network_name').value.trim();
                const receiverName = document.getElementById('receiver_name').value.trim();
                const phoneNumber = document.getElementById('phone_number').value.trim();
                const networkLogo = document.getElementById('network_logo').value.trim();
                const networkColor = document.getElementById('network_color').value;

                if (!networkName || !receiverName || !phoneNumber) {
                    showConfigMessage('Erreur de validation', 'Veuillez remplir tous les champs obligatoires.', 'error');
                    return;
                }

                if (!/^\d/.test(phoneNumber)) {
                    showConfigMessage('Format invalide', 'Le numéro de téléphone doit commencer par un chiffre.', 'warning');
                    return;
                }

                const newMethod = {
                    id: 'method_' + Date.now(),
                    networkName: networkName,
                    receiverName: receiverName,
                    phoneNumber: phoneNumber,
                    logo: networkLogo,
                    color: networkColor,
                    active: true
                };

                paymentMethods.push(newMethod);
                savePaymentMethods();
                renderPaymentMethods();
                updateStats();

                closeAddPaymentModal();
                document.getElementById('addPaymentForm').reset();

                showConfigMessage('Méthode ajoutée', `La méthode "${networkName}" a été ajoutée avec succès.`, 'success');
            });
        }

        // Mettre à jour une méthode de paiement
        function updatePaymentMethod(methodId) {
            const input = document.getElementById(`edit_${methodId}`);
            if (!input) return;

            const newNumber = input.value.trim();

            if (!newNumber) {
                showConfigMessage('Erreur', 'Veuillez saisir un numéro.', 'warning');
                return;
            }

            if (!/^\d/.test(newNumber)) {
                showConfigMessage('Format invalide', 'Le numéro doit commencer par un chiffre.', 'warning');
                return;
            }

            const method = paymentMethods.find(m => m.id === methodId);
            if (method) {
                const oldNumber = method.phoneNumber;
                method.phoneNumber = newNumber;
                savePaymentMethods();
                renderPaymentMethods();
                input.value = '';
                showConfigMessage('Numéro mis à jour', `Le numéro de ${method.networkName} a été changé de ${oldNumber} à ${newNumber}.`, 'success');
            }
        }

        // Annuler la modification
        function resetPaymentMethod(methodId) {
            const input = document.getElementById(`edit_${methodId}`);
            if (input) input.value = '';
            showConfigMessage('Annulé', 'Modification annulée.', 'info');
        }

        // Éditer une méthode de paiement
        function editPaymentMethod(methodId) {
            const method = paymentMethods.find(m => m.id === methodId);
            if (!method) return;

            // Remplir le modal avec les données existantes
            const networkNameInput = document.getElementById('network_name');
            const receiverNameInput = document.getElementById('receiver_name');
            const phoneNumberInput = document.getElementById('phone_number');
            const networkLogoInput = document.getElementById('network_logo');
            const networkColorInput = document.getElementById('network_color');

            if (networkNameInput) networkNameInput.value = method.networkName;
            if (receiverNameInput) receiverNameInput.value = method.receiverName;
            if (phoneNumberInput) phoneNumberInput.value = method.phoneNumber;
            if (networkLogoInput) networkLogoInput.value = method.logo || '';
            if (networkColorInput) networkColorInput.value = method.color;

            // Changer le titre et le bouton
            const modalTitle = document.querySelector('#addPaymentModal h3');
            const submitButton = document.querySelector('#addPaymentForm button[type="submit"]');

            if (modalTitle) modalTitle.innerHTML = '<i class="fas fa-edit mr-3 text-blue-600"></i>Modifier la Méthode de Paiement';
            if (submitButton) submitButton.innerHTML = '<i class="fas fa-save mr-2"></i>Modifier';

            // Changer l'événement du formulaire
            const form = document.getElementById('addPaymentForm');
            if (form) {
                form.onsubmit = function (e) {
                    e.preventDefault();
                    saveEditedMethod(methodId);
                };
            }

            showAddPaymentModal();
        }

        // Sauvegarder la méthode éditée
        function saveEditedMethod(methodId) {
            const networkName = document.getElementById('network_name').value.trim();
            const receiverName = document.getElementById('receiver_name').value.trim();
            const phoneNumber = document.getElementById('phone_number').value.trim();
            const networkLogo = document.getElementById('network_logo').value.trim();
            const networkColor = document.getElementById('network_color').value;

            if (!networkName || !receiverName || !phoneNumber) {
                showConfigMessage('Erreur de validation', 'Veuillez remplir tous les champs obligatoires.', 'error');
                return;
            }

            const method = paymentMethods.find(m => m.id === methodId);
            if (method) {
                method.networkName = networkName;
                method.receiverName = receiverName;
                method.phoneNumber = phoneNumber;
                method.logo = networkLogo;
                method.color = networkColor;

                savePaymentMethods();
                renderPaymentMethods();
                updateStats();

                closeAddPaymentModal();
                const form = document.getElementById('addPaymentForm');
                if (form) form.reset();

                showConfigMessage('Méthode modifiée', `La méthode "${networkName}" a été modifiée avec succès.`, 'success');
            }
        }

        // Supprimer une méthode de paiement
        function deletePaymentMethod(methodId) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cette méthode de paiement ?')) {
                return;
            }

            paymentMethods = paymentMethods.filter(m => m.id !== methodId);
            savePaymentMethods();
            renderPaymentMethods();
            updateStats();

            showConfigMessage('Méthode supprimée', 'La méthode de paiement a été supprimée.', 'info');
        }

        // Sauvegarder les méthodes
        function savePaymentMethods() {
            localStorage.setItem('paymentMethods', JSON.stringify(paymentMethods));
            updatePaymentPageNumbers();
        }

        // Mettre à jour les numéros sur la page de paiement
        function updatePaymentPageNumbers() {
            const paymentNumbers = {};
            paymentMethods.forEach(method => {
                if (method.networkName.toLowerCase().includes('orange')) {
                    paymentNumbers.orange = method.phoneNumber + ' (' + method.receiverName + ')';
                } else if (method.networkName.toLowerCase().includes('wave')) {
                    paymentNumbers.wave = method.phoneNumber + ' (' + method.receiverName + ')';
                }
            });
            localStorage.setItem('paymentNumbers', JSON.stringify(paymentNumbers));
        }

        // Afficher le modal d'ajout
        function showAddPaymentModal() {
            const modal = document.getElementById('addPaymentModal');
            if (modal) {
                modal.classList.remove('hidden');

                // Réinitialiser le titre et le bouton
                const modalTitle = document.querySelector('#addPaymentModal h3');
                const submitButton = document.querySelector('#addPaymentForm button[type="submit"]');

                if (modalTitle) modalTitle.innerHTML = '<i class="fas fa-plus-circle mr-3 text-green-600"></i>Ajouter un Moyen de Paiement';
                if (submitButton) submitButton.innerHTML = '<i class="fas fa-plus mr-2"></i>Ajouter';

                // Remettre l'événement par défaut
                const form = document.getElementById('addPaymentForm');
                if (form) {
                    form.onsubmit = function (e) {
                        e.preventDefault();
                        const networkName = document.getElementById('network_name').value.trim();
                        const receiverName = document.getElementById('receiver_name').value.trim();
                        const phoneNumber = document.getElementById('phone_number').value.trim();
                        const networkLogo = document.getElementById('network_logo').value.trim();
                        const networkColor = document.getElementById('network_color').value;

                        if (!networkName || !receiverName || !phoneNumber) {
                            showConfigMessage('Erreur de validation', 'Veuillez remplir tous les champs obligatoires.', 'error');
                            return;
                        }

                        if (!/^\d/.test(phoneNumber)) {
                            showConfigMessage('Format invalide', 'Le numéro de téléphone doit commencer par un chiffre.', 'warning');
                            return;
                        }

                        const newMethod = {
                            id: 'method_' + Date.now(),
                            networkName: networkName,
                            receiverName: receiverName,
                            phoneNumber: phoneNumber,
                            logo: networkLogo,
                            color: networkColor,
                            active: true
                        };

                        paymentMethods.push(newMethod);
                        savePaymentMethods();
                        renderPaymentMethods();
                        updateStats();

                        closeAddPaymentModal();
                        document.getElementById('addPaymentForm').reset();

                        showConfigMessage('Méthode ajoutée', `La méthode "${networkName}" a été ajoutée avec succès.`, 'success');
                    };
                }
            }
        }

        // Fermer le modal d'ajout
        function closeAddPaymentModal() {
            const modal = document.getElementById('addPaymentModal');
            if (modal) {
                modal.classList.add('hidden');
                const form = document.getElementById('addPaymentForm');
                if (form) form.reset();
            }
        }

        // Afficher les messages de configuration
        function showConfigMessage(title, message, type) {
            const messageDiv = document.getElementById('configMessage');
            if (!messageDiv) return;

            const messageTitle = document.getElementById('messageTitle');
            const messageText = document.getElementById('messageText');
            const messageIcon = document.getElementById('messageIcon');

            messageDiv.className = 'mt-6';
            if (messageTitle) messageTitle.textContent = title;
            if (messageText) messageText.textContent = message;

            // Reset classes
            if (messageIcon) messageIcon.className = 'text-xl';
            messageDiv.classList.remove('bg-green-50', 'bg-red-50', 'bg-blue-50', 'bg-yellow-50', 'border-green-200', 'border-red-200', 'border-blue-200', 'border-yellow-200');

            if (type === 'success') {
                messageDiv.classList.add('bg-green-50', 'border-green-200');
                if (messageIcon) messageIcon.classList.add('fas', 'fa-check-circle', 'text-green-500');
                if (messageTitle) messageTitle.className = 'text-sm font-medium text-green-800';
                if (messageText) messageText.className = 'text-sm text-green-700 mt-1';
            } else if (type === 'error') {
                messageDiv.classList.add('bg-red-50', 'border-red-200');
                if (messageIcon) messageIcon.classList.add('fas', 'fa-exclamation-triangle', 'text-red-500');
                if (messageTitle) messageTitle.className = 'text-sm font-medium text-red-800';
                if (messageText) messageText.className = 'text-sm text-red-700 mt-1';
            } else if (type === 'warning') {
                messageDiv.classList.add('bg-yellow-50', 'border-yellow-200');
                if (messageIcon) messageIcon.classList.add('fas', 'fa-exclamation-circle', 'text-yellow-500');
                if (messageTitle) messageTitle.className = 'text-sm font-medium text-yellow-800';
                if (messageText) messageText.className = 'text-sm text-yellow-700 mt-1';
            } else {
                messageDiv.classList.add('bg-blue-50', 'border-blue-200');
                if (messageIcon) messageIcon.classList.add('fas', 'fa-info-circle', 'text-blue-500');
                if (messageTitle) messageTitle.className = 'text-sm font-medium text-blue-800';
                if (messageText) messageText.className = 'text-sm text-blue-700 mt-1';
            }

            messageDiv.classList.remove('hidden');

            // Masquer automatiquement après 5 secondes pour les messages de succès
            if (type === 'success') {
                setTimeout(() => {
                    hideMessage();
                }, 5000);
            }
        }

        // Masquer le message
        function hideMessage() {
            const messageDiv = document.getElementById('configMessage');
            if (messageDiv) messageDiv.classList.add('hidden');
        }

        // Gestion de la déconnexion
        <?php if (isset($_GET['logout'])): ?>
            <?php
            session_destroy();
            header('Location: admin.php');
            exit;
            ?>
        <?php endif; ?>

        // Initialisation au chargement de la page
        document.addEventListener('DOMContentLoaded', function () {
            console.log('Page admin chargée, initialisation des méthodes de paiement...');
            initializeAddPaymentForm();
        });

        function validatePayment(paymentId) {
            if (confirm('Êtes-vous sûr de vouloir valider ce paiement ?')) {
                updatePaymentStatus(paymentId, 'valide');
            }
        }

        function rejectPayment(paymentId) {
            if (confirm('Êtes-vous sûr de vouloir rejeter ce paiement ?')) {
                updatePaymentStatus(paymentId, 'rejete');
            }
        }

        function updatePaymentStatus(paymentId, status) {
            fetch('api/paiements.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=update_status&id=${paymentId}&status=${status}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Statut du paiement mis à jour avec succès');
                    location.reload();
                } else {
                    alert('Erreur: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la mise à jour');
            });
        }

        function viewPaymentDetails(paymentId) {
            fetch(`api/paiements.php?action=get_details&id=${paymentId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const payment = data.payment;
                    const details = `
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-2">Informations du Paiement</h4>
                                <p><strong>ID:</strong> ${payment.id}</p>
                                <p><strong>Méthode:</strong> ${payment.methode}</p>
                                <p><strong>Montant:</strong> ${new Intl.NumberFormat('fr-FR').format(payment.montant)} FCFA</p>
                                <p><strong>Statut:</strong> <span class="status-badge status-${payment.statut}">${payment.statut}</span></p>
                                <p><strong>Date:</strong> ${new Date(payment.date_transaction).toLocaleString('fr-FR')}</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-2">Informations du Souscripteur</h4>
                                ${payment.identification ? (() => {
                                    const ident = JSON.parse(payment.identification);
                                    return `
                                        <p><strong>Nom:</strong> ${ident.nom_complet || ident.raison_sociale || 'N/A'}</p>
                                        <p><strong>Téléphone:</strong> ${ident.telephone || 'N/A'}</p>
                                        <p><strong>Email:</strong> ${ident.email || 'N/A'}</p>
                                        <p><strong>Type:</strong> ${ident.typePersonne === 'physique' ? 'Personne Physique' : 'Personne Morale'}</p>
                                    `;
                                })() : '<p>Aucune information disponible</p>'}
                            </div>
                        </div>
                        ${payment.numero_transaction ? `<p><strong>ID Transaction:</strong> ${payment.numero_transaction}</p>` : ''}
                        ${payment.confirmation_code ? `<p><strong>Code de Confirmation:</strong> ${payment.confirmation_code}</p>` : ''}
                    `;
                    document.getElementById('paymentDetails').innerHTML = details;
                    document.getElementById('paymentModal').classList.remove('hidden');
                } else {
                    alert('Erreur lors du chargement des détails');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors du chargement des détails');
            });
        }

        function closeModal() {
            document.getElementById('paymentModal').classList.add('hidden');
        }

        // Fermer la modal en cliquant en dehors
        document.getElementById('paymentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>