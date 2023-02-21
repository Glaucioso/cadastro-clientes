<?php

namespace App\Http\Controllers;

use App\Models\local;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class locais extends Controller
{
    public function mostrar_locais()
    {
        $locais = DB::table('locais')
            ->get();
        return view('gestao_de_clientes.cadastros.lista', ['locais' => $locais]);
    }

    public function add_locais()
    {
        return view('gestao_de_clientes.cadastros.cadastrar_local');
    }

    public function gravar_locais(Request $request)
    {
        $local_local = $request->local_local;

        $table = DB::table('locais')
            ->where('local_local', '=', $local_local)
            ->get();
        $table = $table->count();

        if ($table === 0) {
            $grav = new local();
            $grav->local_local = $local_local;
            $grav->save();

            return redirect()->route('lista_locais');
        } else {
            $titulo_erro = "Item Duplicado";
            $msg_erro = "Esse Local ja esta cadastrado na base de dados";
            return view('layout.pag_erro', ['titles' => $titulo_erro, 'msg' => $msg_erro]);
        }
    }

    public function editar_local($id_local)
    {
        $table = DB::table('locais')
            ->where('id_local', '=', $id_local)
            ->get();
        return view('gestao_de_clientes.cadastros.editar_local', ['locais' => $table]);
    }

    public function gravar_edit_locais(Request $request)
    {
        $id_local = $request->id_local;
        $local_local = $request->local_local;
        $visible_local = $request->visible_local;

        $table = DB::table('locais')
            ->where('id_local', '!=', $id_local)
            ->where('local_local', '=', $local_local)
            ->get();

        $table = $table->count();

        if ($table == 0) {
            $table = local::find($id_local);
            $table->local_local = $local_local;
            $table->visible_local = $visible_local;
            $table->save();

            return redirect()->route('lista_locais');
        } else {
            $titulo_erro = "Item Duplicado";
            $msg_erro = "Esse Local ja esta cadastrado na base de dados";
            return view('layout.pag_erro', ['titles' => $titulo_erro, 'msg' => $msg_erro]);
        }
    }
}
