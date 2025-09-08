import { ClinicaInterface } from '@/Interfaces/Clinicas/ClinicaInterface';
import { SearchClinicaInterface } from '@/Interfaces/Clinicas/SearchClinicaInterface';
import { PacienteInterface } from '@/Interfaces/Pacientes/PacienteInterface';
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

async function createPaciente(paciente: PacienteInterface): Promise<PacienteInterface> {
    try {
        const response = await api.post('/pacientes', paciente);
        return response.data;
    } catch (error: any) {
        const message = error.response?.data?.message || 'Erro ao criar paciente. Tente novamente.';
        throw new Error(message);
    }
}

async function editarPaciente(paciente: PacienteInterface): Promise<PacienteInterface> {
    try {
        const response = await api.put(`/pacientes/editar/${paciente.id}`, paciente);
        return response.data;
    } catch (error: any) {
        const message = error.response?.data?.message || 'Erro ao editar paciente. Tente novamente.';
        throw new Error(message);
    }
}

async function deletePaciente(id: number): Promise<void> {
    try {
        await api.delete(`/pacientes/delete/${id}`);
    } catch (error: any) {
        const message = error.response?.data?.message || 'Erro ao deletar paciente. Tente novamente.';
        throw new Error(message);
    }
}

export { createPaciente, deletePaciente, editarPaciente, getAllClinicas };
