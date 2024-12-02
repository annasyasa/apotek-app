@extends('templates.app', ['title' => 'Obat || APOTEK'])

@section('content-dinamis')
    <div class="my-3">
        <a href="{{ route('medicines.add') }}" class="btn btn-success mb-3">+ Tambah</a>
        @if (Session::get('berhasil'))
            <div class="alert alert-success my-2">{{ Session::get('berhasil') }}</div>
        @endif
        <table class="table table-bordered table-stripped text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Obat</th>
                    <th>Tipe</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if (count($medicines) > 0)
                    @foreach ($medicines as $index => $item)
                        <tr>
                            <td>{{ ($medicines->currentPage() - 1) * $medicines->perpage() + ($index + 1) }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['type'] }}</td>
                            <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td class="{{ $item['stock'] <= 3 ? 'bg-danger text-white' : 'bg-white text-dark' }}"
                                onclick="editStock({{ $item['id'] }}, {{ $item['stock'] }})">
                                {{-- {{ $item['stock'] }} --}}
                                <span
                                    style="cursor: pointer; text-decoration: underline !important">{{ $item['stock'] }}</span>
                                {{-- <br> --}}
                                {{-- <small class="text-primary">Ubah Stock</small> --}}
                            </td>
                            <td class="d-flex justify-content-center py-1">
                                <a href="{{ route('medicines.edit', $item['id']) }}" class="btn btn-primary me-3">Edit</a>
                                <button class="btn btn-danger"
                                    onclick="showModal('{{ $item->id }}', '{{ $item->name }}')">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-bold">Data Obat Kosong</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="d-flex justify-content-end mt-3">
            {{ $medicines->links() }}
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="form-delete-obat" method="POST">
                    @csrf
                    {{-- menimpa method="POST" diganti menjadi delete, sesuai dengan http method untuk menghapus data --}}
                    @method('DELETE')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data Obat</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus data obat <span id="nama-obat"></span>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            {{-- save change dibuat type="submit" agar form di modal bisa jalanin action --}}
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- modal stok --}}
        <div class="modal fade" id="editStockModal" tabindex="-1" aria-labelledby="editStockLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="form-edit-stock" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editStockLabel">Edit Stok</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="medicine-id">
                            <div class="form-group">
                                <label for="stock" class="form-label">Stok</label>
                                <input type="number" name="stock" id="stock" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        // fungsi untuk menampilkan modal
        function showModal(id, name) {
            // isi untuk action form
            let action = '{{ route('medicines.delete', ':id') }}';
            action = action.replace(':id', id);
            // buat attribute action pada form
            $('#form-delete-obat').attr('action', action);
            // munculkan modal yg id nya exampleModal
            $('#exampleModal').modal('show');
            // innerText pada element html id nama-obat
            $('#nama-obat').text(name);
        }


        // Fungsi buat nampilin modal edit stok sama masukin nilai stok yang mau diedit
        function editStock(id, stock) {
            $('#medicine-id').val(id);
            $('#stock').val(stock);
            $('#editStockModal').modal('show');
        }

        // Event listener buat handle submit form secara AJAX
        $('#form-edit-stock').on('submit', function(e) {
            // Biar form gak ke-submit dengan cara biasa (refresh halaman), kita pake preventDefault
            e.preventDefault();

            // Ambil id obat dari input hidden
            let id = $('#medicine-id').val();
            // Ambil stok baru yang diinput user
            let stock = $('#stock').val();
            // Bikin URL buat update stok dengan metode PUT
            let actionUrl = "{{ url('/medicines/update-stok')}}/" + id;

            // Kirim request AJAX buat update stok
            $.ajax({
                url: actionUrl, // URL tujuan buat update stok
                type: 'PUT', // Gunakan metode PUT buat update data
                data: {
                    _token: '{{ csrf_token() }}', // Token CSRF biar aman
                    stock: stock // Data stok baru yang mau dikirim ke server
                },
                success: function(response) {
                    // Tutup modal kalau update berhasil
                    $('#editStockModal').modal('hide');
                    // Refresh halaman biar perubahan stok keliatan
                    location.reload();
                },
                error: function(err) {
                    // Kasih alert kalau ada error pas update stok
                    alert(err.responseJSON.failed);
                    console.log(err)
                }
            });
        });
    </script>
@endpush
