import Data from './Data.js';

let elemNameObj={
    classNameInput: "check_string_input",
    classNameBtn:["check_string_btn","story_btn"],
    resultElemName:["border border-success text-center rounded result_check","result_story"],
    parentResultElemName:["check_result_container","story_container"],
    storyElemName:[
        "lines",
        "row story_container_result",
        "col-md-8 border border-success text-center rounded  input_data_story",
        "col-md-2 border border-success text-center rounded  result_story"],
    messageElemName:"message"
}

let data = new Data(elemNameObj);
