<?php

namespace App\Services\Procedimentos;

use App\Interfaces\Procedimentos\ProcedimentosServiceInterface;
use App\DTOs\Procedimentos\ProcedimentoDTO;
use App\Exceptions\Clinicas\NotFoundClinicaException;
use App\Exceptions\Procedimentos\NotFoundProcedimentoException;
use App\Interfaces\Especialidades\EspecialidadeServiceInterface;
use App\Models\Clinica;
use App\Models\Procedimento;

class ProcedimentosService implements ProcedimentosServiceInterface
{

  public function get(int $id): Procedimento
  {
    $procedimento = Procedimento::find($id);

    if (!$procedimento) {
      throw new NotFoundProcedimentoException();
    }

    return $procedimento;
  }

  public function getAllNotInClinica(int $clinica_id)
  {
    $clinica = Clinica::with(['procedimentos',])->find($clinica_id);

    if (!$clinica) {
      throw new NotFoundClinicaException();
    }

    return Procedimento::whereNotIn('id', $clinica->procedimentos->pluck('id'))->get();
  }

  public function getAll(?string $search = null)
  {
    $query = Procedimento::query();

    if ($search) {
      $query->where('nome', 'like', "%{$search}%");
    }

    return $query->get();
  }

  public function create(array $data): Procedimento
  {

    $especialidadeService = app()->make(EspecialidadeServiceInterface::class);

    $especialidadeService->get($data['especialidade_id']);

    return Procedimento::create([
      'nome' => $data['nome'],
      'especialidade_id' => $data['especialidade_id'],
    ]);
  }

  public function update(int $id, array $data): Procedimento
  {
    $procedimento = $this->get($id);

    if (isset($data['especialidade_id'])) {
      $especialidadeService = app()->make(EspecialidadeServiceInterface::class);
      $especialidadeService->get($data['especialidade_id']);
    }

    $procedimento->update($data);

    return $procedimento;
  }

  public function delete(int $id): void
  {
    $procedimento = $this->get($id);

    $procedimento->delete();
  }
}
