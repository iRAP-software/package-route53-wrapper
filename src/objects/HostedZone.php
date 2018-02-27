<?php

/* 
 * An object to represent a single hosted zone.
 * 
 * Below is an example output from the array returned in listHostedZones:
 * [Id] => /hostedzone/Z17YJ2FKH7LX5N
    [Name] => irap-dev.org.
    [CallerReference] => 23137840-2927-8B4A-B780-6387C06268CB
    [Config] => Array
        (
            [Comment] => domain for development
            [PrivateZone] => 
        )

    [ResourceRecordSetCount] => 22
 */

namespace iRAP\Route53Wrapper\Objects;

class HostedZone
{
    private $m_id;
    private $m_name;
    private $m_resourceRecordSetCount;
    
    
    public function __construct(string $id, string $name, int $numRecords)
    {
        $this->m_id = $id;
        $this->m_name = $name;
        $this->m_numRecords = $numRecords;
    }
    
    
    /**
     * Create a TXT record for this zone.
     * @param \Aws\Route53\Route53Client $client
     * @param string $subdomain - the subdomain for the record. We automatically append the domain 
     *                       to this, so if you put in 'test' this will send 'test.mydomain.com'
     * @param string $value - the value for the record. We automatically wrap this with double quotes
     *                       for  you so if you put in 'test' this will send '"test"'
     * @param bool $replaceIfAlreadyExists - set to true if you wish to replace a record if it 
     *                                       already exists, or false if there shouldn't be a record
     *                                       already and if there is then don't do anything.
     * @param int $ttl - the TTL of the record in seconds. E.g. 3600 for one hour.
     * @return type
     */
    public function addTxtRecord(\iRAP\Route53Wrapper\Route53Client $client, string $subdomain, string $value, int $ttl, bool $replaceIfAlreadyExists)
    {
        $domain = substr($this->m_name, 0, -1); // remove the . from the end.
        $fullName = "{$subdomain}.{$domain}";
        $quotedValue = '"'  . str_replace('"', '\"', $value) . '"';
        
        if ($replaceIfAlreadyExists)
        {
            $action = RecordSetChangeAction::createActionUpsert();
        }
        else
        {
            $action = RecordSetChangeAction::createActionCreate();
        }
        
        $changeRequest = new \iRAP\Route53Wrapper\Objects\RecordSetChange(
            $action, 
            RecordType::createTXT(),
            $fullName, 
            $quotedValue, //TXT values need to be wrapped in double quotes. 
            $ttl
        );

        $response = $client->changeResourceRecordSets($this, $changeRequest);
        return $response;
    }
    
    
    /**
     * Create a TXT record for this zone.
     * @param \Aws\Route53\Route53Client $client
     * @param string $subdomain - the subdomain for the record. We automatically append the domain 
     *                       to this, so if you put in 'test' this will send 'test.mydomain.com'
     * @param string $ip - the value for the record. We automatically wrap this with double quotes
     *                       for  you so if you put in 'test' this will send '"test"'
     * @param bool $replaceIfAlreadyExists - set to true if you wish to replace a record if it 
     *                                       already exists, or false if there shouldn't be a record
     *                                       already and if there is then don't do anything.
     * @param int $ttl - the TTL of the record in seconds. E.g. 3600 for one hour.
     * @return type
     */
    public function addARecord(\iRAP\Route53Wrapper\Route53Client $client, string $subdomain, string $ip, int $ttl, bool $replaceIfAlreadyExists)
    {
        $domain = substr($this->m_name, 0, -1); // remove the . from the end.
        $fullName = "{$subdomain}.{$domain}";
        $value = $ip;
        
        if ($replaceIfAlreadyExists)
        {
            $action = RecordSetChangeAction::createActionUpsert();
        }
        else
        {
            $action = RecordSetChangeAction::createActionCreate();
        }
        
        $changeRequest = new \iRAP\Route53Wrapper\Objects\RecordSetChange(
            $action, 
            RecordType::createA(), 
            $fullName, 
            $value, //TXT values need to be wrapped in double quotes. 
            $ttl
        );

        $response = $client->changeResourceRecordSets($this, $changeRequest);
        return $response;
    }
    
    
    # Accessors
    public function get_id() { return $this->m_id; }
    public function get_name() { return $this->m_name; }
    public function get_num_records() { return $this->m_resourceRecordSetCount; }
}

