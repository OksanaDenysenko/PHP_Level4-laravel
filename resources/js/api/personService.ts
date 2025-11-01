import axios, {AxiosResponse} from 'axios';
import {FormOptions, PersonData} from "../types/interfaces";

type LookupKey = keyof Omit<FormOptions, 'genders'>;

/**
 * Function fetches the lookup data (options) for the given key from the API
 * @param key The lookup type ('planets', 'films', etc.)
 */
export async function fetchLookupApi<K extends LookupKey>(key: K): Promise<FormOptions[K]> {
    const response: AxiosResponse<FormOptions[K]> = await axios.get(`/api/${key}`);

    return response.data;
}

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
