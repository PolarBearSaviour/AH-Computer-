function validatePassword(){
  //gets username from inputbox
  var username = document.getElementById('username').value;
  //gets password from inputbox
  var password = document.getElementById('password').value;
  //Get the HTML elements that make the list up
  var list = document.getElementById('list').getElementsByTagName("li");
  //checks password isn't username
  if(!(username == password)){
    //changes that element on list to green success colour
    list[0].className = "list-group-item list-group-item-success"
  }else{
    //changes that element on list to red failure colour
    list[0].className = "list-group-item list-group-item-danger"
  }
  //checks password is correct length
  if(password.length > 8){
    list[1].className = "list-group-item list-group-item-success"
  }else {
    list[1].className = "list-group-item list-group-item-danger"
  }
  //checks password has any numbers in it
  if(password.match(/[0-9]/)){
    list[2].className = "list-group-item list-group-item-success"
  }else{
    list[2].className = "list-group-item list-group-item-danger"
  }
  //checks whether tha password has a space in it
  if(password.match(/[" "]/)){
    list[3].className = "list-group-item list-group-item-success"
  }else{
    list[3].className = "list-group-item list-group-item-danger"
  }
  //checks whether the password has a uppercase character
  if(password.match(/[A-Z]/)){
    list[4].className = "list-group-item list-group-item-success"
  }else{
    list[4].className = "list-group-item list-group-item-danger"
  }
  //checks whether the password has lowercase character
  if(password.match(/[a-z]/)){
    list[5].className = "list-group-item list-group-item-success"
  }else{
    list[5].className = "list-group-item list-group-item-danger"
  }
}
  function checkPwordAndPwordConfirm() {
    //gets password from inputbox
    var password = document.getElementById('password').value;
    //gets password confirm from inputbox
    var passwordConfirm = document.getElementById('passwordConfirm').value;
    //gets list of elements
    var list = document.getElementById('list').getElementsByTagName("li");
    //checks passwords match
    if(password == passwordConfirm){
      list[6].className = "list-group-item list-group-item-success";
    }else{
      list[6].className = "list-group-item list-group-item-danger"
    }
  }
