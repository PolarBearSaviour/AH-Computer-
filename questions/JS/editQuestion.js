function check(form){

  var ID = ['title', 'subject', 'level', 'question'];

  for(var i = 0; i < form.length; i ++){
    if(form[i].value == sessionStorage.getItem(ID[i]) || form[i].value < 0){
      form[i].setAttribute("disabled", "true");
    }
  }
  return true;
}
