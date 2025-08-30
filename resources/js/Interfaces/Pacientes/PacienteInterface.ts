export interface EnderecoInterface {
    logradouro: string;
    numero?: string | null;
    complemento?: string | null;
    bairro: string;
    cidade: string;
    estado: string;
    cep: string;
}

export interface PacienteInterface {
    id: number;
    nome: string;
    data_nascimento: string; // formato 'YYYY-MM-DD'
    cpf: string;
    rg: string;
    sexo: 'M' | 'F' | 'O';
    telefone_fixo?: string | null;
    celular: string;
    email: string;
    convenio?: string | null;
    numero_carteirinha?: string | null;
    observacoes?: string | null;
    status: 'ativo' | 'inativo';

    enderecos: EnderecoInterface[];
}
