import { EnderecoInterface } from "../EnderecoInterface";
import { ProcedimentoInterface } from "../Procedimentos/ProcedimentoInterface";

export interface ClinicaInterface {
    id: number;
    nome_fantasia: string;
    razao_social: string;
    cnpj: string;
    telefone_fixo?: string | null;
    celular: string;
    email: string;

    enderecos: EnderecoInterface[];
    procedimentos: ProcedimentoInterface[];
}
