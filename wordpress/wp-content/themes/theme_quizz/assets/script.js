document.getElementById('toggleToSignup').addEventListener('click', function() {
    document.getElementById('signupForm').style.display = 'block';
    document.getElementById('loginForm').style.display = 'none';
});


document.getElementById('toggleToLogin').addEventListener('click', function() {
    document.getElementById('signupForm').style.display = 'none';
    document.getElementById('loginForm').style.display = 'block';
});
