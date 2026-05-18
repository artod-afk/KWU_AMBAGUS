<x-app-layout>
<style>
* { box-sizing: border-box; }
.pos-wrap { display:flex; height:calc(100vh - 64px); background:#0f172a; overflow:hidden; }

/* ===== KIRI: Produk ===== */
.pos-left { flex:1; display:flex; flex-direction:column; border-right:1px solid rgba(255,255,255,0.08); overflow:hidden; }
.pos-left-header { padding:1rem 1.25rem; background:#1e293b; border-bottom:1px solid rgba(255,255,255,0.08); }
.pos-left-header h2 { color:white; font-weight:700; font-size:1rem; margin-bottom:0.75rem; }
.search-row { display:flex; gap:0.5rem; }
.search-inp { flex:1; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); border-radius:8px; padding:0.55rem 0.9rem; color:white; font-size:0.88rem; outline:none; }
.search-inp:focus { border-color:#22c55e; }
.search-inp::placeholder { color:rgba(255,255,255,0.3); }
.cat-select { background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); border-radius:8px; padding:0.55rem 0.75rem; color:white; font-size:0.85rem; outline:none; min-width:130px; }
.cat-select option { background:#1e293b; }
.product-grid { flex:1; overflow-y:auto; padding:1rem; display:grid; grid-template-columns:repeat(auto-fill,minmax(150px,1fr)); gap:0.75rem; align-content:start; }
.product-grid::-webkit-scrollbar { width:4px; }
.product-grid::-webkit-scrollbar-thumb { background:rgba(255,255,255,0.15); border-radius:4px; }
.prod-card { background:#1e293b; border:1px solid rgba(255,255,255,0.08); border-radius:10px; padding:0.85rem; cursor:pointer; transition:all 0.2s; }
.prod-card:hover { border-color:#22c55e; background:#1a3a2a; transform:translateY(-2px); }
.prod-card.out-of-stock { opacity:0.4; cursor:not-allowed; }
.prod-name { color:white; font-weight:600; font-size:0.85rem; margin-bottom:0.35rem; line-height:1.3; }
.prod-price { color:#4ade80; font-weight:700; font-size:0.9rem; }
.prod-stock { color:rgba(255,255,255,0.4); font-size:0.75rem; margin-top:0.2rem; }
.prod-cat { color:#60a5fa; font-size:0.72rem; margin-bottom:0.3rem; }
.no-product { text-align:center; padding:3rem; color:rgba(255,255,255,0.3); grid-column:1/-1; }

/* ===== KANAN: Keranjang ===== */
.pos-right { width:380px; display:flex; flex-direction:column; background:#1e293b; flex-shrink:0; }
.cart-header { padding:1rem 1.25rem; border-bottom:1px solid rgba(255,255,255,0.08); display:flex; align-items:center; justify-content:space-between; }
.cart-header h2 { color:white; font-weight:700; font-size:1rem; }
.cart-clear { background:rgba(239,68,68,0.15); color:#f87171; border:1px solid rgba(239,68,68,0.3); padding:0.3rem 0.75rem; border-radius:6px; font-size:0.78rem; cursor:pointer; }
.cart-items { flex:1; overflow-y:auto; padding:0.75rem; }
.cart-items::-webkit-scrollbar { width:4px; }
.cart-items::-webkit-scrollbar-thumb { background:rgba(255,255,255,0.15); border-radius:4px; }
.cart-item { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.08); border-radius:10px; padding:0.75rem; margin-bottom:0.5rem; }
.cart-item-name { color:white; font-weight:600; font-size:0.88rem; margin-bottom:0.4rem; }
.cart-item-row { display:flex; align-items:center; justify-content:space-between; }
.qty-ctrl { display:flex; align-items:center; gap:0.4rem; }
.qty-btn { width:28px; height:28px; border-radius:6px; border:none; cursor:pointer; font-weight:700; font-size:0.9rem; display:flex; align-items:center; justify-content:center; transition:all 0.15s; }
.qty-minus { background:rgba(239,68,68,0.2); color:#f87171; }
.qty-minus:hover { background:rgba(239,68,68,0.4); }
.qty-plus { background:rgba(34,197,94,0.2); color:#4ade80; }
.qty-plus:hover { background:rgba(34,197,94,0.4); }
.qty-num { color:white; font-weight:700; font-size:0.95rem; min-width:28px; text-align:center; }
.item-subtotal { color:#4ade80; font-weight:700; font-size:0.9rem; }
.item-del { background:none; border:none; color:rgba(255,255,255,0.3); cursor:pointer; font-size:1rem; padding:0.2rem; }
.item-del:hover { color:#f87171; }
.cart-empty { text-align:center; padding:3rem 1rem; color:rgba(255,255,255,0.3); }

/* ===== PAYMENT ===== */
.payment-section { border-top:1px solid rgba(255,255,255,0.08); padding:1rem 1.25rem; }
.total-row { display:flex; justify-content:space-between; align-items:center; margin-bottom:0.5rem; }
.total-label { color:rgba(255,255,255,0.6); font-size:0.88rem; }
.total-value { color:white; font-weight:700; font-size:1rem; }
.total-big { font-size:1.4rem; color:#4ade80; }
.pay-label { color:rgba(255,255,255,0.6); font-size:0.82rem; margin-bottom:0.4rem; }
.pay-input { width:100%; background:rgba(255,255,255,0.08); border:2px solid rgba(255,255,255,0.15); border-radius:8px; padding:0.65rem 1rem; color:white; font-size:1rem; font-weight:600; outline:none; margin-bottom:0.5rem; }
.pay-input:focus { border-color:#3b82f6; }
.shortcut-row { display:flex; gap:0.4rem; flex-wrap:wrap; margin-bottom:0.75rem; }
.shortcut-btn { background:rgba(59,130,246,0.15); color:#60a5fa; border:1px solid rgba(59,130,246,0.3); padding:0.35rem 0.65rem; border-radius:6px; font-size:0.78rem; font-weight:600; cursor:pointer; transition:all 0.15s; }
.shortcut-btn:hover { background:rgba(59,130,246,0.35); }
.change-box { background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.3); border-radius:8px; padding:0.65rem 1rem; display:flex; justify-content:space-between; align-items:center; margin-bottom:0.75rem; }
.change-label { color:rgba(255,255,255,0.6); font-size:0.85rem; }
.change-value { color:#4ade80; font-weight:700; font-size:1.1rem; }
.change-box.warning { background:rgba(239,68,68,0.1); border-color:rgba(239,68,68,0.3); }
.change-box.warning .change-value { color:#f87171; }
.btn-checkout { width:100%; background:linear-gradient(135deg,#22c55e,#16a34a); color:white; border:none; padding:0.9rem; border-radius:10px; font-weight:700; font-size:1.05rem; cursor:pointer; transition:all 0.2s; box-shadow:0 4px 15px rgba(34,197,94,0.3); }
.btn-checkout:hover { opacity:0.9; transform:translateY(-1px); }
.btn-checkout:disabled { opacity:0.4; cursor:not-allowed; transform:none; }

/* Modal sukses */
.modal-overlay { position:fixed; inset:0; background:rgba(0,0,0,0.7); display:flex; align-items:center; justify-content:center; z-index:999; opacity:0; pointer-events:none; transition:opacity 0.3s; }
.modal-overlay.show { opacity:1; pointer-events:all; }
.modal-box { background:#1e293b; border:1px solid rgba(255,255,255,0.1); border-radius:16px; padding:2rem; max-width:380px; width:90%; text-align:center; transform:scale(0.9); transition:transform 0.3s; }
.modal-overlay.show .modal-box { transform:scale(1); }
.modal-icon { font-size:3rem; margin-bottom:1rem; }
.modal-title { color:white; font-size:1.3rem; font-weight:700; margin-bottom:0.5rem; }
.modal-code { font-family:monospace; color:#4ade80; font-size:1rem; margin-bottom:1rem; }
.modal-row { display:flex; justify-content:space-between; padding:0.4rem 0; border-bottom:1px solid rgba(255,255,255,0.06); }
.modal-row:last-of-type { border-bottom:none; }
.modal-row span:first-child { color:rgba(255,255,255,0.5); font-size:0.88rem; }
.modal-row span:last-child { color:white; font-weight:600; font-size:0.88rem; }
.btn-modal-close { margin-top:1.25rem; background:linear-gradient(135deg,#22c55e,#16a34a); color:white; border:none; padding:0.7rem 2rem; border-radius:8px; font-weight:700; cursor:pointer; width:100%; }
</style>

<div class="pos-wrap">

    <!-- ===== KIRI: Daftar Produk ===== -->
    <div class="pos-left">
        <div class="pos-left-header">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.75rem;">
                <h2>🛍️ Pilih Barang</h2>
                <a href="{{ route('cashier.index') }}" style="color:rgba(255,255,255,0.4); font-size:0.82rem; text-decoration:none;">← Kembali</a>
            </div>
            <div class="search-row">
                <input type="text" id="searchInput" class="search-inp" placeholder="🔍 Cari nama barang...">
                <select id="catFilter" class="cat-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="product-grid" id="productGrid">
            @foreach($products as $p)
                @php
                    $price = $p->selling_price > 0 ? $p->selling_price : (is_numeric($p->unit) ? (float)$p->unit : $p->price);
                    $unit  = is_numeric($p->unit) ? 'Pcs' : $p->unit;
                @endphp
                <div class="prod-card {{ $p->stock <= 0 ? 'out-of-stock' : '' }}"
                     data-id="{{ $p->id }}"
                     data-name="{{ $p->name }}"
                     data-price="{{ $price }}"
                     data-stock="{{ $p->stock }}"
                     data-unit="{{ $unit }}"
                     data-cat="{{ $p->category_id }}"
                     onclick="addToCart(this)">
                    <div class="prod-cat">{{ $p->category?->name ?? 'Umum' }}</div>
                    <div class="prod-name">{{ $p->name }}</div>
                    <div class="prod-price">Rp {{ number_format($price, 0, ',', '.') }}</div>
                    <div class="prod-stock">Stok: {{ $p->stock }} {{ $unit }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- ===== KANAN: Keranjang & Pembayaran ===== -->
    <div class="pos-right">
        <div class="cart-header">
            <h2>🛒 Keranjang</h2>
            <button class="cart-clear" onclick="clearCart()">Kosongkan</button>
        </div>

        <div class="cart-items" id="cartItems">
            <!-- Diisi oleh JavaScript -->
        </div>

        <div class="payment-section">
            <!-- Total -->
            <div class="total-row">
                <span class="total-label">Total Item</span>
                <span class="total-value" id="totalItems">0 item</span>
            </div>
            <div class="total-row" style="margin-bottom:0.85rem;">
                <span class="total-label" style="font-size:1rem;">Total Belanja</span>
                <span class="total-value total-big" id="totalAmount">Rp 0</span>
            </div>

            <!-- Input Bayar -->
            <div class="pay-label">Uang Pembeli</div>
            <input type="number" id="paidInput" class="pay-input" placeholder="0" oninput="calcChange()">

            <!-- Shortcut -->
            <div class="shortcut-row">
                <button class="shortcut-btn" onclick="addPay(1000)">+1K</button>
                <button class="shortcut-btn" onclick="addPay(5000)">+5K</button>
                <button class="shortcut-btn" onclick="addPay(10000)">+10K</button>
                <button class="shortcut-btn" onclick="addPay(20000)">+20K</button>
                <button class="shortcut-btn" onclick="addPay(50000)">+50K</button>
                <button class="shortcut-btn" onclick="addPay(100000)">+100K</button>
                <button class="shortcut-btn" onclick="setPaidExact()" style="background:rgba(249,115,22,0.15); color:#fb923c; border-color:rgba(249,115,22,0.3);">Uang Pas</button>
            </div>

            <!-- Kembalian -->
            <div class="change-box" id="changeBox">
                <span class="change-label">Kembalian</span>
                <span class="change-value" id="changeAmount">Rp 0</span>
            </div>

            <!-- Checkout -->
            <button class="btn-checkout" id="checkoutBtn" onclick="checkout()" disabled>
                ✅ Checkout
            </button>
        </div>
    </div>
</div>

<!-- Modal Sukses -->
<div class="modal-overlay" id="successModal">
    <div class="modal-box">
        <div class="modal-icon">✅</div>
        <div class="modal-title">Transaksi Berhasil!</div>
        <div class="modal-code" id="modalCode"></div>
        <div id="modalDetails"></div>
        <button class="btn-modal-close" onclick="closeModal()">Transaksi Baru</button>
    </div>
</div>

<script>
let cart = {}; // { productId: { id, name, price, qty, stock, unit } }

// ===== SEARCH & FILTER =====
document.getElementById('searchInput').addEventListener('input', filterProducts);
document.getElementById('catFilter').addEventListener('change', filterProducts);

function filterProducts() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const catId  = document.getElementById('catFilter').value;
    document.querySelectorAll('.prod-card').forEach(card => {
        const name    = card.dataset.name.toLowerCase();
        const cardCat = card.dataset.cat;
        const matchS  = !search || name.includes(search);
        const matchC  = !catId  || cardCat == catId;
        card.style.display = (matchS && matchC) ? '' : 'none';
    });
}

// ===== KERANJANG =====
function addToCart(el) {
    if (el.classList.contains('out-of-stock')) return;
    const id    = String(el.dataset.id);
    const name  = el.dataset.name;
    const price = parseFloat(el.dataset.price);
    const stock = parseInt(el.dataset.stock);
    const unit  = el.dataset.unit;

    if (cart[id]) {
        if (cart[id].qty >= cart[id].stock) {
            alert('Stok tidak cukup! Tersedia: ' + cart[id].stock);
            return;
        }
        cart[id].qty++;
    } else {
        cart[id] = { id, name, price, qty: 1, stock, unit };
    }
    renderCart();
}

function changeQty(id, delta) {
    id = String(id);
    if (!cart[id]) return;
    cart[id].qty += delta;
    if (cart[id].qty <= 0) {
        delete cart[id];
    } else if (cart[id].qty > cart[id].stock) {
        cart[id].qty = cart[id].stock;
        alert('Stok tidak cukup!');
    }
    renderCart();
}

function removeItem(id) {
    id = String(id);
    delete cart[id];
    renderCart();
}

function clearCart() {
    cart = {};
    renderCart();
}

function renderCart() {
    const container = document.getElementById('cartItems');
    const keys      = Object.keys(cart);

    if (keys.length === 0) {
        // Tulis ulang empty state langsung ke innerHTML — tidak pakai appendChild
        container.innerHTML = `
            <div style="text-align:center; padding:3rem 1rem; color:rgba(255,255,255,0.3);">
                <div style="font-size:2.5rem; margin-bottom:0.5rem;">🛒</div>
                <p>Keranjang kosong</p>
                <p style="font-size:0.8rem; margin-top:0.25rem;">Klik barang untuk menambahkan</p>
            </div>`;
        updateTotals();
        return;
    }

    let html = '';
    keys.forEach(id => {
        const item     = cart[id];
        const subtotal = item.price * item.qty;
        html += `
        <div class="cart-item" id="cart-item-${id}">
            <div style="display:flex; justify-content:space-between; align-items:start; margin-bottom:0.4rem;">
                <div class="cart-item-name">${item.name}</div>
                <button class="item-del" onclick="removeItem('${id}')">✕</button>
            </div>
            <div class="cart-item-row">
                <div class="qty-ctrl">
                    <button class="qty-btn qty-minus" onclick="changeQty('${id}',-1)">−</button>
                    <span class="qty-num" id="qty-${id}">${item.qty}</span>
                    <button class="qty-btn qty-plus" onclick="changeQty('${id}',1)">+</button>
                </div>
                <div>
                    <div style="color:rgba(255,255,255,0.4); font-size:0.75rem; text-align:right;">
                        Rp ${item.price.toLocaleString('id-ID')} × ${item.qty}
                    </div>
                    <div class="item-subtotal" id="sub-${id}">Rp ${subtotal.toLocaleString('id-ID')}</div>
                </div>
            </div>
        </div>`;
    });

    container.innerHTML = html;
    updateTotals();
}

function updateTotals() {
    let total = 0, items = 0;
    Object.values(cart).forEach(i => {
        total += i.price * i.qty;
        items += i.qty;
    });
    document.getElementById('totalAmount').textContent = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('totalItems').textContent  = items + ' item';
    calcChange();
}

// ===== PEMBAYARAN =====
function addPay(amount) {
    const inp = document.getElementById('paidInput');
    inp.value = (parseFloat(inp.value) || 0) + amount;
    calcChange();
}

function setPaidExact() {
    let total = 0;
    Object.values(cart).forEach(i => total += i.price * i.qty);
    document.getElementById('paidInput').value = total;
    calcChange();
}

function calcChange() {
    let total = 0;
    Object.values(cart).forEach(i => total += i.price * i.qty);
    const paid   = parseFloat(document.getElementById('paidInput').value) || 0;
    const change = paid - total;
    const box    = document.getElementById('changeBox');
    const btn    = document.getElementById('checkoutBtn');
    const changeEl = document.getElementById('changeAmount');

    if (Object.keys(cart).length === 0 || total === 0) {
        changeEl.textContent = 'Rp 0';
        box.classList.remove('warning');
        btn.disabled = true;
        return;
    }

    if (change < 0) {
        box.classList.add('warning');
        changeEl.textContent = '⚠ Kurang Rp ' + Math.abs(change).toLocaleString('id-ID');
        btn.disabled = true;
    } else {
        box.classList.remove('warning');
        changeEl.textContent = 'Rp ' + change.toLocaleString('id-ID');
        btn.disabled = false;
    }
}

// ===== CHECKOUT =====
function checkout() {
    const items = Object.values(cart).map(i => ({ id: i.id, qty: i.qty }));
    const paid  = parseFloat(document.getElementById('paidInput').value) || 0;

    if (items.length === 0) {
        alert('Keranjang masih kosong!');
        return;
    }

    const btn = document.getElementById('checkoutBtn');
    btn.disabled = true;
    btn.textContent = '⏳ Memproses...';

    fetch('{{ route("cashier.checkout") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ items, paid })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showModal(data.transaction);
        } else {
            alert('❌ ' + data.message);
            btn.disabled = false;
            btn.textContent = '✅ Checkout';
        }
    })
    .catch(err => {
        alert('Terjadi kesalahan jaringan');
        btn.disabled = false;
        btn.textContent = '✅ Checkout';
    });
}

function showModal(trx) {
    document.getElementById('modalCode').textContent = trx.code;
    document.getElementById('modalDetails').innerHTML = `
        <div class="modal-row"><span>Total Belanja</span><span>Rp ${Number(trx.total).toLocaleString('id-ID')}</span></div>
        <div class="modal-row"><span>Uang Dibayar</span><span>Rp ${Number(trx.paid).toLocaleString('id-ID')}</span></div>
        <div class="modal-row"><span>Kembalian</span><span style="color:#4ade80;">Rp ${Number(trx.change).toLocaleString('id-ID')}</span></div>
    `;
    document.getElementById('successModal').classList.add('show');
}

function closeModal() {
    document.getElementById('successModal').classList.remove('show');
    cart = {};
    renderCart();
    document.getElementById('paidInput').value = '';
    const btn = document.getElementById('checkoutBtn');
    btn.disabled = true;
    btn.textContent = '✅ Checkout';
    // Reload untuk update stok di kartu produk
    location.reload();
}

// Init render saat halaman load
renderCart();
</script>
</x-app-layout>
