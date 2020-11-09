<?php

abstract class Operation {
  protected $operand_1;
  protected $operand_2;
  public function __construct($o1, $o2) {
    // Make sure we're working with numbers...
    if ( !is_numeric($o1) || (!is_numeric($o2) && $o2 !== null) ) {
      throw new Exception('Please enter a valid 1-step equation');
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
    if ($this->operand_1 < 0) {
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
    return 'Log10(' . $this->operand_1 . ') = ' . $this->operate();
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
  if (isset($_POST['equals']) && $_POST['equals'] == '=') {
    $op1 = null;
    $op2 = null;
    $op = null;
    echo $input;
    echo "<br/>";

    // strpos() finds the position of the first occurrence of a substring in a string
    //----ADDITION--------------------------------------------------------------
    if( ($x = strpos( $input, '+' )) !== false ) {
      $op1 = substr($input,0,$x-1);
      $op2 = substr($input,$x+2,-3);
      $op = new Addition( $op1, $op2 );
    }
    //----SUBTRACTION-----------------------------------------------------------
    else if( ($x = strpos( $input, '-' )) !== false ) {
      $op1 = substr($input,0,$x-1);
      $op2 = substr($input,$x+2,-3);
      $op = new Subtraction( $op1, $op2 );
    }
    //----MULTIPLICATION--------------------------------------------------------
    else if( ($x = strpos( $input, '*' )) !== false ) {
      $op1 = substr($input,0,$x-1);
      $op2 = substr($input,$x+2,-3);
      $op = new Multiplication( $op1, $op2 );
    }
    //----DIVISION--------------------------------------------------------------
    else if( ($x = strpos( $input, '/' )) !== false ) {
      $op1 = substr($input,0,$x-1);
      $op2 = substr($input,$x+2,-3);
      $op = new Division( $op1, $op2 );
    }
    //----SQUARE ROOT-----------------------------------------------------------
    else if( ($x = strpos( $input, 'sqrt(' )) !== false && ($x == 0) && ($y = strpos( $input, ')' )) == (strlen($input)-4) ) {
      $op1 = substr($input,6,-5);
      $op = new SquareRoot( $op1, $op2 );
    }
    //----SQUARE----------------------------------------------------------------
    else if( ($x = strpos( $input, '^2' )) !== false ) {
      $op1 = substr($input,0,$x);
      $op = new Square( $op1, $op2 );
    }
    //----LOG(10)---------------------------------------------------------------
    else if( ($x = strpos( $input, 'Log10' )) !== false && ($x == 0) && ($y = strpos( $input, ')' )) == (strlen($input)-4) ) {
      $op1 = substr($input,7,-5);
      $op = new LogBase10( $op1, $op2 );
    }
    //----NATURAL LOG-----------------------------------------------------------
    else if( ($x = strpos( $input, 'ln' )) !== false && ($x == 0) && ($y = strpos( $input, ')' )) == (strlen($input)-4) ) {
      $op1 = substr($input,4,-5);
      $op = new NaturalLog( $op1, $op2 );
    }
    //----10 EXPONENT-----------------------------------------------------------
    else if( ($x = strpos( $input, '10^(' )) !== false && ($x == 0) && ($y = strpos( $input, ')' )) == (strlen($input)-4) ) {
      $op1 = substr($input,5,-5);
      $op = new TenExponent( $op1, $op2 );
    }
    //----EULER-----------------------------------------------------------------
    else if( ($x = strpos( $input, 'e^(' )) !== false && ($x == 0) && ($y = strpos( $input, ')' )) == (strlen($input)-4) ) {
      $op1 = substr($input,4,-5);
      $op = new EulerExponent( $op1, $op2 );
    }
    //----SINE------------------------------------------------------------------
    else if( ($x = strpos( $input, 'sin(' )) !== false && ($x == 0) && ($y = strpos( $input, ')' )) == (strlen($input)-4) ) {
      $op1 = substr($input,5,-5);
      $op = new Sine( $op1, $op2 );
    }
    //----COSINE----------------------------------------------------------------
    else if( ($x = strpos( $input, 'cos(' )) !== false && ($x == 0) && ($y = strpos( $input, ')' )) == (strlen($input)-4) ) {
      $op1 = substr($input,5,-5);
      $op = new Cosine( $op1, $op2 );
    }
    //----TANGENT---------------------------------------------------------------
    else if( ($x = strpos( $input, 'tan(' )) !== false && ($x == 0) && ($y = strpos( $input, ')' )) == (strlen($input)-4) ) {
      $op1 = substr($input,5,-5);
      $op = new Tangent( $op1, $op2 );
    }
    else {
      throw new Exception('Please enter a valid 1-step equation');
    }

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
    <link rel="stylesheet" href="lab8.css"/>
    <link
      href="https://fonts.googleapis.com/css?family=Roboto:300,400,700"
      rel="stylesheet"
    />
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
    <form id="calcInterface" method="post" action="calculator.php">
      <input type="text" name="input" id="input" value="" />
      <br>
      <div id='operationPad'>
        <button type="button" id="sqrt">&radic;</button>
        <button type="button" id="square">X&sup2;</button>
        <button type="button" id="log10">log<sub>10</sub>(</button>
        <button type="button" id="ln">ln(</button>
        
        <button type="button" id="sine">sin(</button>
        <button type="button" id="cosine">cos(</button>
        <button type="button" id="tangent">tan(</button>
        <button type="button" id="rp">)</button>

        <button type="button" id="tenexp">10^(</button>
        <button type="button" id="euler">e^(</button>
        <button type="button" id="mod">%</button>
        <button type="button" id="backspace">&larr;</button>

        <button type="button" id="add">+</button>
        <button type="button" id="subtract">-</button>
        <button type="button" id="mult">&times;</button>
        <button type="button" id="divi">&divide;</button>

        <button type="button" id="seven">7</button>
        <button type="button" id="eight">8</button>
        <button type="button" id="nine">9</button>
        <button type="button" id="ac">AC</button>

        <button type="button" id="four">4</button>
        <button type="button" id="five">5</button>
        <button type="button" id="six">6</button>
        <button type="button" id="dot">.</button>

        <button type="button" id="one">1</button>
        <button type="button" id="two">2</button>
        <button type="button" id="three">3</button>
        <button type="button" id="zero">0</button> 
      </div>
      <input type="submit" id="equals" name="equals" value="="/>
    </form>
    <script src="calculator.js"></script>
  </body>
</html>
