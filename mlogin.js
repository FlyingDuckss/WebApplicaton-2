/*
    Author: Muhammad Osama Nadeem 
    Roll Number: 104659862
    Validating manager login params
   */


document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById("loginForm");

    loginForm.addEventListener("submit", function (event) {
        const managerId = document.getElementById("managerId").value.trim();
        const password = document.getElementById("password").value.trim();

        if (managerId === "" || password === "") {
            alert("Please fill in both the Manager ID and Password.");
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });
});
