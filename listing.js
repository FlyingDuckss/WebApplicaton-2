/*
    Author: Muhammad Osama Nadeem 
    Roll Number: 104659862

    helper functions for listing.htm
   */
document.addEventListener("DOMContentLoaded", function () {
    const listingForm = document.getElementById("listingForm");
    const logoutButton = document.getElementById("logoutButton");
    
    const managerId = localStorage.getItem('managerId');

    listingForm.addEventListener("submit", function (event) {
        const itemName = document.getElementById("itemName").value.trim();
        const unitPrice = parseFloat(document.getElementById("unitPrice").value);
        const quantityAvailable = parseInt(document.getElementById("quantityAvailable").value);

        if (itemName === "" || isNaN(unitPrice) || unitPrice <= 0 || isNaN(quantityAvailable) || quantityAvailable <= 0) {
            alert("Please fill in all fields correctly.");
            event.preventDefault();
        }
    });

        logoutButton.addEventListener("click", function(e) {
        e.preventDefault();
        const logoutUrl = `logout.htm?managerId=${encodeURIComponent(managerId)}`;
        window.location.href = logoutUrl;
    });
});
