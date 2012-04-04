
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
statis.php

*/
class Statis extends CI_Controller {

    public $words;

    function __construct()
    {
        parent::__construct();
        $this->words = file('./uddata/wordlist');

    }


    /**
     * Index Page for this controller.
     * @var top()
     */
    public function index()
    {
        $div = array();
        foreach ( $this->words as $de )
        {
            $div[] = rtrim($de);
        }

        $word = array();
        $query = $this->db->get('stream');  
        // $query = $this->db->query('SELECT * FROM omeb.faq_old');  

        foreach ( $query->result_array() as $s )
        {
            //preg_match('/[一-龠々〆ヵヶ]+|[ぁ-ん]+|[ァ-ヴー]+|[a-zA-Z0-9]+|[ａ-ｚＡ-Ｚ０-９]+|[、。！!？?()（）「」『』]+/', $s['tweet'], $string);

            // $string = mecab_split($s['tweet']);
            $string = mecab_split($s['tweet']);
            foreach ( $string as $w )
            {
                if (!array_search($w, $div) && 1 != mb_strlen($w) )
                {
                    if ( !empty($word[$w]) )
                        $word[$w]++;
                    else
                        $word[$w] = 1;
                }
            }
        }

        arsort($word);
        foreach ( $word as $key => $value )
        {
            echo "{$value}回 {$key}<br />\n";
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
