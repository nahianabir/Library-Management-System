function updateRequest(id, status) {

    let xhr = new XMLHttpRequest();

    xhr.open("POST", "../ajax/update_request.php", true );

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function() {

        if(this.status == 200) {

            document.getElementById("status_" + id ).innerHTML = status;
        }
    }

    xhr.send("id=" + id +"&status=" + status); 
}