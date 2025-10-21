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
    $procedimento = Procedimento::with(['especialidade'])->find($id);

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
    $query = Procedimento::with(['especialidade']);

    if ($search) {
      $query->where('nome', 'like', "%{$search}%");
    }

    return $query->get();
  }

  public function create(array $data): Procedimento
  {
    $existingProcedimento = Procedimento::where('nome', $data['nome'])
      ->where('especialidade_id', $data['especialidade_id'])
      ->exists();

    if ($existingProcedimento) {
      throw new \Exception('Já existe um procedimento com este nome.', 422);
    }

    $especialidadeService = app()->make(EspecialidadeServiceInterface::class);
    $especialidadeService->get($data['especialidade_id']);

    $procedimento = Procedimento::create([
      'nome' => $data['nome'],
      'especialidade_id' => $data['especialidade_id'],
    ]);

    return $procedimento->load('especialidade');
  }

  public function update(int $id, array $data): Procedimento
  {
    $procedimento = $this->get($id);

    $existingProcedimento = Procedimento::where('nome', $data['nome'])
      ->where('id', '!=', $id)
      ->where('especialidade_id', $data['especialidade_id'])
      ->exists();

    if ($existingProcedimento) {
      throw new \Exception('Já existe um procedimento com este nome.', 422);
    }

    $shouldReloadEspecialidade = isset($data['especialidade_id']) && $data['especialidade_id'] != $procedimento->especialidade_id;

    if (isset($data['especialidade_id'])) {
      $especialidadeService = app()->make(EspecialidadeServiceInterface::class);
      $especialidadeService->get($data['especialidade_id']);
    }

    $procedimento->update($data);

    if ($shouldReloadEspecialidade) {
      $procedimento->load('especialidade');
    }

    return $procedimento;
  }

  public function delete(int $id): void
  {
    $procedimento = $this->get($id);

    $procedimento->delete();
  }
}
