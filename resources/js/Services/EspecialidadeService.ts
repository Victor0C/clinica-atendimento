import { EspecialidadeInterface } from "@/Interfaces/Especialidades/EspecialidadeInterface";
import api from "./api";

async function getAllEspecialidades(search=''):  Promise<EspecialidadeInterface[]> {
    try {
        const response = await api.get('especialidades', {
            params: {
                search
            }
        });
        return response.data;
    } catch (error: any) {
        const message = error.response?.data?.message || 'Erro ao buscar especialidades. Tente novamente.';
        throw new Error(message);
    }
}

async function createEspecialidade(
    payload: Omit<EspecialidadeInterface, 'id'>
): Promise<EspecialidadeInterface> {
    try {
        const response = await api.post('especialidades', payload);
        return response.data;
    } catch (error: any) {
        const message = error.response?.data?.message || 'Erro ao criar especialidade. Tente novamente.';
        throw new Error(message);
    }
}

async function updateEspecialidade(
    id: number,
    payload: Partial<EspecialidadeInterface>
): Promise<EspecialidadeInterface> {
    try {
        const response = await api.put(`especialidades/${id}`, payload);
        return response.data;
    } catch (error: any) {
        const message = error.response?.data?.message || 'Erro ao atualizar especialidade. Tente novamente.';
        throw new Error(message);
    }
}

async function deleteEspecialidade(id: number): Promise<void> {
    try {
        await api.delete(`especialidades/${id}`);
    } catch (error: any) {
        const message = error.response?.data?.message || 'Erro ao deletar especialidade. Tente novamente.';
        throw new Error(message);
    }
}
export { getAllEspecialidades, updateEspecialidade, deleteEspecialidade, createEspecialidade };