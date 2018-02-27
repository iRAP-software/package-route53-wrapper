<?php

/* 
 * An object to represent a single hosted zone.
 * 
 * Below is an example output from the array returned in listHostedZones:
 *  [Name] => capacity.irap-dev.org.
    [Type] => CNAME
    [TTL] => 300
    [ResourceRecords] => Array
        (
            [0] => Array
                (
                    [Value] => ec2-52-31-223-175.eu-west-1.compute.amazonaws.com
                )

        )

 */

namespace iRAP\Route53Wrapper\Objects;

class ZoneRecordSet
{
    private $m_name;
    private $m_type;
    private $m_ttl;
    private $m_resourceRecords = array();
    
    
    private function __construct(){}
    
    
    
    /**
     * Create a zone record set object from 
     * @param $rawResponse - the response from a call to getZoneRecordsResponse
     * @return array - array of \iRAP\Route53Wrapper\Objects\ZoneRecordSet
     */
    public static function createFromGetZoneRecordsResponse($rawResponse) : array
    {
        $zoneRecordSets = array();
        $recordSetsArray = $rawResponse['ResourceRecordSets'];
        
        foreach ($recordSetsArray as $recordSetObj)
        {
            $zoneRecordSet = new ZoneRecordSet();
        
            $zoneRecordSet->m_name = $recordSetObj['Name'];
            $zoneRecordSet->m_type = $recordSetObj['Type'];
            $zoneRecordSet->m_ttl = $recordSetObj['TTL'];

            $records = $recordSetObj['ResourceRecords'];

            foreach ($records as $record)
            {
                $zoneRecordSet->m_resourceRecords[] = $record['Value'];
            }
            
            $zoneRecordSets[] = $zoneRecordSet;
        }
        
        return $zoneRecordSets;
    }
    
    
    public static function create()
    {
        
    }
    
    public static function replace()
    {
        
    }
    
    
    public static function delete()
    {
        
    }
    
    
    
    
    # Accessors
    public function get_id() { return $this->m_name; }
    public function get_name() { return $this->m_name; }
    public function get_num_records() { return $this->m_resourceRecordSetCount; }
}

