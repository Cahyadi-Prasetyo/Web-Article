import { apiRequest } from './config.js';

// Get all published articles (public)
export const getArticles = async (params = {}) => {
    const queryString = new URLSearchParams(params).toString();
    const endpoint = `/articles${queryString ? `?${queryString}` : ''}`;
    return await apiRequest(endpoint);
};

// Get single article by slug (public)
export const getArticle = async (slug) => {
    return await apiRequest(`/articles/${slug}`);
};

// Get all articles for admin (includes drafts and archived)
export const getAdminArticles = async (params = {}) => {
    const queryString = new URLSearchParams(params).toString();
    const endpoint = `/admin/articles${queryString ? `?${queryString}` : ''}`;
    return await apiRequest(endpoint);
};

// Create new article (admin only)
export const createArticle = async (articleData) => {
    return await apiRequest('/articles', {
        method: 'POST',
        body: JSON.stringify(articleData),
    });
};

// Update article (admin only)
export const updateArticle = async (id, articleData) => {
    return await apiRequest(`/articles/${id}`, {
        method: 'PUT',
        body: JSON.stringify(articleData),
    });
};

// Delete article (admin only)
export const deleteArticle = async (id) => {
    return await apiRequest(`/articles/${id}`, {
        method: 'DELETE',
    });
};
