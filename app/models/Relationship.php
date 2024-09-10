<?php
    class Relationship {
        private $db;
        
        public function __construct()
        {
            $this->db = new Database;
        }

        public function getRelationships(){
            $this->db->query('SELECT relationshipId, relationshipName as "relationshipName" FROM hr_surgepays.relationships where status=1;');
            $result = $this->db->resultSetAssoc();
            return $result;
        }
        public function getRelationshipsEnglish(){
            $this->db->query('SELECT relationshipId, relationshipNameEnglish as "relationshipName" FROM hr_surgepays.relationships where status=1;');
            $result = $this->db->resultSetAssoc();
            return $result;
        }
    }

?>