import Request from "./Request.js";
export default class Data {
    constructor(elemNameObj) {
        this.classNameInput = elemNameObj.classNameInput;
        this.classNameBtn = elemNameObj.classNameBtn;
        this.resultElemName = elemNameObj.resultElemName;
        this.parentResultElemName = elemNameObj.parentResultElemName;
        this.storyElemName = elemNameObj.storyElemName;
        this.messageElemName = elemNameObj.messageElemName;
        this.messageOk = "OK";
        this.messageNo = "No";
        this.bracketsArr = ["<","(", "{", "[", "]","}",")",">"];
        this.addEvent();
    }
    addEvent(){
        let checkStringBtn = this.getElem(this.classNameBtn[0]);
        checkStringBtn.addEventListener("click", this.handlerCheckStringBtn.bind(this));

        let storyBtn = this.getElem(this.classNameBtn[1]);
        storyBtn.addEventListener("click", this.handlerStoryBtn.bind(this));
    }
    getInputData(className) {
        return document.getElementsByClassName(className)[0].value;
    }
    getElem(className){
        return document.getElementsByClassName(className)[0];
    }
    handlerCheckStringBtn(){
        let data = this.getInputData(this.classNameInput);
        if (this.checkInputData(data)){
            this.data = data;
            this.methodSend = "POST";
           new Promise(this.sendDataToServer.bind(this)).then(this.outCheckResult.bind(this));
        }else {
            this.getResultElem(this.resultElemName[0]);
            this.outMessage("Введите данные, содержащие скобку!");
        }

    }
    handlerStoryBtn(){
        this.methodSend = "GET";
        new Promise(this.sendDataToServer.bind(this)).then(this.outStory.bind(this));
    }
    checkInputData(data){
        if(data.length === 0){
            return false
        }
        for(let i = 0; i < this.bracketsArr.length; i++){
            if(data.includes(this.bracketsArr[i])){
                return true
            }
        }
        return false;

    }
    sendDataToServer(resolve){
        let request = new Request();
        request.checkDataOnServer(this.data,resolve,this.methodSend);
    }
    outCheckResult(value){
        if(value[0] === "error"){
            this.outMessage("Ошибка на сервере!");
            return;
        }
        let resultElem = this.getResultElem(this.resultElemName[0]);
        if(value.success === "true"){
            resultElem.innerHTML = this.messageOk
        }else{
            resultElem.innerHTML = this.messageNo
        }
        let parentElem = this.getElem(this.parentResultElemName[0]);
        parentElem.appendChild(resultElem);
    }
    getResultElem(resultElemName){
         let resultElem = this.getElem(resultElemName);
         if(resultElem){
             resultElem.remove();
         }
            let newResultElem = this.createElem("div", resultElemName);

        return newResultElem
    }
    outStory(value){
        if(value[0] === "error"){
            this.outMessage("Ошибка на сервере!");
            return;
        }
        let resultElem = this.getResultElem(this.resultElemName[1]);
        let storyContainer = this.getElem(this.parentResultElemName[1]);

        if(value.length > 0) {
            value.forEach(function (storyObj) {
                let linesContainer = this.createElem("div", this.storyElemName[0]);
                let storyContainerResult = this.createElem("div", this.storyElemName[1]);
                let inputDataStoryElem = this.createElem("div", this.storyElemName[2]);
                let resultStoryElem = this.createElem("div", this.storyElemName[3]);

                inputDataStoryElem.innerHTML = storyObj.string;
                if(storyObj.result === "true"){
                    resultStoryElem.innerHTML = this.messageOk
                }else{
                    resultStoryElem.innerHTML = this.messageNo
                }
                storyContainerResult.append(inputDataStoryElem, resultStoryElem);
                linesContainer.appendChild(storyContainerResult);
                resultElem.appendChild(linesContainer);
            }.bind(this));
            storyContainer.appendChild(resultElem);
        }else{
            this.outMessage("Записей не обнаружено!");
        }
    }
    outMessage(message){
        this.message = message;
        new Promise(this.messageOn.bind(this)).then(this.messageOff);
    }
    messageOn(resolve){
        let messageElem = this.getElem(this.messageElemName);
        messageElem.innerHTML = this.message;
        messageElem.hidden = false;
        setTimeout(handler,2000);
        function handler () {
            resolve(messageElem);
        }
    }
    messageOff(messageElem){
        messageElem.innerHTML = "";
        messageElem.hidden = true;
    }
    createElem(tagName,className){
        let elem = document.createElement(tagName);
        elem.className = className;
        return elem;
    }

}