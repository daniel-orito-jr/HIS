<%@page import="javax.script.*"%>
<%@page import="php.java.script.servlet.PhpServletScriptContext"%>

<%!
// use one engine per thread
private ThreadLocal<ScriptEngine> scriptCached = new ThreadLocal<ScriptEngine>();
private ScriptEngine getScript(Servlet servlet, ServletContext application, HttpServletRequest request, HttpServletResponse response) throws ScriptException {
	
	// create or re-use a php script engine
	scriptCached.set((scriptCached.get()!=null) ? scriptCached.get() : new ScriptEngineManager().getEngineByName("php")); 

	// attach the current servlet context to it
	scriptCached.get().setContext(new PhpServletScriptContext(scriptCached.get().getContext(),servlet,application,request,response));

	return scriptCached.get();
}
%>

<%
  ScriptEngine script = null;
  try {
	script = getScript(this, application, request, response);
		  
	script.put("hello", "eval1: " + Thread.currentThread());
	script.eval("<?php echo 'Hello '.java_context()->get('hello').'!<br>\n'; ?>");
	
	script.put("hello", "eval2: " + Thread.currentThread());
	script.eval("<?php echo 'Hello again '.java_context()->get('hello').'!<br>\n'; ?>");
 
  } catch (Exception ex) {
	out.println("Could not evaluate script: "+ex);
  } finally {
	if (script!=null) ((java.io.Closeable)script).close();
  }
%>
