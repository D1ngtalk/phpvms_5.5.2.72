<?php

    class SimBrief extends CodonModule
    {

        public static function getBrief($pilotid, $bidid)
        {
            $pilotid = DB::escape($pilotid);
            $bidid = DB::escape($bidid);
    
            $sql = 'SELECT * FROM simbrief_data WHERE pilotid = ' . $pilotid . ' AND bidid = '. $bidid;
            
            return DB::get_row($sql);
        }
        public static function updateBrief($pilotid, $bidid, $ofpid)
        {
            $pilotid = DB::escape($pilotid);
            $bidid = DB::escape($bidid);
            
            // if (self::getBrief($pilotid, $bidid)) return false;
            
            $ofpid = DB::escape($ofpid);
            
            if (DB::get_row('SELECT * FROM simbrief_data WHERE pilotid=' . $pilotid)){
                $sql = 'DELETE FROM simbrief_data WHERE pilotid = ' . $pilotid;
                
                DB::query($sql);
            }
            
            $sql = 'INSERT INTO simbrief_data (sbid, pilotid, bidid, ofpid) VALUES (NULL, ' . $pilotid . ', ' . $bidid . ', \'' . $ofpid . '\')';

            DB::query($sql);
    
            if (DB::errno() != 0) return false;
    
            return true;
        
        }
        public function index()
        {
            $url = 'https://www.simbrief.com/ofp/flightplans/xml/'.$this->get->ofp_id.'.xml';
            $xml = simplexml_load_file($url);
            $this->set('info', $xml);
            $this->render('SimBrief/SimBrief.tpl'); 
            //print_r($xml);
        }
}