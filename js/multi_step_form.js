/*------------Validation Function-----------------*/
var count = 0; // To count blank fields.
function validation(event) {
var radio_check = document.getElementsByName('gender'); // Fetching radio button by name.
var input_field = document.getElementsByClassName('text_field'); // Fetching all inputs with same class name text_field and an html tag textarea.
var text_area = document.getElementsByTagName('textarea');
// Validating radio button.
if (radio_check[0].checked == false && radio_check[1].checked == false) {
var y = 0;
} else {
var y = 1;
}
// For loop to count blank inputs.
for (var i = input_field.length; i > count; i--) {
if (input_field[i - 1].value == '' || text_area.value == '') {
count = count + 1;
} else {
count = 0;
}
}
if (count != 0 || y == 0) {
alert("*All Fields are mandatory*"); // Notifying validation
event.preventDefault();
} else {
return true;
}
}
/*---------------------------------------------------------*/
// Function that executes on click of first next button.
function next_step1() {
document.getElementById("first").style.display = "none";
document.getElementById("second").style.display = "block";
document.getElementById("active2").style.color = "#235c6d";
document.getElementById("active1").style.color = " #28c320 ";
}
// Function that executes on click of first previous button.
function prev_step1() {
document.getElementById("first").style.display = "block";
document.getElementById("second").style.display = "none";
document.getElementById("active1").style.color = "#235c6d";
document.getElementById("active2").style.color = "gray";
}
// Function that executes on click of second next button.
function next_step2() {
document.getElementById("second").style.display = "none";
document.getElementById("third").style.display = "block";
document.getElementById("active3").style.color = "#235c6d";
document.getElementById("active2").style.color = "#28c320";
}
// Function that executes on click of second previous button.
function prev_step2() {
document.getElementById("third").style.display = "none";
document.getElementById("second").style.display = "block";
document.getElementById("active2").style.color = "#235c6d";
document.getElementById("active3").style.color = "gray";
}
// Function that executes on click of third next button.
function next_step3() {
    document.getElementById("third").style.display = "none";
    document.getElementById("fourth").style.display = "block";
    document.getElementById("active4").style.color = "#235c6d";
    document.getElementById("active3").style.color = "#28c320";
    }
    // Function that executes on click of third previous button.
    function prev_step3() {
    document.getElementById("fourth").style.display = "none";
    document.getElementById("third").style.display = "block";
    document.getElementById("active3").style.color = "#235c6d";
    document.getElementById("active4").style.color = "gray";
    }
    function next_step4() {
        document.getElementById("fourth").style.display = "none";
        document.getElementById("fifth").style.display = "block";
        document.getElementById("active5").style.color = "#235c6d";
        document.getElementById("active4").style.color = "#28c320";
        }
        // Function that executes on click of third previous button.
        function prev_step4() {
        document.getElementById("fifth").style.display = "none";
        document.getElementById("fourth").style.display = "block";
        document.getElementById("active4").style.color = "#235c6d";
        document.getElementById("active5").style.color = "gray";
        }
        function next_step5() {
            document.getElementById("fifth").style.display = "none";
            document.getElementById("sixth").style.display = "block";
            document.getElementById("active6").style.color = "#235c6d";
            document.getElementById("active5").style.color = "#28c320";
            }
            // Function that executes on click of third previous button.
            function prev_step5() {
            document.getElementById("sixth").style.display = "none";
            document.getElementById("fifth").style.display = "block";
            document.getElementById("active5").style.color = "#235c6d";
            document.getElementById("active6").style.color = "gray";
            }
function openForm() {
    document.getElementById("myForm").style.display = "block";
  }
  
  function closeForm() {
    document.getElementById("myForm").style.display = "none";
  }
  document.getElementById("btn1").onclick = disableScreen;
function addInput(){
    var i=1;
    $('#add1'),click(function(){
        i++;
        $('#education').append('<div id="education" name="education"><input class="text_field" name="degree[]" id="degree" placeholder="Degree" type="text" value=""><input class="text_field" name="stream[]" id="stream" placeholder="Stream" type="text" value=""> <input class="text_field" name="syear[]" id="syear" placeholder="Start Year" type="text" value=""><input class="text_field" name="pyear[]" id="pyear" placeholder="Passing Year" type="text" value=""><input class="text_field" name="univ[]" id="univ" placeholder="University" type="text" value=""><input class="text_field" name="score[]" id="score" placeholder="Score" type="text" value=""><hr> <button name="remove" id="'+i+'" class="btn btn-danger btn_remove">Remove Education</button></div>');
    });
    $(document).on('click','.btn-remove',function(){
        var button_id=$(this).attr("id");
        $("#education"+button_id+"").remove();
    });
}
