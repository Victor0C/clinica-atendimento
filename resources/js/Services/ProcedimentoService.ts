import { ProcedimentoInterface } from '@/Interfaces/Procedimentos/ProcedimentoInterface';
import api from './api';


async function getAllNotInClinica(clinicaId: number): Promise<ProcedimentoInterface[]> {
    try {
        const response = await api.get(`clinicas/${clinicaId}/procedimentos`);

        return response.data;
    } catch (error: any) {
        const message = error.response?.data?.message || 'Erro ao buscar procedimentos. Tente novamente.';
        throw new Error(message);
    }
}


export { getAllNotInClinica };
