import { apiRequest, setToken, setUser, removeToken, removeUser } from './config.js';

// Register new user
export const register = async (userData) => {
    const data = await apiRequest('/register', {
        method: 'POST',
        body: JSON.stringify(userData),
    });

    if (data.access_token) {
        setToken(data.access_token);
        setUser(data.user);
    }

    return data;
};

// Login user
export const login = async (credentials) => {
    const data = await apiRequest('/login', {
        method: 'POST',
        body: JSON.stringify(credentials),
    });

    if (data.access_token) {
        setToken(data.access_token);
        setUser(data.user);
    }

    return data;
};

// Logout user
export const logout = async () => {
    try {
        await apiRequest('/logout', {
            method: 'POST',
        });
    } finally {
        removeToken();
        removeUser();
    }
};

// Get current user
export const getCurrentUser = async () => {
    const data = await apiRequest('/me');
    if (data.user) {
        setUser(data.user);
    }
    return data;
};
