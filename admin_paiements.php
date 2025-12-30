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

    // Paiements par statut pour les badges
    $stmt = $db->query("SELECT statut, COUNT(*) as count FROM paiements GROUP BY statut");
    $status_counts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($status_counts as $stat) {
        $stats[$stat['statut']] = $stat['count'];
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
    <title>Administration AFOR - Gestion des Paiements</title>
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
            justify-content: between;
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

        .bulk-actions {
            background: #F9FAFB;
            padding: 12px 20px;
            border-bottom: 1px solid #E5E7EB;
            display: none;
        }

        .bulk-actions.show {
            display: block;
        }

        .checkbox-input {
            margin-right: 8px;
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
            max-width: 600px;
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
                    <h1 class="text-2xl font-bold text-gray-800">Gestion des Paiements</h1>
                    <div class="flex gap-2">
                        <input type="text" id="searchInput" class="search-input"
                               placeholder="Rechercher par ID transaction, méthode..."
                               value="<?php echo htmlspecialchars($search); ?>">
                        <button onclick="searchPayments()" class="btn-admin">
                            <i class="fas fa-search mr-1"></i> Rechercher
                        </button>
                    </div>
                </div>

                <!-- Onglets de filtrage -->
                <div class="filter-tabs">
                    <div class="filter-tab <?php echo empty($status_filter) ? 'active' : ''; ?>"
                         onclick="filterByStatus('')">
                        Tous (<?php echo array_sum($stats); ?>)
                    </div>
                    <div class="filter-tab <?php echo $status_filter === 'en_attente' ? 'active' : ''; ?>"
                         onclick="filterByStatus('en_attente')">
                        En attente (<?php echo $stats['en_attente'] ?? 0; ?>)
                    </div>
                    <div class="filter-tab <?php echo $status_filter === 'valide' ? 'active' : ''; ?>"
                         onclick="filterByStatus('valide')">
                        Validés (<?php echo $stats['valide'] ?? 0; ?>)
                    </div>
                    <div class="filter-tab <?php echo $status_filter === 'rejete' ? 'active' : ''; ?>"
                         onclick="filterByStatus('rejete')">
                        Rejetés (<?php echo $stats['rejete'] ?? 0; ?>)
                    </div>
                </div>
            </div>

            <!-- Actions groupées -->
            <div class="bulk-actions" id="bulkActions">
                <div class="flex justify-between items-center">
                    <span id="selectedCount">0 paiement(s) sélectionné(s)</span>
                    <div class="flex gap-2">
                        <button onclick="bulkValidate()" class="btn-admin">
                            <i class="fas fa-check mr-1"></i> Valider
                        </button>
                        <button onclick="bulkReject()" class="btn-admin btn-outline">
                            <i class="fas fa-times mr-1"></i> Rejeter
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table des paiements -->
            <div id="paymentsTable">
                <div class="text-center py-8">
                    <div class="loading"></div>
                    <p class="mt-2 text-gray-600">Chargement des paiements...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de détails -->
    <div id="paymentModal" class="modal hidden">
        <div class="modal-content">
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

    <script>
        let currentPage = <?php echo $page; ?>;
        let currentStatus = '<?php echo $status_filter; ?>';
        let currentSearch = '<?php echo addslashes($search); ?>';
        let selectedPayments = [];

        // Charger les paiements au démarrage
        document.addEventListener('DOMContentLoaded', function() {
            loadPayments();

            // Recherche en temps réel
            document.getElementById('searchInput').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    searchPayments();
                }
            });
        });

        function loadPayments() {
            const tableContainer = document.getElementById('paymentsTable');
            tableContainer.innerHTML = `
                <div class="text-center py-8">
                    <div class="loading"></div>
                    <p class="mt-2 text-gray-600">Chargement des paiements...</p>
                </div>
            `;

            fetch(`api/admin_paiements.php?action=get_all&page=${currentPage}&status=${currentStatus}&search=${encodeURIComponent(currentSearch)}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderPaymentsTable(data);
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

        function renderPaymentsTable(data) {
            const { paiements, total, page, limit, total_pages } = data;

            let html = `
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left">
                                <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Souscripteur</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Méthode</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
            `;

            if (paiements.length === 0) {
                html += `
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-3xl mb-4"></i>
                            <p>Aucun paiement trouvé</p>
                        </td>
                    </tr>
                `;
            } else {
                paiements.forEach(payment => {
                    const nomComplet = payment.nom_complet || payment.raison_sociale || 'N/A';
                    const statutClass = `status-${payment.statut}`;
                    const statutText = {
                        'en_attente': 'En attente',
                        'valide': 'Validé',
                        'rejete': 'Rejeté'
                    }[payment.statut] || payment.statut;

                    html += `
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <input type="checkbox" class="checkbox-input" value="${payment.id}" onchange="toggleSelection('${payment.id}')">
                            </td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">${payment.id}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                <div>
                                    <div class="font-medium">${nomComplet}</div>
                                    <div class="text-gray-500 text-xs">${payment.telephone || ''}</div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">${payment.methode}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">${new Intl.NumberFormat('fr-FR').format(payment.montant)} FCFA</td>
                            <td class="px-4 py-3">
                                <span class="status-badge ${statutClass}">${statutText}</span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                ${new Date(payment.date_transaction).toLocaleDateString('fr-FR')}
                            </td>
                            <td class="px-4 py-3 text-sm space-x-2">
                                <button onclick="viewPayment('${payment.id}')" class="btn-outline text-xs px-2 py-1">
                                    <i class="fas fa-eye"></i>
                                </button>
                                ${payment.statut === 'en_attente' ? `
                                    <button onclick="validatePayment('${payment.id}')" class="btn-admin text-xs px-2 py-1">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button onclick="rejectPayment('${payment.id}')" class="btn-admin btn-outline text-xs px-2 py-1">
                                        <i class="fas fa-times"></i>
                                    </button>
                                ` : ''}
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
                        Affichage de ${((page - 1) * limit) + 1} à ${Math.min(page * limit, total)} sur ${total} paiements
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

            document.getElementById('paymentsTable').innerHTML = html;
        }

        function filterByStatus(status) {
            currentStatus = status;
            currentPage = 1;
            loadPayments();

            // Mettre à jour les onglets actifs
            document.querySelectorAll('.filter-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            event.target.classList.add('active');
        }

        function searchPayments() {
            currentSearch = document.getElementById('searchInput').value;
            currentPage = 1;
            loadPayments();
        }

        function changePage(page) {
            currentPage = page;
            loadPayments();
        }

        function toggleSelectAll() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.checkbox-input');

            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
                toggleSelection(checkbox.value);
            });
        }

        function toggleSelection(paymentId) {
            const checkbox = document.querySelector(`input[value="${paymentId}"]`);
            const index = selectedPayments.indexOf(paymentId);

            if (checkbox.checked && index === -1) {
                selectedPayments.push(paymentId);
            } else if (!checkbox.checked && index !== -1) {
                selectedPayments.splice(index, 1);
            }

            updateBulkActions();
        }

        function updateBulkActions() {
            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');

            if (selectedPayments.length > 0) {
                bulkActions.classList.add('show');
                selectedCount.textContent = `${selectedPayments.length} paiement(s) sélectionné(s)`;
            } else {
                bulkActions.classList.remove('show');
            }
        }

        function bulkValidate() {
            if (selectedPayments.length === 0) return;

            if (confirm(`Valider ${selectedPayments.length} paiement(s) ?`)) {
                bulkUpdateStatus('valide');
            }
        }

        function bulkReject() {
            if (selectedPayments.length === 0) return;

            if (confirm(`Rejeter ${selectedPayments.length} paiement(s) ?`)) {
                bulkUpdateStatus('rejete');
            }
        }

        function bulkUpdateStatus(status) {
            fetch('api/admin_paiements.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=bulk_update&ids=${JSON.stringify(selectedPayments)}&status=${status}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    selectedPayments = [];
                    updateBulkActions();
                    loadPayments();
                } else {
                    alert('Erreur: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la mise à jour');
            });
        }

        function validatePayment(paymentId) {
            if (confirm('Valider ce paiement ?')) {
                updatePaymentStatus(paymentId, 'valide');
            }
        }

        function rejectPayment(paymentId) {
            if (confirm('Rejeter ce paiement ?')) {
                updatePaymentStatus(paymentId, 'rejete');
            }
        }

        function updatePaymentStatus(paymentId, status) {
            fetch('api/admin_paiements.php', {
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
                    loadPayments();
                } else {
                    alert('Erreur: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la mise à jour');
            });
        }

        function viewPayment(paymentId) {
            fetch(`api/admin_paiements.php?action=get_details&id=${paymentId}`)
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
                                <p><strong>ID Transaction:</strong> ${payment.numero_transaction || 'N/A'}</p>
                                <p><strong>Code Confirmation:</strong> ${payment.confirmation_code || 'N/A'}</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-2">Informations du Souscripteur</h4>
                                ${payment.identification ? (() => {
                                    const ident = JSON.parse(payment.identification);
                                    return `
                                        <p><strong>Nom:</strong> ${ident.nom_complet || ident.raison_sociale || 'N/A'}</p>
                                        <p><strong>Type:</strong> ${ident.typePersonne === 'physique' ? 'Personne Physique' : 'Personne Morale'}</p>
                                        <p><strong>Téléphone:</strong> ${ident.telephone || 'N/A'}</p>
                                        <p><strong>Email:</strong> ${ident.email || 'N/A'}</p>
                                        <p><strong>Pays:</strong> ${ident.pays || 'N/A'}</p>
                                        <p><strong>Document:</strong> ${ident.document || 'N/A'}</p>
                                        <p><strong>N° Pièce:</strong> ${ident.numero_piece || ident.rccm || 'N/A'}</p>
                                    `;
                                })() : '<p>Aucune information disponible</p>'}
                            </div>
                        </div>
                        ${payment.operation_nom ? `
                            <div class="mt-4">
                                <h4 class="font-semibold text-gray-800 mb-2">Informations de l'Opération</h4>
                                <p><strong>Opération:</strong> ${payment.operation_nom}</p>
                                <p><strong>Localité:</strong> ${payment.localite || 'N/A'}</p>
                            </div>
                        ` : ''}
                        ${payment.zone ? `
                            <div class="mt-4">
                                <h4 class="font-semibold text-gray-800 mb-2">Informations de la Parcelle</h4>
                                <p><strong>Zone:</strong> ${payment.zone}</p>
                                <p><strong>Section-Lot-Parcelle:</strong> ${payment.section}-${payment.lot}-${payment.parcelle}</p>
                                <p><strong>Surface:</strong> ${payment.surface ? new Intl.NumberFormat('fr-FR').format(payment.surface) + ' m²' : 'N/A'}</p>
                                <p><strong>Prix Total:</strong> ${payment.prix ? new Intl.NumberFormat('fr-FR').format(payment.prix) + ' FCFA' : 'N/A'}</p>
                                <p><strong>Acompte:</strong> ${payment.acompte ? new Intl.NumberFormat('fr-FR').format(payment.acompte) + ' FCFA' : 'N/A'}</p>
                            </div>
                        ` : ''}
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