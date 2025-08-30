import { CreatePacienteInterface } from '@/Interfaces/Pacientes/CreatePacienteInterface';
import { PacienteInterface } from '@/Interfaces/Pacientes/PacienteInterface';
import api from './api';

async function createPaciente(paciente: CreatePacienteInterface): Promise<PacienteInterface> {
    try {
        const response = await api.post('/pacientes', paciente);
        return response.data;
    } catch (error: any) {
        const message = error.response?.data?.message || 'Erro ao criar paciente. Tente novamente.';
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

export { createPaciente, deletePaciente };
