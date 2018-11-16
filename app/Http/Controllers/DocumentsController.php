<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use Carbon\Carbon;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all_tag($xml){
        $i=0; 
        $name = "";
        foreach ($xml as $k){
            $tag = $k->getName();
            $tag_value = $xml->$tag;
            if ($name == $tag){ $i++;    }
                    $name = $tag;     
                echo $tag .' '.$tag_value[$i].'<br />';
            // recursive
               $this->all_tag($xml->$tag->children());
        }
    }

    public function index()
    {
        return view('documents.search');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     *@param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response xmlresponse
     */
    public function show(Request $request)
    {
        $pmc_identifier = trim($request->input('document_identifier'));
        $url = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?db=pmc&id=$pmc_identifier";
        $xml_document = file_get_contents($url);
        $file_id =  (string) Str::uuid().".xml";
        file_put_contents(public_path()."/tmp/".$file_id, $xml_document );
        $output = shell_exec('/Users/dsalgado/go/bin/pmcparser '.$file_id);
        //print($output);
        $new_doc= strip_tags(preg_replace("/\n/", "", $output));
        $tab_text["text"] = $new_doc;
        $json_bin=json_encode($tab_text);
        $jsonfile_id =  (string) Str::uuid().".json";
        $jsonfile_id_out =  (string) Str::uuid().".out";
        file_put_contents(public_path()."/tmp/".$jsonfile_id, utf8_encode($json_bin) );

        $output2=shell_exec("wget --post-file=".public_path()."/tmp/".$jsonfile_id." --header=\"Content-Type: application/json\" https://pubcasefinder.dbcls.jp/annotate/hpo -O ".public_path()."/tmp/".$jsonfile_id_out);
        $json_returned = file_get_contents(public_path()."/tmp/".$jsonfile_id_out);
        $hpos=json_decode($json_returned, true);
        //print_r($hpos);
        $new_doc_final = $new_doc;
        $shift = 0;
        foreach($hpos["results"] as $key=>$sub_tab){
            //print_r($sub_tab);
                //echo "SHIFT === ".$shift."<br>";
                $start=$sub_tab["START"]+$shift;
                $new_doc_final = substr_replace( $new_doc_final ,"<span style='background:red' id=\"term_".$key."\"onmouseover=\"tooltip_it('term_".$key."', '".$sub_tab["HPO ID"]."');\" >" , $start , 0);
                //echo "replacement1<br>";
                $shift=$shift+strlen("<span style='background:red' id=\"term_".$key."\"onmouseover=\"tooltip_it('term_".$key."', '".$sub_tab["HPO ID"]."');\" >");
                //echo "SHIFT === ".$shift."<br>";
                $end=$sub_tab["END"]+$shift;
                $new_doc_final = substr_replace( $new_doc_final ,"</span>" , $end, 0 );
                //echo "replacement2<br>";
                $shift=$shift+strlen("</span>");

            }
            
        
        //echo  $new_doc_final;
        return view("documents.results", compact('new_doc_final'));




    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        //
    }

    public function search(Request $request)
    {
        //
    }

    public function testseeder()
    {
        
    }
}
