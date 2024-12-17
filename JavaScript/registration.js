function registration_verification() {
    var usernameRegex = /^[a-zA-Z0-9_]+$/; // setting valid characters for username validation
    var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d!@#$%^&*()_+]{4,}$/; // corrected password regex

    // getting logon values from form
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var title = document.getElementById("title").value;
    var firstName = document.getElementById("first_name").value;
    var lastName = document.getElementById("last_name").value;
    var gender = document.getElementById("gender").value;
    var address1 = document.getElementById("adress1").value;
    var address2 = document.getElementById("adress2").value;
    var address3 = document.getElementById("adress3").value;
    var postcode = document.getElementById("postcode").value;
    var description = document.getElementById("description").value;
    var email = document.getElementById("email").value;
    var telephone = document.getElementById("telephone").value; 


    if (!usernameRegex.test(username)) {
        alert("Username can only contain letters, numbers, and underscores.");
        return false;
    }
    if (!passwordRegex.test(password)) { 
        alert("Password must contain at least one letter, number, special character, and uppercase letter.");
        return false;
    }
    
    // returning true if everything is valid
    alert("Title selected: " + title);
    return true; // Change to true to allow form submission if validation passes
}
