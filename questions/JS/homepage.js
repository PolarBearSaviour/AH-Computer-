function check(){
  //get value of subject down menu
  var subject = document.getElementById('subject').value;
  //get value of level drop down menu
  var level = document.getElementById('level').value;
  //check neither have no value
  if(subject == "" || level == ""){
    //displayes error message
    $('#errorMessage').modal('show');
    //prevents data being sent
    return false
  }
  //allws data to be sent
  return true;
}
