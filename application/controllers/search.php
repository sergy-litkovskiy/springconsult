<?php
/**
 * @author Litkovskiy
 * @copyright 2010
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller
{

    public $defaultDescription  = '';
    public $defaultKeywords     = '';
    public $arrMenu             = array();

    public function __construct()
    {
        parent::__construct();
        $this->arrMenu           = $this->_prepareMenu();
        $this->urlArr            = explode('/',$_SERVER['REQUEST_URI']);
    }


    public function search()
    {
        $searchText = (isset($_REQUEST['search_text']) && $_REQUEST['search_text']) ? $_REQUEST['search_text']: null;

        try{
            Common::assertTrue($searchText, 'Вы не ввели посковое предписание!');
            $searchText = xss_clean(strip_image_tags(trim($_REQUEST['search_text'])));

            $this->data_menu      = array('menu' => $this->arrMenu, 'current_url' => $this->urlArr[count($this->urlArr)-1]);
            $contentArr           = $this->index_model->getSearchContent($searchText);
            $searchResult         = $this->_prepareSearchResult($contentArr, $searchText);

            $this->data_arr       = array(
            'title'         	=> 'Springconsulting - search result'
            ,'aforizmus'        => $this->index_model->getAforizmusByRandom()
            ,'meta_keywords'	=> $this->defaultDescription
            ,'meta_description'	=> $this->defaultKeywords
            ,'content'       	=> $searchResult
            ,'searching_text' 	=> $searchText
            ,'empty_result' 	=> count($searchResult) < 1 ? 'К сожалению, по вашему запросу ничего не найдено' : null
            );

            $data = array(
                'menu'          => $this->load->view(MENU, $this->data_menu, true),
                'content'       => $this->load->view('blocks/search_result', $this->data_arr, true),
                'cloud_tag'     => $this->load->view('blocks/cloud_tag', $this->cloudsTag, true),
                'subscribe'     => $this->load->view('blocks/subscribe', count($this->subscribe) ? $this->subscribe : null, true));
            $this->load->view('layout', $data);
        } catch (Exception $e) {
            redirect(base_url());
        }
    }



    private function _prepareSearchResult($contentArr, $searchText)
    {
        $searchResult = array();
        foreach($contentArr as $blockName => $blockArr){
            foreach($blockArr as $key => $val){
                if(isset($val['text'])){
                    $val['text'] = $this->_backlightText($val['text'], $searchText);
                }
                $searchResult[$blockName][$key] = $val;
            }
        }
        return $searchResult;
    }



    private function _backlightText($text, $searchText)
    {
        /*ищем слова совпадения в возвращаемом тексте*/
        $textCut = strstr($text,$searchText);

        /*обрезаем до 20 слов начиная со слова-совпадения*/
        $textCutLink = Common::cutString($textCut, 20);

        /*подсвечиваем совпадения с искомым словом*/
        return str_replace($searchText, "<font style='color:green'><b>".$searchText."</b></font>", $textCutLink );
    }


    protected function _prepareMenu()
    {
        return $this->menu_model->childs;
    }

}