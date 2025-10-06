import { ClinicaInterface } from '@/Interfaces/Clinicas/ClinicaInterface';
import { SearchClinicaInterface } from '@/Interfaces/Clinicas/SearchClinicaInterface';
import api from './api';

async function getAllClinicas(search: SearchClinicaInterface): Promise<ClinicaInterface[]> {
    try {
        const response = await api.get('/clinicas', {
            params: {
                ...search,
            },
        });

        return response.data;
    } catch (error: any) {
        const message = error.response?.data?.message || 'Erro ao buscar clinicas. Tente novamente.';
        throw new Error(message);
    }
}

async function createClinica(clinica: Omit<ClinicaInterface, 'procedimentos'>): Promise<ClinicaInterface> {
    try {
        const response = await api.post('/clinicas', clinica);
        return response.data;
    } catch (error: any) {
        const message = error.response?.data?.message || 'Erro ao criar clinica. Tente novamente.';
        throw new Error(message);
    }
}

async function editarClinica(clinica: Omit<ClinicaInterface, 'procedimentos'>): Promise<ClinicaInterface> {
    try {
        const response = await api.put(`/clinicas/editar/${clinica.id}`, clinica);
        return response.data;
    } catch (error: any) {
        const message = error.response?.data?.message || 'Erro ao editar clinica. Tente novamente.';
        throw new Error(message);
    }
}

async function deleteClinica(id: number): Promise<void> {
    try {
        await api.delete(`/clinicas/delete/${id}`);
    } catch (error: any) {
        const message = error.response?.data?.message || 'Erro ao deletar clinica. Tente novamente.';
        throw new Error(message);
    }
}


async function addProcedimento(id: number, procedimentId: number, preco: number): Promise<ClinicaInterface> {
    try {
        const response = await api.post(`clinicas/${id}/procedimentos/${procedimentId}`, {
            preco
        });
        return response.data;
    } catch (error: any) {
        const message = error.response?.data?.message || 'Erro ao adicionar procedimento. Tente novamente.';
        throw new Error(message);
    }
}

export { createClinica, deleteClinica, editarClinica, getAllClinicas, addProcedimento};
