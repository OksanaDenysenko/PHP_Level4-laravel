import axios from 'axios';

/**
 * The function sends a request to the API to get a paginated list of people.
 * @param {number} page page number.
 * @returns {Promise<object>}
 */
export async function getPeopleApi(page) {
    const response = await axios.get(`/people?page=${page}`, {
        headers: {'X-Requested-With': 'XMLHttpRequest'}
    });

    return response.data;
}
