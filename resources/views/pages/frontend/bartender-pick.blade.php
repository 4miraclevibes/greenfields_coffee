<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambil Pesanan - Bartender</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="https://greenfieldsdairy.com/images/favicon/favicon-96x96.png" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a4d1a 0%, #2d5a27 50%, #4a7c59 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 80%, rgba(120, 200, 120, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(120, 200, 120, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 200, 120, 0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .container-mobile {
            max-width: 400px;
            margin: 0 auto;
            padding: 10px;
            padding-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        /* Force mobile view even on desktop */
        @media (min-width: 768px) {
            .container-mobile {
                max-width: 400px;
                margin: 20px auto;
                box-shadow: 0 0 30px rgba(0,0,0,0.2);
                border-radius: 20px;
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
            }
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 18px;
            margin-bottom: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header-title {
            color: #2d5a27;
            font-weight: bold;
            font-size: 1.4rem;
            margin-bottom: 5px;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .header-subtitle {
            color: #666;
            font-size: 0.85rem;
            margin-bottom: 10px;
        }

        .bartender-info {
            background: linear-gradient(135deg, #4a7c59, #2d5a27);
            color: white;
            padding: 10px 15px;
            border-radius: 10px;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .order-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .order-card {
            background: white;
            border-radius: 16px;
            padding: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-left: 4px solid #ffc107;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .order-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, #ffc107, #ff8f00);
        }

        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .queue-number {
            background: linear-gradient(135deg, #4a7c59, #2d5a27);
            color: white;
            font-size: 2rem;
            font-weight: bold;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            box-shadow: 0 6px 20px rgba(74, 124, 89, 0.3);
            position: relative;
        }

        .queue-number::after {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            border: 3px solid rgba(74, 124, 89, 0.2);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            100% { transform: scale(1.2); opacity: 0; }
        }

        .order-number {
            background: linear-gradient(135deg, #ffc107, #ff8f00);
            color: white;
            font-weight: bold;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
        }

        .order-time {
            color: #666;
            font-size: 0.75rem;
        }

        .order-info {
            margin-bottom: 12px;
        }

        .info-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 6px;
            font-size: 0.85rem;
        }

        .info-label {
            color: #666;
            font-weight: 500;
        }

        .info-value {
            color: #2d5a27;
            font-weight: bold;
        }

        .order-items {
            background: rgba(74, 124, 89, 0.05);
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 12px;
        }

        .order-items-title {
            color: #2d5a27;
            font-weight: bold;
            font-size: 0.8rem;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 6px 0;
            border-bottom: 1px solid rgba(74, 124, 89, 0.1);
            font-size: 0.8rem;
        }

        .item-row:last-child {
            border-bottom: none;
        }

        .item-name {
            color: #333;
            font-weight: 500;
            flex: 1;
        }

        .item-details {
            font-size: 0.7rem;
            color: #666;
            margin-top: 2px;
        }

        .item-qty {
            background: rgba(74, 124, 89, 0.15);
            color: #2d5a27;
            padding: 2px 8px;
            border-radius: 10px;
            font-weight: bold;
            font-size: 0.75rem;
        }

        .btn-pick {
            background: linear-gradient(135deg, #4a7c59, #2d5a27);
            border: none;
            border-radius: 12px;
            padding: 10px;
            color: white;
            font-weight: bold;
            font-size: 0.9rem;
            width: 100%;
            box-shadow: 0 3px 10px rgba(74, 124, 89, 0.3);
            transition: all 0.3s ease;
        }

        .btn-pick:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(74, 124, 89, 0.4);
            background: linear-gradient(135deg, #3d6847, #234019);
        }

        .btn-pick:active {
            transform: translateY(-1px);
        }

        .empty-state {
            background: white;
            border-radius: 16px;
            padding: 40px 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .empty-icon {
            font-size: 4rem;
            color: #6c757d;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-title {
            color: #2d5a27;
            font-weight: bold;
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .empty-text {
            color: #666;
            font-size: 0.9rem;
        }

        .alert-custom {
            border-radius: 12px;
            padding: 12px 15px;
            margin-bottom: 15px;
            font-size: 0.85rem;
        }

        .alert-success-custom {
            background: rgba(40, 167, 69, 0.1);
            border: 1px solid rgba(40, 167, 69, 0.3);
            color: #28a745;
        }

        .alert-error-custom {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #dc3545;
        }

        .refresh-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #4a7c59, #2d5a27);
            color: white;
            border: none;
            border-radius: 50%;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .refresh-btn:hover {
            transform: scale(1.1) rotate(180deg);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }

        /* Custom Confirm Modal */
        .confirm-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            z-index: 9999;
            animation: fadeIn 0.3s ease;
        }

        .confirm-overlay.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .confirm-modal {
            background: white;
            border-radius: 20px;
            padding: 0;
            max-width: 350px;
            width: 90%;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            animation: slideUp 0.3s ease;
            overflow: hidden;
        }

        .confirm-header {
            background: linear-gradient(135deg, #4a7c59, #2d5a27);
            color: white;
            padding: 20px;
            text-align: center;
        }

        .confirm-icon {
            font-size: 3rem;
            margin-bottom: 10px;
            animation: bounce 1s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .confirm-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin: 0;
        }

        .confirm-body {
            padding: 25px 20px;
            text-align: center;
        }

        .confirm-text {
            color: #333;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .confirm-details {
            background: rgba(74, 124, 89, 0.05);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: left;
        }

        .confirm-detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            font-size: 0.85rem;
        }

        .confirm-detail-row:last-child {
            margin-bottom: 0;
        }

        .confirm-detail-label {
            color: #666;
            font-weight: 500;
        }

        .confirm-detail-value {
            color: #2d5a27;
            font-weight: bold;
        }

        .confirm-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-confirm-cancel,
        .btn-confirm-yes {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 12px;
            font-weight: bold;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-confirm-cancel {
            background: #f8f9fa;
            color: #666;
            border: 2px solid #dee2e6;
        }

        .btn-confirm-cancel:hover {
            background: #e9ecef;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .btn-confirm-yes {
            background: linear-gradient(135deg, #4a7c59, #2d5a27);
            color: white;
            box-shadow: 0 4px 15px rgba(74, 124, 89, 0.3);
        }

        .btn-confirm-yes:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 124, 89, 0.4);
        }

        .btn-confirm-yes:active,
        .btn-confirm-cancel:active {
            transform: translateY(0);
        }

        @media (max-width: 480px) {
            .order-grid {
                gap: 12px;
            }

            .order-card {
                padding: 12px;
            }

            .header {
                padding: 15px;
            }

            .header-title {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-mobile">
        <!-- Header -->
        <div class="header text-center">
            <h1 class="header-title">
                <i class="fas fa-tasks"></i> Pick Order
            </h1>
            <p class="header-subtitle">Select the order you want to process</p>
            <div class="bartender-info">
                <i class="fas fa-user-circle"></i>
                <span>{{ auth()->user()->name }}</span>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
        <div class="alert-custom alert-success-custom">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert-custom alert-error-custom">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
        @endif

        <!-- Order List -->
        <div class="order-grid" id="orderList">
            @forelse($transactions as $transaction)
            <div class="order-card">
                <div class="queue-number">{{ $transaction->queue_number }}</div>
                <div class="order-header">
                    <div class="order-number">
                        <i class="fas fa-hashtag"></i> {{ $transaction->id }}
                    </div>
                    <div class="order-time">
                        <i class="fas fa-clock"></i> {{ $transaction->created_at->format('H:i') }}
                    </div>
                </div>

                <div class="order-info">
                    <div class="info-row">
                        <i class="fas fa-building" style="color: #4a7c59;"></i>
                        <span class="info-label">Office:</span>
                        <span class="info-value">{{ $transaction->room->name }}</span>
                    </div>
                    <div class="info-row">
                        <i class="fas fa-map-marker-alt" style="color: #4a7c59;"></i>
                        <span class="info-label">Location:</span>
                        <span class="info-value">{{ $transaction->location }}</span>
                    </div>
                </div>

                <div class="order-items">
                    <div class="order-items-title">
                        <i class="fas fa-list"></i> Order Details ({{ $transaction->transactionDetails->count() }} Items)
                    </div>
                    @foreach($transaction->transactionDetails as $detail)
                    <div class="item-row">
                        <div style="flex: 1;">
                            <div class="item-name">{{ $detail->menu->name }}</div>
                            <div class="item-details">
                                <i class="fas fa-user"></i> {{ $detail->employee }} |
                                @php
                                    $variantParts = explode('_', $detail->variant);
                                    $temp = $variantParts[0] ?? 'ice';
                                    $sugar = implode('_', array_slice($variantParts, 1)) ?: 'normal';

                                    $tempLabel = $temp == 'ice' ? '🧊 Ice' : '🔥 Hot';
                                    $sugarLabels = [
                                        'less_sugar' => 'Less Sweet',
                                        'normal' => 'Normal',
                                        'no_sugar' => 'No Sugar'
                                    ];
                                    $sugarLabel = $sugarLabels[$sugar] ?? ucfirst(str_replace('_', ' ', $sugar));
                                @endphp
                                <i class="fas fa-temperature-low"></i> {{ $tempLabel }} |
                                <i class="fas fa-sliders-h"></i> {{ $sugarLabel }}
                            </div>
                        </div>
                        <span class="item-qty">{{ $detail->quantity }}x</span>
                    </div>
                    @endforeach
                </div>

                <form action="{{ route('bartender.pick.order.store', $transaction->id) }}" method="POST" class="order-form">
                    @csrf
                    <button type="button" class="btn-pick"
                            data-queue-number="{{ $transaction->queue_number }}"
                            data-order-id="{{ $transaction->id }}"
                            data-room="{{ $transaction->room->name }}"
                            data-location="{{ $transaction->location }}"
                            data-items="{{ $transaction->transactionDetails->count() }}"
                            onclick="showConfirm(this)">
                        <i class="fas fa-hand-paper"></i> Pick This Order
                    </button>
                </form>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-coffee"></i>
                </div>
                <h3 class="empty-title">No Orders</h3>
                <p class="empty-text">There are currently no orders to process. Please refresh the page to see new orders.</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Refresh Button -->
    <button class="refresh-btn" onclick="location.reload()" title="Refresh">
        <i class="fas fa-sync-alt"></i>
    </button>

    <!-- Custom Confirm Modal -->
    <div class="confirm-overlay" id="confirmOverlay">
        <div class="confirm-modal">
            <div class="confirm-header">
                <div class="confirm-icon">
                    <i class="fas fa-hand-paper"></i>
                </div>
                <h3 class="confirm-title">Confirm Pick Order</h3>
            </div>
            <div class="confirm-body">
                <p class="confirm-text">
                    Are you sure you want to pick this order? The order will immediately be added to your processing list.
                </p>
                <div class="confirm-details" id="confirmDetails">
                    <!-- Details will be inserted by JavaScript -->
                </div>
                <div class="confirm-buttons">
                    <button type="button" class="btn-confirm-cancel" onclick="hideConfirm()">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="button" class="btn-confirm-yes" onclick="submitOrder()">
                        <i class="fas fa-check"></i> Yes, Pick It!
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentForm = null;

        // Auto refresh every 10 seconds
        setInterval(function() {
            location.reload();
        }, 10000);

        function showConfirm(button) {
            const queueNumber = button.dataset.queueNumber;
            const orderId = button.dataset.orderId;
            const room = button.dataset.room;
            const location = button.dataset.location;
            const items = button.dataset.items;

            currentForm = button.closest('form');

            // Build details HTML
            const detailsHTML = `
                <div class="confirm-detail-row">
                    <span class="confirm-detail-label">
                        <i class="fas fa-list-ol"></i> Queue Number:
                    </span>
                    <span class="confirm-detail-value">#${queueNumber}</span>
                </div>
                <div class="confirm-detail-row">
                    <span class="confirm-detail-label">
                        <i class="fas fa-hashtag"></i> Order ID:
                    </span>
                    <span class="confirm-detail-value">#${orderId}</span>
                </div>
                <div class="confirm-detail-row">
                    <span class="confirm-detail-label">
                        <i class="fas fa-building"></i> Office:
                    </span>
                    <span class="confirm-detail-value">${room}</span>
                </div>
                <div class="confirm-detail-row">
                    <span class="confirm-detail-label">
                        <i class="fas fa-map-marker-alt"></i> Location:
                    </span>
                    <span class="confirm-detail-value">${location}</span>
                </div>
                <div class="confirm-detail-row">
                    <span class="confirm-detail-label">
                                <i class="fas fa-coffee"></i> Total Items:
                            </span>
                            <span class="confirm-detail-value">${items} Items</span>
                </div>
            `;

            document.getElementById('confirmDetails').innerHTML = detailsHTML;
            document.getElementById('confirmOverlay').classList.add('show');
        }

        function hideConfirm() {
            document.getElementById('confirmOverlay').classList.remove('show');
            currentForm = null;
        }

        function submitOrder() {
            if (!currentForm) {
                console.error('No form found');
                return;
            }

            try {
                // Save form reference before hiding modal
                const formToSubmit = currentForm;

                // Update button text
                const btn = formToSubmit.querySelector('.btn-pick');
                if (btn) {
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                    btn.disabled = true;
                }

                // Hide modal first
                hideConfirm();

                // Submit form after a short delay to ensure modal is closed
                setTimeout(() => {
                    if (formToSubmit) {
                        formToSubmit.submit();
                    }
                }, 100);
            } catch (error) {
                console.error('Submit error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
                location.reload();
            }
        }

        // Close modal when clicking outside
        document.getElementById('confirmOverlay').addEventListener('click', function(e) {
            if (e.target === this) {
                hideConfirm();
            }
        });

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                hideConfirm();
            }
        });
    </script>
</body>
</html>

