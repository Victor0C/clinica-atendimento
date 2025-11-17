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

async function getAllProcedimentos(search?: string):  Promise<Omit<ProcedimentoInterface[], 'preco'>> {
    try {
        const response = await api.get('procedimentos', {
            params: { search }
        });
        return response.data;
    } catch (error: any) {
        const message = error.response?.data?.message || 'Erro ao buscar procedimentos. Tente novamente.';
        throw new Error(message);
    }
}

async function deleteProcedimento(id: number): Promise<void> {
    try {
        await api.delete(`procedimentos/${id}`);
    } catch (error: any) {
        const message = error.response?.data?.message || 'Erro ao excluir procedimento. Tente novamente.';
        throw new Error(message);
    }
}

async function createProcedimento(nome: string, especialidadeId: number): Promise<ProcedimentoInterface> {
    try {
        const response = await api.post('procedimentos', { nome, especialidade_id: especialidadeId });
        return response.data;
    } catch (error: any) {
        const message = error.response?.data?.message || 'Erro ao criar procedimento. Tente novamente.';
        throw new Error(message);
    }
}

async function editProcedimento(id: number, data: { nome?: string; especialidade_id?: number }): Promise<ProcedimentoInterface> {
    try {
        const response = await api.put(`procedimentos/${id}`, data);
        return response.data;
    } catch (error: any) {
        const message = error.response?.data?.message || 'Erro ao editar procedimento. Tente novamente.';
        throw new Error(message);
    }
}

export { getAllNotInClinica, getAllProcedimentos, deleteProcedimento, createProcedimento, editProcedimento };
