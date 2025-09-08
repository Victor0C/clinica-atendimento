import { EnderecoInterface } from "../EnderecoInterface";

export interface ClinicaInterface {
    id: number;
    nomeFantasia: string;
    razaoSocial: string;
    cnpj: string;
    rg: string;
    telefoneFixo: string;
    celular: string;
    email: string;

    enderecos: EnderecoInterface[];
}
