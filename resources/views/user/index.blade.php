@extends('templates.app', ['title' => 'Akun || APOTEK'])

@section('content-dinamis')
    <div class="my-3">
        <a href="{{route('users.add')}}" class="btn btn-success mb-3">+ Tambah</a>
        @if (Session::get('berhasil'))
            <div class="alert alert-success my-2">{{Session::get('berhasil')}}</div>
        @endif
        <table class="table table-bordered table-stripped text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama </th>
                    <th>Email </th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1 ; @endphp
                @if (count($users) > 0)
                    @foreach ($users as $index => $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['email'] }}</td>
                            <td>{{ $item['role'] }}</td>
                            {{-- <td>{{ $item['password'] }}</td> --}}
                            <td class="d-flex justify-content-center py-1">
                                <a href="{{ route('users.edit', $item['id']) }}" class="btn btn-primary me-3">Edit</a>
                                <button class="btn btn-danger" onclick="showModal('{{$item->id}}', '{{$item->name}}')">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-bold">Data Kosong</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="d-flex justify-content-end mt-3">
            {{ $users->links() }}
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <form id="form-delete-data" method="POST">
                @csrf
                {{-- menimpa method="POST" diganti menjadi delete, sesuai dengan http method untuk menghapus data --}}
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body"> 
                        Apakah Anda yakin ingin menghapus data <span id="nama-obat"></span>?
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
    </div>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        // fungsi untuk menampilkan modal
        function showModal(id, name) {
            // isi untuk action form
            let action = "{{ route('users.delete', ':id') }}";
            action = action.replace(':id', id);
            // buat attribute action pada form
            $('#form-delete-data').attr('action', action);
            // munculkan modal yg id nya exampleModal
            $('#exampleModal').modal('show');
            // innerText pada element html id nama-obat
            $('#nama-obat').text(name);
        }
</script>
@endpush