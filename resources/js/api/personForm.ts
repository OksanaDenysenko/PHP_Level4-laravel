import axios, {AxiosResponse} from 'axios';

interface FormOptions {
    planets: Array<{ id: number, name: string }>;
    species: Array<{ id: number, name: string }>;
    films: Array<{ id: number, name: string }>;
    vehicles: Array<{ id: number, name: string }>;
    starships: Array<{ id: number, name: string }>;
    genders: string[];
}

interface PersonData {
    name: string;
    height: number | null;
    mass: number | null;
    hair_color: string;
    skin_color: string;
    eye_color: string;
    birth_year: string;
    gender: string;
    planet_id: number | null;
    species_id: number | null;
    film_ids: number[];
    vehicle_ids: number[];
    starship_ids: number[];
}

type LookupKey = keyof Omit<FormOptions, 'genders'>;

/**
 * Function fetches the lookup data (options) for the given key from the API
 * @param key The lookup type ('planets', 'films', etc.)
 */
export async function fetchLookupApi<K extends LookupKey>(key: K): Promise<FormOptions[K]> {
    const response: AxiosResponse<FormOptions[K]> = await axios.get(`/api/lookups/${key}`);

    return response.data;
}

/**
 * Function to save a new character
 * @param data
 */
export async function savePersonApi(data: PersonData): Promise<any> {
    const response = await axios.post('/api/people', data);

    return response.data;
}
