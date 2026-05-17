// Admin JS Functions

function confirmDelete(id) {
    if (confirm("Are you sure you want to delete this record?")) {
        return true;
    }
    return false;
}

function toggleStatus(id, type) {
    if (confirm("Toggle status?")) {
        window.location.href = "controller/" + type + "Controller.php?action=toggleStatus&id=" + id;
    }
}

function showAlert(message, type) {
    const alertDiv = document.createElement("div");
    alertDiv.className = "alert alert-" + type;
    alertDiv.textContent = message;
    document.body.insertBefore(alertDiv, document.body.firstChild);
    setTimeout(function() {
        alertDiv.remove();
    }, 5000);
}

function searchTable(inputId, tableId) {
    const input = document.getElementById(inputId);
    const table = document.getElementById(tableId);
    const rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName("td");
        let match = false;

        for (let j = 0; j < cells.length; j++) {
            if (cells[j].textContent.toLowerCase().includes(input.value.toLowerCase())) {
                match = true;
                break;
            }
        }

        rows[i].style.display = match ? "" : "none";
    }
}

function formatDate(date) {
    const d = new Date(date);
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const day = String(d.getDate()).padStart(2, '0');
    const year = d.getFullYear();
    return `${year}-${month}-${day}`;
}

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function validatePhone(phone) {
    const re = /^[0-9]{10,}$/;
    return re.test(phone);
}

function sortTable(columnIndex, tableId) {
    const table = document.getElementById(tableId);
    const rows = Array.from(table.getElementsByTagName("tr")).slice(1);
    
    rows.sort((a, b) => {
        const aValue = a.cells[columnIndex].textContent;
        const bValue = b.cells[columnIndex].textContent;
        return aValue.localeCompare(bValue);
    });

    rows.forEach(row => table.appendChild(row));
}

document.addEventListener("DOMContentLoaded", function() {
    // Add any initialization code here
});
