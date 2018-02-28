<?php

/* 
 * Test that we can list hosted zones.
 */

class TestListHostedZones extends AbstractTest
{
    private $m_client; /* @var $this->m_client \iRAP\Route53Wrapper\Route53Client */
    
    
    public function __construct(\iRAP\Route53Wrapper\Route53Client $client)
    {
        $this->m_client = $client;
    }
    
    
    public function run() 
    {
        $hostedZones = $this->m_client->getHostedZones();
        
        foreach ($hostedZones as $hostedZone)
        {
            $zonesRecords = $this->m_client->getZoneRecords($hostedZone);
            
            
            if (false)
            {
                $changeRequest = new \iRAP\Route53Wrapper\Objects\RecordSetChange(
                    iRAP\Route53Wrapper\Objects\RecordSetChangeAction::createActionCreate(), 
                    iRAP\Route53Wrapper\Objects\RecordType::createTXT(), 
                    $name="testRecord.irap-dev.org", 
                    $value='"hello-world"', //TXT values need to be wrapped in double quotes. 
                    $ttl=60
                );
                
                $response = $this->m_client->changeResourceRecordSets($hostedZone, $changeRequest);
            }
            else
            {
                $response = $hostedZone->addARecord(
                    $this->m_client, 
                    "testing123", 
                    "192.168.1.1", 
                    60,
                    false
                );
                
                die("response from addTxtRecord: " . print_r($response,true));
            }
            
            //$this->m_client->getHostedZone($hostedZone);
            
            "Records: " . print_r($zonesRecords, true) . PHP_EOL;
        }
    }
}

