@extends('layout.base')

@section('titulo_pagina', 'Clientes')

@section('conteudo_pagina')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Buscar Cliente</h3>
                </div>
                <form action="{{ route('buscar_cliente') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row align-items-end">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nome:</label>
                                    <input type="text" class="form-control" autocomplete="off" name="nome_cliente">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">CPF / CNPJ:</label>
                                    <input type="text" class="form-control" autocomplete="off" name="cpf_cliente"
                                        onkeyup="cpf_cnpj_mask(event), conferir(event)" id='cpf_cnpj_cliente'>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="btn_buscar" onclick="tirarmask()">
                                    Buscar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection




@section('script_final')
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
            var numeros = document.getElementById('cpf_cnpj_cliente').value
            numeros = numeros.replace(/\D/g, '')

            if (numeros.length == 11) {
                if (validacpf(numeros)) {
                    let cpf = document.getElementById('cpf_cnpj_cliente');
                    cpf.classList.remove('is-invalid');
                    cpf.classList.add('is-valid');
                    btn_buscar.style.display = "block";
                } else {
                    let cpf = document.getElementById('cpf_cnpj_cliente');
                    cpf.classList.remove('is-valid');
                    cpf.classList.add('is-invalid');
                    btn_buscar.style.display = "none";
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
                    btn_buscar.style.display = "block";
                } else {
                    let cpf = document.getElementById('cpf_cnpj_cliente');
                    cpf.classList.remove('is-valid');
                    cpf.classList.add('is-invalid');
                    btn_buscar.style.display = "none";
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
                btn_buscar.style.display = "block";
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
