<?php

namespace App\Entity\dti\printers;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Class WebCrawler
 * @package App\Entity\dti\printers
 */
class WebCrawler{    
    
    
    public function dadosstatus($endereco, $uristatus, $urlinfo, $context){
        
        $stat = $this->GetServerStatus($endereco,'80');

        $rows = array();
        $items_rows = array();
        
        if($stat == 'ONLINE'){
            
            $html = file_get_contents($urlinfo, 0, $context);
            $crawler = new Crawler($html);
            $crawler = $crawler->filter('body > table');
            
            $tr_elements = $crawler->filterXPath('//tr');

            // iterate over filter results
            foreach ($tr_elements as $i => $content) {
                $tds = array();
                // create crawler instance for result
                $crawler = new Crawler($content);

                //iterate again
                foreach ($crawler->filter('td') as $i => $node) {
                   // extract the value
                    $tds[] = $node->nodeValue;
                }
                foreach($tds as $i => $td_val){
                    if(!empty($td_val)){
                        $rows[] = $td_val;
                    }
                }
            }

            $index_num_serie = 0;
            $index_modelo = 0;
            $index_troca_toner = 0;
            $contador = 0;
            foreach($rows as $i => $td_val){
                $contador++;
                if($td_val=='Nome do modelo'){
                    $index_modelo = $contador;
                }
                if($td_val=='Número de série'){
                    $index_num_serie = $contador;
                }
                if($td_val=='Nível do toner'){
                    $index_troca_toner = $contador - 2;
                }
            }
            $items_rows[] = 'LIGADA';
            $items_rows[] = $rows[$index_modelo];
            $items_rows[] = $rows[$index_num_serie];
            $items_rows[] = trim($rows[$index_troca_toner]);
            $items_rows = $this->dadosinfo($items_rows, $uristatus, $context);

        }else{
            $items_rows[] = 'DESLIGADA';
        }

        return $items_rows;
        
    }


    public function dadosinfo($items, $uri, $context){
        
        $rows = array();
            
        $html = file_get_contents($uri, 0, $context);
        $crawler = new Crawler($html);
        $crawler = $crawler->filter('body > table');

        $tr_elements = $crawler->filterXPath('//tr');

        // iterate over filter results
        foreach ($tr_elements as $i => $content) {
            $tds = array();

            // create crawler instance for result
            $crawler = new Crawler($content);

            //iterate again
            foreach ($crawler->filter('td') as $i => $node) {
                // extract the value
                $tds[] = $node->nodeValue;
            }
            foreach($tds as $i => $td_val){
                if(!empty($td_val)){
                    $rows[] = $td_val;
                }
            }

        }

        //Pegando a % do Toner
        foreach($rows as $i => $td_val){
            if(substr($td_val, 0, 14) == 'Cartucho Preto'){
                $items[] = substr($td_val, 17, strlen($td_val) - 15);
                break;
            }
        }

        $index_kit_manutencao = 0;
        $contador = 0;

        //Pegando a % do Kit Manutenção
        foreach($rows as $i => $td_val){
            $contador++;
            if($td_val == 'Kit manutenção Vida restante:'){
                $index_kit_manutencao = $contador;
                break;
            }
        }

        $items[] = $rows[$index_kit_manutencao];

        $indice = sizeof($rows);

        //Pegando a % da Unid. de Imagem
        $items[] = $rows[$indice - 1];

        return $items;
    }

    public function getStatusBar($uri, $context){

        $rows = array();

        $html = file_get_contents($uri,0, $context);
        $crawler = new Crawler($html);
        $crawler = $crawler->filter('body > table');

        $tr_elements = $crawler->filterXPath('//tr');

        // iterate over filter results
        foreach ($tr_elements as $i => $content) {
            $tds = array();

            // create crawler instance for result
            $crawler = new Crawler($content);

            //iterate again
            foreach ($crawler->filter('td') as $i => $node) {
                // extract the value
                $tds[] = $node->nodeValue;
            }
            foreach($tds as $i => $td_val){
                if(!empty($td_val)){
                    $rows[] = $td_val;
                }
            }

        }

        return $rows;
    }
    
    function GetServerStatus($site, $port)
    {
        $status = array("OFFLINE", "ONLINE");
        $fp = @fsockopen($site, $port, $errno, $errstr, 1);
        if (!$fp) {
            return $status[0];
        } else{ 
            return $status[1];
        }    
    }
    
}