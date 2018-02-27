<?php

/* 
 * This "ENUM" is here just to prevent mistakes.
 * A record type is an "A" record or "MX" record etc.
 */

namespace iRAP\Route53Wrapper\Objects;


class RecordSetChangeAction
{
    private $m_type;
    
    
    private function __construct(string $type)
    {
        $this->m_type = $type;
    }
    
    
    /**
     * Create an action of type CREATE. Such actions will try to create records, but will fail
     * if there is already a record with that name/type. If you would prefer that it wouldn't fail
     * and that it would just replace the record in such situations, use the UPSERT action.
     * @return \RecordType
     */
    public static function createActionCreate() { return new RecordSetChangeAction('CREATE'); }
    
    
    /**
     * Create the UPSERT action type. This will create the record if it doesnt already exist, and
     * update/replace it if it does.
     * @return \RecordType
     */
    public static function createActionUpsert() { return new RecordSetChangeAction('UPSERT'); }
    
    
    /**
     * Create a DELETE action.
     * @return \RecordType
     */
    public static function createActionDelete() { return new RecordSetChangeAction('DELETE'); }
    
    
    /**
     * Magic method called when we cast this object to string.
     * @return string
     */
    public function __toString() : string { return $this->m_type; }
}