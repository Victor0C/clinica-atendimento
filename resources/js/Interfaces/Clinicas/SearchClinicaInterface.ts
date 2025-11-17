export interface SearchClinicaInterface {
    page: number;
    perPage: number;
    cnpj?: string | null;
    nomeFantasia?: string | null;
    razaoSocial?: string | null;
}
