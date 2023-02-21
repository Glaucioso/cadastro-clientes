@extends('layout.base')


@section('conteudo_pagina')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ $titles }}
                    </h3>
                </div>
                <div class="card-body">
                    {{ $msg }}
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" onclick="voltar()">
                        Voltar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script_final')
    <script>
        function voltar() {
            window.history.back();
        }
    </script>
@endsection
