export function togglePassword() {
    const input = document.querySelector('#password');
    input.type = input.type === 'password' ? 'text' : 'password';
}