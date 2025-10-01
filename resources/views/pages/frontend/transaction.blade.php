<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Kopi - {{ $room->name }}</title>
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
            padding-bottom: 250px; /* Space for fixed cart */
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

        .room-title {
            color: #2d5a27;
            font-weight: bold;
            font-size: 1.4rem;
            margin-bottom: 5px;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .menu-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        /* Ensure equal height cards */
        .menu-grid .menu-card {
            min-height: auto;
        }

        .menu-card {
            background: white;
            border-radius: 16px;
            padding: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-left: 4px solid #4a7c59;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .menu-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, #4a7c59, #2d5a27);
        }

        .menu-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .menu-image {
            width: 100%;
            height: 120px;
            border-radius: 10px;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 0.9rem;
            border: 2px dashed #dee2e6;
            position: relative;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .menu-content {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
        }

        .menu-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }

        .no-image {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            height: 100%;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 8px;
        }

        .no-image i {
            font-size: 1.5rem;
            margin-bottom: 6px;
            opacity: 0.4;
            color: #6c757d;
        }

        .no-image div {
            font-size: 0.8rem;
            color: #6c757d;
            font-weight: 500;
        }

        .menu-info {
            margin-bottom: 8px;
        }

        .menu-name {
            color: #2d5a27;
            font-weight: bold;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 5px;
            line-height: 1.2;
            margin-bottom: 4px;
        }

        .menu-name::before {
            content: '☕';
            font-size: 1rem;
        }

        .menu-desc {
            color: #666;
            font-size: 0.75rem;
            line-height: 1.2;
            font-style: italic;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .variant-section {
            margin: 0;
        }

        .variant-title {
            font-size: 0.7rem;
            font-weight: 600;
            color: #2d5a27;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .variant-options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 6px;
        }

        .variant-option {
            position: relative;
        }

        .variant-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .variant-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 8px 4px;
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.7rem;
            font-weight: 600;
            color: #495057;
            text-align: center;
            height: 100%;
        }

        .variant-label .variant-emoji {
            font-size: 1.3rem;
            line-height: 1;
        }

        .variant-label .variant-text {
            line-height: 1.1;
            white-space: nowrap;
        }

        .variant-option input[type="radio"]:checked + .variant-label {
            border-color: #4a7c59;
            background: #4a7c59;
            color: white;
            box-shadow: 0 3px 8px rgba(74, 124, 89, 0.3);
            transform: scale(1.02);
        }

        .variant-label:hover {
            border-color: #4a7c59;
            background: rgba(74, 124, 89, 0.05);
            transform: translateY(-2px);
        }

        .variant-option input[type="radio"]:checked + .variant-label:hover {
            background: #3d6847;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: auto;
        }

        .btn-quantity {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid #4a7c59;
            background: white;
            color: #4a7c59;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(74, 124, 89, 0.2);
            font-size: 0.9rem;
        }

        .btn-quantity:hover {
            background: #4a7c59;
            color: white;
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(74, 124, 89, 0.3);
        }

        .btn-quantity:active {
            transform: scale(0.95);
        }

        .quantity-display {
            min-width: 35px;
            text-align: center;
            font-weight: bold;
            color: #2d5a27;
            font-size: 1rem;
            background: rgba(74, 124, 89, 0.1);
            border-radius: 6px;
            padding: 6px 8px;
            border: 2px solid rgba(74, 124, 89, 0.2);
        }

        .cart-summary {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 15px;
            margin-top: 15px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-height: 200px;
            z-index: 1000;
        }

        /* Cart items container */
        #cartItems {
            max-height: 120px;
            overflow-y: auto;
        }

        /* Custom scrollbar for cart */
        .cart-summary::-webkit-scrollbar {
            width: 4px;
        }

        .cart-summary::-webkit-scrollbar-track {
            background: rgba(74, 124, 89, 0.1);
            border-radius: 2px;
        }

        .cart-summary::-webkit-scrollbar-thumb {
            background: rgba(74, 124, 89, 0.3);
            border-radius: 2px;
        }

        .cart-summary::-webkit-scrollbar-thumb:hover {
            background: rgba(74, 124, 89, 0.5);
        }

        .btn-order {
            background: linear-gradient(135deg, #4a7c59, #2d5a27);
            border: none;
            border-radius: 20px;
            padding: 8px 16px;
            color: white;
            font-weight: bold;
            font-size: 0.9rem;
            box-shadow: 0 3px 10px rgba(74, 124, 89, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-order::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-order:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(74, 124, 89, 0.4);
        }

        .btn-order:hover::before {
            left: 100%;
        }

        .btn-order:active {
            transform: translateY(-1px);
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
            transition: all 0.3s ease;
        }

        .cart-item:hover {
            background: rgba(74, 124, 89, 0.05);
            border-radius: 6px;
            padding: 8px 6px;
            margin: 0 -6px;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .total-price {
            font-size: 1.1rem;
            font-weight: bold;
            color: #2d5a27;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .empty-cart {
            text-align: center;
            color: #666;
            padding: 15px 10px;
            background: rgba(74, 124, 89, 0.05);
            border-radius: 10px;
            border: 2px dashed rgba(74, 124, 89, 0.2);
        }

        .empty-cart i {
            font-size: 2rem;
            margin-bottom: 10px;
            opacity: 0.5;
        }

        /* Mobile optimizations */
        @media (max-width: 480px) {
            .menu-grid {
                gap: 12px;
            }

            .menu-card {
                padding: 10px;
            }

            .menu-image {
                height: 100px;
                margin-bottom: 8px;
            }

            .menu-name {
                font-size: 0.95rem;
            }

            .menu-desc {
                font-size: 0.7rem;
            }

            .variant-title {
                font-size: 0.65rem;
                margin-bottom: 5px;
            }

            .variant-label {
                padding: 6px 3px;
                font-size: 0.65rem;
            }

            .variant-emoji {
                font-size: 1.1rem;
            }

            .btn-quantity {
                width: 32px;
                height: 32px;
                font-size: 0.85rem;
            }

            .quantity-display {
                min-width: 35px;
                font-size: 0.95rem;
                padding: 5px 6px;
            }

            .header {
                padding: 18px;
            }

            .room-title {
                font-size: 1.3rem;
            }

            .cart-summary {
                padding: 15px;
                max-height: 180px;
                left: 15px;
                right: 15px;
            }

            .btn-order {
                padding: 10px 20px;
                font-size: 0.9rem;
            }

            #cartItems {
                max-height: 100px;
            }
        }
    </style>
</head>
<body>
    <div class="container-mobile">
        <!-- Header -->
        <div class="header text-center">
            <h1 class="room-title">
                <i class="fas fa-coffee"></i> {{ $room->name }}
            </h1>
            <p class="text-muted mb-0">Pilih menu kopi yang ingin dipesan</p>
        </div>

        <!-- Menu List -->
        <div class="menu-grid" id="menuList">
            @foreach($menus as $menu)
            <div class="menu-card" data-menu-id="{{ $menu->id }}">
                <!-- Image -->
                <div class="menu-image">
                    @if($menu->image)
                        <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}">
                    @else
                        <div class="no-image">
                            <i class="fas fa-image"></i>
                            <div>No Image</div>
                        </div>
                    @endif
                </div>

                <!-- Content -->
                <div class="menu-content">
                    <div class="menu-info">
                        <div class="menu-name">{{ $menu->name }}</div>
                        <div class="menu-desc">{{ $menu->descriptions }}</div>
                    </div>

                    <!-- Variant Selection -->
                    <div class="variant-section">
                        <div class="variant-title">
                            <i class="fas fa-sliders-h"></i> Varian Rasa
                        </div>
                        <div class="variant-options">
                            <div class="variant-option">
                                <input type="radio"
                                       name="variant-{{ $menu->id }}"
                                       id="variant-less-{{ $menu->id }}"
                                       value="less_sugar"
                                       checked
                                       onchange="updateVariant({{ $menu->id }}, 'less_sugar')">
                                <label for="variant-less-{{ $menu->id }}" class="variant-label">
                                    <span class="variant-emoji">🙂</span>
                                    <span class="variant-text">Kurang<br>Manis</span>
                                </label>
                            </div>
                            <div class="variant-option">
                                <input type="radio"
                                       name="variant-{{ $menu->id }}"
                                       id="variant-normal-{{ $menu->id }}"
                                       value="normal"
                                       onchange="updateVariant({{ $menu->id }}, 'normal')">
                                <label for="variant-normal-{{ $menu->id }}" class="variant-label">
                                    <span class="variant-emoji">😊</span>
                                    <span class="variant-text">Normal</span>
                                </label>
                            </div>
                            <div class="variant-option">
                                <input type="radio"
                                       name="variant-{{ $menu->id }}"
                                       id="variant-none-{{ $menu->id }}"
                                       value="no_sugar"
                                       onchange="updateVariant({{ $menu->id }}, 'no_sugar')">
                                <label for="variant-none-{{ $menu->id }}" class="variant-label">
                                    <span class="variant-emoji">🚫</span>
                                    <span class="variant-text">Tanpa<br>Gula</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="quantity-controls">
                        <button class="btn btn-quantity" onclick="decreaseQuantity({{ $menu->id }})">
                            <i class="fas fa-minus"></i>
                        </button>
                        <span class="quantity-display" id="qty-{{ $menu->id }}">0</span>
                        <button class="btn btn-quantity" onclick="increaseQuantity({{ $menu->id }})">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Cart Summary -->
        <div class="cart-summary">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">
                    <i class="fas fa-shopping-cart"></i> Pesanan
                </h5>
                <form id="orderForm" action="{{ route('transaction.store') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                    <input type="hidden" name="items" id="itemsInput" value="[]">
                    <button type="submit" class="btn btn-order" id="orderBtn" disabled>
                        <i class="fas fa-check"></i> Pesan Sekarang
                    </button>
                </form>
            </div>
            <div id="cartItems">
                <div class="empty-cart">
                    <i class="fas fa-shopping-cart fa-2x text-muted"></i>
                    <p>Belum ada item di pesanan</p>
                </div>
            </div>
            <div class="mt-3">
                <div class="d-flex justify-content-center">
                    <span class="total-price">Total Item: <span id="totalItems">0</span></span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let cart = {};
        let variants = {}; // Track selected variant for each menu
        let totalItems = 0;

        // Initialize variants with default value (less_sugar)
        document.querySelectorAll('.menu-card').forEach(card => {
            const menuId = card.dataset.menuId;
            variants[menuId] = 'less_sugar';
        });

        function updateVariant(menuId, variant) {
            variants[menuId] = variant;
            console.log('Variant updated for menu', menuId, 'to', variant);
        }

        function updateQuantity(menuId, change) {
            if (!cart[menuId]) {
                cart[menuId] = 0;
            }

            cart[menuId] += change;

            if (cart[menuId] < 0) {
                cart[menuId] = 0;
            }

            document.getElementById(`qty-${menuId}`).textContent = cart[menuId];
            updateCart();

            console.log('Quantity updated for menu', menuId, 'to', cart[menuId]);
        }

        function increaseQuantity(menuId) {
            updateQuantity(menuId, 1);
        }

        function decreaseQuantity(menuId) {
            updateQuantity(menuId, -1);
        }

        function updateCart() {
            const cartItems = document.getElementById('cartItems');
            const totalItemsElement = document.getElementById('totalItems');
            const orderBtn = document.getElementById('orderBtn');
            const itemsInput = document.getElementById('itemsInput');

            let cartHTML = '';
            totalItems = 0;
            let items = [];

            // Variant labels for display
            const variantLabels = {
                'less_sugar': 'Kurang Manis',
                'normal': 'Normal',
                'no_sugar': 'Tanpa Gula'
            };

            for (let menuId in cart) {
                if (cart[menuId] > 0) {
                    const menuElement = document.querySelector(`[data-menu-id="${menuId}"]`);
                    const menuName = menuElement.querySelector('.menu-name').textContent;
                    const variantLabel = variantLabels[variants[menuId]] || 'Normal';

                    cartHTML += `
                        <div class="cart-item">
                            <div>
                                <div class="fw-bold">${menuName}</div>
                                <small class="text-muted">
                                    <i class="fas fa-sliders-h"></i> ${variantLabel} | Qty: ${cart[menuId]}
                                </small>
                            </div>
                            <div class="fw-bold text-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    `;

                    totalItems += cart[menuId];
                    items.push({
                        menu_id: parseInt(menuId),
                        quantity: parseInt(cart[menuId]),
                        variant: variants[menuId]
                    });
                }
            }

            if (items.length === 0) {
                cartHTML = `
                    <div class="empty-cart">
                        <i class="fas fa-shopping-cart fa-2x text-muted"></i>
                        <p>Belum ada item di pesanan</p>
                    </div>
                `;
                orderBtn.disabled = true;
            } else {
                orderBtn.disabled = false;
            }

            cartItems.innerHTML = cartHTML;
            totalItemsElement.textContent = totalItems;
            itemsInput.value = JSON.stringify(items);

            console.log('Cart updated:', items);
        }

        // Form submission
        document.getElementById('orderForm').addEventListener('submit', function(e) {
            const itemsInput = document.getElementById('itemsInput');

            try {
                const items = JSON.parse(itemsInput.value);

                console.log('Form submitted with items:', items);
                console.log('Items input value:', itemsInput.value);
                console.log('Room ID:', document.querySelector('input[name="room_id"]').value);
                console.log('CSRF Token:', document.querySelector('input[name="_token"]').value);

                if (!items || items.length === 0) {
                    e.preventDefault();
                    alert('Pilih minimal satu menu untuk dipesan!');
                    return false;
                }

                // Show loading state
                const orderBtn = document.getElementById('orderBtn');
                orderBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
                orderBtn.disabled = true;

                // Let the form submit naturally
                return true;

            } catch (error) {
                console.error('Error parsing items:', error);
                e.preventDefault();
                alert('Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
                return false;
            }
        });

        // Debug cart on page load
        console.log('Page loaded, initial cart:', cart);
        console.log('Initial items input value:', document.getElementById('itemsInput').value);

        // Test form submission
        console.log('Form action:', document.getElementById('orderForm').action);
        console.log('Form method:', document.getElementById('orderForm').method);
        console.log('CSRF token exists:', !!document.querySelector('input[name="_token"]'));
        console.log('Room ID exists:', !!document.querySelector('input[name="room_id"]'));
        console.log('Items input exists:', !!document.getElementById('itemsInput'));

        // Test button click
        document.getElementById('orderBtn').addEventListener('click', function(e) {
            console.log('Order button clicked');
            console.log('Button disabled:', this.disabled);
            console.log('Current cart:', cart);
            console.log('Items input value:', document.getElementById('itemsInput').value);

            if (this.disabled) {
                e.preventDefault();
                console.log('Button is disabled, preventing form submission');
                return false;
            }
        });

        // Test quantity buttons
        document.querySelectorAll('.btn-quantity').forEach(btn => {
            btn.addEventListener('click', function(e) {
                console.log('Quantity button clicked:', this);
            });
        });

        // Test menu cards
        document.querySelectorAll('.menu-card').forEach(card => {
            console.log('Menu card found:', card.dataset.menuId);
        });
    </script>
</body>
</html>
