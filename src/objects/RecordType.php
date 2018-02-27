<?php

/* 
 * This "ENUM" is here just to prevent mistakes.
 * A record type is an "A" record or "MX" record etc.
 */

namespace iRAP\Route53Wrapper\Objects;

class RecordType
{
    private $m_type;
    
    
    private function __construct(string $type)
    {
        $this->m_type = $type;
    }
    
    
    # Static constructors for the various types
    public static function createSOA() { return new RecordType('SOA'); }
    public static function createA() { return new RecordType('A'); }
    public static function createTXT() { return new RecordType('TXT'); }
    public static function createNS() { return new RecordType('NS'); }
    public static function createCNAME() { return new RecordType('CNAME'); }
    public static function createMX() { return new RecordType('MX'); }
    public static function createNAPTR() { return new RecordType('NAPTR'); }
    public static function createPTR() { return new RecordType('PTR'); }
    public static function createSRV() { return new RecordType('SRV'); }
    public static function createSPF() { return new RecordType('SPF'); }
    public static function createAAAA() { return new RecordType('AAAA'); }
    public static function createCAA() { return new RecordType('CAA'); }
    
    
    public function __toString() 
    {
        return $this->m_type;
    }
}