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

        /* Modal Styles */
        .modal-backdrop {
            background: rgba(0, 0, 0, 0.7);
        }

        .modal-content {
            border-radius: 20px;
            border: none;
        }

        .modal-header {
            background: linear-gradient(135deg, #4a7c59, #2d5a27);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 20px;
        }

        .modal-body {
            padding: 20px;
            max-height: 60vh;
            overflow-y: auto;
        }

        .order-item {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 4px solid #4a7c59;
        }

        .order-item-header {
            font-weight: bold;
            color: #2d5a27;
            margin-bottom: 10px;
            font-size: 1rem;
        }

        .item-detail {
            background: white;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 8px;
            border: 1px solid #e9ecef;
        }

        .item-detail:last-child {
            margin-bottom: 0;
        }

        .item-number {
            font-weight: bold;
            color: #4a7c59;
            margin-bottom: 8px;
            font-size: 0.85rem;
        }

        .form-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 5px;
        }

        .form-select, .form-control {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 8px 12px;
            font-size: 0.85rem;
        }

        .form-select:focus, .form-control:focus {
            border-color: #4a7c59;
            box-shadow: 0 0 0 0.2rem rgba(74, 124, 89, 0.25);
        }

        .btn-submit-order {
            background: linear-gradient(135deg, #4a7c59, #2d5a27);
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            color: white;
            font-weight: bold;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-submit-order:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(74, 124, 89, 0.4);
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
            <p class="text-muted mb-0">Please select your order</p>
        </div>

        <!-- Menu List -->
        <div class="menu-grid" id="menuList">
            @foreach($menus as $menu)
            <div class="menu-card" data-menu-id="{{ $menu->id }}">
                <!-- Image -->
                <div class="menu-image">
                    @if($menu->image)
                        <img src="{{ Storage::url($menu->image) }}" alt="{{ $menu->name }}">
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
                    <i class="fas fa-shopping-cart"></i> Order
                </h5>
                <button type="button" class="btn btn-order" id="orderBtn" disabled onclick="showOrderModal()">
                    <i class="fas fa-check"></i> Order Now
                </button>
            </div>
            <div id="cartItems">
                <div class="empty-cart">
                    <i class="fas fa-shopping-cart fa-2x text-muted"></i>
                    <p>No items in your order yet</p>
                </div>
            </div>
            <div class="mt-3">
                <div class="d-flex justify-content-center">
                    <span class="total-price">Total Items: <span id="totalItems">0</span></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel">
                        <i class="fas fa-clipboard-list"></i> Order Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="orderForm" action="{{ route('transaction.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="room_id" value="{{ $room->id }}">

                        <!-- Location Selection -->
                        <div class="order-item" style="margin-bottom: 20px;">
                            <div class="order-item-header">
                                <i class="fas fa-door-open"></i> Select Room
                            </div>
                            <div class="item-detail">
                                <label class="form-label">
                                    <i class="fas fa-location-arrow"></i> Destination Room
                                </label>
                                <select name="location" class="form-select" required>
                                    <option value="">-- Select Room --</option>
                                    @forelse($room->roomDetails as $detail)
                                        <option value="{{ $detail->name }}">{{ $detail->name }}</option>
                                    @empty
                                        <option value="" disabled>No rooms available</option>
                                    @endforelse
                                </select>
                                @if($room->roomDetails->count() == 0)
                                    <small class="text-danger">
                                        <i class="fas fa-exclamation-triangle"></i> No rooms available for this office yet. Please contact admin.
                                    </small>
                                @endif
                            </div>
                        </div>

                        <div id="orderDetailsContainer"></div>
                        <button type="submit" class="btn btn-submit-order mt-3">
                            <i class="fas fa-paper-plane"></i> Submit Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let cart = {};
        let totalItems = 0;
        let orderModal = null;

        // Get menu data
        const menuData = {};
        document.querySelectorAll('.menu-card').forEach(card => {
            const menuId = card.dataset.menuId;
            const menuName = card.querySelector('.menu-name').textContent;
            menuData[menuId] = menuName;
        });

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

            let cartHTML = '';
            totalItems = 0;

            for (let menuId in cart) {
                if (cart[menuId] > 0) {
                    const menuName = menuData[menuId];

                    cartHTML += `
                        <div class="cart-item">
                            <div>
                                <div class="fw-bold">${menuName}</div>
                                <small class="text-muted">Qty: ${cart[menuId]}</small>
                            </div>
                            <div class="fw-bold text-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    `;

                    totalItems += cart[menuId];
                }
            }

            if (totalItems === 0) {
                cartHTML = `
                    <div class="empty-cart">
                        <i class="fas fa-shopping-cart fa-2x text-muted"></i>
                        <p>No items in your order yet</p>
                    </div>
                `;
                orderBtn.disabled = true;
            } else {
                orderBtn.disabled = false;
            }

            cartItems.innerHTML = cartHTML;
            totalItemsElement.textContent = totalItems;
        }

        function showOrderModal() {
            const container = document.getElementById('orderDetailsContainer');
            let html = '';
            let itemIndex = 0;

            for (let menuId in cart) {
                if (cart[menuId] > 0) {
                    const menuName = menuData[menuId];

                    html += `
                        <div class="order-item">
                            <div class="order-item-header">
                                <i class="fas fa-coffee"></i> ${menuName}
                            </div>
                    `;

                    // Create inputs for each quantity
                    for (let i = 0; i < cart[menuId]; i++) {
                        html += `
                            <div class="item-detail">
                                <div class="item-number">Item #${itemIndex + 1}</div>

                                <input type="hidden" name="items[${itemIndex}][menu_id]" value="${menuId}">

                                <div class="mb-2">
                                    <label class="form-label">
                                        <i class="fas fa-user"></i> Name
                                    </label>
                                    <input type="text" name="items[${itemIndex}][employee]" class="form-control" required placeholder="Enter name">
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">
                                        <i class="fas fa-temperature-low"></i> Hot / Ice
                                    </label>
                                    <select class="form-select temp-select" data-index="${itemIndex}" required>
                                        <option value="hot">🔥 Hot</option>
                                        <option value="ice">🧊 Ice</option>
                                    </select>
                                </div>

                                <div class="mb-0">
                                    <label class="form-label">
                                        <i class="fas fa-sliders-h"></i> Sugar Level
                                    </label>
                                    <select class="form-select sugar-select" data-index="${itemIndex}" required>
                                        <option value="less_sugar">🙂 Less Sweet</option>
                                        <option value="normal">😊 Normal</option>
                                        <option value="no_sugar">🚫 No Sugar</option>
                                    </select>
                                </div>

                                <!-- Hidden field untuk variant (hasil concatenate) -->
                                <input type="hidden" name="items[${itemIndex}][variant]" class="variant-input" data-index="${itemIndex}" value="ice_normal">
                            </div>
                        `;
                        itemIndex++;
                    }

                    html += `</div>`;
                }
            }

            container.innerHTML = html;

            // Setup event listeners untuk concatenate variant
            setupVariantListeners();

            // Show modal
            if (!orderModal) {
                orderModal = new bootstrap.Modal(document.getElementById('orderModal'));
            }
            orderModal.show();
        }

        // Function untuk setup variant listeners
        function setupVariantListeners() {
            // Event listener untuk temperature dan sugar changes
            document.querySelectorAll('.temp-select, .sugar-select').forEach(select => {
                select.addEventListener('change', function() {
                    updateVariant(this.dataset.index);
                });
            });
        }

        // Function untuk update variant (concatenate temp + sugar)
        function updateVariant(index) {
            const tempSelect = document.querySelector(`.temp-select[data-index="${index}"]`);
            const sugarSelect = document.querySelector(`.sugar-select[data-index="${index}"]`);
            const variantInput = document.querySelector(`.variant-input[data-index="${index}"]`);

            if (tempSelect && sugarSelect && variantInput) {
                const temp = tempSelect.value;
                const sugar = sugarSelect.value;
                variantInput.value = `${temp}_${sugar}`;
            }
        }

        // Form submission
        document.getElementById('orderForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Show loading state
            const submitBtn = this.querySelector('.btn-submit-order');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            submitBtn.disabled = true;

            // Submit form
            this.submit();
        });
    </script>
</body>
</html>
