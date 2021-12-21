<?php

class Conf
{
    private $file;
    private $xml;
    private $lastMatch;

    function __construct($file)
    {
        $this->file = $file;
        if (!file_exists($file)) {
            throw new FileException("File: $file does not exist");
        }
        $this->xml = simplexml_load_file($file, null, LIBXML_NOERROR);
        if (!is_object($this->xml)) {
            throw new XmlException(libxml_get_last_error());
        }
        print gettype($this->xml);
        $matches = $this->xml->xpath("/conf");
        if (!count($matches)) {
            throw new ConfException("Main element conf is missing");
        }
    }

    function write()
    {
        if (!is_writable($this->file)) {
            throw new FileException("File: $this->file is not writable");
        }
        file_put_contents($this->file, $this->xml->asXML());
    }

    function get($str)
    {
        $matches = $this->xml->xpath("/conf/item[@name=\"$str\"]");
        if (count($matches)) {
            $this->lastmatch = $matches[0];
            return (string)$matches[0];
        }
        return null;
    }

    function set($key, $value)
    {
        if (!is_null($this->get($key))) {
            $this->lastMatch[0] = $value;
            return;
        }
        $conf = $this->xml->conf;
        $this->xml->addChild('item', $value)->addAttribute('name', $key);
    }
}

class XmlException extends Exception
{
    private $error;

    function __construct(LibXMLError $error)
    {
        $shortFile = basename($error->file);
        $msg = "[{$shortFile}, line {$error->line}, ";
        $msg .= "column {$error->column}] {$error->message}";
        $this->error = $error;
        parent::__construct($msg, $error->code);
    }

    function getLibXmlError()
    {
        return $this->error;
    }
}
class FileException extends Exception
{
}
class ConfException extends Exception
{
}


class Runner
{
    static function init()
    {
        $fh = fopen("./log.txt", "w");
        try {
            fputs($fh, "Start\n");
            $conf = new Conf(dirname(__FILE__) . "/conf01.xml");
            $conf->set("pass", "newpass");
            $conf->set("address", "vilnius");
            $conf->write();
            print "user: " . $conf->get('user') . "<br>";
            print "host: " . $conf->get('host') . "\n";
            print "address: " . $conf->get('address') . "\n";
        } catch (FileException $e) {
            fputs($fh, "File error\n");
        } catch (XmlException $e) {
            fputs($fh, "Error in code\n");
        } catch (ConfException $e) {
            fputs($fh, "Configuration file error\n");
        } catch (Exception $e) {
            fputs($fh, "Other error\n");
        } finally {
            fputs($fh, "The end\n");
            fclose($fh);
        }
    }
}

Runner::init();
