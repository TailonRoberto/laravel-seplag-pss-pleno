<?php

namespace App\Http\Controllers;

use App\Models\ServidorEfetivo;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\MinioService;

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
    
    // -- buscando por partes do nome do servidor
    public function enderecoFuncionalPorNome(Request $request)
    {
        $nome = $request->query('nome');
        $perPage = $request->query('per_page', 10);

        $servidores = ServidorEfetivo::with([
            'pessoa.lotacoes.unidade.enderecos.cidade'
        ])
        ->whereHas('pessoa', function ($query) use ($nome) {
            $query->where('pes_nome', 'ILIKE', "%{$nome}%");
        })
        ->paginate($perPage);

        $servidores->setCollection(
            $servidores->getCollection()->map(function ($servidor) {
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
            })
        );
    
        return $servidores;
    }  

    // -- listando servidores por unidade  
    public function porUnidade($unid_id, MinioService $minio)
    {
        $perPage = request('per_page', 10); 

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
        ->paginate($perPage);
        
        $servidores->setCollection(
            $servidores->getCollection()->map(function ($servidor) use ($minio) {
                $pessoa = $servidor->pessoa;
                $unidade = $pessoa->lotacoes->first()?->unidade?->unid_nome;

                $fotos = $pessoa->fotos->map(function ($foto) use ($minio) {
                    $url = $foto->fp_bucket && $foto->fp_hash
                        ? $minio->generateSignedUrl($foto->fp_hash, $foto->fp_bucket)
                        : null;

                    return [
                        'hash' => $foto->fp_hash,
                        'data' => $foto->fp_data,
                        'url' => $url,
                    ];
                });

                return [
                    'nome' => $pessoa->pes_nome,
                    'idade' => Carbon::parse($pessoa->pes_data_nascimento)->age,
                    'unidade' => $unidade,
                    'fotografias' => $fotos,
                ];
            })
        );

        return $servidores;
    }

}
