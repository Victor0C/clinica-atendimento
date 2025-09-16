<?php

namespace App\Interfaces\Clinicas;

use App\DTOs\Clinicas\SearchGetAllClinicasDTO;
use Illuminate\Database\Eloquent\Collection;

interface GetAllClinicasServiceInterface
{
  public function fire(int $page, int $perPage = 20, ?SearchGetAllClinicasDTO $searchDTO = null): Collection;
}
