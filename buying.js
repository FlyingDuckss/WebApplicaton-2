/*
    Author: Muhammad Osama Nadeem 
    Roll Number: 104659862
    helper functions for buying.htm
   */
document.addEventListener("DOMContentLoaded", function() {
    const xhr = new XMLHttpRequest();
function fetchItems() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'fetch_items.php', true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById('itemList').innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }

    const cart = [];
    const cartItemsContainer = document.getElementById('cartItems');
    const cartTotalDisplay = document.getElementById('cartTotal');


    fetchItems();
    setInterval(fetchItems, 10000);
    window.addToCart = function(itemNumber, itemName, quantity, price) {
        
    
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_hold.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            console.log('Response:', xhr.responseText);  // Log the raw response

            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        console.log('Quantity on hold updated successfully');
                        const itemIndex = cart.findIndex(item => item.itemNumber === itemNumber);
                        if (itemIndex !== -1) {
                            cart[itemIndex].quantity += 1;  
                        } else {
                            cart.push({ itemNumber, itemName, quantity: 1, price });
                        }
                        renderCart();
                    } else {
                        alert(response.message);  
                    }
                } catch (e) {
                    console.error('Failed to parse JSON:', e);
                }
            } else {
                console.error('Error: HTTP status', xhr.status);
            }
        }
    };
    xhr.send(`itemNumber=${itemNumber}`);
    };

    // Logout functionality
window.logout = function() {
    if (cart.length > 0) {
        cart.forEach(item => {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'removed_hold.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        console.log(`Item ${item.itemName} updated successfully on the server.`);
                        if (cart.indexOf(item) === cart.length - 1) {
                            completeLogout(); 
                        }
                    } else {
                        console.log('Error during item removal: ' + response.message);
                    }
                }
            };
            xhr.send(`itemNumber=${item.itemNumber}&quantity=${item.quantity}`);
        });
    } else {
        completeLogout();
    }
};
    

window.removeFromCart = function(itemNumber) {
    const itemIndex = cart.findIndex(item => item.itemNumber === itemNumber);
    
    if (itemIndex !== -1) {
        if (cart[itemIndex].quantity > 1) {
            cart[itemIndex].quantity -= 1;
        } else {
            cart.splice(itemIndex, 1);
        }
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'removed_hold.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    console.log('Server-side quantity updated successfully');
                } else {
                    console.log('Error: ' + response.message);
                }
            }
        };
        xhr.send(`itemNumber=${itemNumber}`);
        renderCart();
    }
};


    function renderCart() {
        cartItemsContainer.innerHTML = '';
        let totalAmount = 0;

        cart.forEach(item => {
            const itemTotal = item.quantity * item.price;
            totalAmount += itemTotal;
            cartItemsContainer.innerHTML += `
                <tr>
                    <td>${item.itemNumber}</td>
                    <td>${item.itemName}</td>
                    <td>${item.quantity}</td>
                    <td>$${item.price}</td>
                    <td>$${itemTotal.toFixed(2)}</td>
                    <td><button onclick="removeFromCart('${item.itemNumber}')">Remove</button></td>
                </tr>
            `;
        });

        cartTotalDisplay.textContent = `Total Amount: $${totalAmount.toFixed(2)}`;
    }

    window.confirmPurchase = function() {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'confirm_purchase.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    const totalAmountDue = response.totalAmountDue;
                    alert(`Your purchase has been confirmed and the total amount due is $${totalAmountDue.toFixed(2)}`);
                    cart.length = 0;
                    renderCart();
                } else {
                    alert('Error: ' + response.message);
                }
            }
        };
        
        xhr.send(`cart=${JSON.stringify(cart)}`);
    };

    window.cancelPurchase = function() {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'cancel_purchase.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    alert('Your purchase request has been cancelled, welcome to shop next time.');
                    cart.length = 0; 
                    renderCart();
                } else {
                    alert('Error: ' + response.message);
                }
            }
        };
        
        xhr.send(`cart=${JSON.stringify(cart)}`);
    };
});

function completeLogout() {
    const customerId = localStorage.getItem('customerId'); 
    const logoutUrl = `logout.htm?customerId=${customerId}`;
    window.location.href = logoutUrl;
}

