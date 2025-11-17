// Function to toggle between forms
function toggleForm(formId) {
    const forms = ['login-form', 'signup-form', 'password-reset-form'];
    forms.forEach(id => {
        const form = document.getElementById(id);
        if (form) {
            form.style.display = formId === id ? 'block' : 'none';
        }
    });
}

// Event listener for toggling password visibility in login form
document.getElementById('login-show-password').addEventListener('change', (e) => {
    const passwordInput = document.querySelector('#login-form input[name="password"]');
    passwordInput.type = e.target.checked ? 'text' : 'password';
});

// Ensure other parts of the script only run if the respective elements are present

document.getElementById('show-signup')?.addEventListener('click', (e) => {
    e.preventDefault();
    toggleForm('signup-form');
});

document.getElementById('show-login')?.addEventListener('click', (e) => {
    e.preventDefault();
    toggleForm('login-form');
});

// Event listener for toggling password visibility in signup form
document.getElementById('signup-show-password')?.addEventListener('change', (e) => {
    const passwordInput = document.querySelector('#signup-form input[name="password"]');
    passwordInput.type = e.target.checked ? 'text' : 'password';
});

// Event listener for toggling password visibility in reset password form
document.getElementById('reset-show-password')?.addEventListener('change', (e) => {
    const passwordInput = document.querySelector('#password-reset-form input[name="password"]');
    passwordInput.type = e.target.checked ? 'text' : 'password';
});

// Event listener for opening the password reset form
document.getElementById('forgot-password')?.addEventListener('click', (e) => {
    e.preventDefault();
    toggleForm('password-reset-form');
});

// Event listener for canceling the password reset process
document.getElementById('cancel-reset')?.addEventListener('click', (e) => {
    e.preventDefault();
    toggleForm('login-form');
});
