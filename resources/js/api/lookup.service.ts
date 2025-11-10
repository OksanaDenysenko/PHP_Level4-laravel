import axios, {AxiosResponse} from 'axios';
import {FormOptions} from "../types/interfaces";

type LookupKey = keyof Omit<FormOptions, 'genders'>;

/**
 * Function fetches the lookup data (options) for the given key from the API
 * @param key The lookup type ('planets', 'films', etc.)
 */
export async function fetchLookupApi<K extends LookupKey>(key: K): Promise<FormOptions[K]> {
    const response: AxiosResponse<FormOptions[K]> = await axios.get(`/api/${key}`);

    return response.data;
}
