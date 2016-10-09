function check(form){
  //sets up an array of IDs (ie the keys for data stored in session Storage)
  var ID = ['title', 'subject', 'level', 'question'];
  var element;
  //loops around for the number of IDs in the array
  for(var i = 0; i < ID.length; i ++){
    //gets the html input value
    element = document.getElementById(ID[i]);
    //checks whether the ID is question or title
    if(ID[i] == 'question' || ID[i] == 'title'){
      //checks whether the value stored from the answer page matches the current value
      if(element.value == sessionStorage.getItem(ID[i])){
        //disables the element so it won't be sent (since no change has been made, the server doesn't need to update)
        form[i].setAttribute("disabled", "true");
      }
    }else{
      //checks the value isn't empty or whether the user has entered the same subject as previous
      if(element.value == "" || element[element.selectedIndex].innerHTML == sessionStorage.getItem([ID[i]])){
        //disables element to prevent it being sent
        form[i].setAttribute("disabled", "true");
      }
    }
  }

  //reutrns true (allows the data to be sent)
  return true;
}
