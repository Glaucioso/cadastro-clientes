@extends('layout.base')

@section('header')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <script>
        function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('rua').value = ("");
            document.getElementById('bairro').value = ("");
            document.getElementById('cidade').value = ("");
            document.getElementById('uf').value = ("");
        }

        function meu_callback(conteudo) {
            if (!("erro" in conteudo)) {
                //Atualiza os campos com os valores.
                document.getElementById('rua').value = (conteudo.logradouro);
                document.getElementById('bairro').value = (conteudo.bairro);
                document.getElementById('cidade').value = (conteudo.localidade);
                document.getElementById('uf').value = (conteudo.uf);
            } //end if.
            else {
                //CEP não Encontrado.
                limpa_formulário_cep();
                alert("CEP não encontrado.");
            }
        }

        function pesquisacep(valor) {

            //Nova variável "cep" somente com dígitos.
            var cep = valor.replace(/\D/g, '');

            //Verifica se campo cep possui valor informado.
            if (cep != "") {

                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if (validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    document.getElementById('rua').value = "...";
                    document.getElementById('bairro').value = "...";
                    document.getElementById('cidade').value = "...";
                    document.getElementById('uf').value = "...";

                    //Cria um elemento javascript.
                    var script = document.createElement('script');

                    //Sincroniza com o callback.
                    script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

                    //Insere script no documento e carrega o conteúdo.
                    document.body.appendChild(script);

                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
        };
    </script>
@endsection


@section('conteudo_pagina')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Cadastrar Clientes</h3>
                </div>
                <form action="{{ route('gravar_cliente') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nome:</label>
                                    <input type="text" class="form-control" autocomplete="off" name="nome_cliente"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">CPF / CNPJ:</label>
                                    <input type="text" class="form-control" autocomplete="off" name="cpf_cnpj_cliente"
                                        onblur="cpf_cnpj_mask(event), conferir(event)" id='cpf_cnpj_cliente'
                                        value="{{ $codigo }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Data de Nascimento:</label>
                                    <input type="date" class="form-control" autocomplete="off"
                                        name="dtnascimento_cliente">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">E-mail:</label>
                                    <input type="email" class="form-control" autocomplete="off" name="email_cliente">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Telefone 1:</label>
                                    <input type="text" class="form-control" autocomplete="off" name="tel1_cliente"
                                        onkeyup="telmask(event)" maxlength="16" id="tel1_cliente" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Telefone 2:</label>
                                    <input type="text" class="form-control" autocomplete="off" onkeyup="telmask(event)"
                                        maxlength="16" id="tel2_cliente" name="tel2_cliente">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-start">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Local:</label>
                                    <select class="form-control select2" name="fk_locais_cliente" required>
                                        <option></option>
                                        @foreach ($locais as $local)
                                            <option value="{{ $local->id_local }}">{{ $local->local_local }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">CEP:</label>
                                    <input type="text" class="form-control" autocomplete="off" id="cep"
                                        size="10" maxlength="9" onblur="pesquisacep(this.value);" name="cep_end"
                                        onkeyup="handleZipCode(event)" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Rua:</label>
                                    <input type="text" class="form-control" autocomplete="off" id="rua"
                                        name="rua_end" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Numero:</label>
                                    <input type="text" class="form-control" autocomplete="off" name="num_cliente"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Bairro:</label>
                                    <input type="text" class="form-control" autocomplete="off" id="bairro"
                                        name="bairro_end" required>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Cidade:</label>
                                    <input type="text" class="form-control" autocomplete="off" id="cidade"
                                        name="cidade_end" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">UF:</label>
                                    <input type="text" class="form-control" autocomplete="off" id="uf"
                                        name="uf_end" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="btn_cad" style="display: none"
                            onclick="tirarmask()">
                            Cadastrar
                        </button>
                        <label id="info">Por Favor verifique o CPF / CNPJ digitado.(Ou click no campo CPF e depois
                            click fora)</label>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script_final')
    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        const handleZipCode = (event) => {
            let input = event.target
            input.value = zipCodeMask(input.value)
        }

        const zipCodeMask = (value) => {
            if (!value) return ""
            value = value.replace(/\D/g, '')
            value = value.replace(/(\d{5})(\d)/, '$1-$2')
            return value
        }

        const telmask = (event) => {
            let input = event.target
            input.value = telefonemask(input.value)
        }

        const telefonemask = (value) => {
            if (!value) return ""
            if (value.length > 10) {
                value = value.replace(/\D/g, '')
                value = value.replace(/(\d{2})(\d{1})(\d{4})(\d{4})/, '($1) $2 $3-$4')
            } else {
                value = value.replace(/\D/g, '')
                value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3')
            }
            return value
        }

        function tirarmask() {
            document.getElementById('cpf_cnpj_cliente').value = document.getElementById('cpf_cnpj_cliente').value.replace(
                /\D/g, '');
            document.getElementById('tel1_cliente').value = document.getElementById('tel1_cliente').value.replace(/\D/g,
                '');
            document.getElementById('tel2_cliente').value = document.getElementById('tel2_cliente').value.replace(/\D/g,
                '');
        }

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
            let btn_cad = document.getElementById('btn_cad');
            let info = document.getElementById('info');
            var numeros = document.getElementById('cpf_cnpj_cliente').value
            numeros = numeros.replace(/\D/g, '');

            if (numeros.length == 11) {
                if (validacpf(numeros)) {
                    let cpf = document.getElementById('cpf_cnpj_cliente');
                    cpf.classList.remove('is-invalid');
                    cpf.classList.add('is-valid');
                    btn_cad.style.display = "block";
                    info.style.display = "none";
                } else {
                    let cpf = document.getElementById('cpf_cnpj_cliente');
                    cpf.classList.remove('is-valid');
                    cpf.classList.add('is-invalid');
                    btn_cad.style.display = "none";
                    info.style.display = "block";
                }
            } else if (numeros.length == 14) {
                if (validarCNPJ(numeros)) {
                    let cpf = document.getElementById('cpf_cnpj_cliente');
                    cpf.classList.remove('is-invalid');
                    cpf.classList.add('is-valid');
                    btn_cad.style.display = "block";
                    info.style.display = "none";
                } else {
                    let cpf = document.getElementById('cpf_cnpj_cliente');
                    cpf.classList.remove('is-valid');
                    cpf.classList.add('is-invalid');
                    btn_cad.style.display = "none";
                    info.style.display = "block";
                }
            } else {
                let cpf = document.getElementById('cpf_cnpj_cliente');
                cpf.classList.remove('is-valid');
                cpf.classList.remove('is-invalid');
                btn_cad.style.display = "none";
                info.style.display = "block";
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
    </script>
    <script>
        $('.select2').select2({
            theme: 'bootstrap4'
        })
    </script>
@endsection
