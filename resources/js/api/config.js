// API Configuration
const API_BASE_URL = '/api';

// Get token from localStorage
export const getToken = () => {
    return localStorage.getItem('auth_token');
};

// Set token to localStorage
export const setToken = (token) => {
    localStorage.setItem('auth_token', token);
};

// Remove token from localStorage
export const removeToken = () => {
    localStorage.removeItem('auth_token');
};

// Get user from localStorage
export const getUser = () => {
    const user = localStorage.getItem('user');
    return user ? JSON.parse(user) : null;
};

// Set user to localStorage
export const setUser = (user) => {
    localStorage.setItem('user', JSON.stringify(user));
};

// Remove user from localStorage
export const removeUser = () => {
    localStorage.removeItem('user');
};

// Check if user is authenticated
export const isAuthenticated = () => {
    return !!getToken();
};

// Check if user is admin
export const isAdmin = () => {
    const user = getUser();
    return user && user.role === 'admin';
};

// API request helper
export const apiRequest = async (endpoint, options = {}) => {
    const token = getToken();
    
    const config = {
        ...options,
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            ...(token && { 'Authorization': `Bearer ${token}` }),
            ...options.headers,
        },
    };

    try {
        const response = await fetch(`${API_BASE_URL}${endpoint}`, config);
        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Something went wrong');
        }

        return data;
    } catch (error) {
        console.error('API Error:', error);
        throw error;
    }
};

export default API_BASE_URL;
