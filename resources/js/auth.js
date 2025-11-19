// Auth Helper Functions
export function getToken() {
    return localStorage.getItem('auth_token');
}

export function getUser() {
    const user = localStorage.getItem('user');
    return user ? JSON.parse(user) : null;
}

export function isAuthenticated() {
    return !!getToken();
}

export function isAdmin() {
    const user = getUser();
    return user && user.role === 'admin';
}

export function isUser() {
    const user = getUser();
    return user && user.role === 'user';
}

export function logout() {
    localStorage.removeItem('auth_token');
    localStorage.removeItem('user');
    window.location.href = '/login';
}

export function checkAuth() {
    if (!isAuthenticated()) {
        window.location.href = '/login';
        return false;
    }
    return true;
}

// Fetch with auth token
export async function fetchWithAuth(url, options = {}) {
    const token = getToken();
    
    const headers = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        ...options.headers
    };
    
    if (token) {
        headers['Authorization'] = `Bearer ${token}`;
    }
    
    const response = await fetch(url, {
        ...options,
        headers
    });
    
    // If unauthorized, redirect to login
    if (response.status === 401) {
        logout();
        return null;
    }
    
    return response;
}
