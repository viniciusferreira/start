<?php

namespace Lib\Neos;
use o;

class Output {
    
    //Parameters
    private $content = '';
    
    
    function __construct($content = ''){
        $this->content = $content;
    }
 
    /* SEND
     * Send headers & Output tris content
     * 
     */
    function send() {
        ob_end_clean();
        ob_start('ob_gzhandler');
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
        header('Cache-Control: must_revalidate, public, max-age=31536000');
        header('X-Framework: NEOS PHP Framework - version 0.1');
        exit($this->content . $this->statusBar());
    }
    
    
    /* DOWNLOAD
     * TODO: pleasy, make tests . . .
     *
     */
    function download($ext, $path){
        //search for mime type
        include o::app('config').'mimes.php';
        if (!isset($_mimes[$ext])) $mime = 'text/plain';
        else $mime = (is_array($_mimes[$ext])) ? $_mimes[$ext][0] : $_mimes[$ext];
        
        //get file
        $dt = file_get_contents($path);
        
        //download
        ob_end_clean();
        ob_start('ob_gzhandler');
    
        header('Vary: Accept-Language, Accept-Encoding');
        header('Content-Type: ' . $mime);
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($path)) . ' GMT');
        header('Cache-Control: must_revalidate, public, max-age=31536000');
        header('Content-Length: ' . strlen($dt));
        header('x-Server: nfw/RunPHP');
        header('ETAG: '.md5($path));
        exit($dt);
    }
    
    /* DEBUG/LOG
       * Save, send or display log string
       *
       * TODO: Lack build feature!
       *
       * @param $msg String Mesage
       * @param $mode String Save mode [log, mail, display]
       *
       * @return void
       */
    function _debug($msg, $mode = 'log') {
       $log = date('Y d m H i s').' | '.$msg;
    }
    
    /* Status Bar
     * TODO : Criar o carregamento e compressão de arquivos CSS/JS para incluir os da barra de status.
     *
     * @return string Html status bar.
     */
    
    function statusBar(){
        if(!defined('INITIME')) return '';
	    $t = explode(' ',microtime());
        $i = explode(' ', INITIME);
	    return '<p style="position: fixed; bottom:0; right: 0; background: #999; color:#000; font-family: \'Oxygen Mono\', monospace; padding: 3px 5px; font-size: 10px; font-weight: normal; font-style: italic; text-shadow:1px 1px 1px #DDD">time: '.number_format((($t[0] * 1000)-$i[0] * 1000),1,',','.').' ms</p>';
    }
    
    function statusBar_old($extended = true){
        $sb = '<script type="text/javascript">var neos_=\'none\';function neostatus(){if(neos_==\'none\'){neos_=\'block\'}else{neos_=\'none\'};document.getElementById(\'neostatustable\').style.display=neos_}</script>'
                . '<style>#neostatus{position:fixed;bottom:10px;right:10px;z-index:200;background:#777;background-color:rgba(60,60,60,0.7);'
                . 'box-shadow:0 1px 3px #000;cursor:pointer;font-size:10px;color:#FFF !important;'
                . 'font-family:Helvetica,Tahoma,monospace,\'Courier New\',Courier,serif;margin:0;'
                . 'padding:4px 8px;border:none;border-radius:7px;text-align:right}'
                . '#neostatustable{display:none;color:#FFF;margin:0 0 20px 0}'
                . '#neostatustable a{color:#FFF}'
                . '#neostatustable tr td{background:transparent !important;padding:2px 5px 0 0; color:#FF9}'
                . '#neostatustable th{padding:5px 0;color:#FFF}'
                . '#neostatustable tr th{font-size:12px;font-weight:bold}'
                . '#neostatustable pre {white-space:pre-wrap}'
                . '.neostatuslg td{border-bottom:1px dashed #999}'
                . '.r{text-align:right !important;padding:2px 0 0 0 !important}</style><div id="neostatus" onClick="neostatus()">';
    
        if($extended){
            $sb .= '<table id="neostatustable" title="hide!"><tr><th colspan="2"><a href="http://colabore.co.vu" target="new">ZoOm!</a></th></tr>';
            foreach(get_included_files() as $f){$sb .= '<tr><td colspan="2">'.$f.'</td></tr>';}
            $sb.='<tr><td>Files (total)</td><td class="r">'.count(get_included_files()).'</td></tr>'.
                 '<tr><td>Memory</td><td class="r">'.number_format(round((memory_get_usage()/1000),0),0,',','.').' kb</td></tr>'.
                 '<tr><td>Memory Peak</td><td class="r">'.number_format(round((memory_get_peak_usage()/1000),0),0,',','.').' kb</td></tr></table>';
        }
        $t = explode(' ',microtime());
        $i = explode(' ', INITIME);
        return $sb.number_format((($t[0] * 1000)-$i[0] * 1000),1,',','.').' ms</div>';
    }   
    
}