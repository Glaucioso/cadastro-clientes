<?php

namespace App\Http\Controllers;

use App\Models\cliente;
use Illuminate\Http\Request;
use App\Models\endereco;
use App\Models\local;
use Illuminate\Support\Facades\DB;

class clientes extends Controller
{
    public function listar_cliente()
    {
        $result = 0;
        return view('gestao_de_clientes.clientes.lista', ['result' => $result]);
    }
    public function listar2_cliente(Request $request)
    {
        $nome_cliente = $request->nome_cliente;
        $cpf_cliente = $request->cpf_cliente;

        if ($cpf_cliente == null) {
            $table = DB::table('clientes')
                ->join('enderecos', 'fk_end_cliente', '=', 'id_end')
                ->join('locais', 'fk_locais_cliente', '=', 'id_local')
                ->where('nome_cliente', 'like', "%$nome_cliente%")
                ->get();
            $result = $table->count();
        } elseif ($nome_cliente == null) {
            $table = DB::table('clientes')
                ->join('enderecos', 'fk_end_cliente', '=', 'id_end')
                ->join('locais', 'fk_locais_cliente', '=', 'id_local')
                ->where('cpf_cnpj_cliente', 'like', "%$cpf_cliente%")
                ->get();
            $result = $table->count();
        } elseif ($cpf_cliente != null and $nome_cliente != null) {
            $table = DB::table('clientes')
                ->join('enderecos', 'fk_end_cliente', '=', 'id_end')
                ->join('locais', 'fk_locais_cliente', '=', 'id_local')
                ->where('cpf_cnpj_cliente', 'like', "%$cpf_cliente%")
                ->where('nome_cliente', 'like', "%$nome_cliente%")
                ->get();
            $result = $table->count();
        }

        if ($result > 0) {
            return view(
                'gestao_de_clientes.clientes.lista2',
                ['tabelas' => $table, 'nome_cliente' => $nome_cliente, 'cpf_cliente' => $cpf_cliente, 'result' => $result]
            );
        } else {
            return view(
                'gestao_de_clientes.clientes.lista2',
                ['tabelas' => $table, 'nome_cliente' => $nome_cliente, 'cpf_cliente' => $cpf_cliente, 'result' => $result]
            );
        }
    }
    public function add_cliente($codigo)
    {
        $table = DB::table('locais')
            ->where('visible_local', '=', '1')
            ->get();
        return view('gestao_de_clientes.clientes.cadastro', ['locais' => $table, 'codigo' => $codigo]);
    }
    public function gravar_cliente(Request $request)
    {
        $i = 0;
        while ($i == 0) {
            $table = DB::table('enderecos')
                ->where('cep_end', '=', $request->cep_end)
                ->get();
            $table = $table->count();
            if ($table == 0) {
                $insert = new endereco();
                $insert->cep_end = $request->cep_end;
                $insert->rua_end = $request->rua_end;
                $insert->bairro_end = $request->bairro_end;
                $insert->cidade_end = $request->cidade_end;
                $insert->uf_end = $request->uf_end;
                $insert->save();
            } else {
                $tables = DB::table('enderecos')
                    ->where('cep_end', '=', $request->cep_end)
                    ->get();
                foreach ($tables as $table) {
                    $fk_end_cliente = $table->id_end;
                }
                $i = 1;
            }
        }

        $table = DB::table('clientes')
            ->where('cpf_cnpj_cliente', '=', $request->cpf_cnpj_cliente)
            ->get();
        $table = $table->count();

        if ($table > 0) {
            $titulo_erro = "Item Duplicado";
            $msg_erro = "Esse CPF/CNPJ ja esta cadastrado na base de dados";
            return view('layout.pag_erro', ['titles' => $titulo_erro, 'msg' => $msg_erro]);
        } else {
            $insert = new cliente();
            $insert->nome_cliente = $request->nome_cliente;
            $insert->cpf_cnpj_cliente = $request->cpf_cnpj_cliente;
            $insert->dtnascimento_cliente = $request->dtnascimento_cliente;
            $insert->email_cliente = $request->email_cliente;
            $insert->tel1_cliente = $request->tel1_cliente;
            $insert->tel2_cliente = $request->tel2_cliente;
            $insert->num_cliente = $request->num_cliente;
            $insert->fk_locais_cliente = $request->fk_locais_cliente;
            $insert->fk_end_cliente = $fk_end_cliente;
            $insert->save();

            $titulo_erro = "Continuação para o Sistema";
            $msg_erro = "Tudo certo com o cadastro do cliente, aqui nos continuariamos para a geração da ordem de serviço";
            return view('layout.pag_erro', ['titles' => $titulo_erro, 'msg' => $msg_erro]);
        }
    }
    public function editar_cliente($codigo)
    {
        $table = DB::table('clientes')
            ->join('enderecos', 'fk_end_cliente', '=', 'id_end')
            ->join('locais', 'fk_locais_cliente', '=', 'id_local')
            ->where('id_cliente', '=', $codigo)
            ->get();

        $locais = DB::table('locais')
            ->where('visible_local', '=', '1')
            ->get();

        return view('gestao_de_clientes.clientes.edit', ['tabelas' => $table, 'locais' => $locais]);
    }
    public function gravar_edit_cliente(Request $request)
    {
        $i = 0;
        while ($i == 0) {
            $table = DB::table('enderecos')
                ->where('cep_end', '=', $request->cep_end)
                ->get();
            $table = $table->count();
            if ($table == 0) {
                $insert = new endereco();
                $insert->cep_end = $request->cep_end;
                $insert->rua_end = $request->rua_end;
                $insert->bairro_end = $request->bairro_end;
                $insert->cidade_end = $request->cidade_end;
                $insert->uf_end = $request->uf_end;
                $insert->save();
            } else {
                $tables = DB::table('enderecos')
                    ->where('cep_end', '=', $request->cep_end)
                    ->get();
                foreach ($tables as $table) {
                    $fk_end_cliente = $table->id_end;
                }
                $i = 1;
            }
        }

        $insert = cliente::find($request->id_cliente);
        $insert->nome_cliente = $request->nome_cliente;
        $insert->dtnascimento_cliente = $request->dtnascimento_cliente;
        $insert->email_cliente = $request->email_cliente;
        $insert->tel1_cliente = $request->tel1_cliente;
        $insert->tel2_cliente = $request->tel2_cliente;
        $insert->fk_locais_cliente = $request->fk_locais_cliente;
        $insert->num_cliente = $request->num_cliente;
        $insert->fk_end_cliente = $fk_end_cliente;
        $insert->save();

        $titulo_erro = "Continuação para o Sistema";
        $msg_erro = "Tudo certo com o cadastro do cliente, aqui nos continuariamos para a geração da ordem de serviço";
        return view('layout.pag_erro', ['titles' => $titulo_erro, 'msg' => $msg_erro]);
    }
}
