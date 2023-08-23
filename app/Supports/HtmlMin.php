<?php

namespace App\Supports;

use voku\helper\HtmlMin as HtmlMinificate;

/**
 *
 */
class HtmlMin
{
    /**
     * @var HtmlMinificate
     */
    private HtmlMinificate $htmlMin;

    /**
     *
     */
    public function __construct()
    {
        $this->htmlMin = new HtmlMinificate();

        $this->htmlMin->doOptimizeViaHtmlDomParser(true);
        $this->htmlMin->doRemoveComments();
        $this->htmlMin->doOptimizeAttributes(true);
        $this->htmlMin->doSortCssClassNames();
        $this->htmlMin->doSortHtmlAttributes();
        $this->htmlMin->doRemoveValueFromEmptyInput();
        $this->htmlMin->doRemoveEmptyAttributes();
        $this->htmlMin->doRemoveDeprecatedAnchorName();
        $this->htmlMin->doRemoveDeprecatedScriptCharsetAttribute();
        $this->htmlMin->doRemoveDeprecatedTypeFromScriptTag();
        $this->htmlMin->doRemoveDeprecatedTypeFromStylesheetLink();
        $this->htmlMin->doRemoveDeprecatedTypeFromStyleAndLinkTag();
    }

    /**
     * @param String $html
     * @return string
     */
    public function minify(String $html)
    {
        if($_SERVER['SERVER_NAME'] == SITE_PROD)
        {
            return $this->htmlMin->minify($html);
        }

        return $html;
    }
}