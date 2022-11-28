<?php
header("Content-type: application/pdf");
header("Content-Disposition: attachment; filename=downloaded.pdf");

define ("JAVA_HOSTS", "127.0.0.1:8080");
define ("JAVA_SERVLET", "/JavaBridge/JavaBridge.phpjavabridge");

require_once("java/Java.inc");

session_start(); 

$here = getcwd();

$ctx = java_context()->getServletContext();
$birtReportEngine =        java("org.eclipse.birt.php.birtengine.BirtEngine")->getBirtEngine($ctx);
java_context()->onShutdown(java("org.eclipse.birt.php.birtengine.BirtEngine")->getShutdownHook());


try{


$report = $birtReportEngine->openReportDesign("${here}/TopNPercent.rptdesign");
$task = $birtReportEngine->createRunAndRenderTask($report);
$taskOptions = new java("org.eclipse.birt.report.engine.api.PDFRenderOption");
$outputStream = new java("java.io.ByteArrayOutputStream");
$taskOptions->setOutputStream($outputStream);
$taskOptions->setOption("pdfRenderOption.pageOverflow", "pdfRenderOption.fitToPage");
$taskOptions->setOutputFormat("pdf");

$task->setRenderOption( $taskOptions );
$task->run();
$task->close();

} catch (JavaException $e) {
	echo $e; //"Error Calling BIRT";
	
}

//echo $outputStream;
echo java_values($outputStream->toByteArray());



?>