<?php

namespace App\Http\Controllers;

use App\Models\ServidorEfetivo;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ServidorEfetivoController extends Controller
{
    public function index()
    {
        return ServidorEfetivo::with('pessoa')->paginate(10);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pes_id' => 'required|exists:pessoa,pes_id',
            'se_matricula' => 'required|string|max:50',
        ]);

        return ServidorEfetivo::create($data);
    }

    public function show($id)
    {
        return ServidorEfetivo::with('pessoa')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $registro = ServidorEfetivo::findOrFail($id);

        $data = $request->validate([
            'se_matricula' => 'sometimes|string|max:50',
        ]);

        $registro->update($data);
        return $registro;
    }

    public function destroy($id)
    {
        $registro = ServidorEfetivo::findOrFail($id);
        $registro->delete();
        return response()->json(['message' => 'Deletado com sucesso']);
    }

    public function porUnidade($unid_id)
    {
        $servidores = ServidorEfetivo::with([
            'pessoa.fotos',
            'pessoa.lotacoes' => function ($query) use ($unid_id) {
                $query->where('unid_id', $unid_id);
            },
            'pessoa.lotacoes.unidade',
        ])
        ->whereHas('pessoa.lotacoes', function ($query) use ($unid_id) {
            $query->where('unid_id', $unid_id);
        })
        ->get();

        return $servidores->map(function ($servidor) {
            $pessoa = $servidor->pessoa;

            return [
                'nome' => $pessoa->pes_nome,
                'idade' => Carbon::parse($pessoa->pes_data_nascimento)->age,
                'unidade' => $pessoa->lotacoes->first()?->unidade->unid_nome,
                'foto' => $pessoa->fotos->first()?->fp_bucket ?? null,
            ];
        });
    }
    public function enderecoFuncionalPorNome(Request $request)
    {
        $nome = $request->query('nome');

        $servidores = ServidorEfetivo::with([
            'pessoa.lotacoes.unidade.enderecos.cidade'
        ])
        ->whereHas('pessoa', function ($query) use ($nome) {
            $query->where('pes_nome', 'ILIKE', "%{$nome}%");
        })
        ->get();

        return $servidores->map(function ($servidor) {
            $unidade = $servidor->pessoa->lotacoes->first()?->unidade;

            $endereco = $unidade?->enderecos->first();

            return [
                'servidor' => $servidor->pessoa->pes_nome,
                'unidade' => $unidade?->unid_nome,
                'endereco' => $endereco ? [
                    'logradouro' => $endereco->end_tipo_logradouro . ' ' . $endereco->end_logradouro,
                    'numero' => $endereco->end_numero,
                    'bairro' => $endereco->end_bairro,
                    'cidade' => $endereco->cidade->cid_nome ?? null,
                ] : null,
            ];
        });
    }
}
