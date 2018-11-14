<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        print($output);

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
}
