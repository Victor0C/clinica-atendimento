import { EnderecoInterface } from "../EnderecoInterface";

export interface ClinicaInterface {
    id: number;
    nome_fantasia: string;
    razao_social: string;
    cnpj: string;
    telefone_fixo?: string | null;
    celular: string;
    email: string;

    enderecos: EnderecoInterface[];
}
