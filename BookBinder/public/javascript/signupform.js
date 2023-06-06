const username_element = document.getElementById('sign_up_form_username')
const message_element = document.getElementById('message_check')
const submit_button = document.getElementById('sign_up_form_submit')

username_element.addEventListener('change', updateMessage)

function updateMessage(event) {
    message_element.innerHTML = ""
    if (username_element.value.length === 0) return
    /* set hardcoded baseURL variable */
    //let baseURL = 'http://localhost:8080/'

    /* use regular expression to extract baseURL from document.URL
     * ref: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Regular_Expressions */
    const re = new RegExp('https?:\/\/[a-zA-Z\.\-_]+(:[0-9]+)?\/');
    let resultMatch = document.URL.match(re)
    let baseURL = resultMatch[0]

    let data = new FormData()
    data.append('sign_up_form_username', username_element.value)
    /* use baseURL variable to dynamically construct URL */
    fetch(`${baseURL}api/check_user`,{method:'post',body:data})
        .then((response) => {
            if (response.status === 404) {
                message_element.innerHTML = "Username already exist";
                message_element.style.color = "red";
                submit_button.disabled = true;
                submit_button.style.background = '#808080';
            }
            if (response.status === 400) {
                message_element.innerHTML = "This field is required";
                message_element.style.color = "red";
                submit_button.disabled = true;
                submit_button.style.background = '#808080';
            }
            if (response.status === 200){
                message_element.innerHTML = "Username can be used";
                message_element.style.color = 'green';
                submit_button.disabled = false;
                submit_button.style.background = '#8670F7';
            }
        })
}


