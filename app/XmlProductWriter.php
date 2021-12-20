<?php

namespace Xml;

use Writer\ShopProductWriter;
use XMLWriter;

class XmlProductWriter extends ShopProductWriter
{
    public function write()
    {
        $writer = new XMLWriter();
        $writer->openMemory();
        $writer->startDocument('1.0', 'UTF-8');
        $writer->startElement("products");

        foreach ($this->products as $shopProduct) {
            $writer->startElement("product");
            $writer->writeAttribute("title", $shopProduct->getTitle());
            $writer->startElement("summary");
            $writer->text($shopProduct->getSummaryLine());
            $writer->endElement();
            $writer->endElement();
        }

        $writer->endElement();
        $writer->endDocument();
        print $writer->flush();
    }
}
