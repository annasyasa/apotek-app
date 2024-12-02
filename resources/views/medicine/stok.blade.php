@extends('templates.app', ['title'=> 'Tambah Stok || APOTEK'])

@section('content-dinamis')
<h1 class="mt-3">STOK</h1>
<table class="table table-bordered table-stripped text-center">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Obat</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach ($medicines as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{$item['name'] }}</td>
                <td>{{ $item['stock'] }}</td>
                
            </tr>
    </tbody>
</table>
@endsection

@push('script')
       <script type="text/javascript">
       $.ajaxsetup({
        headers : {
            'X-CSRF-TOKEN' : $('meta["name=csrf-token"]').attr('content')
        }
       });
       function edit(id){
        var url= "{{ route('medicine.stock.edit', ":id") }}";
        url = url.replace(':id', id);
        $.ajax({
            type : "GET",
            url : url,
            dataType: "json",
            success: function(res){
                $('#edit-stock').modal('show');
                $('#id').val(red.id);
                $('#name').val(res.name);
                $('#stock').val(res.stock);
            }
        });
       }
       </script>
@endpush 