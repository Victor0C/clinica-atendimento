<?php

namespace App\Console\Commands;

use App\DTOs\Clinicas\ClinicaWithProcedimentosDTO;
use App\Interfaces\Clinicas\ClinicasServiceInterface;
use App\Models\Clinica;
use App\Services\Clinicas\ClinicasService;
use Illuminate\Console\Command;

class victor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:victor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        dd(ClinicaWithProcedimentosDTO::fromModel(Clinica::with(['enderecos', 'procedimentos.especialidade'])->find(1)));

        // $clinicaService = app()->make(ClinicasServiceInterface::class);
        // dd($clinicaService->addProcedimentos(1, 1, 5000));
    }
}
