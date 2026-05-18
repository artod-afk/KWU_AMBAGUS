<x-app-layout>

    <div class="p-6">

        <h1 class="text-2xl font-bold mb-6">
            Riwayat Stok
        </h1>

        <table class="w-full border">

            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 border">Produk</th>
                    <th class="p-3 border">Tipe</th>
                    <th class="p-3 border">Jumlah</th>
                    <th class="p-3 border">Tanggal</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($histories as $history)

                    <tr>

                        <td class="p-3 border">
                            {{ $history->product->name }}
                        </td>

                        <td class="p-3 border">
                            {{ $history->type }}
                        </td>

                        <td class="p-3 border">
                            {{ $history->quantity }}
                        </td>

                        <td class="p-3 border">
                            {{ $history->created_at }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</x-app-layout>