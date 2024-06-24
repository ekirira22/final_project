/*
 *We define a variable dropdown that gets elements with classname 'dropdown-btn'
 */
var dropdown = document.getElementsByClassName('dropdown-btn');
//We declare variable i that we will use in the for loop
var i;

for (i = 0; i < dropdown.length; i++) {
  //for the dropdown length, add an event listener
  dropdown[i].addEventListener("click", function() {
    //toggle each if selected, add active, then add block or
    //none display styles
    this.classList.toggle("active");

    var dropdownContent = this.nextElementSibling;

    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}

// For deletion buttons
function deleteConfig(){

  var del=confirm("Are you sure you want to delete this record? This action cannot be reversed");
  if (del === false){
    return del;
  }

}

//For approval and delay buttons
function approve(){
  var app=confirm("Approve this project? This action cannot be reversed");
  if (app === false){
    return app;
  }
}

//delay project confirmation
function delay(){
  var del=confirm("Delay this project? This action cannot be reversed");
  if (del === false){
    return del;
  }
}

//start project confirmation

function startProject()
{
  var start=confirm("Start Project? Time and Budget meter will start now");
  if (start === false){
    return start;
  }
}

//complete project confirmation
function completeProject()
{
  var comp=confirm("Complete Project?");
  if (comp === false){
    return comp;
  }
}
