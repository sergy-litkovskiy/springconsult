<?php
/**
 * @author Litkovskiy
 * @copyright 2010
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rss extends CI_Controller
{

    public function __construct()
    {
       parent::__construct();
    }


    public function show_rss()
    {
        $articlesArr = null;
        $rssTotalArr = $rssItemsArr = array();
        //set limit of articles's amount
        $params = array(
            'limit' => 3
        );

        $articlesArr = $this->index_model->getArticlesForRssByParams($params);

        foreach($articlesArr as $key => $item){
            $rssItemsArr[$key]['title']       = $item['title'];
            $rssItemsArr[$key]['link']        = 'http://'.$_SERVER['SERVER_NAME'].'/articles/'.$item['id'];
            $rssItemsArr[$key]['description'] = Common::cutString($item['text'], 60);
        }
        $rssTotalArr = array(
         'rss_channel_title'        => 'Последние статьи сайта Spring Consulting'
        ,'rss_channel_link'         => 'http://'.$_SERVER['SERVER_NAME']
        ,'rss_channel_description'  => 'На нашем сайте Вы сможете найти .'
        ,'rss_channel_language'     => 'ru'
        ,'rss_channel_copyright'    => '&copy; Copyright Spring consulting'

        ,'rss_logo_url'             => 'http://'.$_SERVER['SERVER_NAME'].'/spring_logo.png'
        ,'rss_logo_title'           => 'Spring Consulting'
        ,'rss_logo_link'            => 'http://'.$_SERVER['SERVER_NAME']

        ,'arr_rss_items'            => $rssItemsArr
        );

        header("Content-type: application/xml");
        //header("Content-Disposition: inline; filename=prestige_rss.xml");

        print $this->_makeXmlRss($rssTotalArr);
        exit;
    }



    private function _makeXmlRss($rssTotalArr)
    {
        $xw = new xmlWriter();
        $xw->openMemory();

        $xw->startDocument('1.0', 'UTF-8');
        //set atribute 'version' for element 'rss'
        //<rss version = '2.0'>
        $xw->startAttribute("version");
        $xw->startElement("rss");
        $xw->writeAttribute("version", "2.0");
        $xw->endAttribute();
        //<channel>
        $xw->startElement('channel');
        //<title>value</title>
        $xw->writeElement('title', $rssTotalArr['rss_channel_title']);
        //<link>value</link>
        $xw->writeElement('link', $rssTotalArr['rss_channel_link']);
        //<description>value</description>
        $xw->writeElement('description', $rssTotalArr['rss_channel_description']);
        //<language>value</language>
        $xw->writeElement('language', $rssTotalArr['rss_channel_language']);
        //<copyright>value</copyright>
        $xw->writeElement('copyright', $rssTotalArr['rss_channel_copyright']);
        //<image>
        $xw->startElement('image');
        //<title>value</title>
        $xw->writeElement('url', $rssTotalArr['rss_logo_url']);
        //<link>value</link>
        $xw->writeElement('title', $rssTotalArr['rss_logo_title']);
        //<description>value</description>
        $xw->writeElement('link', $rssTotalArr['rss_logo_link']);
        //</image>
        $xw->endElement();
        foreach ($rssTotalArr['arr_rss_items'] as $item) {
            //<item>
            $xw->startElement('item');
            //<title>value</title>
            $xw->writeElement('title', $item['title']);
            //<link>value</link>
            $xw->writeElement('link', $item['link']);
            //<description>value</description>
            $xw->writeElement('description', $item['description']);
            //<guid>value</guid>
            $xw->writeElement('guid', $item['link']);
            //</item>
            $xw->endElement();
        }
        //</channel>
        $xw->endElement();
        //</rss>
        $xw->endElement();

        $xw->endDocument();

        return $xw->outputMemory(true);
    }
}