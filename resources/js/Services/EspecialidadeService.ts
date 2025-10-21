import { EspecialidadeInterface } from "@/Interfaces/Especialidades/EspecialidadeInterface";
import api from "./api";

async function getAllEspecialidades():  Promise<Omit<EspecialidadeInterface[], 'preco'>> {
    try {
        const response = await api.get('especialidades');
        return response.data;
    } catch (error: any) {
        const message = error.response?.data?.message || 'Erro ao buscar especialidades. Tente novamente.';
        throw new Error(message);
    }
}

export { getAllEspecialidades };