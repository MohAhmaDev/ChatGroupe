



function save_ip() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "server/get_adress_Ip.php?ip");

    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) 
        {
            let result = xhr.responseText;
            console.log(xhr);
        }
    }

}
save_ip();
