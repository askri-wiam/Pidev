function getRndv() {
if(document.getElementById("idInput").value.length<1 || isNaN(document.getElementById("idInput").value)) {
    document.getElementById("errorMessage").innerHTML = "ID non valid";
    document.getElementById("errorMessage").style.display = "inherit";
    document.getElementById("idInput").value ="";
} else {
    id = document.getElementById("idInput").value;
    document.getElementById("idInput").value="";
    $.post("/findUserBy/"+id, function(data) {
        if(data === "0") {
            document.getElementById("errorMessage").innerHTML = "ID non valid";
            document.getElementById("errorMessage").style.display = "inherit";
        } else {
            window.location.replace("/rendezvous/"+id);
        }
    })
}
}

function exportCSV(id) {
    document.getElementById('exportButton').disabled = true;
    $.ajax({
        url:"/expoerCSV/"+id,
        success: function(file) {
            let filename = 'rendez-vous.csv';
            let csvFile = new Blob([file], {type: "text/csv"});
            let downloadLink = document.createElement("a");
            downloadLink.download = filename;
            downloadLink.href = window.URL.createObjectURL(csvFile);
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.getElementById('exportButton').disabled = false;
      }})
}