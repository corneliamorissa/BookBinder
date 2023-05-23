function fetch_details(isbn){
    const xhttp = new XMLHttpRequest();
    //What happens when we receive the answer (json)
    xhttp.onload=function (){
        const bookData = JSON.parse(this.responseText);
        const isbnKey = 'ISBN:' + isbn;
        if (bookData[isbnKey]) {
            getCover(bookData[isbnKey]);
            getTitle(bookData[isbnKey]);
            getAuthor(bookData[isbnKey]);
            /*getDetails(bookData[isbnKey])*/
        } else {
            console.log('Cover image not found.');
        }
    };
    //create and send the request
    xhttp.open("GET", `https://openlibrary.org/api/books?bibkeys=ISBN:${isbn}&jscmd=data&format=json`, true);
    xhttp.send();
}

function getCover(bookdata){
    const coverImageUrl = bookdata.cover.large;
    /*console.log(coverImageUrl);*/
    document.getElementById('BookPic').src = coverImageUrl;
}

function getTitle(bookdata){
    const title = bookdata.title;
    document.getElementById('BookTitle').textContent = title;
}

function getAuthor(bookdata){
    const authors = bookdata.authors;
    const authorName = authors[0].name;
    /*console.log(authorName);*/
    document.getElementById('BookAuthor').textContent ='Author: ' + authorName;
}

/*function getDetails(bookdata){
    const excerpts = bookdata.excerpts;
    if (Array.isArray(excerpts) && excerpts.length > 0) {
        const text = excerpts[0].text;
        console.log(text);
    } else {
        console.log("Excerpts not found or empty.");
    }
}*/
