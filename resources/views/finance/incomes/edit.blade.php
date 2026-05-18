<x-app-layout>
    <div class="p-6 max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Edit Pemasukan</h1>
            <p class="text-gray-600 mt-2">Ubah data transaksi penjualan barang</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('incomes.update', $income) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Product Selection -->
                <div class="mb-4">
                    <label for="product_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Barang <span class="text-red-500">*</span>
                    </label>
                    <select name="product_id" 
                            id="product_id" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('product_id') border-red-500 @enderror"
                            required>
                        <option value="">Pilih Barang</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" 
                                    data-price="{{ $product->price }}"
                                    {{ old('product_id', $income->product_id) == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quantity -->
                <div class="mb-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                        Jumlah <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="quantity" 
                           id="quantity" 
                           value="{{ old('quantity', $income->quantity) }}"
                           min="1"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('quantity') border-red-500 @enderror"
                           required>
                    @error('quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Selling Price -->
                <div class="mb-4">
                    <label for="selling_price" class="block text-sm font-medium text-gray-700 mb-2">
                        Harga Jual <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="selling_price" 
                           id="selling_price" 
                           value="{{ old('selling_price', $income->selling_price) }}"
                           min="0"
                           step="0.01"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('selling_price') border-red-500 @enderror"
                           required>
                    @error('selling_price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Total (Auto Calculate) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Total
                    </label>
                    <div class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 text-gray-700 font-semibold">
                        Rp <span id="total-display">{{ number_format($income->total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Transaction Date -->
                <div class="mb-4">
                    <label for="transaction_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Transaksi <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           name="transaction_date" 
                           id="transaction_date" 
                           value="{{ old('transaction_date', $income->transaction_date->format('Y-m-d')) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('transaction_date') border-red-500 @enderror"
                           required>
                    @error('transaction_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div class="mb-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan
                    </label>
                    <textarea name="notes" 
                              id="notes" 
                              rows="3"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                              placeholder="Catatan tambahan (opsional)">{{ old('notes', $income->notes) }}</textarea>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4">
                    <button type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-300">
                        Update
                    </button>
                    <a href="{{ route('incomes.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded-lg transition duration-300">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Auto calculate total
        const quantityInput = document.getElementById('quantity');
        const priceInput = document.getElementById('selling_price');
        const totalDisplay = document.getElementById('total-display');

        function calculateTotal() {
            const quantity = parseFloat(quantityInput.value) || 0;
            const price = parseFloat(priceInput.value) || 0;
            const total = quantity * price;
            totalDisplay.textContent = total.toLocaleString('id-ID');
        }

        quantityInput.addEventListener('input', calculateTotal);
        priceInput.addEventListener('input', calculateTotal);
    </script>
</x-app-layout>
