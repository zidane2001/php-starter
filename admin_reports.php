<?php
session_start();

// Vérification de l'authentification admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit();
}

include_once 'config/Database.php';

$database = new Database();
$db = $database->getConnection();

// Période par défaut (dernier mois)
$start_date = $_GET['start_date'] ?? date('Y-m-d', strtotime('-30 days'));
$end_date = $_GET['end_date'] ?? date('Y-m-d');

try {
    // Statistiques générales
    $stats = [];

    // Paiements dans la période
    $stmt = $db->prepare("
        SELECT
            COUNT(*) as total_paiements,
            SUM(CASE WHEN statut = 'valide' THEN 1 ELSE 0 END) as paiements_valides,
            SUM(CASE WHEN statut = 'valide' THEN montant ELSE 0 END) as montant_total,
            AVG(CASE WHEN statut = 'valide' THEN montant ELSE NULL END) as montant_moyen
        FROM paiements
        WHERE date_transaction BETWEEN :start_date AND :end_date
    ");
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);
    $stmt->execute();
    $stats['paiements'] = $stmt->fetch(PDO::FETCH_ASSOC);

    // Souscriptions dans la période
    $stmt = $db->prepare("
        SELECT COUNT(*) as total_souscriptions, SUM(montant_souscription) as montant_souscriptions
        FROM operations
        WHERE date_creation BETWEEN :start_date AND :end_date
    ");
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);
    $stmt->execute();
    $stats['souscriptions'] = $stmt->fetch(PDO::FETCH_ASSOC);

    // Répartition par méthode de paiement
    $stmt = $db->prepare("
        SELECT methode, COUNT(*) as count, SUM(montant) as total
        FROM paiements
        WHERE statut = 'valide' AND date_transaction BETWEEN :start_date AND :end_date
        GROUP BY methode
        ORDER BY total DESC
    ");
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);
    $stmt->execute();
    $stats['methodes'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Évolution quotidienne des paiements
    $stmt = $db->prepare("
        SELECT DATE(date_transaction) as date,
               COUNT(*) as count,
               SUM(montant) as total
        FROM paiements
        WHERE statut = 'valide' AND date_transaction BETWEEN :start_date AND :end_date
        GROUP BY DATE(date_transaction)
        ORDER BY date
    ");
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);
    $stmt->execute();
    $stats['evolution'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Top localités
    $stmt = $db->prepare("
        SELECT o.localite, COUNT(*) as count, SUM(p.montant) as total
        FROM operations o
        LEFT JOIN paiements p ON o.id = p.operation_id AND p.statut = 'valide'
        WHERE o.date_creation BETWEEN :start_date AND :end_date
        GROUP BY o.localite
        ORDER BY total DESC
        LIMIT 10
    ");
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);
    $stmt->execute();
    $stats['localites'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    $error = "Erreur lors de la récupération des statistiques: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration AFOR - Rapports & Statistiques</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="assets/images/logo_MCLU.png" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #ff6f00a2 0%, #FF8F00 100%);
        }

        .afor-orange {
            background-color: #FF6F00;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            border-top: 4px solid #FF6F00;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #FF6F00;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .chart-container {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .btn-admin {
            background-color: #FF6F00;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            display: inline-block;
            border: none;
            cursor: pointer;
        }

        .btn-admin:hover {
            background-color: #E65100;
            transform: translateY(-1px);
        }

        .form-input {
            padding: 8px 12px;
            border: 1px solid #D1D5DB;
            border-radius: 6px;
            font-size: 0.875rem;
        }

        .form-input:focus {
            outline: none;
            border-color: #FF6F00;
            box-shadow: 0 0 0 3px rgba(255, 111, 0, 0.1);
        }

        .table-report {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .table-report th {
            background: #F9FAFB;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 1px solid #E5E7EB;
        }

        .table-report td {
            padding: 12px;
            border-bottom: 1px solid #F3F4F6;
        }

        .export-btn {
            background: #10B981;
            color: white;
        }

        .export-btn:hover {
            background: #059669;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="afor-orange shadow-lg">
        <nav class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <a href="admin.php" class="flex items-center space-x-3">
                        <img src="assets/images/logo_MCLU.png" alt="Logo AFOR" class="h-12 w-auto">
                        <span class="text-white font-bold">Administration AFOR</span>
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="admin.php" class="text-white hover:text-orange-200 transition">
                        <i class="fas fa-home mr-1"></i> Accueil
                    </a>
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

    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Filtres de période -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold text-gray-800">Rapports & Statistiques</h1>
                <div class="flex gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date début</label>
                        <input type="date" id="start_date" class="form-input" value="<?php echo $start_date; ?>">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date fin</label>
                        <input type="date" id="end_date" class="form-input" value="<?php echo $end_date; ?>">
                    </div>
                    <div class="flex items-end">
                        <button onclick="updateReports()" class="btn-admin">
                            <i class="fas fa-search mr-2"></i> Actualiser
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex gap-2">
                <button onclick="exportReport('pdf')" class="btn-admin export-btn">
                    <i class="fas fa-file-pdf mr-2"></i> Exporter PDF
                </button>
                <button onclick="exportReport('excel')" class="btn-admin export-btn">
                    <i class="fas fa-file-excel mr-2"></i> Exporter Excel
                </button>
            </div>
        </div>

        <?php if (isset($error)): ?>
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                    <span class="text-red-700"><?php echo htmlspecialchars($error); ?></span>
                </div>
            </div>
        <?php endif; ?>

        <!-- Statistiques principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="stat-number"><?php echo number_format($stats['paiements']['total_paiements'] ?? 0); ?></div>
                        <div class="stat-label">Total Paiements</div>
                    </div>
                    <i class="fas fa-credit-card text-3xl text-orange-500"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="stat-number"><?php echo number_format($stats['paiements']['paiements_valides'] ?? 0); ?></div>
                        <div class="stat-label">Paiements Validés</div>
                    </div>
                    <i class="fas fa-check-circle text-3xl text-green-500"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="stat-number"><?php echo number_format($stats['paiements']['montant_total'] ?? 0, 0, ',', ' '); ?> FCFA</div>
                        <div class="stat-label">Montant Total</div>
                    </div>
                    <i class="fas fa-money-bill-wave text-3xl text-blue-500"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="stat-number"><?php echo number_format($stats['souscriptions']['total_souscriptions'] ?? 0); ?></div>
                        <div class="stat-label">Souscriptions</div>
                    </div>
                    <i class="fas fa-file-contract text-3xl text-purple-500"></i>
                </div>
            </div>
        </div>

        <!-- Graphiques -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Répartition par méthode de paiement -->
            <div class="chart-container">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Répartition par méthode de paiement</h3>
                <canvas id="methodesChart" width="400" height="300"></canvas>
            </div>

            <!-- Évolution des paiements -->
            <div class="chart-container">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Évolution des paiements</h3>
                <canvas id="evolutionChart" width="400" height="300"></canvas>
            </div>
        </div>

        <!-- Tableaux détaillés -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top localités -->
            <div class="table-report">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th colspan="3" class="text-center">Top 10 Localités</th>
                        </tr>
                        <tr>
                            <th>Localité</th>
                            <th>Souscriptions</th>
                            <th>Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stats['localites'] as $localite): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($localite['localite'] ?? 'N/A'); ?></td>
                                <td><?php echo number_format($localite['count']); ?></td>
                                <td><?php echo number_format($localite['total'] ?? 0, 0, ',', ' '); ?> FCFA</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Détail des méthodes -->
            <div class="table-report">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th colspan="3" class="text-center">Détail par méthode de paiement</th>
                        </tr>
                        <tr>
                            <th>Méthode</th>
                            <th>Nombre</th>
                            <th>Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stats['methodes'] as $methode): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($methode['methode']); ?></td>
                                <td><?php echo number_format($methode['count']); ?></td>
                                <td><?php echo number_format($methode['total'], 0, ',', ' '); ?> FCFA</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Données pour les graphiques
        const methodesData = <?php echo json_encode($stats['methodes']); ?>;
        const evolutionData = <?php echo json_encode($stats['evolution']); ?>;

        // Graphique des méthodes de paiement
        const methodesCtx = document.getElementById('methodesChart').getContext('2d');
        new Chart(methodesCtx, {
            type: 'doughnut',
            data: {
                labels: methodesData.map(item => item.methode),
                datasets: [{
                    data: methodesData.map(item => item.total),
                    backgroundColor: [
                        '#FF6F00', '#FF8F00', '#FFB74D', '#4CAF50', '#2196F3', '#9C27B0'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed;
                                return new Intl.NumberFormat('fr-FR').format(value) + ' FCFA';
                            }
                        }
                    }
                }
            }
        });

        // Graphique d'évolution
        const evolutionCtx = document.getElementById('evolutionChart').getContext('2d');
        new Chart(evolutionCtx, {
            type: 'line',
            data: {
                labels: evolutionData.map(item => {
                    const date = new Date(item.date);
                    return date.toLocaleDateString('fr-FR');
                }),
                datasets: [{
                    label: 'Montant des paiements',
                    data: evolutionData.map(item => item.total),
                    borderColor: '#FF6F00',
                    backgroundColor: 'rgba(255, 111, 0, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('fr-FR').format(value) + ' FCFA';
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed.y;
                                return 'Montant: ' + new Intl.NumberFormat('fr-FR').format(value) + ' FCFA';
                            }
                        }
                    }
                }
            }
        });

        function updateReports() {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            if (startDate && endDate) {
                window.location.href = `admin_reports.php?start_date=${startDate}&end_date=${endDate}`;
            }
        }

        function exportReport(format) {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            // Pour l'instant, on affiche juste un message
            // En production, il faudrait implémenter l'export réel
            alert(`Export ${format.toUpperCase()} - Fonctionnalité à implémenter\nPériode: ${startDate} à ${endDate}`);
        }
    </script>
</body>
</html>