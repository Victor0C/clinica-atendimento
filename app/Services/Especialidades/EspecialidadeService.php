<?php

namespace App\Services\Especialidades;

use App\Interfaces\Especialidades\EspecialidadeServiceInterface;
use App\DTOs\Especialidades\SearchGetAllEspecialidadesDTO;
use App\Exceptions\Especialidades\NotFoundEspecialidadeException;
use App\Models\Especialidade;
use App\DTOs\Especialidades\EspecialidadeDTO;


class EspecialidadeService implements EspecialidadeServiceInterface
{
  public function get($id): Especialidade
  {
    $especialidade = Especialidade::find($id);

    if (!$especialidade) {
      throw new NotFoundEspecialidadeException();
    }

    return $especialidade;
  }

  public function getAll(?SearchGetAllEspecialidadesDTO $searchDTO = null)
  {
    $query = Especialidade::query();

    if ($searchDTO && $searchDTO->nome) {
      $query->where('nome', 'like', "%{$searchDTO->nome}%");
    }

    return $query->get();
  }


  public function create(array $data): Especialidade
  {
    if (Especialidade::where('nome', $data['nome'])->exists()) {
      throw new \Exception('Já existe uma especialidade com esse nome.', 422);
    }

    $especialidade = Especialidade::create($data);
    return $especialidade;
  }

  public function update(int $id, array $data): Especialidade
  {
    $especialidade = $this->get($id);
    if (isset($data['nome']) && $data['nome'] !== $especialidade->nome) {
      if (Especialidade::where('nome', $data['nome'])->where('id', '!=', $id)->exists()) {
        throw new \Exception('Já existe uma especialidade com esse nome.', 422);
      }
    }

    $especialidade->update($data);
    return $especialidade;
  }

  public function delete(int $id): void
  {
    $especialidade = $this->get($id);
    $especialidade->delete();
  }
}
