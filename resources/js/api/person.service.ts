import axios, {AxiosResponse} from 'axios';
import {PersonData} from "../types/interfaces";

/**
 * Function to save a new character
 * @param data
 */
export async function savePersonApi(data: PersonData): Promise<any> {
    const response: AxiosResponse<PersonData> = await axios.post('/api/people', data);

    return response.data;
}

/**
 * Function to update an existing character
 * @param id The ID of the person to update
 * @param data The updated data
 */
export async function updatePersonApi(id: number, data: PersonData): Promise<PersonData> {
    const response: AxiosResponse<PersonData> = await axios.put(`/api/people/${id}`, data);

    return response.data;
}
