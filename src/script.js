const btn = document.getElementById('btn')

btn.addEventListener('click', (e) => {
    const city = document.getElementById('input').value
    let getCityInfo = sendData(city)
    getCityInfo.then(function(result) {
        displayResult(result)
    }); 
})


function sendData(city) {
    const promise = new Promise((resolve, reject) => {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        console.log(this);
        if (this.readyState == 4 && this.status == 200) {
            resolve (this.responseText);
        }
        }
    
        xhttp.open("POST", "cityInfo.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`search=${city}`);
    });
    return promise
};



function displayResult(result) {
   data = JSON.parse(result)
   infoContainer = document.getElementById('cityInfo') 
   console.log(typeof data)
   for(let i = 0; i < data.length; i++) {
    let p = document.createElement('p')
    p.innerHTML = item
    console.log(p)
    infoContainer.appendChild(p)
   }
};
