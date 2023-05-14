// Reemplazar el horrible mensaje de html de "Alarga el texto a 8 caracteres"

document.addEventListener("DOMContentLoaded", function() {
    var passwordInput = document.getElementById("password-input");

    passwordInput.addEventListener("input", function() {
        var minLength = parseInt(passwordInput.getAttribute("minlength"));

        var passwordValue = passwordInput.value;
        var currentLength = passwordValue.length;
  
        if (currentLength < minLength) {
          passwordInput.setCustomValidity("La contraseña debe tener al menos " + minLength + " caracteres " + 
                                          "(actualmente está usando " + currentLength + " caracteres).");
        } 
        else {
          passwordInput.setCustomValidity("");
        }
    });
});
