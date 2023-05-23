function fetch_details(isbn){
    const xhttp = new XMLHttpRequest();
    //What happens when we receive the answer (json)
    xhttp.onload=function (){
        const bookData = JSON.parse(this.responseText);
        const isbnKey = 'ISBN:' + isbn;
        getCover(bookData[isbnKey]);
        getTitle(bookData[isbnKey]);
        getAuthor(bookData[isbnKey]);
    };
    //create and send the request
    xhttp.open("GET", `https://openlibrary.org/api/books?bibkeys=ISBN:${isbn}&jscmd=data&format=json`, true);
    xhttp.send();
}

function getCover(bookdata){
    if(bookdata){
        document.getElementById('BookPic').src = bookdata.cover.large;
    }else{
        document.getElementById('BookPic').src = '/assets/no_cover.jpg';
    }
}

function getTitle(bookdata){
    if(bookdata){
        document.getElementById('BookTitle').textContent = bookdata.title;
    }else{
        document.getElementById('BookTitle').textContent = 'An error occurred. Try to load the page again.';
    }
}

function getAuthor(bookdata){
    if(bookdata){
        const authors = bookdata.authors;
        const authorName = authors[0].name;
        /*console.log(authorName);*/
        document.getElementById('BookAuthor').textContent ='Author: ' + authorName;
    }else {
        document.getElementById('BookAuthor').textContent = 'An error occurred. Try to load the page again.';
    }
}

