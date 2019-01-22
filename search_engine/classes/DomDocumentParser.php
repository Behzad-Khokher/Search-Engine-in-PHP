<?php
class DomDocumentParser {

    private $doc;

    public function __construct($url) {

        $options = array(
            'http'=>array('method'=>"GET", 'header'=>"User-Agent: SearchMeBOT/0.1\n")
            );
        $context = stream_context_create($options);

        $this->doc = new DomDocument();
        @$this->doc->loadHTML(file_get_contents($url, false, $context));

    }

    public function getLinks() {
        return $this->doc->getElementsbyTagName("a");
    }

    public function getTitleTags() {
        return $this->doc->getElementsbyTagName("title");
    }

    public function getMetaTags() {
        return $this->doc->getElementsbyTagName("meta");
    }

    public function getImages() {
        return $this->doc->getElementsbyTagName("img");
    }

}


?>
