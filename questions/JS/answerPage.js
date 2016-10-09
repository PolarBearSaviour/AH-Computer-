//saves the current values of HTML for the question details and creates the link for the editPage
function createLink(){
  //array of ID names
  var ID = ['title', 'subject', 'level', 'question'];
  //sets up variable
  var element;
  //loops around for the number of ID
  for (var i = 0; i < ID.length; i++){
    //gets the text inbetween the HTML tag of the given element
    element = document.getElementById(ID[i]).innerHTML;
    //saves the data into sessionStorage so it can on other pages
    sessionStorage.setItem(ID[i], element);
  }

  //gets the current query string the URL
  var questionID = location.search;
  //add the query string to the URL for the edit page and then the user is sent there
  window.location.href = "editQuestion.php".concat(questionID);
}

//sends the user to the deleteQuestion page for question a given question
function link(){
  window.location.href = "deleteQuestion.php".concat(location.search);
}

//changes the action of a form so it contains the query string for the given page
function editAction(form){
  //sets the correct URL
  form.action = "QandA.php".concat(location.search);
  return true;
}

//Shows the modal for the delete question button
function showDialouge(){
  $('#deleteDialouge').modal('show');
}


function hideElement(elementToBeHidden, elementToBeShown){
  //gets HTML elements to be hidden
  var hide = document.getElementById(elementToBeHidden);
  //hides the element to be hidden by adding the hidden attribute to it
  hide.setAttribute("hidden", "hidden")
  //gets the element to be shown
  var show = document.getElementById(elementToBeShown);
  //removes the hidden attribute from element to be shown
  show.removeAttribute("hidden");

}
