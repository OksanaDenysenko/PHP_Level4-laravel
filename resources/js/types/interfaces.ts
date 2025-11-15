export interface LookupItem {
    id: number;
    name: string;
}

export interface FormOptions {
    planets: LookupItem[];
    species: LookupItem[];
    films: LookupItem[];
    vehicles: LookupItem[];
    starships: LookupItem[];
    genders: string[];
}

export interface PersonData {
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

export interface SavedEvent {
    type: 'created' | 'updated';
    data: PersonData;
}

export interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

export interface PaginatedResponse<T> {
    current_page: number;
    data: T[];
    total: number;
    last_page: number;
    per_page: number;
    from: number | null;
    to: number | null;
    prev_page_url: string | null;
    next_page_url: string | null;
    path: string;
    links: PaginationLink[];
}
