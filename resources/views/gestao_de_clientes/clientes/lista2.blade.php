@extends('layout.base')

@section('header')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('titulo_pagina', 'Clientes')


@section('conteudo_pagina')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Buscar Cliente</h3>
                </div>
                <form action="#" method="POST" id="form">
                    @csrf
                    <div class="card-body">
                        <div class="row align-items-end">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nome:</label>
                                    <input type="text" class="form-control" autocomplete="off" name="nome_cliente"
                                        value="{{ $nome_cliente }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">CPF / CNPJ:</label>
                                    <input type="text" class="form-control" autocomplete="off" name="cpf_cliente"
                                        onkeyup="cpf_cnpj_mask(event), conferir(event)" id='cpf_cnpj_cliente'
                                        value="{{ $cpf_cliente }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="btn_buscar" onclick="tirarmask()">
                                    Buscar
                                </button>

                                @if ($result > 0)
                                @else
                                    <a href="{{ route('add_cliente', ['codigo' => $cpf_cliente]) }}" id="add_link"
                                        class="btn btn-primary">
                                        Adicionar
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Listagem de Clientes
            </h3>
        </div>
        <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>CPF / CNPJ:</th>
                        <th>Nome:</th>
                        <th>Telefone:</th>
                        <th>Endereço:</th>
                        <th>Local:</th>
                        <th>Ações:</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tabelas as $tabela)
                        <tr>
                            <td>{{ $tabela->cpf_cnpj_cliente }}</td>
                            <td>{{ $tabela->nome_cliente }}</td>
                            <td>{{ $tabela->tel1_cliente }}</td>
                            <td>
                                {{ $tabela->rua_end . ', ' . $tabela->num_cliente . ', ' . $tabela->bairro_end . ', ' . $tabela->cidade_end }}
                            </td>
                            <td>{{ $tabela->local_local }}</td>
                            <td>
                                <a href="{{ route('editar_cliente', ['codigo' => $tabela->id_cliente]) }}">
                                    Editar
                                </a>
                                /
                                <a href="#">
                                    Abrir OS
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
                "searching": false,
                "ordering": false,
                "info": false,
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
    <script>
        const cpf_cnpj_mask = (event) => {
            let input = event.target
            input.value = mask_cpf_cnpj(input.value)
        }

        const mask_cpf_cnpj = (value) => {
            if (!value) return ""
            if (value.length > 11) {
                value = value.replace(/\D/g, '')
                value = value.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5')
            } else {
                value = value.replace(/\D/g, '')
                value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4')
            }
            return value
        }
        const conferir = (event) => {
            let btn_buscar = document.getElementById('btn_buscar');
            let add_link = document.getElementById('add_link');
            var numeros = document.getElementById('cpf_cnpj_cliente').value
            numeros = numeros.replace(/\D/g, '')



            if (numeros.length == 11) {
                if (validacpf(numeros)) {
                    let cpf = document.getElementById('cpf_cnpj_cliente');
                    cpf.classList.remove('is-invalid');
                    cpf.classList.add('is-valid');
                    btn_buscar.style.display = "inline-block";
                    add_link.style.display = "inline-block";
                } else {
                    let cpf = document.getElementById('cpf_cnpj_cliente');
                    cpf.classList.remove('is-valid');
                    cpf.classList.add('is-invalid');
                    btn_buscar.style.display = "none";
                    add_link.style.display = "none";
                    $(document).ready(function() {
                        $('form').keypress(function(e) {
                            if ((e.keyCode == 10) || (e.keyCode == 13)) {
                                e.preventDefault();
                            }
                        });
                    });
                }
            } else if (numeros.length == 14) {
                if (validarCNPJ(numeros)) {
                    let cpf = document.getElementById('cpf_cnpj_cliente');
                    cpf.classList.remove('is-invalid');
                    cpf.classList.add('is-valid');
                    btn_buscar.style.display = "inline-block";
                    add_link.style.display = "inline-block";
                } else {
                    let cpf = document.getElementById('cpf_cnpj_cliente');
                    cpf.classList.remove('is-valid');
                    cpf.classList.add('is-invalid');
                    btn_buscar.style.display = "none";
                    add_link.style.display = "none";
                    $(document).ready(function() {
                        $('form').keypress(function(e) {
                            if ((e.keyCode == 10) || (e.keyCode == 13)) {
                                e.preventDefault();
                            }
                        });
                    });
                }
            } else {
                let cpf = document.getElementById('cpf_cnpj_cliente');
                cpf.classList.remove('is-valid');
                cpf.classList.remove('is-invalid');
                btn_buscar.style.display = "inline-block";
            }




            function validarCNPJ(cnpj) {

                cnpj = cnpj.replace(/[^\d]+/g, '');

                if (cnpj == '') return false;

                if (cnpj.length != 14)
                    return false;

                // Elimina CNPJs invalidos conhecidos
                if (cnpj == "00000000000000" ||
                    cnpj == "11111111111111" ||
                    cnpj == "22222222222222" ||
                    cnpj == "33333333333333" ||
                    cnpj == "44444444444444" ||
                    cnpj == "55555555555555" ||
                    cnpj == "66666666666666" ||
                    cnpj == "77777777777777" ||
                    cnpj == "88888888888888" ||
                    cnpj == "99999999999999")
                    return false;

                // Valida DVs
                tamanho = cnpj.length - 2
                numeros = cnpj.substring(0, tamanho);
                digitos = cnpj.substring(tamanho);
                soma = 0;
                pos = tamanho - 7;
                for (i = tamanho; i >= 1; i--) {
                    soma += numeros.charAt(tamanho - i) * pos--;
                    if (pos < 2)
                        pos = 9;
                }
                resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                if (resultado != digitos.charAt(0))
                    return false;

                tamanho = tamanho + 1;
                numeros = cnpj.substring(0, tamanho);
                soma = 0;
                pos = tamanho - 7;
                for (i = tamanho; i >= 1; i--) {
                    soma += numeros.charAt(tamanho - i) * pos--;
                    if (pos < 2)
                        pos = 9;
                }
                resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                if (resultado != digitos.charAt(1))
                    return false;

                return true;

            }

            function validacpf(strcpf) {
                var Soma;
                var Resto;
                Soma = 0;
                if (strcpf == "00000000000")
                    return false;
                for (i = 1; i <= 9; i++)
                    Soma = Soma + parseInt(strcpf.substring(i - 1, i)) * (11 - i);
                Resto = (Soma * 10) % 11;
                if ((Resto == 10) || (Resto == 11))
                    Resto = 0;
                if (Resto != parseInt(strcpf.substring(9, 10)))
                    return false;
                Soma = 0;
                for (i = 1; i <= 10; i++)
                    Soma = Soma + parseInt(strcpf.substring(i - 1, i)) * (12 - i);
                Resto = (Soma * 10) % 11;
                if ((Resto == 10) || (Resto == 11))
                    Resto = 0;
                if (Resto != parseInt(strcpf.substring(10, 11)))
                    return false;
                return true;
            }
        }

        function tirarmask() {
            document.getElementById('cpf_cnpj_cliente').value = document.getElementById('cpf_cnpj_cliente').value.replace(
                /\D/g, '');
        }
    </script>
@endsection
