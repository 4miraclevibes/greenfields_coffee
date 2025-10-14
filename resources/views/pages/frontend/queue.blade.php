<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="https://greenfieldsdairy.com/images/favicon/favicon-96x96.png" />
    <title>Antrian Pesanan - Greenfields Coffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: url('{{ asset('bg_greenfields.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            overflow-x: hidden;
        }


        .queue-container {
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
            text-align: center;
        }

        .header h1 {
            color: #2d5a27;
            font-weight: bold;
            font-size: 3rem;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header .subtitle {
            color: #666;
            font-size: 1.2rem;
            margin-bottom: 0;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.2);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #2d5a27;
            margin-bottom: 10px;
        }

        .stat-label {
            color: #666;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .queue-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .queue-card {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .queue-card.process {
            opacity: 0.9;
            transform: scale(0.98);
            background: rgba(255, 255, 255, 0.95);
        }

        .queue-card.completed {
            opacity: 0.8;
            transform: scale(0.95);
            background: rgba(255, 255, 255, 0.92);
        }

        .queue-card.canceled {
            opacity: 0.7;
            transform: scale(0.9);
            background: rgba(255, 255, 255, 0.88);
        }

        .queue-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #4a7c59, #2d5a27);
        }

        .queue-card.process::before {
            background: linear-gradient(90deg, #17a2b8, #138496);
        }

        .queue-card.completed::before {
            background: linear-gradient(90deg, #28a745, #20c997);
        }

        .queue-card.canceled::before {
            background: linear-gradient(90deg, #dc3545, #c82333);
        }

        .queue-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }

        .queue-card.process:hover {
            transform: translateY(-4px) scale(0.99);
        }

        .queue-card.completed:hover {
            transform: translateY(-3px) scale(0.97);
        }

        .queue-card.canceled:hover {
            transform: translateY(-2px) scale(0.92);
        }

        .queue-number {
            background: linear-gradient(135deg, #4a7c59, #2d5a27);
            color: white;
            font-size: 2rem;
            font-weight: bold;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 6px 20px rgba(74, 124, 89, 0.3);
            position: relative;
        }

        .queue-card.process .queue-number {
            background: linear-gradient(135deg, #17a2b8, #138496);
            box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3);
        }

        .queue-card.completed .queue-number {
            background: linear-gradient(135deg, #28a745, #20c997);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        .queue-card.canceled .queue-number {
            background: linear-gradient(135deg, #dc3545, #c82333);
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
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

        .queue-card.process .queue-number::after {
            border-color: rgba(23, 162, 184, 0.2);
            animation: none;
        }

        .queue-card.completed .queue-number::after {
            border-color: rgba(40, 167, 69, 0.2);
            animation: none;
        }

        .queue-card.canceled .queue-number::after {
            border-color: rgba(220, 53, 69, 0.2);
            animation: none;
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            100% { transform: scale(1.2); opacity: 0; }
        }

        .queue-info {
            text-align: center;
            margin-bottom: 20px;
        }

        .room-name {
            font-size: 1.5rem;
            font-weight: bold;
            color: #2d5a27;
            margin-bottom: 5px;
        }

        .order-time {
            color: #666;
            font-size: 1rem;
            margin-bottom: 15px;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: bold;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: linear-gradient(135deg, #ffc107, #ff8f00);
            color: white;
        }

        .status-process {
            background: linear-gradient(135deg, #17a2b8, #138496);
            color: white;
        }

        .status-completed {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .status-canceled {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
        }

        .order-items {
            background: rgba(74, 124, 89, 0.05);
            border-radius: 12px;
            padding: 15px;
            margin-top: 15px;
        }

        .order-items h6 {
            color: #2d5a27;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 1rem;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid rgba(74, 124, 89, 0.1);
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .order-item > div:first-child {
            flex: 1;
        }

        .item-name {
            color: #333;
            font-weight: 500;
            display: block;
        }

        .item-quantity {
            background: rgba(74, 124, 89, 0.1);
            color: #2d5a27;
            padding: 4px 12px;
            border-radius: 15px;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .no-orders {
            text-align: center;
            padding: 60px 20px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        }

        .no-orders i {
            font-size: 4rem;
            color: #6c757d;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .no-orders h3 {
            color: #666;
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .no-orders p {
            color: #999;
            font-size: 1.1rem;
        }

        .refresh-indicator {
            position: fixed;
            top: 20px;
            right: 20px;
            background: rgba(74, 124, 89, 0.9);
            color: white;
            padding: 10px 15px;
            border-radius: 25px;
            font-size: 0.9rem;
            z-index: 1000;
            display: none;
        }

        .refresh-indicator.show {
            display: block;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .queue-grid {
                grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }

            .queue-grid {
                grid-template-columns: 1fr;
            }

            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .header h1 {
                font-size: 1.5rem;
            }

            .stats-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="queue-container">
        <!-- Header -->
        <div class="header">
            <h1><i class="fas fa-coffee"></i> Order Queue</h1>
            <p class="subtitle">Greenfields Coffee - {{ date('d F Y') }}</p>
        </div>

        <!-- Statistics -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-number" id="totalOrders">{{ $transactions->count() }}</div>
                <div class="stat-label">Total Orders</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="pendingOrders">{{ $transactions->where('status', 'pending')->count() }}</div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="completedOrders">{{ $transactions->where('status', 'completed')->count() }}</div>
                <div class="stat-label">Completed</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="canceledOrders">{{ $transactions->where('status', 'canceled')->count() }}</div>
                <div class="stat-label">Cancelled</div>
            </div>
        </div>

        <!-- Queue List -->
        <div id="queueList">
            @if($transactions->count() > 0)
                <div class="queue-grid">
                    @foreach($transactions as $transaction)
                    <div class="queue-card {{ $transaction->status }}">
                        <div class="queue-number">{{ $transaction->queue_number }}</div>
                        <div class="queue-info">
                            <div class="room-name">{{ $transaction->room->name }}</div>
                            <div class="order-time" style="margin-bottom: 5px;">
                                <i class="fas fa-building"></i> {{ $transaction->location }}
                            </div>
                            <div class="order-time">
                                <i class="fas fa-clock"></i> {{ $transaction->created_at->format('H:i') }}
                            </div>

                            <!-- Customer/Responsible Person Info -->
                            @if($transaction->status == 'process' && $transaction->user->name != 'Admin')
                                <div class="responsible-person" style="margin: 12px 0; padding: 12px 16px; background: linear-gradient(135deg, rgba(23, 162, 184, 0.15), rgba(23, 162, 184, 0.25)); border-radius: 12px; border-left: 4px solid #17a2b8;">
                                    <div style="font-size: 0.75rem; color: #138496; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">
                                        <i class="fas fa-user-tie"></i> Responsible Person
                                    </div>
                                    <div style="font-size: 1.1rem; font-weight: bold; color: #0c5460;">
                                        {{ $transaction->user->name }}
                                    </div>
                                </div>
                            @else
                                <div class="customer-info" style="margin: 12px 0; padding: 12px 16px; background: linear-gradient(135deg, rgba(74, 124, 89, 0.15), rgba(74, 124, 89, 0.25)); border-radius: 12px; border-left: 4px solid #4a7c59;">
                                    <div style="font-size: 0.75rem; color: #2d5a27; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">
                                        <i class="fas fa-user"></i> Customer
                                    </div>
                                    <div style="font-size: 1.1rem; font-weight: bold; color: #1e3a1c;">
                                        {{ $transaction->user->name }}
                                    </div>
                                </div>
                            @endif

                            <span class="status-badge status-{{ $transaction->status }}">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </div>
                        <div class="order-items">
                            <h6><i class="fas fa-list"></i> Order Details</h6>
                            @foreach($transaction->transactionDetails as $detail)
                            <div class="order-item">
                                <div>
                                    <span class="item-name">{{ $detail->menu->name }}</span>
                                    <div style="font-size: 0.75rem; color: #666; margin-top: 2px;">
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
                                <span class="item-quantity">{{ $detail->quantity }}x</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="no-orders">
                    <i class="fas fa-coffee"></i>
                    <h3>No Orders Yet</h3>
                    <p>Orders will appear here when they come in</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Refresh Indicator -->
    <div class="refresh-indicator" id="refreshIndicator">
        <i class="fas fa-sync-alt fa-spin"></i> Updating...
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto refresh every 5 seconds
        setInterval(function() {
            refreshQueue();
        }, 5000);

        function refreshQueue() {
            // Show refresh indicator
            const indicator = document.getElementById('refreshIndicator');
            indicator.classList.add('show');

            // Fetch new data
            fetch(window.location.href, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            })
            .then(response => response.text())
            .then(html => {
                // Parse the response and extract the queue list
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newQueueList = doc.getElementById('queueList');
                const newStats = {
                    total: doc.getElementById('totalOrders').textContent,
                    pending: doc.getElementById('pendingOrders').textContent,
                    completed: doc.getElementById('completedOrders').textContent,
                    canceled: doc.getElementById('canceledOrders').textContent
                };

                // Update the queue list
                if (newQueueList) {
                    document.getElementById('queueList').innerHTML = newQueueList.innerHTML;
                }

                // Update statistics
                document.getElementById('totalOrders').textContent = newStats.total;
                document.getElementById('pendingOrders').textContent = newStats.pending;
                document.getElementById('completedOrders').textContent = newStats.completed;
                document.getElementById('canceledOrders').textContent = newStats.canceled;

                // Hide refresh indicator
                setTimeout(() => {
                    indicator.classList.remove('show');
                }, 1000);
            })
            .catch(error => {
                console.error('Error refreshing queue:', error);
                // Hide refresh indicator even on error
                setTimeout(() => {
                    indicator.classList.remove('show');
                }, 1000);
            });
        }

        // Initial load
        console.log('Queue page loaded');
        console.log('Auto-refresh enabled every 5 seconds');
    </script>
</body>
</html>
