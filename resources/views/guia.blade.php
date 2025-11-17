<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            margin: 20px;
            color: #333;
        }

        .titulo {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 25px;
            text-transform: uppercase;
        }

        .secao {
            margin-bottom: 25px;
            border: 1px solid #aaa;
            padding: 15px;
            border-radius: 5px;
        }

        .secao h3 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 16px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        .linha {
            margin-bottom: 5px;
        }

        .label {
            font-weight: bold;
            width: 160px;
            display: inline-block;
        }
    </style>
</head>

<body>

    @php
        function formatCPF($cpf)
        {
            return $cpf ? preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', "$1.$2.$3-$4", $cpf) : '—';
        }

        function formatCNPJ($cnpj)
        {
            return $cnpj ? preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', "$1.$2.$3/$4-$5", $cnpj) : '—';
        }

        function formatPhone($phone)
        {
            if (!$phone) {
                return '—';
            }
            $phone = preg_replace('/\D/', '', $phone);

            if (strlen($phone) == 10) {
                return preg_replace('/(\d{2})(\d{4})(\d{4})/', "($1) $2-$3", $phone);
            }

            if (strlen($phone) == 11) {
                return preg_replace('/(\d{2})(\d{5})(\d{4})/', "($1) $2-$3", $phone);
            }

            return $phone;
        }

        function formatCEP($cep)
        {
            return $cep ? preg_replace('/(\d{5})(\d{3})/', "$1-$2", $cep) : '—';
        }
    @endphp


    <div style="text-align: left; margin-bottom: 10px;">
        <img src="{{ public_path('imgs/logo.jpeg') }}" alt="Logo" style="width: 50px;">
    </div>
    <div class="titulo">Guia de Encaminhamento Clínico</div>

    <div class="secao">
        <h3>Dados do Paciente</h3>

        <div class="linha"><span class="label">Nome Completo:</span> {{ $encaminhamento->paciente->nome }}</div>
        <div class="linha"><span class="label">CPF:</span> {{ formatCPF($encaminhamento->paciente->cpf) }}</div>
        <div class="linha"><span class="label">Celular:</span> {{ formatPhone($encaminhamento->paciente->celular) }}
        </div>

        <div class="linha"><span class="label">E-mail:</span> {{ $encaminhamento->paciente->email }}</div>

        <div class="linha"><span class="label">Convênio:</span>
            {{ $encaminhamento->paciente->convenio ?? '—' }}
        </div>

        <div class="linha"><span class="label">Carteirinha:</span>
            {{ $encaminhamento->paciente->numero_carteirinha ?? '—' }}
        </div>

        @php
            $end = $encaminhamento->paciente->enderecos[0] ?? null;
        @endphp

        <div class="linha"><span class="label">Endereço:</span>
            @if ($end)
                {{ $end->logradouro }},
                {{ $end->numero }},
                {{ $end->bairro }},
                {{ $end->cidade }} - {{ $end->estado }},
                CEP: {{ $end->cep }}
            @else
                —
            @endif
        </div>
    </div>

    <div class="secao">
        <h3>Dados da Clínica Destino</h3>

        <div class="linha"><span class="label">Nome:</span>
            {{ $encaminhamento->clinicaDestino->nome_fantasia }}</div>
        <div class="linha"><span class="label">CNPJ:</span> {{ formatCNPJ($encaminhamento->clinicaDestino->cnpj) }}
        </div>
        <div class="linha"><span class="label">Telefone:</span>
            {{ formatPhone($encaminhamento->clinicaDestino->telefone_fixo) }}</div>
        <div class="linha"><span class="label">Celular:</span>
            {{ formatPhone($encaminhamento->clinicaDestino->celular) }}</div>

        @php
            $endC = $encaminhamento->clinicaDestino->enderecos[0] ?? null;
        @endphp

        <div class="linha"><span class="label">Endereço:</span>
            @if ($endC)
                {{ $endC->logradouro }},
                {{ $endC->numero }},
                {{ $endC->bairro }},
                {{ $endC->cidade }} - {{ $endC->estado }},
                CEP: {{ $endC->cep }}
            @else
                —
            @endif
        </div>
    </div>
    </div>

    <div class="secao">
        <h3>Dados do Encaminhamento</h3>

        <div class="linha"><span class="label">Procedimento:</span>
            {{ $encaminhamento->procedimento->nome }}
        </div>

        <div class="linha"><span class="label">Encaminhado:</span>
            {{ \Carbon\Carbon::parse($encaminhamento->created_at)->format('d/m/Y H:i') }}
        </div>
    </div>

    <div style="margin-top: 80px; text-align: center;">
        <div style="border-top: 1px solid #000; width: 300px; margin: 0 auto; padding-top: 5px;">
            <span style="font-size: 12px;">Sistema de encaminhamento clínico HSRB</span>
        </div>
    </div>

</body>

</html>
