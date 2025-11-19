// Format date to readable format
export const formatDate = (dateString) => {
    if (!dateString) return '-';
    
    const date = new Date(dateString);
    const options = { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    
    return date.toLocaleDateString('id-ID', options);
};

// Truncate text
export const truncate = (text, length = 100) => {
    if (!text) return '';
    if (text.length <= length) return text;
    return text.substring(0, length) + '...';
};

// Show toast notification
export const showToast = (message, type = 'success') => {
    // You can use any toast library here (e.g., Toastify, SweetAlert2)
    // For now, we'll use a simple alert
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6'};
        color: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        z-index: 9999;
        animation: slideIn 0.3s ease-out;
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
};

// Show loading spinner
export const showLoading = (element) => {
    if (!element) return;
    element.innerHTML = `
        <div class="loading-spinner">
            <div class="spinner"></div>
            <p>Loading...</p>
        </div>
    `;
};

// Hide loading spinner
export const hideLoading = (element) => {
    if (!element) return;
    const spinner = element.querySelector('.loading-spinner');
    if (spinner) spinner.remove();
};

// Validate form
export const validateForm = (formData, rules) => {
    const errors = {};
    
    for (const [field, rule] of Object.entries(rules)) {
        const value = formData[field];
        
        if (rule.required && !value) {
            errors[field] = `${field} is required`;
        }
        
        if (rule.minLength && value && value.length < rule.minLength) {
            errors[field] = `${field} must be at least ${rule.minLength} characters`;
        }
        
        if (rule.maxLength && value && value.length > rule.maxLength) {
            errors[field] = `${field} must not exceed ${rule.maxLength} characters`;
        }
        
        if (rule.email && value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
            errors[field] = `${field} must be a valid email`;
        }
    }
    
    return {
        isValid: Object.keys(errors).length === 0,
        errors
    };
};

// Get status badge class
export const getStatusBadge = (status) => {
    const badges = {
        published: 'badge-success',
        draft: 'badge-warning',
        archived: 'badge-secondary'
    };
    return badges[status] || 'badge-default';
};

// Debounce function
export const debounce = (func, wait) => {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
};
