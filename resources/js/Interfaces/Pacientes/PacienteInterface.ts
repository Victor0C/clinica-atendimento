import { EnderecoInterface } from "../EnderecoInterface";

export interface PacienteInterface {
    id: number;
    nome: string;
    data_nascimento: string;
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
