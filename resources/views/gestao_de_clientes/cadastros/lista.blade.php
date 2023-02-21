@extends('layout.base')

@section('header')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('titulo_pagina', 'Locais de Divulgação')


@section('conteudo_pagina')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('add_locais') }}">
                <h3 class="card-title">
                    <i class="fa-solid fa-plus"></i>
                    Adicionar
                </h3>
            </a>
        </div>
        <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Local:</th>
                        <th>Data de Cadastro:</th>
                        <th>Status:</th>
                        <th>Editar:</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($locais as $local)
                        <tr>
                            <td>{{ $local->local_local }}</td>
                            <td>{{ date('d/m/Y', strtotime($local->created_at)) }}</td>
                            <td>
                                @if ($local->visible_local == 0)
                                    Desativado
                                @else
                                    Ativo
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('editar_locais', ['id_local' => $local->id_local]) }}">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection




@section('script_final')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
        $(function() {
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "language": {
                    "paginate": {
                        "previous": "Anterior",
                        "next": "Proxima"
                    },
                    "info": "Mostrando pagina _PAGE_ de _PAGES_",
                    "search": "Buscar:",
                    "infoFiltered": "",
                    "emptyTable": "Nenhum Local Cadastrado",
                    "zeroRecords": "Sem correspondencia para a busca",
                    "infoEmpty": "Mostrando 0 a 0 de 0 encontrados",
                }
            });
        });
    </script>
@endsection
