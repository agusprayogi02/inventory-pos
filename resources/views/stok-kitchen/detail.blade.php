<table class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>User</th>
            <th>Jumlah (gram)</th>
            <th>Status</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($stokKitchen as $row)
            <tr @if ($row->status == \App\Enums\StokStatus::MINUS->value) class="bg-red" @endif>
                <td>{{ $row->tanggal ? date('d M Y', $row->tanggal) : '-' }}</td>
                <td>{{ $row->user->name ?? '-' }}</td>
                <td>{{ $row->jumlah_real }}</td>
                <td>{{ $row->status == \App\Enums\StokStatus::PLUS->value ? 'Masuk' : 'Keluar' }}</td>
                <td>{{ $row->keterangan ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada data</td>
            </tr>
        @endforelse
    </tbody>
</table>
