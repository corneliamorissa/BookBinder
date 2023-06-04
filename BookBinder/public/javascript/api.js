// JavaScript code to fetch and update the book cover image
const book_images = document.getElementsByClassName('rounded-3 w-50 book-image');

Array.from(book_images).forEach((image) => {
    const isbn = image.getAttribute('data-isbn');
    const xhttp = new XMLHttpRequest();
    xhttp.onload=function (){
        const bookData = JSON.parse(this.responseText);
        const isbnKey = 'ISBN:' + isbn;
        if(bookData[isbnKey]){
            image.src = bookData[isbnKey].cover.large;
        }else{
            image.src = '/public/assets/no_cover.jpg';
        }

    };
    //create and send the request
    xhttp.open("GET", `https://openlibrary.org/api/books?bibkeys=ISBN:${isbn}&jscmd=data&format=json`, true);
    xhttp.send();
});

/*Start of bookpage functions*/
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
        document.getElementById('BookPic').src = '/public/assets/no_cover.jpg';
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
        document.getElementById('BookAuthor').textContent ='Author: ' + authorName;
    }else {
        document.getElementById('BookAuthor').textContent = 'An error occurred. Try to load the page again.';
    }
}
/*End of bookpage functions*/

function redirectToBook() {
    var isbn = document.getElementById('isbn').value;
    console.log("0");
    fetch(`/public/search/book/${isbn}`)
        .then(response => response.json())
        .then(data => {
            var book = data;
            var id = book.id;
            var url = '/public/Book/' + id;
            console.log("url: " + url);
            window.location.href = url;


        })
        .catch(error => console.error('Error:', error));
}


function searchBookByISBN() {
    var isbn = document.getElementById('isbn').value;
    console.log(isbn)
    var bookPic = document.getElementById('BookPic');
    bookPic.setAttribute('data-isbn', isbn);

    fetch(`/public/search/book/${isbn}`)
        .then(response => response.json())
        .then(data => {
            var book = data;
            Array.from(book_images).forEach((image) => {
                const isbn = image.getAttribute('data-isbn');
                const xhttp = new XMLHttpRequest();
                xhttp.onload=function (){
                    const bookData = JSON.parse(this.responseText);
                    const isbnKey = 'ISBN:' + isbn;
                    if(bookData[isbnKey]){
                        image.src = bookData[isbnKey].cover.large;
                    }else{
                        image.src = '/public/assets/no_cover.jpg';
                    }

                };
                //create and send the request
                xhttp.open("GET", `https://openlibrary.org/api/books?bibkeys=ISBN:${isbn}&jscmd=data&format=json`, true);
                xhttp.send();
            });
            document.getElementById('bookTitle').textContent = book.title || 'No book found';
            document.getElementById('bookAuthor').textContent = book.author || '';
            document.getElementById('bookRating').textContent = book.rating || '';
            document.getElementById('bookNumberOfFollowers').textContent = book.number_of_followers || '';
            document.getElementById('id').textContent = book.id || '';
            document.getElementById('isbn').textContent = book.isbn || '';
            document.getElementById('bookgenres').textContent = book.genres || '';

        })
        .catch(error => console.error('Error:', error));
}

window.onload = function () {
    var searchButton = document.getElementById('searchButton');
    searchButton.addEventListener('click', searchBookByISBN);
};


