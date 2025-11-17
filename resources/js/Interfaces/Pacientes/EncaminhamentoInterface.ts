export interface EncaminhamentoInterface {
  id: number;
  clinica: {
    id: number;
    nome: string;
  };
  procedimento: {
    id: number;
    nome: string;
  };
  data_encaminhamento: string;
}
