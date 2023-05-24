const usernameElement = document.getElementById('sign_up_form_username')
const messageElement = document.getElementById('message_check')
const submitButton = document.getElementById('sign_up_form_submit')

usernameElement.addEventListener('change', updateMessage)

function updateMessage(event) {
    messageElement.innerHTML = ""
    if (usernameElement.value.length === 0) return
    /* set hardcoded baseURL variable */
    //let baseURL = 'http://localhost:8080/'

    /* use regular expression to extract baseURL from document.URL
     * ref: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Regular_Expressions */
    const re = new RegExp('https?:\/\/[a-zA-Z\.\-_]+(:[0-9]+)?\/');
    let resultMatch = document.URL.match(re)
    let baseURL = resultMatch[0]

    let data = new FormData()
    data.append('sign_up_form_username', usernameElement.value)
    /* use baseURL variable to dynamically construct URL */
    fetch(`${baseURL}api/check_user`,{method:'post',body:data})
        .then((response) => {
            if (response.status === 404) {
                messageElement.innerHTML = "Username already exist";
                submitButton.disabled = true;
                submitButton.style.background = '#808080';
            }
            if (response.status === 400) {
                messageElement.innerHTML = "This field is required";
                submitButton.disabled = true;
                submitButton.style.background = '#808080';
            }
            if (response.status === 200){
                submitButton.disabled = false;
                submitButton.style.background = '#8670F7';
            }
        })
}
