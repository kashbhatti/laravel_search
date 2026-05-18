## Search API

This is a Laravel API example. You can test with Postman or Insomnia.

You need to login, fetch a bearer token and use that when posting a search request.

To login, POST request to https://search.preview1.co.uk/api/login

Provide these 2 parameters as form data to authenticate.
- **email**: user@company.com
- **password**: password

Then use the supplied bearer token in the next POST request to https://search.preview1.co.uk/api/search

Simply supply a parameter 
- **query**: ipad 

or any other computer hardware related terms such as monitor, speaker, memory, hard drive, apple, macbook.

You can also supply an optional parameter **sort** which is either 'asc' or 'desc'
This will sort by price.
Finally you may supply a third parameter **offSet** which is an integer.

If the data is in the database you will receive matching products.

To test the VueJS front end, visit https://search.preview1.co.uk/
