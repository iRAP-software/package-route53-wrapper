<?php

namespace iRAP\Route53Wrapper;

final class Route53Client
{
    private $m_client;
    
    
    public function __construct($apiKey, $secret, Objects\AwsRegion $region)
    {
        $credentials = array(
            'key'    => $apiKey,
            'secret' => $secret
        );
        
        $params = array(
            'credentials' => $credentials,
            'version'     => '2013-04-01',
            'region'      => (string) $region
        );
        
        $this->m_client = new \Aws\Route53\Route53Client($params);
    }
    
    
    /**
     * Retrieves a list of the public and private hosted zones that are associated with the 
     * current AWS account. The response includes a HostedZones child element for each hosted zone.
     * WARNING: this wrapper does not *yet* support cases where you have more than 100 hosted zones.
     */
    public function getHostedZones()
    {
        $params = array();
        $rawResponse = $this->m_client->listHostedZones($params);
        $hostedZones = array();
        
        if (isset($rawResponse['HostedZones']))
        {
            foreach ($rawResponse['HostedZones'] as $hostedZoneDataArray)
            {
                $id = $hostedZoneDataArray['Id'];
                $name = $hostedZoneDataArray['Name'];
                $numRecords = intval($hostedZoneDataArray['ResourceRecordSetCount']);
                $hostedZones[] = new Objects\HostedZone($id, $name, $numRecords);
            }
        }
        else
        {
            throw new Exception("Unable to fetch any hosted zones.");
        }
        
        return $hostedZones;
    }
    
    
    
    /**
     * Change one or more records in Route53 (the zone is specified within the change 
     * objects provided)
     * @param  $changes - one or more RecordSetChange objects that are the changes we wish to happen
     * @return type
     */
    public function changeResourceRecordSets(Objects\HostedZone $zone, Objects\RecordSetChange ...$changes)
    {
        $changesArray = array();
        
        foreach ($changes as $change)
        {
            /* @var $change \RecordSetChange */
            $changesArray[] = $change->getArrayForm();
        }
        
        $params = array(
            'ChangeBatch' => array(
                'Changes' => $changesArray
            ),
            'HostedZoneId' => $zone->get_id()
        );
        
        $rawResponse = $this->m_client->changeResourceRecordSets($params);
        return $rawResponse;
    }
    
    
    /**
     * Get the records for the specified zone.
     * @param \iRAP\Route53Wrapper\Objects\HostedZone $zone
     * @return array - array list of the ZoneRecordSet objects
     * @throws Exception
     */
    public function getZoneRecords(Objects\HostedZone $zone) : array
    {
        $params = array(
            'HostedZoneId' => $zone->get_id(), // REQUIRED
        );
        
        $rawResponse = $this->m_client->listResourceRecordSets($params);
        
        if (!isset($rawResponse['ResourceRecordSets']))
        {
            throw new Exception("Failed to fetch zones records.");
        }
        
        $recordSets = Objects\ZoneRecordSet::createFromGetZoneRecordsResponse($rawResponse);
        return $recordSets;
    }
}
