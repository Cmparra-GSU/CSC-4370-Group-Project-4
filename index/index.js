function openModal() {
    closeAllModals();
    var modal = document.getElementById('signup-modal');
    if (modal) modal.style.display = 'block';
}

function closeModal() {
    var modal = document.getElementById('signup-modal');
    if (modal) modal.style.display = 'none';
}

function openLoginModal() {
    closeAllModals();
    var modal = document.getElementById('login-modal');
    if (modal) modal.style.display = 'block';
}

function closeLoginModal() {
    var modal = document.getElementById('login-modal');
    if (modal) modal.style.display = 'none';
}

function closeAllModals() {
    // Select all elements with the class 'modal'
    var modals = document.querySelectorAll('.modal');

    // Loop through the NodeList and set display to 'none' for each modal
    modals.forEach(function(modal) {
        modal.style.display = 'none';
    });
}

var isEmailValid = false;

function checkEmail() {
    
    var email = document.getElementById('email').value.trim().toLowerCase();
    var emailStatus = document.getElementById('emailStatus');
    var regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

    if (!regex.test(email)) {
        emailStatus.innerHTML = "Invalid email format";
        isEmailValid = false;
        validateForm();
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'check_email.php?email=' + encodeURIComponent(email), true);
    xhr.onload = function() {
        var responseText = xhr.responseText.trim(); // Trim the response text
        console.log('Server response:', responseText); // Log the trimmed response

        if (xhr.status === 200) {
            if(responseText === "Email is already in use") {
                emailStatus.innerHTML = "Email is already in use";
                isEmailValid = false;
            } else if (responseText === "Email available") {
                emailStatus.innerHTML = "Email available";
                isEmailValid = true;
            } else {
                console.error("Unexpected response:", responseText);
                emailStatus.innerHTML = ""; // Clear or set to a default message
                isEmailValid = false;
            }
        }

        validateForm();
    };
    xhr.onerror = function() {
        console.error("Request failed");
        emailStatus.innerHTML = "Error in email validation"; // Display an error message
        isEmailValid = false;
        validateForm();
    };
    xhr.send();
}


function validateForm() {
    var isFormValid = isEmailValid;
    document.getElementById('signup-button').disabled = !isFormValid;
}




window.onclick = function (event) {
    var signupModal = document.getElementById('signup-modal');
    var loginModal = document.getElementById('login-modal');

    if (event.target == signupModal) {
        signupModal.style.display = 'none';
    }

    if (event.target == loginModal) {
        loginModal.style.display = 'none';
    }
};
