@extends('layout.base')


@section('conteudo_pagina')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Editar Local</h3>
                </div>
                <form action="{{ route('gravar_edit_locais') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        @foreach ($locais as $local)
                            <div class="form-group">
                                <label for="exampleInputEmail1">Descrição do Local:</label>
                                <input type="text" class="form-control" autocomplete="off" name="local_local"
                                    value="{{ $local->local_local }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Ativo:</label>
                                <select class="form-control" name="visible_local">
                                    @if ($local->visible_local == 0)
                                        <option value="0">NÃO</option>
                                        <option value="1">SIM</option>
                                    @else
                                        <option value="1">SIM</option>
                                        <option value="0">NÃO</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group" style="display: none">
                                <label for="exampleInputEmail1">ID do Local:</label>
                                <input type="text" class="form-control" autocomplete="off" name="id_local"
                                    value="{{ $local->id_local }}">
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Editar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
