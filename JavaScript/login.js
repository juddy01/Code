function login_verification() {
    var usernameRegex = /^[a-zA-Z0-9_]+$/; //setting valid characters for username validation
    // getting logon values from form
    var username = document.getElementById("txtUserName").value; 
    var password = document.getElementById("txtPWD").value; 

    if (!usernameRegex.test(username)) {
        alert("Username can only contain letters, numbers, and underscores.");
        return false;
    }
    if (username.length<3){
        alert("Username must atleast 3 characters");
        return false; // Prevent form submission
    }
    if (password.length<8){
        alert("Password must be atleast 8 characters");
        return false; // Prevent form submission
    }
    else{
        return true
    }
}