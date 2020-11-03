<?php

abstract class Operation {
  protected $operand_1;
  protected $operand_2;
  public function __construct($o1, $o2) {
    // Make sure we're working with numbers...
    if (!is_numeric($o1) || !is_numeric($o2)) {
      throw new Exception('Non-numeric operand.');
    }

    // Assign passed values to member variables
    $this->operand_1 = $o1;
    $this->operand_2 = $o2;
  }
  public abstract function operate();
  public abstract function getEquation();
}

// Addition subclass inherits from Operation
class Addition extends Operation {
  public function operate() {
    return $this->operand_1 + $this->operand_2;
  }
  public function getEquation() {
    return $this->operand_1 . ' + ' . $this->operand_2 . ' = ' . $this->operate();
  }
}


// Add subclasses for Subtraction, Multiplication and Division here

// Subtraction subclass inherits from Operation
class Subtraction extends Operation {
  public function operate() {
    return $this->operand_1 - $this->operand_2;
  }
  public function getEquation() {
    return $this->operand_1 . ' - ' . $this->operand_2 . ' = ' . $this->operate();
  }
}

class Multiplication extends Operation {
  public function operate() {
    return $this->operand_1 * $this->operand_2;
  }
  public function getEquation() {
    return $this->operand_1 . ' * ' . $this->operand_2 . ' = ' .$this->operate();
  }
}

// Division subclass inherits from Operation
class Division extends Operation {
  public function operate() {
    if ($this->operand_2 == 0) {
      return "UNDEFINED";
    }

    return (float)($this->operand_1) / (float)($this->operand_2);
  }
  public function getEquation() {
    return $this->operand_1 . ' / ' . $this->operand_2 . ' = ' . $this->operate();
  }
}

class SquareRoot extends Operation {
  public function operate() {
    if ($this->oeprand_1 < 0) {
      return "UNDEFINED";
    }
    return sqrt($this->operand_1);
  }
  public function getEquation() {
    return 'sqrt(' . $this->operand_1 . ') = ' . $this->operate();
  }
}

class Square extends Operation {
  public function operate() {
    return $this->operand_1 * $this->operand_1;
  }
  public function getEquation() {
    return $this->operand_1 . '^2  = ' .$this->operate();
  }
}

class LogBase10 extends Operation {
  public function operate() {
    return log($this->operand_1, 10);
  }
  public function getEquation() {
    return 'Log(10)(' . $this->operand_1 . ') = ' . $this->operate();
  }
}

class NaturalLog extends Operation {
  public function operate() {
    return log($this->operand_1);
  }
  public function getEquation() {
    return 'Ln(' . $this->operand_1 . ') = ' . $this->operate();
  }
}

class TenExponent extends Operation {
  public function operate() {
    return 10**($this->operand_1);
  }
  public function getEquation() {
    return '10^(' . $this->operand_1 . ') = ' . $this->operate();
  }
}

class EulerExponent extends Operation {
  public function operate() {
    return exp($this->operand_1);
  }
  public function getEquation() {
    return 'e^(' . $this->operand_1 . ') = ' . $this->operate();
  }
}

class Sine extends Operation {
  public function operate() {
    return sin($this->operand_1);
  }
  public function getEquation() {
    return 'sin(' . $this->operand_1 . ') = ' . $this->operate();
  }
}

class Cosine extends Operation {
  public function operate() {
    return cos($this->operand_1);
  }
  public function getEquation() {
    return 'cos(' . $this->operand_1 . ') = ' . $this->operate();
  }
}

class Tangent extends Operation {
  public function operate() {
    return tan($this->operand_1);
  }
  public function getEquation() {
    return 'tan(' . $this->operand_1 . ') = ' . $this->operate();
  }
}

// Some debugs - uncomment these to see what is happening...
// echo '$_POST print_r=>',print_r($_POST);
// echo "<br>",'$_POST vardump=>',var_dump($_POST);
// echo '<br/>$_POST is ', (isset($_POST) ? 'set' : 'NOT set'), "<br/>";
// echo "<br/>---";


// Check to make sure that POST was received
// upon initial load, the page will be sent back via the initial GET at which time
// the $_POST array will not have values - trying to access it will give undefined message

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $input = $_POST['input'];
}
$err = Array();


// Instantiate an object for each operation based on the values returned on the form
// For example, check to make sure that $_POST is set and then check its value and
// instantiate its object
//
// The Add is done below.  Go ahead and finish the remiannig functions.
// Then tell me if there is a way to do this without the ifs
// We might cover such a way on Tuesday...

try {
  if (isset($_POST['equals']) && $_POST['equals'] == 'Equals') {
    $op1 = null;
    $op2 = null;
    $op = null;
    echo $input;
    echo "<br/>";

    // strpos() finds the position of the first occurrence of a substring in a string
    $x = strpos( $input, '+' );
    // If addition...
    if( $x !== false ) {
      $op1 = substr($input,0,$x-1);
      $op2 = substr($input,$x+2,-3);
      $op = new Addition( $op1, $op2 );
    }
    $x = strpos( $input, '-' );
    if( $x !== false ) {
      $op1 = substr($input,0,$x-1);
      $op2 = substr($input,$x+2,-3);
      $op = new Subtraction( $op1, $op2 );
    }
    $x = strpos( $input, '*' );
    if( $x !== false ) {
      $op1 = substr($input,0,$x-1);
      $op2 = substr($input,$x+2,-3);
      $op = new Multiplication( $op1, $op2 );
    }
    $x = strpos( $input, '/' );
    if( $x !== false ) {
      $op1 = substr($input,0,$x-1);
      $op2 = substr($input,$x+2,-3);
      $op = new Division( $op1, $op2 );
    }

    // $op = new Operation($input);
  }
}
catch (Exception $e) {
  $err[] = $e->getMessage();
}
?>

<!doctype html>
<html>
  <head>
    <title>PHP Calculator</title>
  </head>
  <body>
    <pre id="result">
      <?php
        if (isset($op)) {
          try {
            echo $op->getEquation();
          }
          catch (Exception $e) {
            $err[] = $e->getMessage();
          }
        }

        foreach($err as $error) {
            echo $error . "\n";
        }
      ?>
    </pre>
    <form method="post" action="calculator.php">
      <input type="text" name="input" id="input" value="" />
      <br/>
      <button type="button" id="add">+</button>
      <button type="button" id="subtract">-</button>
      <button type="button" id="mult">*</button>
      <button type="button" id="divi">/</button>
      <input type="submit" id="equals" name="equals" value="Equals"/>
    </form>

    <script>
      var input = document.getElementById("input");
      function appendOperator( operator ) {
        var input = document.getElementById("input");
        input.value = input.value + operator;
      }
      document.getElementById("add").addEventListener( 'click', function() {
        appendOperator( " + " );
      });
      document.getElementById("subtract").addEventListener( 'click', function() {
        appendOperator( " - " );
      });
      document.getElementById("mult").addEventListener( 'click', function() {
        appendOperator( " * " );
      });
      document.getElementById("divi").addEventListener( 'click', function() {
        appendOperator( " / " );
      });
      document.getElementById("equals").addEventListener( 'click', function() {
        appendOperator( " = " );
      });
    </script>
  </body>
</html>
