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

// Paramètres de filtrage
$page = intval($_GET['page'] ?? 1);
$status_filter = $_GET['status'] ?? '';
$search = $_GET['search'] ?? '';

try {
    // Statistiques pour les filtres
    $stats = [];

    // Souscriptions par statut
    $stmt = $db->query("
        SELECT
            CASE
                WHEN p.statut = 'valide' THEN 'complete'
                WHEN p.statut = 'en_attente' THEN 'en_cours'
                WHEN p.statut IS NULL OR p.statut = '' THEN 'sans_paiement'
                ELSE 'autre'
            END as status_group,
            COUNT(*) as count
        FROM operations o
        LEFT JOIN paiements p ON o.id = p.operation_id
        GROUP BY status_group
    ");
    $status_counts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($status_counts as $stat) {
        $stats[$stat['status_group']] = $stat['count'];
    }

} catch (Exception $e) {
    $error = "Erreur lors de la récupération des statistiques: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration AFOR - Gestion des Souscriptions</title>
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

        .status-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-complete {
            background: #E8F5E8;
            color: #2E7D32;
        }

        .status-en_cours {
            background: #FFF3E0;
            color: #FF6F00;
        }

        .status-sans_paiement {
            background: #F3E5F5;
            color: #7B1FA2;
        }

        .status-autre {
            background: #FFEBEE;
            color: #C62828;
        }

        .btn-admin {
            background-color: #FF6F00;
            color: white;
            padding: 6px 12px;
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

        .btn-outline {
            border: 1px solid #FF6F00;
            color: #FF6F00;
            background: transparent;
        }

        .btn-outline:hover {
            background-color: #FF6F00;
            color: white;
        }

        .table-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .table-header {
            background: #F9FAFB;
            border-bottom: 1px solid #E5E7EB;
            padding: 16px 20px;
        }

        .filter-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 16px;
        }

        .filter-tab {
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #F3F4F6;
            color: #6B7280;
        }

        .filter-tab.active {
            background: #FF6F00;
            color: white;
        }

        .filter-tab:hover:not(.active) {
            background: #E5E7EB;
        }

        .search-input {
            padding: 8px 12px;
            border: 1px solid #D1D5DB;
            border-radius: 6px;
            font-size: 0.875rem;
            width: 250px;
        }

        .search-input:focus {
            outline: none;
            border-color: #FF6F00;
            box-shadow: 0 0 0 3px rgba(255, 111, 0, 0.1);
        }

        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            background: #F9FAFB;
            border-top: 1px solid #E5E7EB;
        }

        .pagination-info {
            font-size: 0.875rem;
            color: #6B7280;
        }

        .pagination-buttons {
            display: flex;
            gap: 4px;
        }

        .pagination-btn {
            padding: 6px 12px;
            border: 1px solid #D1D5DB;
            background: white;
            color: #374151;
            border-radius: 4px;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .pagination-btn:hover:not(:disabled) {
            background: #F3F4F6;
        }

        .pagination-btn.active {
            background: #FF6F00;
            color: white;
            border-color: #FF6F00;
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal.hidden {
            display: none;
        }

        .modal-content {
            background: white;
            padding: 24px;
            border-radius: 10px;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .loading {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #FF6F00;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
        <!-- Filtres et recherche -->
        <div class="table-container mb-6">
            <div class="table-header">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold text-gray-800">Gestion des Souscriptions</h1>
                    <div class="flex gap-2">
                        <input type="text" id="searchInput" class="search-input"
                               placeholder="Rechercher par nom, opération..."
                               value="<?php echo htmlspecialchars($search); ?>">
                        <button onclick="searchSouscriptions()" class="btn-admin">
                            <i class="fas fa-search mr-1"></i> Rechercher
                        </button>
                    </div>
                </div>

                <!-- Onglets de filtrage -->
                <div class="filter-tabs">
                    <div class="filter-tab <?php echo empty($status_filter) ? 'active' : ''; ?>"
                         onclick="filterByStatus('')">
                        Toutes (<?php echo array_sum($stats); ?>)
                    </div>
                    <div class="filter-tab <?php echo $status_filter === 'complete' ? 'active' : ''; ?>"
                         onclick="filterByStatus('complete')">
                        Complètes (<?php echo $stats['complete'] ?? 0; ?>)
                    </div>
                    <div class="filter-tab <?php echo $status_filter === 'en_cours' ? 'active' : ''; ?>"
                         onclick="filterByStatus('en_cours')">
                        En cours (<?php echo $stats['en_cours'] ?? 0; ?>)
                    </div>
                    <div class="filter-tab <?php echo $status_filter === 'sans_paiement' ? 'active' : ''; ?>"
                         onclick="filterByStatus('sans_paiement')">
                        Sans paiement (<?php echo $stats['sans_paiement'] ?? 0; ?>)
                    </div>
                </div>
            </div>

            <!-- Table des souscriptions -->
            <div id="souscriptionsTable">
                <div class="text-center py-8">
                    <div class="loading"></div>
                    <p class="mt-2 text-gray-600">Chargement des souscriptions...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de détails -->
    <div id="souscriptionModal" class="modal hidden">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-800">Détails de la Souscription</h3>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="souscriptionDetails" class="space-y-4">
                <!-- Les détails seront chargés ici -->
            </div>
        </div>
    </div>

    <script>
        let currentPage = <?php echo $page; ?>;
        let currentStatus = '<?php echo $status_filter; ?>';
        let currentSearch = '<?php echo addslashes($search); ?>';

        // Charger les souscriptions au démarrage
        document.addEventListener('DOMContentLoaded', function() {
            loadSouscriptions();

            // Recherche en temps réel
            document.getElementById('searchInput').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    searchSouscriptions();
                }
            });
        });

        function loadSouscriptions() {
            const tableContainer = document.getElementById('souscriptionsTable');
            tableContainer.innerHTML = `
                <div class="text-center py-8">
                    <div class="loading"></div>
                    <p class="mt-2 text-gray-600">Chargement des souscriptions...</p>
                </div>
            `;

            fetch(`api/admin_souscriptions.php?action=get_all&page=${currentPage}&status=${currentStatus}&search=${encodeURIComponent(currentSearch)}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderSouscriptionsTable(data);
                } else {
                    tableContainer.innerHTML = `
                        <div class="text-center py-8 text-red-600">
                            <i class="fas fa-exclamation-triangle text-3xl mb-4"></i>
                            <p>Erreur: ${data.message}</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                tableContainer.innerHTML = `
                    <div class="text-center py-8 text-red-600">
                        <i class="fas fa-exclamation-triangle text-3xl mb-4"></i>
                        <p>Erreur de connexion au serveur</p>
                    </div>
                `;
            });
        }

        function renderSouscriptionsTable(data) {
            const { souscriptions, total, page, limit, total_pages } = data;

            let html = `
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Souscripteur</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Opération</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Parcelle</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
            `;

            if (souscriptions.length === 0) {
                html += `
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-3xl mb-4"></i>
                            <p>Aucune souscription trouvée</p>
                        </td>
                    </tr>
                `;
            } else {
                souscriptions.forEach(souscription => {
                    const statusClass = `status-${souscription.status_group}`;
                    const statusText = {
                        'complete': 'Complète',
                        'en_cours': 'En cours',
                        'sans_paiement': 'Sans paiement',
                        'autre': 'Autre'
                    }[souscription.status_group] || souscription.status_group;

                    html += `
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">${souscription.operation_id}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                <div>
                                    <div class="font-medium">${souscription.nom_complet || souscription.raison_sociale || 'N/A'}</div>
                                    <div class="text-gray-500 text-xs">${souscription.telephone || ''}</div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                <div>
                                    <div class="font-medium">${souscription.intitule}</div>
                                    <div class="text-gray-500 text-xs">${souscription.localite}</div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                ${souscription.zone ? `${souscription.zone} - ${souscription.section}-${souscription.lot}-${souscription.parcelle}` : 'N/A'}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                ${souscription.montant_souscription ? new Intl.NumberFormat('fr-FR').format(souscription.montant_souscription) + ' FCFA' : 'N/A'}
                            </td>
                            <td class="px-4 py-3">
                                <span class="status-badge ${statusClass}">${statusText}</span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                ${new Date(souscription.date_creation).toLocaleDateString('fr-FR')}
                            </td>
                            <td class="px-4 py-3 text-sm space-x-2">
                                <button onclick="viewSouscription('${souscription.operation_id}')" class="btn-outline text-xs px-2 py-1">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button onclick="printSouscription('${souscription.operation_id}')" class="btn-admin text-xs px-2 py-1">
                                    <i class="fas fa-print"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
            }

            html += `
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination">
                    <div class="pagination-info">
                        Affichage de ${((page - 1) * limit) + 1} à ${Math.min(page * limit, total)} sur ${total} souscriptions
                    </div>
                    <div class="pagination-buttons">
                        <button class="pagination-btn ${page <= 1 ? 'disabled' : ''}"
                                onclick="changePage(${page - 1})" ${page <= 1 ? 'disabled' : ''}>
                            <i class="fas fa-chevron-left"></i>
                        </button>
            `;

            for (let i = Math.max(1, page - 2); i <= Math.min(total_pages, page + 2); i++) {
                html += `
                    <button class="pagination-btn ${i === page ? 'active' : ''}" onclick="changePage(${i})">
                        ${i}
                    </button>
                `;
            }

            html += `
                        <button class="pagination-btn ${page >= total_pages ? 'disabled' : ''}"
                                onclick="changePage(${page + 1})" ${page >= total_pages ? 'disabled' : ''}>
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            `;

            document.getElementById('souscriptionsTable').innerHTML = html;
        }

        function filterByStatus(status) {
            currentStatus = status;
            currentPage = 1;
            loadSouscriptions();

            // Mettre à jour les onglets actifs
            document.querySelectorAll('.filter-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            event.target.classList.add('active');
        }

        function searchSouscriptions() {
            currentSearch = document.getElementById('searchInput').value;
            currentPage = 1;
            loadSouscriptions();
        }

        function changePage(page) {
            currentPage = page;
            loadSouscriptions();
        }

        function viewSouscription(operationId) {
            fetch(`api/admin_souscriptions.php?action=get_details&id=${operationId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const souscription = data.souscription;
                    const details = `
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-3">Informations du Souscripteur</h4>
                                <div class="space-y-2">
                                    <p><strong>Nom:</strong> ${souscription.nom_complet || souscription.raison_sociale || 'N/A'}</p>
                                    <p><strong>Type:</strong> ${souscription.type_personne === 'physique' ? 'Personne Physique' : 'Personne Morale'}</p>
                                    <p><strong>Téléphone:</strong> ${souscription.telephone || 'N/A'}</p>
                                    <p><strong>Email:</strong> ${souscription.email || 'N/A'}</p>
                                    <p><strong>Pays:</strong> ${souscription.pays || 'N/A'}</p>
                                    <p><strong>Document:</strong> ${souscription.document || 'N/A'}</p>
                                    <p><strong>N° Pièce:</strong> ${souscription.numero_piece || souscription.rccm || 'N/A'}</p>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-3">Informations de l'Opération</h4>
                                <div class="space-y-2">
                                    <p><strong>Opération:</strong> ${souscription.intitule}</p>
                                    <p><strong>Localité:</strong> ${souscription.localite}</p>
                                    <p><strong>Montant souscription:</strong> ${souscription.montant_souscription ? new Intl.NumberFormat('fr-FR').format(souscription.montant_souscription) + ' FCFA' : 'N/A'}</p>
                                    <p><strong>Date création:</strong> ${new Date(souscription.date_creation).toLocaleString('fr-FR')}</p>
                                </div>
                            </div>
                        </div>

                        ${souscription.parcelle ? `
                            <div class="mt-6">
                                <h4 class="font-semibold text-gray-800 mb-3">Informations de la Parcelle</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <p><strong>Zone:</strong> ${souscription.parcelle.zone || 'N/A'}</p>
                                        <p><strong>Section:</strong> ${souscription.parcelle.section || 'N/A'}</p>
                                        <p><strong>Lot:</strong> ${souscription.parcelle.lot || 'N/A'}</p>
                                        <p><strong>Parcelle:</strong> ${souscription.parcelle.parcelle || 'N/A'}</p>
                                    </div>
                                    <div class="space-y-2">
                                        <p><strong>Surface:</strong> ${souscription.parcelle.surface ? new Intl.NumberFormat('fr-FR').format(souscription.parcelle.surface) + ' m²' : 'N/A'}</p>
                                        <p><strong>Prix total:</strong> ${souscription.parcelle.prix ? new Intl.NumberFormat('fr-FR').format(souscription.parcelle.prix) + ' FCFA' : 'N/A'}</p>
                                        <p><strong>Acompte:</strong> ${souscription.parcelle.acompte ? new Intl.NumberFormat('fr-FR').format(souscription.parcelle.acompte) + ' FCFA' : 'N/A'}</p>
                                        <p><strong>Reste à payer:</strong> ${souscription.parcelle.reste_a_payer ? new Intl.NumberFormat('fr-FR').format(souscription.parcelle.reste_a_payer) + ' FCFA' : 'N/A'}</p>
                                    </div>
                                </div>
                            </div>
                        ` : ''}

                        ${souscription.paiements && souscription.paiements.length > 0 ? `
                            <div class="mt-6">
                                <h4 class="font-semibold text-gray-800 mb-3">Historique des Paiements</h4>
                                <div class="space-y-2">
                                    ${souscription.paiements.map(paiement => `
                                        <div class="border rounded p-3 bg-gray-50">
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <span class="font-medium">${paiement.methode}</span>
                                                    <span class="text-sm text-gray-600 ml-2">${new Intl.NumberFormat('fr-FR').format(paiement.montant)} FCFA</span>
                                                </div>
                                                <span class="status-badge status-${paiement.statut}">${paiement.statut}</span>
                                            </div>
                                            <div class="text-sm text-gray-600 mt-1">
                                                ${new Date(paiement.date_transaction).toLocaleString('fr-FR')}
                                                ${paiement.numero_transaction ? ` - ID: ${paiement.numero_transaction}` : ''}
                                            </div>
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                        ` : `
                            <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded">
                                <p class="text-yellow-800"><i class="fas fa-exclamation-triangle mr-2"></i>Aucun paiement enregistré pour cette souscription.</p>
                            </div>
                        `}
                    `;
                    document.getElementById('souscriptionDetails').innerHTML = details;
                    document.getElementById('souscriptionModal').classList.remove('hidden');
                } else {
                    alert('Erreur lors du chargement des détails');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors du chargement des détails');
            });
        }

        function printSouscription(operationId) {
            // Ouvrir une nouvelle fenêtre pour l'impression
            const printWindow = window.open(`print_souscription.php?id=${operationId}`, '_blank');
            if (printWindow) {
                printWindow.focus();
            } else {
                alert('Veuillez autoriser les popups pour cette fonctionnalité');
            }
        }

        function closeModal() {
            document.getElementById('souscriptionModal').classList.add('hidden');
        }

        // Fermer la modal en cliquant en dehors
        document.getElementById('souscriptionModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>