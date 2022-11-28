<?php include_once("java/Java.inc");

phpinfo();

try {
  /* invoke java.lang.System.getProperties() */
  $props = java("java.lang.System")->getProperties();
  
  /* convert the result object into a PHP array */
  $array = java_values($props);
  foreach($array as $k=>$v) {
    echo "$k=>$v"; echo "<br>\n";
  }
  echo "<br>\n";
  
  /* create a PHP class which implements the Java toString() method */
  class MyClass {
    function toString() { return "hello PHP from Java!"; }
  }
  
  /* create a Java object from the PHP object */
  $javaObject = java_closure(new MyClass());
  echo "PHP says that Java says: "; echo $javaObject;  echo "<br>\n";
  echo "<br>\n";
  

  echo java("php.java.bridge.Util")->VERSION; echo "<br>\n";

} catch (JavaException $ex) {
  echo "An exception occured: "; echo $ex; echo "<br>\n";
}

?>