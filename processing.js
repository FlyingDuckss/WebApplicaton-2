/*
    Author: Muhammad Osama Nadeem 
    Roll Number: 104659862
    Functions to assist the process button hit
   */
document.addEventListener("DOMContentLoaded", function() {
    const processButton = document.getElementById("processSoldItemsButton");
    const managerId = localStorage.getItem('managerId');
    if (managerId) {
        document.getElementById('managerInfo').textContent = "Manager ID: " + managerId;
    } else {
        window.location.href = 'mlogin.htm';
    }
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'processing_data.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById('soldItemsTable').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
    processButton.addEventListener("click", function() {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'processing_process.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert('Sold items processed successfully!');
                location.reload();
            }
        };

        xhr.send();
    });
    
    logoutButton.addEventListener("click", function(e) {
        e.preventDefault();
        const logoutUrl = `logout.htm?managerId=${encodeURIComponent(managerId)}`;
        window.location.href = logoutUrl;
    });
});
