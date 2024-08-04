function validatePassword() {
    var password = document.getElementById("password").value;
    var minLength = 8;
    var uppercasePattern = /[A-Z]/;
    var specialCharPattern = /[!@#$%^&*(),.?":{}|<>]/;

    if (password.length < minLength) {
        alert('Minimum 8 characters required.');
        return false;
    }
    if (!uppercasePattern.test(password)) {
        alert('Password must contain at least one uppercase letter.');
        return false;
    }
    if (!specialCharPattern.test(password)) {
        alert('Password must contain at least one special character.');
        return false;
    }
    return true;
}

function validateForm() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirm_password").value;

    if (!validatePassword()) {
        return false;
    }
    if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return false;
    }
    return true;
}