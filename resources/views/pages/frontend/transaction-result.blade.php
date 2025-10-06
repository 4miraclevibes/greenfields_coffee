<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - {{ $transaction->room->name }}</title>
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
            position: relative;
            z-index: 1;
        }

        .success-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 25px;
            padding: 35px 25px;
            margin: 25px 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .success-icon {
            font-size: 5rem;
            color: #4a7c59;
            margin-bottom: 25px;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        .success-title {
            color: #2d5a27;
            font-weight: bold;
            font-size: 2rem;
            margin-bottom: 15px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .success-subtitle {
            color: #666;
            font-size: 1rem;
            margin-bottom: 30px;
        }

        .order-details {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 25px;
            margin: 25px 0;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .order-header {
            background: #4a7c59;
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
            transition: all 0.3s ease;
        }

        .order-item:hover {
            background: rgba(74, 124, 89, 0.05);
            border-radius: 8px;
            padding: 15px 10px;
            margin: 0 -10px;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .item-name {
            font-weight: bold;
            color: #2d5a27;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .item-name::before {
            content: '☕';
            font-size: 1.1rem;
        }

        .item-quantity {
            color: #666;
            font-size: 0.9rem;
        }

        .item-price {
            font-weight: bold;
            color: #4a7c59;
            font-size: 1.1rem;
        }

        .total-section {
            background: linear-gradient(135deg, #4a7c59, #2d5a27);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-top: 20px;
            text-align: center;
        }

        .total-price {
            font-size: 1.4rem;
            font-weight: bold;
            color: white;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .status-pending {
            background: linear-gradient(135deg, #ffc107, #ff8f00);
            color: white;
        }

        .status-process {
            background: linear-gradient(135deg, #17a2b8, #138496);
            color: white;
            animation: processPulse 2s infinite;
        }

        .status-completed {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .status-canceled {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
        }

        @keyframes processPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .btn-home {
            background: linear-gradient(135deg, #4a7c59, #2d5a27);
            border: none;
            border-radius: 30px;
            padding: 18px 35px;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
            width: 100%;
            box-shadow: 0 6px 20px rgba(74, 124, 89, 0.4);
            margin-top: 25px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-home::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-home:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(74, 124, 89, 0.5);
        }

        .btn-home:hover::before {
            left: 100%;
        }

        .btn-home:active {
            transform: translateY(-1px);
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

        .responsible-person {
            margin: 8px 0;
            padding: 6px 12px;
            background: rgba(23, 162, 184, 0.1);
            border-radius: 15px;
            font-size: 0.9rem;
            color: #138496;
        }

        .status-icon {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container-mobile">
        <!-- Success Message -->
        <div class="success-card" id="successCard">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1 class="success-title">Pesanan Berhasil!</h1>
            <p class="success-subtitle">
                Terima kasih telah memesan kopi di {{ $transaction->room->name }}
            </p>
            <span class="status-badge status-{{ $transaction->status }}">
                @if($transaction->status == 'pending')
                    <i class="fas fa-clock status-icon"></i> Menunggu
                @elseif($transaction->status == 'process')
                    <i class="fas fa-spinner fa-spin status-icon"></i> Diproses
                @elseif($transaction->status == 'completed')
                    <i class="fas fa-check-circle status-icon"></i> Selesai
                @elseif($transaction->status == 'canceled')
                    <i class="fas fa-times-circle status-icon"></i> Dibatalkan
                @endif
            </span>
            @if($transaction->status == 'process' && $transaction->user->name != 'Admin')
                <div class="responsible-person">
                    <i class="fas fa-user"></i> Diproses oleh: <strong>{{ $transaction->user->name }}</strong>
                </div>
            @endif
        </div>

        <!-- Order Details -->
        <div class="order-details">
            <div class="order-header">
                <h5 class="mb-0">
                    <i class="fas fa-receipt"></i> Detail Pesanan
                </h5>
            </div>

            <div class="mb-3">
                <strong>Ruangan:</strong> {{ $transaction->room->name }}<br>
                <strong>Lokasi Kirim:</strong> {{ $transaction->location }}<br>
                <strong>Waktu Pesan:</strong> {{ $transaction->created_at->format('d/m/Y H:i') }}<br>
                <strong>ID Pesanan:</strong> #{{ $transaction->id }}
            </div>

            <h6 class="mb-3">Item yang dipesan:</h6>
            @foreach($transaction->transactionDetails as $detail)
            <div class="order-item">
                <div>
                    <div class="item-name">{{ $detail->menu->name }}</div>
                    <div class="item-quantity">
                        <i class="fas fa-user"></i> {{ $detail->employee }} |
                        <i class="fas fa-sliders-h"></i>
                        @if($detail->variant == 'less_sugar')
                            Kurang Manis
                        @elseif($detail->variant == 'normal')
                            Normal
                        @elseif($detail->variant == 'no_sugar')
                            Tanpa Gula
                        @endif
                    </div>
                </div>
                <div class="item-price">
                    <i class="fas fa-check-circle text-success"></i>
                </div>
            </div>
            @endforeach

            <div class="total-section">
                <div class="d-flex justify-content-center align-items-center">
                    <span class="total-price">
                        <i class="fas fa-coffee"></i> Total {{ $transaction->transactionDetails->sum('quantity') }} Item
                    </span>
                </div>
            </div>
        </div>

        <!-- Action Button -->
        <button class="btn btn-home" onclick="window.location.href='{{ route('transaction', $transaction->room_id) }}'">
            <i class="fas fa-coffee"></i> Pesan Lagi
        </button>
    </div>

    <!-- Refresh Indicator -->
    <div class="refresh-indicator" id="refreshIndicator">
        <i class="fas fa-sync-alt fa-spin"></i> Memperbarui status...
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto refresh every 5 seconds
        setInterval(function() {
            refreshTransactionStatus();
        }, 5000);

        function refreshTransactionStatus() {
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
                // Parse the response and extract the updated content
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newSuccessCard = doc.getElementById('successCard');

                // Update the success card with new status
                if (newSuccessCard) {
                    document.getElementById('successCard').innerHTML = newSuccessCard.innerHTML;
                }

                // Hide refresh indicator
                setTimeout(() => {
                    indicator.classList.remove('show');
                }, 1000);
            })
            .catch(error => {
                console.error('Error refreshing transaction status:', error);
                // Hide refresh indicator even on error
                setTimeout(() => {
                    indicator.classList.remove('show');
                }, 1000);
            });
        }

        // Initial load
        console.log('Transaction result page loaded');
        console.log('Auto-refresh enabled every 5 seconds');
    </script>
</body>
</html>
