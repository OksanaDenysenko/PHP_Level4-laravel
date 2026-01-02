import axios, {AxiosResponse} from 'axios';
import {PersonCore, PersonFull} from "../types/interfaces";

/**
 * Function to save a new character
 * @param data
 */
export async function savePersonApi(data: PersonCore): Promise<any> {
    const response: AxiosResponse<PersonFull> = await axios.post('/api/people', data);

    return response.data;
}

/**
 * Function to update an existing character
 * @param id The ID of the person to update
 * @param data The updated data
 */
export async function updatePersonApi(id: number, data: PersonCore): Promise<PersonFull> {
    const response: AxiosResponse<PersonFull> = await axios.put(`/api/people/${id}`, data);

    return response.data;
}
