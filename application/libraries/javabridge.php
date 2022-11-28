<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/JavaBridge/webapps/JavaBridge/java/Java.inc');

class Javabridge
{
    protected function ci()
    {
        return get_instance();
    }
    
    public function load_system()
    {
        $system = new Java('java.lang.System');
        
        return $system;
    }  
    
    public function load_class()
    {
        $class = new JavaClass("java.lang.Class");
        
        return $class;
    }   
    
    public function load_manager($type)
    {
        if($type === "compiler")
        {
            $javaclass = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");
        }
        else if($type === "importer")
        {
            $javaclass = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        }
        else if($type === "exporter")
        {
            $javaclass = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");
        }

        return $javaclass;
    }
    
    public function load_util($utility)
    {
        if($utility === "hashmap")
        {
            $javautil = new Java("java.util.HashMap");
        }
        else if($utility === "arraylist")
        {
            $javautil = new Java( 'java.util.ArrayList');
        }
        
        return $javautil;
    }
    
    public function load_datasource($source, $arraylist)
    {
        if($source === "emptydata")
        {
            $datasource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");
        }
        else if($source === "multidata")
        {
            $datasource = new Java("net.sf.jasperreports.engine.data.JRBeanCollectionDataSource", $arraylist);
        }
        
        return $datasource;
    }
}
