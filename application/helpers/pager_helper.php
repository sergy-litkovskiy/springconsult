<?php

/**
 * @author Litkovskiy
 * @copyright 2010
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

        function prepare_pager_config()
    	{
    	   return array(
                        'uri_segment'       => 3
                        ,'per_page'         => 8
                        ,'num_links'        => 6
                        ,'full_tag_open'    => '<div id="pager">'
                        ,'full_tag_close'   => '</div>'
                        //first page links
                        ,'first_link'       => 'first'
                        ,'first_tag_open'   => '<span class="pager">'
                        ,'first_tag_close'  => '</span>'
                        //last page links
                        ,'last_link'        => 'last'
                        ,'last_tag_open'    => '<span class="pager">'
                        ,'last_tag_close'   => '</span>'
                        //next page links
                        ,'next_link'        => '<img src="'.base_url().'img/img_main/nav_right.png">'
                        ,'next_tag_open'    => '<span class="pager">'
                        ,'next_tag_close'   => '</span>'
                        //prev page links
                        ,'prev_link'        => '<img src="'.base_url().'img/img_main/nav_left.png">'
                        ,'prev_tag_open'    => '<span class="pager">'
                        ,'prev_tag_close'   => '</span>'
                        //current page links
                        ,'cur_tag_open'     => '<span class="current_page">'
                        ,'cur_tag_close'    => '</span>'
                        //digits links
                        ,'num_tag_open'     => '<span class="pager">'
                        ,'num_tag_close'    => '</span>'
                    );
       }

?>