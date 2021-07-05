export default class Request {
    constructor() {
        this.frontController = 'frontController.php';
    }
    checkDataOnServer(data,resolve,postMethod){
        this.resolve = resolve;
        let responsePromise;
        if(postMethod === "POST"){
         responsePromise = fetch(this.frontController, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        }else if(postMethod === "GET"){
             responsePromise = fetch(this.frontController, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'text/html; charset=UTF-8'
                    }
                });
        }
        responsePromise.then(this.jsonDecoder.bind(this));
    }

    jsonDecoder(response){
        response.json().then(this.getResult.bind(this));
    }
    getResult(response){
        this.resolve(response);
    }



}