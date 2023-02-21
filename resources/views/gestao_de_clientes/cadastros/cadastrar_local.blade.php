@extends('layout.base')


@section('conteudo_pagina')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Cadastrar Local</h3>
                </div>
                <form action="{{ route('gravar_locais') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Descrição do Local:</label>
                            <input type="text" class="form-control" autocomplete="off" name="local_local">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Ativo:</label>
                            <select class="form-control" name="visible_local" disabled>
                                <option value="1">SIM</option>
                                <option value="0">NÃO</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
