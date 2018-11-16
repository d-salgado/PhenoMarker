<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('hpo2synos')->delete();
        DB::table('hpos')->delete();
        $lines = file(public_path()."/data/hp.obo.txt");
        $term_info=[];
        foreach($lines as $line_number=>$line_content){
            if (preg_match("/^\[Term\]/", $line_content)){
                if(count($term_info)>0){
                    $tab_of_terms[]=$term_info;
                    $term_info=[];
                }
            }
            if (preg_match("/^id: (.+)$/", $line_content, $matches)){
                $term_info["identifier"]=trim($matches[1]);
            }
            if (preg_match("/^name: (.+)$/", $line_content, $matches)){
                $term_info["name"]=trim($matches[1]);
            }
            if (preg_match("/^def: \"([^\"]+)\"/", $line_content, $matches)){
                $term_info["desc"]=trim($matches[1]);
            }
            if (preg_match("/^synonym: \"([\"]+)\"/", $line_content, $matches)){
                $term_info["synonym"][]=trim($matches[1]);
            }
            
        }
        //this is for the last term readed
        $tab_of_terms[]=$term_info;
        foreach($tab_of_terms as $key=>$hpo_data){
            $ident=$hpo_data["identifier"];
            $name=$hpo_data["name"];
            $desc=(isset($hpo_data["desc"])? $hpo_data["desc"] : "" );
            $term_id= DB::table('hpos')->insertGetId([
            'identifier' => $ident,
            'term_name' => $name, 
            'description' => $desc, 

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            if(!empty($hpo_data["synonym"])){
                foreach($hpo_data["synonym"] as $newk=>$newval){
                    $syno = $newval;
                    DB::table('hpo2synos')->insert([
                        'hpo_id' => $term_id,
                        'synonym' => $syno, 
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                }
            }
           // echo "$ident and synos iserted in the DB";

        }

    }
}
