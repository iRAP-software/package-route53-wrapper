<?php

/* 
 * This object helps with calls to changeResourceRecordSets()
 */

namespace iRAP\Route53Wrapper\Objects;

class RecordSetChange
{
    private $m_action;
    private $m_name;
    private $m_values = array();
    private $m_type;
    private $m_ttl;
    
    
    /**
     * Create a RecordSetChange object for creating/editing/deleting a DNS record.
     * @param RecordSetChangeAction $action - the action we wish to perform. E.g. create/delete.
     * @param RecordType $type - the type of record, e.g. a TXT or A record.
     * @param string $name - the name for the record. E.g. www.irap.org
     * @param string $value - the value. E.g this would be an ip address for an A record.
     * @param int $ttl - the amount of time the record should be cached for in seconds. 
     *                   e.g 3600 for 1 hour or 300 for 5 minutes.
     */
    public function __construct(RecordSetChangeAction $action, RecordType $type, string $name, string $value, int $ttl)
    {
        $this->m_action = $action;
        $this->m_type = $type;
        $this->m_name = $name;
        $this->m_values[] = $value;
        $this->m_ttl = $ttl;
    }
    
    
    /**
     * Add another value to the request. You may wish to do this for things like load balancing.
     * E.g. you create an A record with a singulare name (www.irap.org), but have multiple values
     * (ip addresses) that it points to. That way requests are split across those servers.
     * @param string $value - the value to add to the change object.
     */
    public function addValue(string $value)
    {
        $this->m_values[] = $value;
    }
    
    
    public function getArrayForm()
    {
        $resourceRecords = array();
        
        foreach ($this->m_values as $value)
        {
            $resourceRecords[] = array('Value' => $value);
        }
        
        $resourceRecordSet = array(
            'ResourceRecords' => $resourceRecords,
            'Name' => $this->m_name,
            'TTL' => $this->m_ttl,
            'Type' => (string) $this->m_type,
        );
        
        $request = array(
            'Action' => (string) $this->m_action, 
            'ResourceRecordSet' => $resourceRecordSet,
        );
        
        //die(print_r($request, true));
        return $request;
    }
}
