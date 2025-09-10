export interface EnderecoInterface {
    id: number;
    logradouro: string;
    numero?: string | null;
    complemento?: string | null;
    bairro: string;
    cidade: string;
    estado: string;
    cep: string;
}
