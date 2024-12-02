@extends('templates.app', ['title' => 'Riwayat || Apotek'])

@section('content-dinamis')
    <div class="container mt-5" style="width: 80%; max-width: 1200px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="text-success">HISTORY</h3>
            </div>
            <div class="d-flex" style="gap: 20px">
                <form action="" class="d-flex" style="gap: 10px">
                    <input class="form-control me-2" type="date" placeholder="Search" name="search" aria-label="Search">
                    <button class="btn btn-warning" type="submit">Cari</button>
                    <button class="btn btn-secondary" type="submit">Clear</button>
                </form>
        </div>
        </div>
        <div class="d-flex justify-content-end">
            <a href="{{ route('orders.export.excel') }}" class="btn btn-success">Export Excel</a>
        </div>
        <div class="mt-4">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kasir</th>
                    <th>Nama Pembeli</th>
                    <th>Obat</th>
                    <th>Total Harga</th>
                    <th>Tanggal Pembelian</th>
                  </tr>
                </thead>
                <tbody>
                     @foreach ($order as $index => $item)
                    <tr>
                          <td> {{$index + 1}} </td>
                          <td> {{ $item['user'] ['name']}}</td>
                          <td> {{$item['name_customer']}}</td>
                          <td> @php $medicines = $item['medicines']; 
                            $detailObat =[]; foreach ($medicines as $medicine){
                            $detailObat[] ='' . $medicine['name_medicine'] . 'Rp.(' . number_format($medicine['sub_price'], 0, ',', '.') . ') = ' . number_format($medicine['price'], 0, ',', '.') . '<small class="text-success"> qty' . $medicine['qty'] . '</small>';}
                            $namaObat=implode('<br>', $detailObat);
                            @endphp
                              {!! $namaObat!!}
                          </td>
                          <td>Rp. {{ number_format($item['total_price'], 0, ',', '.') }}</td>
                          <td>{{ Carbon\Carbon::parse($item->created_at)->formatLocalized('%d %B %Y') }}</td>
                          <td> <a class="btn btn-danger" href="{{ route('orders.download', $item['id'])}}">Download</a></td>
                    </tr>
                        @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-4">
            @if ($order->count())
              {{ $order->links() }}
            @endif
        </div>
    </div>
@endsection