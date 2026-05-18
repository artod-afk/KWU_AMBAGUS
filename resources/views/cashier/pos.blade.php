<x-app-layout>
<style>
* { box-sizing: border-box; }

/* ===== BASE ===== */
.pos-page { background:#0f172a; min-height:calc(100vh - 60px); display:flex; flex-direction:column; }

/* ===== MOBILE TAB BAR ===== */
.mobile-tabs { display:none; background:#1e293b; border-bottom:1px solid rgba(255,255,255,0.08); }
.mobile-tab { flex:1; padding:0.85rem; border:none; background:transparent; color:rgba(255,255,255,0.5); font-size:0.88rem; font-weight:600; cursor:pointer; border-bottom:2px solid transparent; transition:all 0.2s; font-family:inherit; }
.mobile-tab.active { color:#22c55e; border-bottom-color:#22c55e; }
.mobile-cart-badge { background:#22c55e; color:white; border-radius:50%; width:18px; height:18px; font-size:0.65rem; font-weight:700; display:inline-flex; align-items:center; justify-content:center; margin-left:0.3rem; vertical-align:middle; }

/* ===== DESKTOP LAYOUT ===== */
.pos-wrap { display:flex; flex:1; overflow:hidden; height:calc(100vh - 60px); }

/* ===== KIRI: Produk ===== */
.pos-left { flex:1; display:flex; flex-direction:column; border-right:1px solid rgba(255,255,255,0.08); overflow:hidden; }
.pos-left-header { padding:0.85rem 1rem; background:#1e293b; border-bottom:1px solid rgba(255,255,255,0.08); }
.pos-top-bar { display:flex; align-items:center; justify-content:space-between; margin-bottom:0.65rem; }
.pos-top-bar h2 { color:white; font-weight:700; font-size:0.95rem; }
.back-link { color:rgba(255,255,255,0.4); font-size:0.8rem; text-decoration:none; }
.search-row { display:flex; gap:0.5rem; }
.search-inp { flex:1; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); border-radius:8px; padding:0.55rem 0.85rem; color:white; font-size:0.88rem; outline:none; min-width:0; }
.search-inp:focus { border-color:#22c55e; }
.search-inp::placeholder { color:rgba(255,255,255,0.3); }
.cat-select { background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); border-radius:8px; padding:0.55rem 0.6rem; color:white; font-size:0.82rem; outline:none; max-width:130px; }
.cat-select option { background:#1e293b; }
.product-grid { flex:1; overflow-y:auto; padding:0.85rem; display:grid; grid-template-columns:repeat(auto-fill,minmax(140px,1fr)); gap:0.65rem; align-content:start; }
.product-grid::-webkit-scrollbar { width:3px; }
.product-grid::-webkit-scrollbar-thumb { background:rgba(255,255,255,0.15); border-radius:4px; }
.prod-card { background:#1e293b; border:1px solid rgba(255,255,255,0.08); border-radius:10px; padding:0.8rem; cursor:pointer; transition:all 0.2s; -webkit-tap-highlight-color:transparent; }
.prod-card:active { transform:scale(0.97); }
.prod-card:hover { border-color:#22c55e; background:#1a3a2a; }
.prod-card.out-of-stock { opacity:0.4; cursor:not-allowed; }
.prod-cat { color:#60a5fa; font-size:0.7rem; margin-bottom:0.25rem; }
.prod-name { color:white; font-weight:600; font-size:0.83rem; margin-bottom:0.3rem; line-height:1.3; }
.prod-price { color:#4ade80; font-weight:700; font-size:0.88rem; }
.prod-stock { color:rgba(255,255,255,0.4); font-size:0.72rem; margin-top:0.15rem; }

/* ===== KANAN: Keranjang ===== */
.pos-right { width:360px; display:flex; flex-direction:column; background:#1e293b; flex-shrink:0; }
.cart-header { padding:0.85rem 1rem; border-bottom:1px solid rgba(255,255,255,0.08); display:flex; align-items:center; justify-content:space-between; }
.cart-header h2 { color:white; font-weight:700; font-size:0.95rem; }
.cart-clear { background:rgba(239,68,68,0.15); color:#f87171; border:1px solid rgba(239,68,68,0.3); padding:0.3rem 0.7rem; border-radius:6px; font-size:0.75rem; cursor:pointer; font-family:inherit; }
.cart-items { flex:1; overflow-y:auto; padding:0.65rem; }
.cart-items::-webkit-scrollbar { width:3px; }
.cart-items::-webkit-scrollbar-thumb { background:rgba(255,255,255,0.15); border-radius:4px; }
.cart-item { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.08); border-radius:10px; padding:0.7rem; margin-bottom:0.45rem; }
.cart-item-name { color:white; font-weight:600; font-size:0.85rem; margin-bottom:0.35rem; }
.cart-item-row { display:flex; align-items:center; justify-content:space-between; }
.qty-ctrl { display:flex; align-items:center; gap:0.35rem; }
.qty-btn { width:32px; height:32px; border-radius:7px; border:none; cursor:pointer; font-weight:700; font-size:1rem; display:flex; align-items:center; justify-content:center; transition:all 0.15s; -webkit-tap-highlight-color:transparent; }
.qty-minus { background:rgba(239,68,68,0.2); color:#f87171; }
.qty-plus { background:rgba(34,197,94,0.2); color:#4ade80; }
.qty-num { color:white; font-weight:700; font-size:0.95rem; min-width:28px; text-align:center; }
.item-subtotal { color:#4ade80; font-weight:700; font-size:0.88rem; }
.item-del { background:none; border:none; color:rgba(255,255,255,0.3); cursor:pointer; font-size:1.1rem; padding:0.2rem; line-height:1; }
.item-del:hover { color:#f87171; }

/* ===== PAYMENT ===== */
.payment-section { border-top:1px solid rgba(255,255,255,0.08); padding:0.85rem 1rem; }
.total-row { display:flex; justify-content:space-between; align-items:center; margin-bottom:0.4rem; }
.total-label { color:rgba(255,255,255,0.6); font-size:0.85rem; }
.total-value { color:white; font-weight:700; font-size:0.95rem; }
.total-big { font-size:1.3rem; color:#4ade80; }
.pay-label { color:rgba(255,255,255,0.6); font-size:0.8rem; margin-bottom:0.35rem; margin-top:0.5rem; }
.pay-input { width:100%; background:rgba(255,255,255,0.08); border:2px solid rgba(255,255,255,0.15); border-radius:8px; padding:0.6rem 0.9rem; color:white; font-size:1rem; font-weight:600; outline:none; margin-bottom:0.45rem; font-family:inherit; }
.pay-input:focus { border-color:#3b82f6; }
.shortcut-row { display:flex; gap:0.35rem; flex-wrap:wrap; margin-bottom:0.65rem; }
.shortcut-btn { background:rgba(59,130,246,0.15); color:#60a5fa; border:1px solid rgba(59,130,246,0.3); padding:0.35rem 0.55rem; border-radius:6px; font-size:0.75rem; font-weight:600; cursor:pointer; font-family:inherit; -webkit-tap-highlight-color:transparent; }
.change-box { background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.3); border-radius:8px; padding:0.6rem 0.9rem; display:flex; justify-content:space-between; align-items:center; margin-bottom:0.65rem; }
.change-label { color:rgba(255,255,255,0.6); font-size:0.82rem; }
.change-value { color:#4ade80; font-weight:700; font-size:1rem; }
.change-box.warning { background:rgba(239,68,68,0.1); border-color:rgba(239,68,68,0.3); }
.change-box.warning .change-value { color:#f87171; }
.btn-checkout { width:100%; background:linear-gradient(135deg,#22c55e,#16a34a); color:white; border:none; padding:0.85rem; border-radius:10px; font-weight:700; font-size:1rem; cursor:pointer; transition:all 0.2s; box-shadow:0 4px 15px rgba(34,197,94,0.3); font-family:inherit; -webkit-tap-highlight-color:transparent; }
.btn-checkout:disabled { opacity:0.4; cursor:not-allowed; }

/* ===== MODAL ===== */
.modal-overlay { position:fixed; inset:0; background:rgba(0,0,0,0.75); display:flex; align-items:center; justify-content:center; z-index:999; opacity:0; pointer-events:none; transition:opacity 0.3s; padding:1rem; }
.modal-overlay.show { opacity:1; pointer-events:all; }
.modal-box { background:#1e293b; border:1px solid rgba(255,255,255,0.1); border-radius:16px; padding:1.75rem; max-width:360px; width:100%; text-align:center; transform:scale(0.9); transition:transform 0.3s; }
.modal-overlay.show .modal-box { transform:scale(1); }
.modal-icon { font-size:2.5rem; margin-bottom:0.75rem; }
.modal-title { color:white; font-size:1.2rem; font-weight:700; margin-bottom:0.4rem; }
.modal-code { font-family:monospace; color:#4ade80; font-size:0.95rem; margin-bottom:0.85rem; }
.modal-row { display:flex; justify-content:space-between; padding:0.4rem 0; border-bottom:1px solid rgba(255,255,255,0.06); }
.modal-row:last-of-type { border-bottom:none; }
.modal-row span:first-child { color:rgba(255,255,255,0.5); font-size:0.85rem; }
.modal-row span:last-child { color:white; font-weight:600; font-size:0.85rem; }
.btn-modal-close { margin-top:1.1rem; background:linear-gradient(135deg,#22c55e,#16a34a); color:white; border:none; padding:0.7rem 2rem; border-radius:8px; font-weight:700; cursor:pointer; width:100%; font-family:inherit; font-size:0.95rem; }

/* ===== RESPONSIVE MOBILE ===== */
@media (max-width: 768px) {
    .mobile-tabs { display:flex; }
    .pos-wrap { height:auto; flex-direction:column; overflow:visible; }
    .pos-left { border-right:none; height:auto; overflow:visible; }
    .pos-left[data-hidden="true"] { display:none; }
    .product-grid { height:auto; max-height:none; overflow:visible; grid-template-columns:repeat(2,1fr); padding:0.75rem; }
    .pos-right { width:100%; height:auto; }
    .pos-right[data-hidden="true"] { display:none; }
    .cart-items { max-height:none; overflow:visible; }
    .payment-section { position:sticky; bottom:0; background:#1e293b; border-top:2px solid rgba(34,197,94,0.3); }
    .shortcut-btn { padding:0.45rem 0.65rem; font-size:0.8rem; min-height:36px; }
    .qty-btn { width:36px; height:36px; }
    .btn-checkout { padding:1rem; font-size:1.05rem; }
}
@media (max-width: 400px) {
    .product-grid { grid-template-columns:repeat(2,1fr); gap:0.5rem; padding:0.6rem; }
    .prod-card { padding:0.65rem; }
}
</style>

<div class="pos-page">

    <!-- Mobile Tab Bar -->
    <div class="mobile-tabs" id="mobileTabs">
        <button class="mobile-tab active" id="tabProducts" onclick="switchTab('products')">
            🛍️ Pilih Barang
        </button>
        <button class="mobile-tab" id="tabCart" onclick="switchTab('cart')">
            🛒 Keranjang <span class="mobile-cart-badge" id="cartBadge" style="display:none">0</span>
        </button>
    </div>

    <div class="pos-wrap">

        <!-- KIRI: Produk -->
        <div class="pos-left" id="panelProducts">
            <div class="pos-left-header">
                <div class="pos-top-bar">
                    <h2>🛍️ Pilih Barang</h2>
                    <a href="{{ route('cashier.index') }}" class="back-link">← Kembali</a>
                </div>
                <div class="search-row">
                    <input type="text" id="searchInput" class="search-inp" placeholder="🔍 Cari barang...">
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

        <!-- KANAN: Keranjang -->
        <div class="pos-right" id="panelCart" data-hidden="true">
            <div class="cart-header">
                <h2>🛒 Keranjang</h2>
                <button class="cart-clear" onclick="clearCart()">Kosongkan</button>
            </div>
            <div class="cart-items" id="cartItems"></div>
            <div class="payment-section">
                <div class="total-row">
                    <span class="total-label">Total Item</span>
                    <span class="total-value" id="totalItems">0 item</span>
                </div>
                <div class="total-row" style="margin-bottom:0.5rem;">
                    <span class="total-label" style="font-size:0.95rem;">Total Belanja</span>
                    <span class="total-value total-big" id="totalAmount">Rp 0</span>
                </div>
                <div class="pay-label">Uang Pembeli</div>
                <input type="number" id="paidInput" class="pay-input" placeholder="0" inputmode="numeric" oninput="calcChange()">
                <div class="shortcut-row">
                    <button class="shortcut-btn" onclick="addPay(1000)">+1K</button>
                    <button class="shortcut-btn" onclick="addPay(5000)">+5K</button>
                    <button class="shortcut-btn" onclick="addPay(10000)">+10K</button>
                    <button class="shortcut-btn" onclick="addPay(20000)">+20K</button>
                    <button class="shortcut-btn" onclick="addPay(50000)">+50K</button>
                    <button class="shortcut-btn" onclick="addPay(100000)">+100K</button>
                    <button class="shortcut-btn" onclick="setPaidExact()" style="background:rgba(249,115,22,0.15);color:#fb923c;border-color:rgba(249,115,22,0.3);">Uang Pas</button>
                </div>
                <div class="change-box" id="changeBox">
                    <span class="change-label">Kembalian</span>
                    <span class="change-value" id="changeAmount">Rp 0</span>
                </div>
                <button class="btn-checkout" id="checkoutBtn" onclick="checkout()" disabled>✅ Checkout</button>
            </div>
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
let cart = {};
const isMobile = () => window.innerWidth <= 768;

// ===== TAB SWITCHING (MOBILE) =====
function switchTab(tab) {
    const panelProducts = document.getElementById('panelProducts');
    const panelCart     = document.getElementById('panelCart');
    const tabProducts   = document.getElementById('tabProducts');
    const tabCart       = document.getElementById('tabCart');

    if (tab === 'products') {
        panelProducts.removeAttribute('data-hidden');
        panelCart.setAttribute('data-hidden', 'true');
        tabProducts.classList.add('active');
        tabCart.classList.remove('active');
    } else {
        panelCart.removeAttribute('data-hidden');
        panelProducts.setAttribute('data-hidden', 'true');
        tabCart.classList.add('active');
        tabProducts.classList.remove('active');
    }
}

// Pastikan desktop selalu tampil keduanya
window.addEventListener('resize', function() {
    if (!isMobile()) {
        document.getElementById('panelProducts').removeAttribute('data-hidden');
        document.getElementById('panelCart').removeAttribute('data-hidden');
    }
});

// ===== SEARCH & FILTER =====
document.getElementById('searchInput').addEventListener('input', filterProducts);
document.getElementById('catFilter').addEventListener('change', filterProducts);

function filterProducts() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const catId  = document.getElementById('catFilter').value;
    document.querySelectorAll('.prod-card').forEach(card => {
        const matchS = !search || card.dataset.name.toLowerCase().includes(search);
        const matchC = !catId  || card.dataset.cat == catId;
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
        if (cart[id].qty >= cart[id].stock) { alert('Stok tidak cukup!'); return; }
        cart[id].qty++;
    } else {
        cart[id] = { id, name, price, qty: 1, stock, unit };
    }
    renderCart();
    // Di mobile, auto pindah ke tab keranjang setelah tambah
    if (isMobile()) switchTab('cart');
}

function changeQty(id, delta) {
    id = String(id);
    if (!cart[id]) return;
    cart[id].qty += delta;
    if (cart[id].qty <= 0) delete cart[id];
    else if (cart[id].qty > cart[id].stock) { cart[id].qty = cart[id].stock; alert('Stok tidak cukup!'); }
    renderCart();
}

function removeItem(id) { delete cart[String(id)]; renderCart(); }
function clearCart()    { cart = {}; renderCart(); }

function renderCart() {
    const container = document.getElementById('cartItems');
    const keys      = Object.keys(cart);
    const badge     = document.getElementById('cartBadge');
    const totalQty  = Object.values(cart).reduce((s,i) => s + i.qty, 0);

    // Update badge
    if (totalQty > 0) { badge.style.display = 'inline-flex'; badge.textContent = totalQty; }
    else              { badge.style.display = 'none'; }

    if (keys.length === 0) {
        container.innerHTML = `
            <div style="text-align:center;padding:2.5rem 1rem;color:rgba(255,255,255,0.3);">
                <div style="font-size:2.5rem;margin-bottom:0.5rem;">🛒</div>
                <p style="font-size:0.9rem;">Keranjang kosong</p>
                <p style="font-size:0.78rem;margin-top:0.25rem;">Klik barang untuk menambahkan</p>
            </div>`;
        updateTotals(); return;
    }

    let html = '';
    keys.forEach(id => {
        const item = cart[id];
        const sub  = item.price * item.qty;
        html += `
        <div class="cart-item">
            <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:0.35rem;">
                <div class="cart-item-name">${item.name}</div>
                <button class="item-del" onclick="removeItem('${id}')">✕</button>
            </div>
            <div class="cart-item-row">
                <div class="qty-ctrl">
                    <button class="qty-btn qty-minus" onclick="changeQty('${id}',-1)">−</button>
                    <span class="qty-num">${item.qty}</span>
                    <button class="qty-btn qty-plus" onclick="changeQty('${id}',1)">+</button>
                </div>
                <div style="text-align:right;">
                    <div style="color:rgba(255,255,255,0.4);font-size:0.72rem;">Rp ${item.price.toLocaleString('id-ID')} × ${item.qty}</div>
                    <div class="item-subtotal">Rp ${sub.toLocaleString('id-ID')}</div>
                </div>
            </div>
        </div>`;
    });
    container.innerHTML = html;
    updateTotals();
}

function updateTotals() {
    let total = 0, items = 0;
    Object.values(cart).forEach(i => { total += i.price * i.qty; items += i.qty; });
    document.getElementById('totalAmount').textContent = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('totalItems').textContent  = items + ' item';
    calcChange();
}

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
    const el     = document.getElementById('changeAmount');

    if (!Object.keys(cart).length || total === 0) {
        el.textContent = 'Rp 0'; box.classList.remove('warning'); btn.disabled = true; return;
    }
    if (change < 0) {
        box.classList.add('warning');
        el.textContent = '⚠ Kurang Rp ' + Math.abs(change).toLocaleString('id-ID');
        btn.disabled = true;
    } else {
        box.classList.remove('warning');
        el.textContent = 'Rp ' + change.toLocaleString('id-ID');
        btn.disabled = false;
    }
}

function checkout() {
    const items = Object.values(cart).map(i => ({ id: i.id, qty: i.qty }));
    const paid  = parseFloat(document.getElementById('paidInput').value) || 0;
    if (!items.length) { alert('Keranjang kosong!'); return; }

    const btn = document.getElementById('checkoutBtn');
    btn.disabled = true; btn.textContent = '⏳ Memproses...';

    fetch('{{ route("cashier.checkout") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ items, paid })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) { showModal(data.transaction); }
        else { alert('❌ ' + data.message); btn.disabled = false; btn.textContent = '✅ Checkout'; }
    })
    .catch(() => { alert('Kesalahan jaringan'); btn.disabled = false; btn.textContent = '✅ Checkout'; });
}

function showModal(trx) {
    document.getElementById('modalCode').textContent = trx.code;
    document.getElementById('modalDetails').innerHTML = `
        <div class="modal-row"><span>Total Belanja</span><span>Rp ${Number(trx.total).toLocaleString('id-ID')}</span></div>
        <div class="modal-row"><span>Uang Dibayar</span><span>Rp ${Number(trx.paid).toLocaleString('id-ID')}</span></div>
        <div class="modal-row"><span>Kembalian</span><span style="color:#4ade80;">Rp ${Number(trx.change).toLocaleString('id-ID')}</span></div>`;
    document.getElementById('successModal').classList.add('show');
}

function closeModal() {
    document.getElementById('successModal').classList.remove('show');
    cart = {}; renderCart();
    document.getElementById('paidInput').value = '';
    document.getElementById('checkoutBtn').disabled = true;
    document.getElementById('checkoutBtn').textContent = '✅ Checkout';
    location.reload();
}

// Init
renderCart();
// Desktop: tampilkan kedua panel
if (!isMobile()) {
    document.getElementById('panelProducts').removeAttribute('data-hidden');
    document.getElementById('panelCart').removeAttribute('data-hidden');
}
</script>
</x-app-layout>
