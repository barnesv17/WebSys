var input = document.getElementById("input");
function appendOperator( operator ) {
  var input = document.getElementById("input");
  input.value = input.value + operator;
}

function clearInput() {
  var input_text = document.getElementById("input");
  input_text.innerHTML = "";
}
window.onload = function () {
  document.getElementById("input").value = "";
  document.getElementById("add").addEventListener( 'click', function() {
    appendOperator( " + " );
    input.focus();
  });
  document.getElementById("subtract").addEventListener( 'click', function() {
    appendOperator( " - " );
    input.focus();
  });
  document.getElementById("mult").addEventListener( 'click', function() {
    appendOperator( " * " );
    input.focus();
  });
  document.getElementById("divi").addEventListener( 'click', function() {
    appendOperator( " / " );
    input.focus();
  });
  document.getElementById("sqrt").addEventListener( 'click', function() {
    appendOperator( "sqrt( " );
    input.focus();
  });
  document.getElementById("rp").addEventListener( 'click', function() {
    appendOperator( " )" );
    input.focus();
  });
  document.getElementById("square").addEventListener( 'click', function() {
    appendOperator( "^2" );
    input.focus();
  });
  document.getElementById("log10").addEventListener( 'click', function() {
    appendOperator( "log10( " );
    input.focus();
  });
  document.getElementById("ln").addEventListener( 'click', function() {
    appendOperator( "ln( " );
    input.focus();
  });
  document.getElementById("tenexp").addEventListener( 'click', function() {
    appendOperator( "10^( " );
    input.focus();
  });
  document.getElementById("euler").addEventListener( 'click', function() {
    appendOperator( "e^( " );
    input.focus();
  });
  document.getElementById("sine").addEventListener( 'click', function() {
    appendOperator( "sin( " );
    input.focus();
  });
  document.getElementById("cosine").addEventListener( 'click', function() {
    appendOperator( "cos( " );
    input.focus();
  });
  document.getElementById("tangent").addEventListener( 'click', function() {
    appendOperator( "tan( " );
    input.focus();
  });
  document.getElementById("equals").addEventListener( 'click', function() {
    appendOperator( " = " );
    input.focus();
  });
  
  document.getElementById("mod").addEventListener( 'click', function() {
    appendOperator( " % ");
    input.focus();
  });

  document.getElementById("dot").addEventListener( 'click', function() {
    appendOperator( ".");
    input.focus();
  });

  document.getElementById("one").addEventListener( 'click', function() {
    appendOperator( "1");
    input.focus();
  });

  document.getElementById("two").addEventListener( 'click', function() {
    appendOperator( "2");
    input.focus();
  });

  document.getElementById("three").addEventListener( 'click', function() {
    appendOperator( "3");
    input.focus();
  });

  document.getElementById("four").addEventListener( 'click', function() {
    appendOperator( "4");
    input.focus();
  });

  document.getElementById("five").addEventListener( 'click', function() {
    appendOperator( "5");
    input.focus();
  });

  document.getElementById("six").addEventListener( 'click', function() {
    appendOperator( "6");
    input.focus();
  });

  document.getElementById("seven").addEventListener( 'click', function() {
    appendOperator( "7");
    input.focus();
  });

  document.getElementById("eight").addEventListener( 'click', function() {
    appendOperator( "8");
    input.focus();
  });

  document.getElementById("nine").addEventListener( 'click', function() {
    appendOperator( "9");
    input.focus();
  });

  document.getElementById("zero").addEventListener( 'click', function() {
    appendOperator( "0");
    input.focus();
  });

  document.getElementById("ac").addEventListener( 'click', function() {
    input.value = '';
  });
  
  document.getElementById("backspace").onclick = function() {
    var input = document.getElementById("input");
    var start = input.selectionStart;
    var end = input.selectionEnd;
    var text_length = input.value.length;
  
    var before = input.value.substring(0, start);
    var selected = input.value.substring(start, end);
    var after = input.value.substring(end, text_length);
    if (start == end) {
      input.value = input.value.substring(0, start - 1) + after;
      document.getElementsByTagName("body").innerHTML = "input.value = input.value.substring(0, start - 1) + after;<br>";
      input.focus();
      document.getElementsByTagName("body").innerHTML = "input.focus()<br>";
      input.selectionStart = start - 1;
      document.getElementsByTagName("body").innerHTML = "input.selectionStart = start - 1;<br>";
      input.selectionEnd = end - 1;
      document.getElementsByTagName("body").innerHTML = "input.value = input.value.substring(0, start - 1) + after;<br>";
    } else {
      input.value = before + after;
      input.focus();
      input.selectionStart = start;
      input.selectionEnd = start;
    }
  };
  
};
